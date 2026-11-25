<?php
/*
 * debitmydata.io: the content (wallets, roadmap, specs, pool settings, the two mining guides),
 * the icons, small helpers and the parts of the page (head, top bar, footer). index.php lays the
 * page out, and stats.php gives it the network figures.
 *
 * Images and the whitepaper are linked from the site's root ("/assets/img/...", "/assets/logo/..."),
 * so the page also works when it is opened from a test folder such as /preview/.
 */
declare(strict_types=1);

const POOL_STRATUM = 'connect.debitmydata.io:8700';
const POOL_FEE = '0.5%';    // keep in step with the pool's fees (dmd.sha.conf [PPLNS] fee and solo_fee)
const SOLO_FEE = '1%';
const ID_SITE = 'https://id.debitmydata.io/';
const API_DOCS = 'https://api.debitmydata.io/docs/advanced';
const WHITEPAPER = '/DebitMyData_Whitepaper_v2.0.pdf';
const EXPLORER = 'https://mempool.debitmydata.io/';
const DISCORD = 'https://discord.gg/PSK436rP4Y';
const X_ACCOUNT = 'https://x.com/debitmydataPOW';
const YOUTUBE = 'https://youtube.com/@DebitMyData';
const GITHUB = 'https://github.com/DebitMyData-PoW';
const CONTACT = 'info@debitmydata.com';

// The wallets offered for download, with each file's SHA-256. A new release: change the version
// and the three files with their SHA-256 (from the release's SHA256SUMS).
$core = [
    'name' => 'DebitMyData Core',
    'version' => '1.3.5',
    'about' => 'The full node and desktop wallet: it keeps the whole chain and checks every block itself.',
    'base' => 'https://github.com/DebitMyData-PoW/DebitMyData-PoW-Core/releases/download/v1.3.5',
    'releases' => 'https://github.com/DebitMyData-PoW/DebitMyData-PoW-Core/releases',
    'files' => [
        ['Windows', 'monitor', 'debitmydata-1.3.5-win64.zip', 'b7f26737cc63a3224a3e1b4816b6f722cb020a051605292d2e02fd9adbaad8ce'],
        ['Linux / Ubuntu', 'terminal', 'debitmydata-1.3.5-x86_64-linux-gnu.tar.gz', 'de0d55fd37650ed50b03d9de4297e65c31d88450abbf448b4f66bbcf413033ca'],
        ['macOS', 'laptop', 'debitmydata-1.3.5-x86_64-apple-darwin.tar.gz', 'cde90061cbd6dce13936af8a684306cc093bd2301d1f75536cfce992c21b52f2'],
    ],
];
$electrum = [
    'name' => 'DebitMyData Electrum',
    'version' => '4.8.2',
    'about' => 'The light desktop wallet: no chain to download, ready in a minute.',
    'base' => 'https://github.com/DebitMyData-PoW/electrum/releases/download/4.8.2-dmd2',
    'releases' => 'https://github.com/DebitMyData-PoW/electrum/releases',
    'files' => [
        ['Windows', 'monitor', 'debitmydata-electrum-4.8.2-dmd2-setup.exe', 'b3c5b552ca2d7ba5d9fa5f8ffc404fea99f9c0e5cfd3759048a53a4f28c6e7f4'],
        ['Linux', 'terminal', 'debitmydata-electrum-4.8.2-dmd2-x86_64.AppImage', '0c73abb4ac41f4e167dcccef96e6043ea3d60696afae834213f5fffe9d4d553f'],
        ['macOS', 'laptop', 'debitmydata-electrum-4.8.2-dmd1-x86_64.dmg', '54135443f90e970abadac42b181faec4e7dd8f50b97e055d0db1b2a1548b2029'],
    ],
];

