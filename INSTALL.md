# Installing the website

The site is the `public/` folder: a few PHP files, styles, fonts and images. Any web server with
PHP 8 can serve it, with no database and nothing to build. Below, `www.example.com` stands for
your own name.

## Trying it on your computer

With PHP 8 (`php -v`):

```sh
git clone https://github.com/DebitMyData-PoW/debitmydata-website.git
cd debitmydata-website/public
php -S localhost:8080
```

Then open <http://localhost:8080>. The network figures come from the public explorers, the Agent
Gateway and GitHub, so the computer needs to reach the internet for them; without it, the page
shows a dash instead (and the Core version of the downloads).

## Making it your own

Everything to change is at the top of two files:

- **`public/lib.php`**: the pool's address and fees (`POOL_STRATUM`, `POOL_FEE`, `SOLO_FEE`), the
  links (`ID_SITE`, `API_DOCS`, `EXPLORER`, `DISCORD`, `X_ACCOUNT`, `YOUTUBE`, `GITHUB`), the
  contact address and the whitepaper. Below them: the wallets offered for download (for a new
  release, its version and each file's name and SHA-256, from the release's `SHA256SUMS`), the
  roadmap (each item `done`, `now` or `next`) and the specs.
- **`public/stats.php`**: where the network figures come from. By default, an
  [eIquidus](https://github.com/team-exor/eiquidus) explorer for the height, hashrate and supply,
  a [mempool](https://github.com/mempool/mempool) explorer for the latest blocks, the
  [Agent Gateway](https://github.com/DebitMyData-PoW/agent-gateway)'s `/v1/prices/dmd-usd` for the
  reference price, and GitHub's tags of `DMD_CORE_REPO` for the latest Core version (the highest
  plain version number, asked once an hour). To try other servers without editing the file, start
  PHP with `DMD_EXPLORER_URL`, `DMD_MEMPOOL_URL`, `DMD_PRICE_API` and `DMD_GITHUB_API` set to
  their addresses.

`public/llms.txt` describes the coin for AI assistants: change its text and links too.

## Putting it online

On Ubuntu 24.04, with **nginx** and **PHP-FPM**, behind Cloudflare with a Cloudflare origin
certificate (in Cloudflare: your domain, **SSL/TLS**, **Origin Server**, **Create Certificate**;
encryption mode **Full (strict)**), saved as `/etc/ssl/cloudflare/example.com.pem` and
`/etc/ssl/cloudflare/example.com.key`. Without Cloudflare, `certbot --nginx` gives a Let's
Encrypt certificate instead.

1. **nginx, PHP and the site's folder:**

   ```sh
   sudo apt-get install -y nginx php8.3-fpm
   sudo mkdir -p /var/www/example.com
   ```

   Then copy the contents of `public/` into `/var/www/example.com` (with `scp`, `rsync` or an
   SFTP client). Only `public/` goes on the server: this file, the README and the rest of the
   repository stay out of the web folder.

2. **The nginx site**, in `/etc/nginx/sites-available/www.example.com`:

   ```nginx
   server {
       listen 443 ssl http2;
       listen [::]:443 ssl http2;
       server_name www.example.com example.com;

       ssl_certificate     /etc/ssl/cloudflare/example.com.pem;
       ssl_certificate_key /etc/ssl/cloudflare/example.com.key;

       root /var/www/example.com;
       index index.php;

       add_header X-Content-Type-Options "nosniff" always;
       add_header Referrer-Policy "strict-origin-when-cross-origin" always;
       add_header X-Frame-Options "DENY" always;
       add_header Strict-Transport-Security "max-age=31536000" always;

       location / {
           try_files $uri $uri/ =404;
       }

       # Only the page and its figures run as PHP; lib.php is included by them, never opened.
       location ~ ^/(index|stats)\.php$ {
           include snippets/fastcgi-php.conf;
           fastcgi_pass unix:/run/php/php8.3-fpm.sock;
       }
       location ~ \.php$ {
           return 404;
       }

       location /assets/ {
           add_header Cache-Control "public, max-age=604800" always;
           add_header X-Content-Type-Options "nosniff" always;
       }
   }

   server {
       listen 80;
       listen [::]:80;
       server_name www.example.com example.com;
       return 301 https://$host$request_uri;
   }
   ```

   ```sh
   sudo ln -s /etc/nginx/sites-available/www.example.com /etc/nginx/sites-enabled/
   sudo nginx -t && sudo systemctl reload nginx
   ```

3. **Check** `https://www.example.com`: the page opens, and after a few seconds the network
   figures and the latest blocks appear.

## Updating

Copy the changed files from `public/` over the ones on the server. Nothing needs restarting.
After a change to `assets/site.css` or `assets/site.js`, raise the number after `?v=` where
`lib.php` and `index.php` load them, so that browsers fetch the new file instead of the one they
kept.
