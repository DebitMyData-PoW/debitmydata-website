<?php
/*
 * The network figures on the home page, kept for 30 seconds so that the explorers are asked at
 * most twice a minute however many people have the page open:
 *   - block height, hashrate and DMD mined, from the explorer (explorer.debitmydata.io);
 *   - the latest blocks (height, time, pool), from the mempool explorer (mempool.debitmydata.io);
 *   - DebitMyData's reference price, from the Agent Gateway (api.debitmydata.io).
 * And the latest DebitMyData Core version tagged on GitHub, kept for an hour: GitHub answers
 * 60 requests an hour without a key, and a new version is rare.
 *
 * index.php includes this file to show the figures straight away. Opened directly
 * (/stats.php), it answers the same figures as JSON, which the page fetches to refresh them.
 */
declare(strict_types=1);

const DMD_STATS_TTL = 30;       // seconds the figures are kept
const DMD_STATS_TIMEOUT = 4;    // seconds to wait for an explorer
const DMD_BLOCKS = 15;          // the latest blocks kept (the mempool explorer gives 15 at a time)
const DMD_CORE_TTL = 3600;      // seconds the Core version is kept
const DMD_CORE_RETRY = 300;     // seconds before GitHub is asked again when it didn't answer
const DMD_CORE_REPO = 'https://github.com/DebitMyData-PoW/DebitMyData-PoW-Core';

// DMD_EXPLORER_URL, DMD_MEMPOOL_URL, DMD_PRICE_API and DMD_GITHUB_API only to try the page
// against other servers.
function dmd_url(string $env, string $default): string
{
    $url = getenv($env);
    return rtrim($url !== false && $url !== '' ? $url : $default, '/');
}

/** One answer, decoded (an object, a list or a plain number), or null if it failed. */
function dmd_fetch(string $url)
{
    $context = stream_context_create([
        'http' => ['timeout' => DMD_STATS_TIMEOUT, 'header' => "User-Agent: debitmydata.io\r\n"],
    ]);
    $body = @file_get_contents($url, false, $context);
    if ($body === false) {
        return null;
    }
    $value = json_decode(trim($body), true);
    return $value === null ? null : $value;
}

/** The latest blocks, newest first: [height, time, pool], or null if the explorer didn't answer. */
function dmd_blocks(): ?array
{
    $list = dmd_fetch(dmd_url('DMD_MEMPOOL_URL', 'https://mempool.debitmydata.io') . '/api/v1/blocks');
    if (!is_array($list) || $list === []) {
        return null;
    }
    $blocks = [];
    foreach (array_slice($list, 0, DMD_BLOCKS) as $block) {
        if (!is_array($block) || !isset($block['height'], $block['timestamp'])) {
            continue;
        }
        $pool = $block['extras']['pool']['name'] ?? 'Unknown';
        $blocks[] = [
            'height' => (int) $block['height'],
            'time' => (int) $block['timestamp'],
            'pool' => is_string($pool) && $pool !== '' ? substr($pool, 0, 40) : 'Unknown',
        ];
    }
    return $blocks === [] ? null : $blocks;
}

/**
 * DebitMyData's reference price, in US dollars per DMD, or null if the gateway didn't answer.
 * Not a market price: the minimum rate, or the cost of mining DMD when that is higher
 * (https://docs.debitmydata.io/data/reference-price/).
 */
function dmd_price(): ?float
{
    $answer = dmd_fetch(dmd_url('DMD_PRICE_API', 'https://api.debitmydata.io') . '/v1/prices/dmd-usd');
    $usd = is_array($answer) ? ($answer['usd_per_unit'] ?? null) : null;
    return is_numeric($usd) && (float) $usd > 0 ? (float) $usd : null;
}

/**
 * The latest DebitMyData Core version tagged on GitHub ("v1.3.5"), or null. Only tags that are
 * plain version numbers count (not "v1.4.0-rc1"), the highest one, whatever order GitHub lists
 * them in.
 */
function dmd_core_tag(): ?string
{
    $cache = sys_get_temp_dir() . '/debitmydata-io-core-tag.json';
    $cached = is_file($cache) ? json_decode((string) @file_get_contents($cache), true) : null;
    $tag = is_array($cached) && is_string($cached['tag'] ?? null) ? $cached['tag'] : null;
    if (is_array($cached) && time() < (int) ($cached['next'] ?? 0)) {
        return $tag;
    }
    $repo = substr(DMD_CORE_REPO, strlen('https://github.com/'));
    $list = dmd_fetch(dmd_url('DMD_GITHUB_API', 'https://api.github.com') . '/repos/' . $repo . '/tags?per_page=100');
    $latest = null;
    foreach (is_array($list) ? $list : [] as $item) {
        $name = is_array($item) ? ($item['name'] ?? null) : null;
        if (!is_string($name) || !preg_match('/^v?\d+(\.\d+){1,3}$/', $name)) {
            continue;
        }
        if ($latest === null || version_compare(ltrim($name, 'v'), ltrim($latest, 'v'), '>')) {
            $latest = $name;
        }
    }
    $tag = $latest ?? $tag;
    $wait = $latest !== null ? DMD_CORE_TTL : DMD_CORE_RETRY;
    @file_put_contents($cache, json_encode(['tag' => $tag, 'next' => time() + $wait]), LOCK_EX);
    return $tag;
}