// The roadmap: done, now (in progress) or next (planned).
$roadmap = [
    ['Phase 1', 'Mainnet & infrastructure', [
        ['done', 'Mainnet launch', 'SHA-256 Proof-of-Work blockchain with 150-second block intervals'],
        ['done', 'Public mining pool', 'Deployment of dedicated SHA-256 mining infrastructure'],
        ['done', 'BIP324 v2 transport', 'Support for encrypted peer-to-peer node communication'],
        ['done', 'Electrum integration', 'Light wallet support with decentralized Electrum server infrastructure'],
        ['done', 'Non-custodial web wallet', 'Secure browser-based wallet with full user control over private keys'],
        ['done', 'Android wallet', 'Launch of non-custodial mobile wallets'],
        ['done', 'iOS wallet', 'The non-custodial web wallet installs as an app on iPhone and iPad, straight from Safari'],
        ['done', 'Pool upgrade', 'PPLNS paid in the block itself, solo mining, and a stratum tuned for the latest ASIC miners and firmwares'],
    ]],
    ['Phase 2', 'Agentics & payment integration', [
        ['done', 'Agent Gateway integration', 'Secure connection between the DMD Proof-of-Work blockchain and the DebitMyData Agentics ecosystem'],
        ['done', 'Native DMD payment gateway', 'Autonomous agents, AI systems and applications pay for services directly in DMD'],
        ['done', 'Agentic DID-LLM registration', 'Decentralized identity registration with a fixed $25 USD commercial fee, paid in approved cryptocurrencies'],
        ['done', 'Get a DID-LLM app', 'DID-LLMs for AI agents, bots, people and organizations at id.debitmydata.io, installable on phones'],
        ['done', 'Payment quote & intent API', 'Dynamic cryptocurrency pricing, payment requests and transaction tracking for autonomous agents'],
        ['done', 'MCP & API integration', 'Agents discover services, request payment quotes, verify transactions and access authorized resources'],
        ['done', 'Settlement & identity security', 'Blockchain confirmation monitoring, payment verification, wallet ownership proofs and secure DID-LLM issuance'],
        ['done', 'x402 & Bazaar integration', 'x402-compatible agentic payments in USDC on Base and automated service discovery'],
        ['done', 'Card & PayPal payments', 'DID-LLMs paid by debit or credit card, or with PayPal, in US dollars'],
        ['now', 'AI assistant connections', 'DID-LLMs and the Agent Gateway inside AI assistants such as ChatGPT, Claude, Grok and Gemini'],
        ['next', 'Multi-chain payment support', 'Payment compatibility with approved EVM, Solana and additional cryptocurrency networks'],
    ]],
    ['Phase 3', 'Blockchain expansion', [
        ['next', 'Taproot Assets', 'Research and implementation of multi-asset functionality on top of the DebitMyData blockchain'],
        ['next', 'Ordinals protocol', 'Native inscription support for digital artifacts and on-chain content'],
        ['next', 'Expanded OP_RETURN', 'Research and evaluate data anchoring capabilities up to 100 KB for document notarization'],
        ['next', 'Stratum v2', 'Advanced mining protocol support to improve mining efficiency and security'],
        ['next', 'AssumeUTXO', 'Accelerated blockchain synchronization through UTXO snapshots for decentralized node onboarding'],
    ]],
    ['Phase 4', 'Scaling & advanced transactions', [
        ['next', 'Lightning Network', 'Layer-2 payment infrastructure for near-instant, low-fee DMD transactions'],
        ['next', 'TRUC (v3) transactions', 'Enhanced transaction relay policies to improve Layer-2 channel safety and reliability'],
        ['next', 'Miniscript vaults', 'Advanced spending policies and programmable custody solutions for enhanced asset security'],
    ]],
    ['Phase 5', 'Privacy, efficiency & future security', [
        ['next', 'Silent Payments', 'Enhanced transaction privacy through reusable payment addresses'],
        ['next', 'Erlay protocol', 'More efficient transaction relay to reduce bandwidth consumption across the network'],
        ['next', 'Post-quantum security & BIP360', 'Research, audit and evaluate Pay-to-Merkle-Root (P2MR) integration to reduce exposure to potential quantum computing threats'],
    ]],
    ['Ongoing', 'Ecosystem & adoption', [
        ['done', 'Documentation website', 'Guides and API references for users, miners, developers and AI agents at docs.debitmydata.io'],
        ['done', 'Network stats & analytics', 'Chain monitoring with public statistics at stats.debitmydata.io, and on-chain analytics with an open API at analytics.debitmydata.io'],
        ['done', 'Mining pools tracker', 'Every DMD mining pool live, with block notifications, at mining.debitmydata.io'],
        ['done', 'Open-source platforms', 'The pool, explorers, Electrum wallet, stats, analytics, docs and Agent Gateway on GitHub, with install guides'],
        ['next', 'Exchange listings', 'Pursue initial and additional cryptocurrency exchange listings to expand DMD market accessibility and liquidity'],
        ['now', 'Strategic partnerships', 'Develop relationships with infrastructure providers, blockchain projects and technology partners'],
        ['next', 'Ecosystem grants', 'Support independent developers, open-source contributions and third-party ecosystem integrations'],
        ['now', 'Community & adoption', 'Expand community participation, developer resources, documentation and ecosystem awareness'],
    ]],
];

$specs = [
    ['Name', 'DebitMyData PoW'],
    ['Ticker', 'DMD'],
    ['Algorithm', 'SHA-256'],
    ['Block time', '150 seconds'],
    ['Difficulty', 'LWMA-3, 60 blocks'],
    ['Block size', '4 MB'],
    ['Block reward', '35 DMD'],
    ['Halving', 'Every 300,000 blocks'],
    ['Max supply', '21,000,000 DMD'],
    ['Pre-mined', '0 DMD'],
    ['Block maturity', '250 blocks'],
    ['Ports', 'P2P 18556 · RPC 18557'],
];

