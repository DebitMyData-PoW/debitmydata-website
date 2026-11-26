<?php
/*
 * debitmydata.io, "Aurora" design: the DebitMyData PoW chain and its coin, DMD. Sora headlines,
 * Inter text, soft red glows and glass cards, light and dark. Fonts, icons and scripts are served
 * from this site; nothing is loaded from other sites. The network figures come from stats.php,
 * the content and the shared parts from lib.php.
 */
declare(strict_types=1);
require __DIR__ . '/stats.php';
require __DIR__ . '/lib.php';

$stats = dmd_stats_display();
$blocks = $stats['blocks'];
?><!doctype html>
<html lang="en" data-now="<?= time() ?>">
<head>
<?= page_head(['sora.woff2', 'inter.woff2'], '#ffffff', '#0b0a0f') ?>
</head>
<body id="top">

<div class="glow" aria-hidden="true"></div>
<?= site_header() ?>

<main>
<section class="hero">
<div class="wrap">
<?= ext(ID_SITE, '<b>New</b> Pay for your DID-LLM with DMD ' . icon('arrow'), 'pillbadge') ?>
<h1>The <span class="nw">Proof-of-Work</span> coin built for the <span class="grad">agent economy</span></h1>
<p class="lead">DMD is the native coin of the DebitMyData Proof-of-Work chain: SHA-256 mining, 150-second
blocks, no pre-mine, and a block reward that starts a new cycle once the maximum supply is reached,
instead of ending.</p>
<p class="btns"><a class="btn btn-primary" href="#wallets">Get a wallet <?= icon('arrow') ?></a>
<a class="btn btn-ghost" href="#mining">Start mining</a></p>
<ul class="perks"><li><?= icon('check') ?>No pre-mine</li><li><?= icon('clock') ?>150-second blocks</li><li><?= icon('badge') ?>Pays for DID-LLMs</li></ul>

<div class="showcase">
<div class="panel net" aria-labelledby="net-title">
<div class="panel-head"><h2 class="panel-title" id="net-title">DebitMyData network</h2><span class="live"><i></i>Live</span></div>
<dl class="net-grid" aria-live="polite">
<div><dt>Block height</dt><dd data-stat="height"><?= e($stats['height']) ?></dd></div>
<div><dt>Network hashrate</dt><dd><span data-stat="hashrate"><?= e($stats['hashrate']) ?></span> <small data-stat="hashrate_unit"><?= e($stats['hashrate_unit']) ?></small></dd></div>
<div><dt>DMD mined</dt><dd data-stat="supply"><?= e($stats['supply']) ?></dd></div>
<div><dt>Block reward</dt><dd>35 <small>DMD</small></dd></div>
<div><dt>Reference price <a class="net-info" href="<?= e(REFERENCE_PRICE) ?>" target="_blank" rel="noopener" title="Not a market price: DebitMyData's minimum rate of $0.001, or the cost of mining DMD when that is higher. It can go up or down, and the market price will replace it once DMD is listed on an exchange." aria-label="What the reference price is"><?= icon('info') ?></a></dt><dd><span data-stat="price"><?= e($stats['price']) ?></span> <small>per DMD</small></dd></div>
<?php $coreTag = $stats['core'] ?? 'v' . $core['version']; ?>
<div><dt>Latest Core version</dt><dd><a class="net-link" data-stat="core" data-stat-href="core_url" href="<?= e($stats['core_url'] ?? $core['releases']) ?>" target="_blank" rel="noopener"><?= e($coreTag) ?></a> <small>GitHub</small></dd></div>
</dl>
<div class="net-chart">
<p class="net-sub"><span>Time between the latest blocks</span><span>average <b data-average><?= e(average_time($blocks)) ?></b></span></p>
<?= block_times($blocks) ?>
<p class="net-axis"><span>older</span><span>target 150 s</span><span>newest</span></p>
</div>
<div class="net-blocks">
<p class="net-sub"><span>Latest blocks</span><?= ext(EXPLORER, 'Explorer ' . icon('arrow')) ?></p>
<?= latest_blocks($blocks, 5) ?>
</div>
</div>
<div class="showcase-side">
<?= pool_config() ?>
<div class="card mini-did">
<span class="f-ic"><?= icon('badge') ?></span>
<div><h3>DID-LLMs, paid in DMD</h3><p>A verifiable ID for an AI agent, a bot, a person or an organization: $25, paid once.</p>
<?= ext(ID_SITE, 'Get my DID-LLM ' . icon('arrow'), 'more') ?></div>
</div>
</div>
</div>
</div>
</section>

<section class="sec" id="about" aria-labelledby="about-title">
<div class="wrap">
<?= section_head('Why DMD', 'Mining that <span class="grad">never ends</span>', 'Many blockchains run out of block rewards for good. DebitMyData keeps Proof-of-Work a living system rather than a finite race that only rewards early adopters.', 'about-title') ?>
<?= why_features() ?>
</div>
</section>

<section class="sec" id="ecosystem" aria-labelledby="eco-title">
<div class="wrap">
<?= section_head('Ecosystem', 'Part of the DebitMyData ecosystem', 'An initiative exploring decentralized technologies, digital identity, artificial intelligence and the emerging Agentic Economy. The DMD chain runs as an independent Proof-of-Work network; its vision goes beyond mining.', 'eco-title') ?>
<?= ecosystem() ?>
</div>
</section>

