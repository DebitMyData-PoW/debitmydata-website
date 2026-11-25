# debitmydata.io

The website of the DebitMyData Proof-of-Work chain and its coin, DMD:
**[debitmydata.io](https://debitmydata.io)**. It explains the coin, shows the network live, and
takes people from their first wallet to their first mined DMD.

![debitmydata.io, in the light and dark themes](docs/images/website-preview.webp)

## What it shows

- **The network, live**: block height, hashrate, DMD mined and the block reward, the time between
  the latest blocks against the 150-second target, and the latest blocks with the pool that found
  each one. The figures come from DebitMyData's public explorers and refresh by themselves.
- **Why DMD**: SHA-256 Proof-of-Work, nothing pre-mined, and a block reward that starts a new
  cycle once the maximum supply is reached, instead of ending.
- **The DebitMyData ecosystem**: DMD pays for DID-LLMs, DebitMyData's verifiable identities for
  AI agents, bots, people and organizations, through the
  [Agent Gateway](https://github.com/DebitMyData-PoW/agent-gateway).
- **The roadmap**, phase by phase, with what is done, in progress and planned.
- **The specs** of the chain.
- **Wallets**: DebitMyData Core and the Electrum wallet for Windows, Linux and macOS, each file
  with its SHA-256 to check the download, the web wallet and the Android app.
- **Mining**, step by step: the official pool's settings (PPLNS or solo), an ASIC's configuration
  page, the pool's wallet page and its notifications, and renting hashrate from
  MiningRigRentals or NiceHash for people without an ASIC.
- **For AI agents**: [`llms.txt`](public/llms.txt), the coin and its links in plain words.

## How it is made

- **Plain PHP**, three files: `index.php` lays out the page, `lib.php` holds the content (wallets,
  roadmap, specs, guides) and `stats.php` the network figures. No framework and no database.
- **Light on the explorers**: the figures are kept for 30 seconds, so the explorers are asked at
  most twice a minute however many people have the page open.
- **Nothing from other sites**: fonts, icons and scripts are served by the site itself.
- **Light and dark themes**, in DebitMyData's Aurora design, remembered per browser.

## The other DebitMyData sites

[Get a DID-LLM](https://id.debitmydata.io) · [Docs](https://docs.debitmydata.io) ·
[Mining pool](https://pool.debitmydata.io) · [Mempool explorer](https://mempool.debitmydata.io) ·
[Network stats](https://stats.debitmydata.io) · [On-chain analytics](https://analytics.debitmydata.io) ·
[Pool stats](https://mining.debitmydata.io)

## Installation

To run it on a server of your own, see **[INSTALL.md](INSTALL.md)**.

## License

The site's code is under the MIT license ([LICENSE](LICENSE)). The fonts (Inter, Sora and
JetBrains Mono) are under the SIL Open Font License; their license texts are in
[`public/assets/fonts`](public/assets/fonts). The DebitMyData logo, the DMD coin, the whitepaper
and the screenshots are DebitMyData's; the NiceHash and MiningRigRentals logos belong to their
owners.