// Inline icons (24 x 24, drawn with the text colour).
function icon(string $name, string $class = 'ic'): string
{
    static $paths = [
        'block' => '<path d="M12 3l8 4.5v9L12 21l-8-4.5v-9z"/><path d="M4 7.5l8 4.5 8-4.5M12 12v9"/>',
        'bolt' => '<path d="M13 3L5 13.5h6L10 21l9-11h-6.5z"/>',
        'coins' => '<ellipse cx="12" cy="6" rx="7" ry="3"/><path d="M5 6v6c0 1.7 3.1 3 7 3s7-1.3 7-3V6"/><path d="M5 12v6c0 1.7 3.1 3 7 3s7-1.3 7-3v-6"/>',
        'clock' => '<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>',
        'cycle' => '<path d="M20 11a8 8 0 0 0-14.6-4.5L4 8"/><path d="M4 3v5h5"/><path d="M4 13a8 8 0 0 0 14.6 4.5L20 16"/><path d="M20 21v-5h-5"/>',
        'chip' => '<rect x="6" y="6" width="12" height="12" rx="2"/><path d="M10 10h4v4h-4zM9 2v4M15 2v4M9 18v4M15 18v4M2 9h4M2 15h4M18 9h4M18 15h4"/>',
        'seed' => '<path d="M12 21v-8"/><path d="M12 13c0-4.2 3-7 8-7 0 4.2-3 7-8 7z"/><path d="M12 15.5C12 12.4 9.6 10 5 10c0 3.1 2.4 5.5 7 5.5z"/>',
        'bot' => '<rect x="4" y="8" width="16" height="11" rx="3"/><path d="M12 5v3"/><circle cx="12" cy="4" r="1"/><path d="M9 13h.01M15 13h.01M9.5 16h5"/>',
        'network' => '<circle cx="12" cy="5" r="2.5"/><circle cx="5" cy="19" r="2.5"/><circle cx="19" cy="19" r="2.5"/><path d="M12 7.5v4M12 11.5L6.7 17M12 11.5l5.3 5.5"/>',
        'file' => '<path d="M14 3H6a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"/><path d="M14 3v6h6M12 12v6M9 15l3 3 3-3"/>',
        'wallet' => '<path d="M5 7V6a2 2 0 0 1 2-2h11v3"/><rect x="3" y="7" width="18" height="13" rx="2"/><path d="M16.5 13.5h.01"/>',
        'download' => '<path d="M12 3v12M7 10l5 5 5-5M4 21h16"/>',
        'monitor' => '<rect x="3" y="4" width="18" height="12" rx="2"/><path d="M8 20h8M12 16v4"/>',
        'laptop' => '<rect x="5" y="5" width="14" height="10" rx="1.5"/><path d="M3 19h18"/>',
        'terminal' => '<rect x="3" y="4" width="18" height="16" rx="2"/><path d="M7 9l3 3-3 3M12 15h5"/>',
        'globe' => '<circle cx="12" cy="12" r="9"/><path d="M3 12h18M12 3c3 3.5 3 14.5 0 18M12 3c-3 3.5-3 14.5 0 18"/>',
        'phone' => '<rect x="6" y="2" width="12" height="20" rx="3"/><path d="M11 18h2"/>',
        'server' => '<rect x="3" y="4" width="18" height="7" rx="2"/><rect x="3" y="13" width="18" height="7" rx="2"/><path d="M7 7.5h.01M7 16.5h.01"/>',
        'badge' => '<rect x="3" y="4" width="18" height="12" rx="2"/><circle cx="12" cy="10" r="2.5"/><path d="M9.5 20l2.5-1.5 2.5 1.5v-4"/>',
        'key' => '<circle cx="8" cy="15" r="4"/><path d="M11 12l9-9M16 7l3 3M14 9l2 2"/>',
        'shield' => '<path d="M12 3l8 3v6c0 5-3.5 8-8 9-4.5-1-8-4-8-9V6z"/><path d="M8.5 12l2.5 2.5 4.5-5"/>',
        'search' => '<circle cx="11" cy="11" r="7"/><path d="M20 20l-4-4"/>',
        'signal' => '<path d="M5.6 6.6a9 9 0 0 0 0 12.8M18.4 6.6a9 9 0 0 1 0 12.8"/><path d="M8.5 9.5a5 5 0 0 0 0 7M15.5 9.5a5 5 0 0 1 0 7"/><circle cx="12" cy="13" r="1.5"/>',
        'out' => '<path d="M7 17L17 7M9 7h8v8"/>',
        'arrow' => '<path d="M5 12h14M13 6l6 6-6 6"/>',
        'up' => '<path d="M12 5l-7 7m7-7l7 7M12 5v14"/>',
        'check' => '<path d="M5 12.5l4.5 4.5L19 7.5"/>',
        'dot' => '<circle cx="12" cy="12" r="4"/>',
        'moon' => '<path d="M20.5 14.2A8.5 8.5 0 1 1 9.8 3.5a6.8 6.8 0 0 0 10.7 10.7z"/>',
        'sun' => '<circle cx="12" cy="12" r="4.5"/><path d="M12 2v2.2M12 19.8V22M4.9 4.9l1.6 1.6M17.5 17.5l1.6 1.6M2 12h2.2M19.8 12H22M4.9 19.1l1.6-1.6M17.5 6.5l1.6-1.6"/>',
        'pickaxe' => '<path d="M14.5 6.5l3 3M3 21l9.5-9.5"/><path d="M5 7c4-4 10-4 14 0-2-.5-4-.4-6 .5M17 19c4-4 4-10 0-14 .5 2 .4 4-.5 6"/>',
        'chat' => '<path d="M21 12a8 8 0 0 1-11.5 7.2L4 20.5l1.3-4.8A8 8 0 1 1 21 12z"/>',
        'mail' => '<rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3.5 6.5L12 13l8.5-6.5"/>',
        'play' => '<rect x="3" y="5" width="18" height="14" rx="4"/><path d="M10 9.5v5l4.5-2.5z"/>',
        'code' => '<path d="M8 8l-4 4 4 4M16 8l4 4-4 4M13.5 5l-3 14"/>',
        'xmark' => '<path d="M5 4l14 16M19 4L5 20"/>',
        'book' => '<path d="M4 5.5A2.5 2.5 0 0 1 6.5 3H20v15H6.5A2.5 2.5 0 0 0 4 20.5z"/><path d="M4 20.5A2.5 2.5 0 0 0 6.5 23H20v-5"/>',
        'pool' => '<circle cx="12" cy="12" r="9"/><path d="M12 3v9l6.4 6.4"/>',
    ];
    return '<svg class="' . $class . '" viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" '
        . 'stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">'
        . $paths[$name] . '</svg>';
}