/** "$0.0123", "$0.001", "$1.50": enough decimals for a small price, without trailing zeros. */
function dmd_usd(?float $usd): string
{
    if ($usd === null) {
        return '—';
    }
    $text = number_format($usd, $usd < 0.01 ? 5 : ($usd < 1 ? 4 : 2));
    return '$' . preg_replace('/(\.\d{2}\d*?)0+$/', '$1', $text);
}

/** The figures, from the cache when it is recent enough. */
function dmd_stats(): array
{
    // Its own file: the earlier page's stats.php keeps a file without the blocks.
    $cache = sys_get_temp_dir() . '/debitmydata-io-stats-v2.json';
    $cached = null;
    if (is_file($cache)) {
        $cached = json_decode((string) @file_get_contents($cache), true);
        if (is_array($cached) && time() - (int) ($cached['updated'] ?? 0) < DMD_STATS_TTL) {
            return $cached;
        }
    }
    $explorer = dmd_url('DMD_EXPLORER_URL', 'https://explorer.debitmydata.io');
    $basic = dmd_fetch($explorer . '/ext/getbasicstats');
    $hashps = dmd_fetch($explorer . '/api/getnetworkhashps');
    $supply = dmd_fetch($explorer . '/ext/getmoneysupply');
    $blocks = dmd_blocks();
    $price = dmd_price();
    $stats = [
        'height' => is_array($basic) && isset($basic['block_count']) ? (int) $basic['block_count'] : null,
        'hashps' => is_numeric($hashps) ? (float) $hashps : null,
        'supply' => is_numeric($supply) ? (float) $supply : null,
        'price' => $price,
        'blocks' => $blocks ?? [],
        'updated' => time(),
    ];
    if ($stats['height'] === null && $blocks !== null) {
        $stats['height'] = $blocks[0]['height'];   // the explorer is down, the mempool explorer isn't
    }
    if (is_array($cached)) {
        // An explorer didn't answer: its last figures, not asked again for 30 seconds.
        foreach (['height', 'hashps', 'supply', 'price'] as $field) {
            $stats[$field] ??= $cached[$field] ?? null;
        }
        if ($blocks === null) {
            $stats['blocks'] = $cached['blocks'] ?? [];
        }
    }
    @file_put_contents($cache, json_encode($stats), LOCK_EX);
    return $stats;
}

/**
 * The figures as the page shows them: "144,257", "40.2" "TH/s", "5,048,995", "$0.0123", the Core
 * version with its page on GitHub ("v1.3.5", or null when GitHub hasn't answered yet), and the blocks.
 */
function dmd_stats_display(): array
{
    $stats = dmd_stats();
    $hash = '—';
    $unit = '';
    if ($stats['hashps'] !== null) {
        $value = $stats['hashps'];
        $unit = 'H/s';
        foreach (['EH/s' => 1e18, 'PH/s' => 1e15, 'TH/s' => 1e12, 'GH/s' => 1e9, 'MH/s' => 1e6] as $name => $size) {
            if ($value >= $size) {
                $value /= $size;
                $unit = $name;
                break;
            }
        }
        $hash = number_format($value, $value < 10 ? 2 : 1);
    }
    $core = dmd_core_tag();
    return [
        'height' => $stats['height'] === null ? '—' : number_format($stats['height']),
        'hashrate' => $hash,
        'hashrate_unit' => $unit,
        'supply' => $stats['supply'] === null ? '—' : number_format($stats['supply']),
        'price' => dmd_usd(isset($stats['price']) ? (float) $stats['price'] : null),
        'core' => $core,
        'core_url' => $core === null ? null : DMD_CORE_REPO . '/releases/tag/' . rawurlencode($core),
        'blocks' => $stats['blocks'] ?? [],
        'now' => time(),
    ];
}

// Opened directly: the figures as JSON.
if (realpath((string) ($_SERVER['SCRIPT_FILENAME'] ?? '')) === __FILE__) {
    header('Content-Type: application/json');
    header('Cache-Control: no-store');
    header('X-Content-Type-Options: nosniff');
    echo json_encode(dmd_stats_display());
}