<section class="sec" id="did" aria-labelledby="did-title">
<div class="wrap">
<div class="did-card">
<div class="did-text">
<p class="eyebrow">New · id.debitmydata.io</p>
<h2 id="did-title">Get your <span class="grad nw">DID-LLM</span>, paid in DMD</h2>
<p>A DID-LLM is a digital ID that its owner controls. DebitMyData issues them for AI agents, bots,
people and organizations, each with a credential signed by DebitMyData that anyone can check.</p>
<p class="price"><b>$25</b><span>USD, paid once · in DMD, USDC, card or PayPal</span></p>
<p class="btns"><?= ext(ID_SITE, 'Get my DID-LLM ' . icon('out'), 'btn btn-primary') ?>
<?= ext(ID_SITE . '#get-the-app', icon('phone') . ' Get the app', 'btn btn-ghost') ?></p>
<p class="small">Agents can register on their own, through the API and the MCP server at
<?= ext(API_DOCS, 'api.debitmydata.io') ?>.</p>
</div>
<?= did_steps() ?>
</div>
</div>
</section>

<section class="sec" id="roadmap" aria-labelledby="roadmap-title">
<div class="wrap">
<?= section_head('Roadmap', 'Development roadmap', 'Where DebitMyData PoW is going, and what is already done.', 'roadmap-title') ?>
<?= roadmap($roadmap) ?>
</div>
</section>

<section class="sec" id="specs" aria-labelledby="specs-title">
<div class="wrap">
<?= section_head('Specs', 'The specs', 'DebitMyData PoW works much like Bitcoin: to find a new block, miners solve a cryptographic challenge (Proof-of-Work) with the SHA-256 algorithm, which also secures each block\'s hash.', 'specs-title') ?>
<?= specs($specs) ?>
</div>
</section>

<section class="sec" id="wallets" aria-labelledby="wallets-title">
<div class="wrap">
<?= section_head('Wallets', 'Get a DMD wallet', 'Every DebitMyData wallet is non-custodial: you alone hold your keys. DebitMyData Core is the full node; DebitMyData Electrum is the light wallet, with no chain to download. DMD addresses start with <code>dm1</code>.', 'wallets-title') ?>
<?= wallets($core, $electrum) ?>
</div>
</section>

<section class="sec" id="mining" aria-labelledby="mining-title">
<div class="wrap">
<div class="mining">
<div>
<?= section_head('Mining', 'Mining <span class="grad">DMD</span>', 'DMD isn\'t listed on an exchange yet: mining is how you get it. Point any SHA-256 ASIC at the official pool, ' . ext('https://pool.debitmydata.io/', 'pool.debitmydata.io') . ', and the DMD goes to your wallet, paid right in the blocks the pool finds. Mine with the pool, or solo.', 'mining-title') ?>
<p class="btns"><?= ext('https://pool.debitmydata.io/', 'Open the pool ' . icon('out'), 'btn btn-primary') ?>
<a class="btn btn-ghost" href="#rent">Rent hashrate</a></p>
<p class="small">The default starting difficulty is 2048. The pool is NiceHash compatible: hashrate
rented from NiceHash starts automatically at NiceHash's required 500,000 difficulty.</p>
</div>
<div class="card pool-card">
<h3><?= icon('server') ?> Pool settings</h3>
<?= pool_settings() ?>
</div>
</div>

<h3 class="sub">With the pool, or solo</h3>
<?= pool_or_solo() ?>

<h3 class="sub">Mining with an ASIC</h3>
<p class="sub-lead">Settings differ between ASIC models and firmwares; the screenshots below are from an Antminer S19.</p>
<?= asic_guide() ?>
</div>
</section>

<section class="sec" id="rent" aria-labelledby="rent-title">
<div class="wrap">
<?= section_head('No ASIC?', 'Rent hashrate', 'Rent SHA-256 hashrate and point it at the pool. Make sure you rent for the <b>SHA-256</b> algorithm.', 'rent-title') ?>
<?= rent_options() ?>
<h3 class="sub">Renting an ASIC on MiningRigRentals</h3>
<?= rent_guide() ?>
</div>
</section>

<section class="sec" id="start" aria-labelledby="start-title">
<div class="wrap">
<div class="join">
<p class="eyebrow">Get started</p>
<h2 id="start-title">Join the DebitMyData network</h2>
<p class="join-lead">Get a wallet, point your rigs (or rented hashrate) at the pool, and use your DMD for
DID-LLMs and payments by AI agents. Every step is above, and the community is there to help.</p>
<p class="btns"><a class="btn btn-light" href="#wallets">Get a wallet <?= icon('arrow') ?></a>
<?= ext('https://pool.debitmydata.io/', 'Open the pool ' . icon('out'), 'btn btn-outline') ?></p>
<?= join_steps() ?>
<p class="join-help">Questions? Ask on <?= ext(DISCORD, 'Discord') ?>, follow <?= ext(X_ACCOUNT, 'DebitMyData on X') ?>,
or write to <a href="mailto:<?= CONTACT ?>"><?= CONTACT ?></a>.</p>
</div>
</div>
</section>
</main>

<?= site_footer() ?>
<script src="assets/site.js?v=5" defer></script>
</body>
</html>