function e(string $text): string
{
    return htmlspecialchars($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
}

/** A link that opens in a new tab. $label is HTML (it may hold an icon). */
function ext(string $url, string $label, string $class = ''): string
{
    $cls = $class !== '' ? ' class="' . $class . '"' : '';
    return '<a' . $cls . ' href="' . e($url) . '" target="_blank" rel="noopener">' . $label . '</a>';
}

/** A screenshot from the guides, from the site's root: opens full size (in a window when scripts run). */
function shot(string $src, string $alt): string
{
    $file = rtrim((string) ($_SERVER['DOCUMENT_ROOT'] ?? ''), '/') . $src;
    $size = $file !== $src ? @getimagesize($file) : false;
    $dims = $size ? " width=\"{$size[0]}\" height=\"{$size[1]}\"" : '';
    return '<a class="shot" href="' . e($src) . '" target="_blank" rel="noopener">'
        . '<img src="' . e($src) . '" alt="' . e($alt) . '" loading="lazy" decoding="async"' . $dims . '></a>';
}

/** Opened from a folder other than the site's root (a preview): search engines leave it out. */
function is_preview(): bool
{
    $script = (string) ($_SERVER['SCRIPT_NAME'] ?? '/index.php');
    return $script !== '/index.php' && $script !== '/';
}

/* ------------------------------------------------------------------ the live network */

/** "18 s ago", "4 min ago", "2 h ago". */
function ago(int $seconds): string
{
    $seconds = max(0, $seconds);
    if ($seconds < 60) {
        return $seconds . ' s ago';
    }
    if ($seconds < 3600) {
        return intdiv($seconds, 60) . ' min ago';
    }
    if ($seconds < 172800) {
        return intdiv($seconds, 3600) . ' h ago';
    }
    return intdiv($seconds, 86400) . ' days ago';
}

/** "2 min 31 s" for an average block time. */
function duration(int $seconds): string
{
    $minutes = intdiv($seconds, 60);
    $rest = $seconds % 60;
    return $minutes > 0 ? ($minutes . ' min' . ($rest ? ' ' . $rest . ' s' : '')) : ($rest . ' s');
}

/** The latest blocks, newest first: each one's height, pool and age. Filled again by site.js. */
function latest_blocks(array $blocks, int $count = 5): string
{
    $rows = '';
    $now = time();
    foreach (array_slice($blocks, 0, $count) as $block) {
        $rows .= '<li><span class="b-h">' . number_format((int) $block['height']) . '</span>'
            . '<span class="b-pool">' . e((string) $block['pool']) . '</span>'
            . '<span class="b-t" data-time="' . (int) $block['time'] . '">' . ago($now - (int) $block['time']) . '</span></li>';
    }
    return '<ol class="blocks" data-blocks="' . $count . '">' . $rows . '</ol>';
}

/**
 * The time between the latest blocks, as bars (oldest on the left), with the 150-second target
 * as a line. Taller than the target: the block took longer than 150 seconds.
 */
function block_times(array $blocks): string
{
    $bars = '';
    $gaps = [];
    for ($i = count($blocks) - 1; $i > 0; $i--) {
        $gaps[] = max(1, (int) $blocks[$i - 1]['time'] - (int) $blocks[$i]['time']);
    }
    foreach ($gaps as $gap) {
        $height = min(100, (int) round($gap / 450 * 100));
        $bars .= '<i style="height:' . max(4, $height) . '%" title="' . duration($gap) . '"></i>';
    }
    return '<div class="times" data-times aria-hidden="true"><span class="target"></span>' . $bars . '</div>';
}

/** The average time between the latest blocks, "2 min 31 s", or "—". */
function average_time(array $blocks): string
{
    if (count($blocks) < 2) {
        return '—';
    }
    $span = (int) $blocks[0]['time'] - (int) end($blocks)['time'];
    return duration((int) round($span / (count($blocks) - 1)));
}

/* ------------------------------------------------------------------ parts of the page */

function feature(string $icon, string $title, string $text): string
{
    return '<li class="card feature"><span class="f-ic">' . icon($icon) . '</span><h3>' . $title . '</h3><p>' . $text . '</p></li>';
}

function section_head(string $eyebrow, string $title, string $lead = '', string $id = ''): string
{
    $idattr = $id !== '' ? ' id="' . $id . '"' : '';
    return '<div class="section-head"><p class="eyebrow">' . $eyebrow . '</p><h2' . $idattr . '>' . $title . '</h2>'
        . ($lead !== '' ? '<p class="lead">' . $lead . '</p>' : '') . '</div>';
}

function why_features(): string
{
    return '<ul class="grid three">'
        . feature('cycle', 'A cyclical reward', 'Once the maximum supply is reached, the block reward restarts instead of ending mining incentives altogether.')
        . feature('chip', 'Proof-of-Work, like Bitcoin', 'Miners solve a SHA-256 challenge to find each block and secure the network, with 4 MB blocks every 150 seconds.')
        . feature('seed', 'For future miners', 'Future generations of miners keep a meaningful part in network security and block production.')
        . '</ul>';
}

function ecosystem(): string
{
    return '<ul class="grid four">'
        . feature('bot', 'Payments for agents', 'DMD is being developed as a native payment and settlement layer for autonomous agents, AI-powered applications and decentralized services.')
        . feature('network', 'The Agent Gateway', 'Agents, bots and people already pay in DMD for a DebitMyData DID-LLM, through secure APIs, an MCP server and the Get a DID-LLM app.'
            . ' ' . ext(ID_SITE, 'Open the app ' . icon('arrow'), 'more'))
        . feature('signal', 'Agentic Spaces', 'DebitMyData\'s Agentic Hub, where you register agents, broadcast encrypted signals and manage neural nodes across a decentralized intelligence grid.'
            . ' ' . ext('https://agenticssocialspaces.debitmydata.com/', 'Visit Agentic Spaces ' . icon('arrow'), 'more'))
        . feature('file', 'The whitepaper', 'How DebitMyData PoW works, in detail.'
            . ' ' . ext(WHITEPAPER, 'Download the PDF ' . icon('arrow'), 'more'))
        . '</ul>'
        . '<p class="note">Planned services on the roadmap are not all operational yet. Learn more about the whole project at '
        . ext('https://debitmydata.com/', 'debitmydata.com') . '.</p>';
}

/** The four steps to a DID-LLM. */
function did_steps(): string
{
    $steps = [
        ['Tell us about it', 'A name, what it is for, and the wallet or key that will own it.'],
        ['Pay $25', 'Once, in DMD from any DMD wallet.'],
        ['Prove it is yours', 'Sign a one-time message with your wallet or key. Nothing is sent.'],
        ['Get your DID-LLM', 'Your DID-LLM document and signed credential, ready to use.'],
    ];
    $out = '';
    foreach ($steps as $i => [$title, $text]) {
        $out .= '<li><span class="n">' . ($i + 1) . '</span><div><h3>' . $title . '</h3><p>' . $text . '</p></div></li>';
    }
    return '<ol class="steps">' . $out . '</ol>';
}

function roadmap(array $roadmap): string
{
    $out = '<p class="legend"><span class="st done">Done</span><span class="st now">In progress</span><span class="st next">Planned</span></p><ol class="roadmap">';
    foreach ($roadmap as [$phase, $title, $items]) {
        $done = count(array_filter($items, fn ($item) => $item[0] === 'done'));
        $now = count(array_filter($items, fn ($item) => $item[0] === 'now'));
        $state = $done === count($items) ? ['done', 'Completed'] : ($done + $now > 0 ? ['now', 'In progress'] : ['next', 'Planned']);
        $percent = (int) round($done / count($items) * 100);
        $out .= '<li class="card phase ' . $state[0] . '"><div class="phase-top"><span class="phase-name">' . e($phase) . '</span>'
            . '<span class="badge ' . $state[0] . '">' . $state[1] . '</span></div><h3>' . e($title) . '</h3>'
            . '<div class="progress" role="img" aria-label="' . $done . ' of ' . count($items) . ' done"><i style="width:' . $percent . '%"></i></div>'
            . '<p class="count">' . $done . ' of ' . count($items) . ' done</p><ul class="items">';
        foreach ($items as [$status, $name, $text]) {
            $mark = $status === 'done' ? icon('check') : icon('dot');
            $out .= '<li class="st ' . $status . '">' . $mark . '<span><b>' . e($name) . '</b> ' . e($text)
                . ($status === 'now' ? ' <em class="tag-now">In progress</em>' : '') . '</span></li>';
        }
        $out .= '</ul></li>';
    }
    return $out . '</ol>';
}

function specs(array $specs): string
{
    $out = '<dl class="specs">';
    foreach ($specs as [$name, $value]) {
        $out .= '<div class="spec"><dt>' . e($name) . '</dt><dd>' . e($value) . '</dd></div>';
    }
    return $out . '</dl>';
}

/** One desktop wallet (Core or Electrum): its three downloads, each with its SHA-256. */
function desktop_wallet(array $wallet, string $icon): string
{
    $rows = '';
    foreach ($wallet['files'] as [$os, $osIcon, $file, $sha]) {
        $rows .= '<li class="dl"><span class="dl-os">' . icon($osIcon) . '<b>' . e($os) . '</b></span>'
            . '<span class="dl-sha" title="SHA-256 of ' . e($file) . '"><span>SHA-256</span><code>' . e($sha) . '</code></span>'
            . ext($wallet['base'] . '/' . $file, icon('download') . ' Download', 'btn btn-sm btn-primary') . '</li>';
    }
    return '<li class="card product"><div class="product-head"><span class="f-ic">' . icon($icon) . '</span><div><h3>' . e($wallet['name'])
        . ' <span class="ver">' . e($wallet['version']) . '</span></h3><p>' . e($wallet['about']) . '</p></div></div>'
        . '<ul class="downloads">' . $rows . '</ul>'
        . '<p class="product-foot">' . ext($wallet['releases'], 'All releases on GitHub ' . icon('out')) . '</p></li>';
}

function wallets(array $core, array $electrum): string
{
    return '<ul class="grid two products">' . desktop_wallet($core, 'server') . desktop_wallet($electrum, 'bolt') . '</ul>'
        . '<ul class="grid three others">'
        . '<li class="card feature"><span class="f-ic">' . icon('globe') . '</span><h3>Web wallet</h3><p>A secure wallet in your browser, with full control over your private keys.</p>'
        . ext('https://mydmd.io/', 'Open mydmd.io ' . icon('out'), 'btn btn-sm btn-ghost') . '</li>'
        . '<li class="card feature"><span class="f-ic">' . icon('phone') . '</span><h3>Android</h3><p>DMD Secure Wallet, the non-custodial DMD wallet for your phone, on Google Play.</p>'
        . ext('https://play.google.com/store/apps/details?id=com.debitmydatapow.wallet', 'Get it on Google Play ' . icon('out'), 'btn btn-sm btn-ghost') . '</li>'
        . '<li class="card feature"><span class="f-ic">' . icon('search') . '</span><h3>Check a download</h3><p>Compare the SHA-256 of the file you downloaded with the one shown here before you run it.</p>'
        . '<span class="btn-row">' . ext($core['releases'], 'Core releases ' . icon('out'), 'btn btn-sm btn-ghost')
        . ext($electrum['releases'], 'Electrum releases ' . icon('out'), 'btn btn-sm btn-ghost') . '</span></li>'
        . '</ul>';
}

/** The pool settings, as a list. */
function pool_settings(): string
{
    return '<dl class="kv">'
        . '<div><dt>Pool URL</dt><dd><code>' . POOL_STRATUM . '</code></dd></div>'
        . '<div><dt>Username</dt><dd>Your DMD address (dm1…), optionally followed by a dot and a worker name, such as <code>.S19</code></dd></div>'
        . '<div><dt>Password</dt><dd>It can be empty, or just <code>x</code>. You can set a starting difficulty such as <code>d=65536</code>. To mine solo, add <code>m=solo</code>. You can combine them: <code>d=65536,m=solo</code></dd></div>'
        . '<div><dt>Fees</dt><dd>' . POOL_FEE . ' with the pool, ' . SOLO_FEE . ' solo</dd></div>'
        . '</dl>';
}

/** What a miner types into its settings: the same pool settings, as a configuration. */
function pool_config(): string
{
    return '<div class="panel term"><div class="term-bar"><i></i><i></i><i></i><span>Miner configuration</span></div>'
        . '<pre class="term-body"><span class="c-d"># Pool</span>' . "\n"
        . '<span class="c-k">URL</span>       stratum+tcp://' . POOL_STRATUM . "\n"
        . '<span class="c-k">Username</span>  <span class="c-v">dm1q…your-address</span>.S19' . "\n"
        . '<span class="c-k">Password</span>  x' . "\n\n"
        . '<span class="c-d"># Options in the password, with a comma</span>' . "\n"
        . '<span class="c-k">d=65536</span>   <span class="c-d">starting difficulty</span>' . "\n"
        . '<span class="c-k">m=solo</span>    <span class="c-d">mine solo (fee ' . SOLO_FEE . ')</span>' . "\n\n"
        . '<span class="c-d"># PPLNS by default, fee ' . POOL_FEE . '</span></pre></div>';
}

function pool_or_solo(): string
{
    return '<ul class="grid two">'
        . feature('network', 'With the pool (PPLNS)', 'Each block the pool finds pays everyone who mined in the last stretch, in proportion to their work: steady rewards, paid to your address inside the block itself. Amounts too small for the block go to your balance and are paid out with the next balance payout. Fee ' . POOL_FEE . '.')
        . feature('chip', 'Solo', 'Your rigs look for blocks of their own: when one finds a block, the whole reward is yours, paid inside the block; until then, nothing. Best with a lot of hashrate. Add <code>m=solo</code> to the password. Fee ' . SOLO_FEE . '.')
        . '</ul><p class="note">Rewards paid in a block can be spent once the block has matured on the network (250 blocks).</p>';
}

/** A guide: numbered steps, each with its text and screenshots. */
function guide(array $steps): string
{
    $out = '<ol class="guide">';
    foreach ($steps as $i => [$title, $text, $shots]) {
        $images = '';
        foreach ($shots as [$src, $alt]) {
            $images .= shot($src, $alt);
        }
        $out .= '<li class="card"><div class="g-text"><span class="n">' . ($i + 1) . '</span><div><h4>' . $title . '</h4><p>' . $text . '</p></div></div>'
            . '<div class="g-shots' . (count($shots) > 1 ? ' two' : '') . '">' . $images . '</div></li>';
    }
    return $out . '</ol>';
}

function asic_guide(): string
{
    return guide([
        ['Open the settings', 'Depending on your ASIC\'s model and firmware, go to the <b>Settings</b> or <b>Miner Configuration</b> page.',
            [['/assets/img/guides/asic/s19.png', 'Antminer S19 miner configuration page']]],
        ['The pool\'s address', 'In the <b>Pool</b> field, type the pool\'s stratum address: <code>' . POOL_STRATUM . '</code>',
            [['/assets/img/guides/asic/s19-2.png', 'The pool field with connect.debitmydata.io:8700']]],
        ['Your DMD address', 'In the <b>Miner</b> or <b>Address</b> field, type your DMD wallet address. You can add a dot and a worker name after it (<code>.S19</code> in the second image).',
            [['/assets/img/guides/asic/s19-3.png', 'The address field with a DMD address'], ['/assets/img/guides/asic/s19-6.png', 'A DMD address followed by the worker name S19']]],
        ['The password', 'In the <b>Password</b> field, type <code>x</code>. To choose the difficulty your ASIC starts from on the pool, type it instead as <code>d=</code> and the number (<code>d=200000</code> in the second image). To mine solo, type <code>m=solo</code>, or both with a comma: <code>d=200000,m=solo</code>.',
            [['/assets/img/guides/asic/s19-4.png', 'The password field with x'], ['/assets/img/guides/asic/s19-7.png', 'A starting difficulty of 200,000 in the password field']]],
        ['Your wallet page', 'Open the ' . ext('https://pool.debitmydata.io/mywallet/?address=', 'wallet page') . ' of the mining pool, enter your DMD address and press Enter: your hashrate, your rigs, the blocks that paid you and your payouts show there.',
            [['/assets/img/guides/pool/pool_mywallet.png', 'The mining pool wallet page, where you enter your DMD address']]],
        ['The app and notifications', 'On your phone, open ' . ext('https://pool.debitmydata.io/', 'pool.debitmydata.io') . ' and tap <b>Get the app</b>. On your wallet page, <b>Turn on notifications</b> to hear about the blocks that pay you and your payouts (on an iPhone, from the app).',
            [['/assets/img/guides/pool/pool_notifications.png', 'The Notifications card of the wallet page']]],
    ]);
}

function rent_options(): string
{
    return '<ul class="grid two">'
        . '<li class="card feature"><span class="f-logo"><img src="/assets/img/guides/rental/nicehash.png" alt="" width="56" height="56" loading="lazy"></span><h3>NiceHash</h3>'
        . '<p>Ideal for higher hashrate at a reduced price. The pool starts NiceHash orders at NiceHash\'s required 500,000 difficulty by itself.</p>'
        . ext('https://www.nicehash.com/support/hash-power-marketplace', 'NiceHash marketplace ' . icon('arrow'), 'more') . '</li>'
        . '<li class="card feature"><span class="f-logo"><img src="/assets/img/guides/rental/mrr.jpg" alt="" width="56" height="56" loading="lazy"></span><h3>MiningRigRentals</h3>'
        . '<p>Great for renting the smallest hashrate possible, by the hour.</p>'
        . ext('https://www.miningrigrentals.com/helpcenter', 'MiningRigRentals help center ' . icon('arrow'), 'more') . '</li>'
        . '</ul>';
}

function rent_guide(): string
{
    return guide([
        ['Create an account', 'Go to ' . ext('https://www.miningrigrentals.com/', 'miningrigrentals.com') . ' and create a free account. Verify your email, then log in.',
            [['/assets/img/guides/rental/mrr_01.png', 'MiningRigRentals home page']]],
        ['Choose SHA-256', 'In <b>Marketplace</b>, search for <b>sha256</b> and choose <b>SHA256 Asicboost</b>: ASIC rigs that can mine DMD.',
            [['/assets/img/guides/rental/mrr_02.png', 'The Marketplace menu with SHA256 Asicboost']]],
        ['Pick a rig', 'Browse the rigs for rent (you can sort them by price, hashrate and location) and open one.',
            [['/assets/img/guides/rental/mrr_03.png', 'The list of SHA256 Asicboost rigs for rent']]],
        ['Rent now', 'On the rig\'s page, check its hashrate and price, then click <b>Rent Now!</b>',
            [['/assets/img/guides/rental/mrr_04.png', 'A rig and its Rent Now button']]],
        ['How long', 'Choose how many hours to rent it: the amount to pay shows below. Then click <b>Next</b>.',
            [['/assets/img/guides/rental/mrr_05.png', 'The rental length and the amount to pay']]],
        ['Add the pool', 'Pool host <code>' . POOL_STRATUM . '</code> (after <code>stratum+tcp://</code>), workername: your DMD address, password <code>x</code>. Then click <b>Add pool</b>.',
            [['/assets/img/guides/rental/mrr_06.png', 'The pool settings of a rental']]],
        ['Add anyway', 'If MiningRigRentals says it was unable to authenticate with the pool, click <b>Add Anyways</b>.',
            [['/assets/img/guides/rental/mrr_07.png', 'The Add Anyways button']]],
        ['Review and pay', 'The pool is added: click <b>Next</b>, check everything (above all your DMD address and the pool), and pay with one of the supported cryptocurrencies.',
            [['/assets/img/guides/rental/mrr_08.png', 'The pool added, and the Next button']]],
    ]);
}

function join_steps(): string
{
    $steps = [
        ['wallet', 'Get a wallet', 'On your computer, your phone, or the web at mydmd.io.'],
        ['pickaxe', 'Mine', 'Point a SHA-256 ASIC or rented hashrate at ' . POOL_STRATUM . '.'],
        ['bolt', 'Follow your rewards', 'On your wallet page or in the pool app, with notifications.'],
        ['badge', 'Use your DMD', 'For a DID-LLM, or for payments by AI agents and people.'],
    ];
    $out = '<ol class="join-steps">';
    foreach ($steps as $i => [$ic, $title, $text]) {
        $out .= '<li><span class="n">' . ($i + 1) . '</span><h3>' . $title . '</h3><p>' . $text . '</p></li>';
    }
    return $out . '</ol>';
}

/** The header: the coin (small), the sections, the light / dark switch, the DID-LLM button. */
function site_header(string $extra = ''): string
{
    $links = '';
    foreach ([['about', 'About'], ['roadmap', 'Roadmap'], ['specs', 'Specs'], ['wallets', 'Wallets'], ['mining', 'Mining']] as [$id, $label]) {
        $links .= '<a href="#' . $id . '">' . $label . '</a>';
    }
    return '<header class="topbar"><div class="wrap bar">'
        . '<a class="brand" href="#top" aria-label="DebitMyData PoW, back to the top"><img src="/assets/logo/64.png" srcset="/assets/logo/64.png 1x, /assets/logo/128.png 2x" alt="" width="28" height="28">'
        . '<span>DebitMyData</span><span class="brand-tag">PoW</span></a>'
        . '<input type="checkbox" id="menu-toggle" class="menu-toggle" aria-label="Menu" aria-controls="site-menu">'
        . '<nav id="site-menu" class="menu" aria-label="Sections">' . $links . '<a class="menu-did" href="#did">Get a DID-LLM</a></nav>'
        . '<div class="bar-end">'
        . '<button type="button" id="theme-toggle" class="theme-toggle" aria-label="Switch between the light and dark themes">'
        . icon('moon', 'ic moon') . icon('sun', 'ic sun') . '</button>'
        . '<a class="btn btn-sm btn-primary bar-cta" href="#did">Get a DID-LLM</a>'
        . '<label for="menu-toggle" class="menu-button" aria-hidden="true"><span></span></label>'
        . '</div>' . $extra . '</div></header>';
}

function site_footer(): string
{
    $col = fn (string $head, string $links) => '<div class="f-col"><p class="f-head">' . $head . '</p>' . $links . '</div>';
    return '<footer class="footer"><div class="wrap">'
        . '<div class="f-top"><div class="f-brand">'
        . '<a class="brand" href="#top"><img src="/assets/logo/64.png" srcset="/assets/logo/64.png 1x, /assets/logo/128.png 2x" alt="" width="28" height="28"><span>DebitMyData</span><span class="brand-tag">PoW</span></a>'
        . '<p>SHA-256 Proof-of-Work with a block reward that never ends, and the native coin of the agentic DebitMyData ecosystem.</p>'
        . '<div class="f-socs">'
        . ext(DISCORD, icon('chat') . '<span class="sr">Discord</span>', 'f-soc')
        . ext(X_ACCOUNT, icon('xmark') . '<span class="sr">X (Twitter)</span>', 'f-soc')
        . ext(YOUTUBE, icon('play') . '<span class="sr">YouTube</span>', 'f-soc')
        . ext(GITHUB, icon('code') . '<span class="sr">GitHub</span>', 'f-soc')
        . '</div></div><div class="f-cols">'
        . $col('DebitMyData PoW', '<a href="#about">About</a><a href="#roadmap">Roadmap</a><a href="#specs">Specs</a>'
            . ext(WHITEPAPER, 'Whitepaper (PDF)') . ext('https://docs.debitmydata.io/', 'Docs'))
        . $col('Get started', '<a href="#wallets">Wallets</a><a href="#mining">Mining guide</a><a href="#rent">Rent hashrate</a>'
            . ext('https://pool.debitmydata.io/', 'Mining pool'))
        . $col('Explorers &amp; stats', ext('https://mempool.debitmydata.io/', 'Mempool explorer') . ext('https://chain.debitmydata.io/', 'Lite explorer')
            . ext('https://explorer.debitmydata.io/', 'Rich list &amp; API') . ext('https://stats.debitmydata.io/', 'Network stats')
            . ext('https://analytics.debitmydata.io/', 'On-chain analytics') . ext('https://mining.debitmydata.io/', 'Pool stats'))
        . $col('Get a DID-LLM', ext(ID_SITE, 'Get a DID-LLM') . ext(API_DOCS, 'API docs') . ext('https://api.debitmydata.io/policies', 'Policies')
            . ext(ID_SITE . '#get-the-app', icon('phone') . 'Get the app', 'get-app'))
        . $col('Network', ext('https://mydmd.io/', 'Web wallet') . ext('https://github.com/DebitMyData-PoW/electrum/releases', 'Electrum wallet')
            . ext('https://github.com/DebitMyData-PoW/DebitMyData-PoW-Core', 'Source code') . ext('https://debitmydata.com/', 'debitmydata.com')
            . ext('https://agenticssocialspaces.debitmydata.com/', 'Agentic Spaces'))
        . $col('Community', ext(DISCORD, 'Discord') . ext(X_ACCOUNT, 'X (Twitter)') . ext(YOUTUBE, 'YouTube') . ext(GITHUB, 'GitHub')
            . '<a href="mailto:' . CONTACT . '">' . CONTACT . '</a>')
        . '</div></div>'
        . '<div class="f-bottom"><span>© ' . date('Y') . ' DebitMyData PoW</span><span>DMD is the native coin of the DebitMyData Proof-of-Work chain</span></div>'
        . '</div></footer>'
        . '<a class="back-to-top" href="#top" aria-label="Back to top" title="Back to top">' . icon('up') . '</a>'
        . '<dialog id="zoom" class="zoom" aria-label="Screenshot"><img alt=""></dialog>';
}

/** The page's <head>: its title, description and sharing picture, the theme colours and the fonts. */
function page_head(array $fonts, string $light, string $dark): string
{
    $preload = '';
    foreach ($fonts as $font) {
        $preload .= '<link rel="preload" href="assets/fonts/' . $font . '" as="font" type="font/woff2" crossorigin>';
    }
    return '<meta charset="utf-8">'
        . '<meta name="viewport" content="width=device-width, initial-scale=1">'
        . '<title>DebitMyData PoW · the DMD coin</title>'
        . '<meta name="description" content="DebitMyData PoW (DMD) is a SHA-256 Proof-of-Work blockchain within the DebitMyData ecosystem: wallets, mining guide, roadmap, and DMD payments for AI agents and DID-LLMs.">'
        . (is_preview() ? '<meta name="robots" content="noindex">' : '')
        . '<meta name="theme-color" content="' . $light . '" data-light="' . $light . '" data-dark="' . $dark . '">'
        . '<link rel="canonical" href="https://debitmydata.io/">'
        . '<meta property="og:type" content="website">'
        . '<meta property="og:title" content="DebitMyData PoW · Blockchain &amp; Agentic Economy">'
        . '<meta property="og:description" content="Discover DebitMyData PoW (DMD), a Proof-of-Work blockchain supporting the DebitMyData ecosystem and its vision for the Agentic Economy.">'
        . '<meta property="og:url" content="https://debitmydata.io/">'
        . '<meta property="og:image" content="https://debitmydata.io/assets/img/share.png">'
        . '<meta name="twitter:card" content="summary_large_image">'
        . '<meta name="twitter:title" content="DebitMyData PoW · Blockchain &amp; Agentic Economy">'
        . '<meta name="twitter:image" content="https://debitmydata.io/assets/img/share.png">'
        . '<link rel="icon" href="/assets/img/favicon.png">'
        . '<link rel="apple-touch-icon" href="/assets/img/apple-touch-icon.png">'
        . $preload
        . '<script src="assets/theme.js?v=2"></script>'
        . '<link rel="stylesheet" href="assets/site.css?v=6">';
}
