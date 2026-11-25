"use strict";
// debitmydata.io: the live network figures and latest blocks, cards that rise into view, the
// screenshots opened full size, the light / dark switch, in-page links that keep the address
// clean, and the phone menu closing after a choice. The page works without it.
(() => {
  const reducedMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;

  // ------------------------------------------------------------------ the live network
  // Refreshed every 30 seconds while the page is in view (stats.php keeps the figures for 30
  // seconds, so the explorers aren't asked once per visitor). The ages ("18 s ago") count on
  // every 10 seconds, from the server's clock (a phone's clock may be off).
  const REFRESH_MS = 30000;
  let clockOffset = 0; // server time - this device's time, in seconds

  const now = () => Math.floor(Date.now() / 1000) + clockOffset;
  const fmt = (n) => Number(n).toLocaleString("en-US");
  function ago(seconds) {
    seconds = Math.max(0, seconds);
    if (seconds < 60) return `${seconds} s ago`;
    if (seconds < 3600) return `${Math.floor(seconds / 60)} min ago`;
    if (seconds < 172800) return `${Math.floor(seconds / 3600)} h ago`;
    return `${Math.floor(seconds / 86400)} days ago`;
  }
  function duration(seconds) {
    const m = Math.floor(seconds / 60);
    const s = seconds % 60;
    return m > 0 ? `${m} min${s ? ` ${s} s` : ""}` : `${s} s`;
  }
  function el(tag, cls, text) {
    const node = document.createElement(tag);
    if (cls) node.className = cls;
    if (text !== undefined) node.textContent = text;
    return node;
  }

  function showBlocks(blocks) {
    if (!Array.isArray(blocks) || blocks.length === 0) return;
    for (const list of document.querySelectorAll("[data-blocks]")) {
      const count = Number(list.dataset.blocks) || 5;
      list.replaceChildren(
        ...blocks.slice(0, count).map((block) => {
          const row = el("li");
          row.append(el("span", "b-h", fmt(block.height)), el("span", "b-pool", block.pool));
          const time = el("span", "b-t", ago(now() - block.time));
          time.dataset.time = block.time;
          row.append(time);
          return row;
        })
      );
    }
    for (const chart of document.querySelectorAll("[data-times]")) {
      const bars = [el("span", "target")];
      for (let i = blocks.length - 1; i > 0; i--) {
        const gap = Math.max(1, blocks[i - 1].time - blocks[i].time);
        const bar = el("i");
        bar.style.height = `${Math.max(4, Math.min(100, Math.round((gap / 450) * 100)))}%`;
        bar.title = duration(gap);
        bars.push(bar);
      }
      chart.replaceChildren(...bars);
    }
    const span = blocks[0].time - blocks[blocks.length - 1].time;
    const average = blocks.length > 1 ? duration(Math.round(span / (blocks.length - 1))) : "—";
    for (const field of document.querySelectorAll("[data-average]")) field.textContent = average;
    for (const field of document.querySelectorAll("[data-latest-height]")) field.textContent = fmt(blocks[0].height);
    for (const field of document.querySelectorAll("[data-latest-pool]")) field.textContent = blocks[0].pool;
    for (const field of document.querySelectorAll("[data-latest-time]")) field.dataset.time = blocks[0].time;
    tick();
  }
  function tick() {
    for (const field of document.querySelectorAll("[data-time]")) {
      field.textContent = ago(now() - Number(field.dataset.time));
    }
  }

  async function refresh() {
    if (document.hidden) return;
    try {
      const response = await fetch("stats.php", { cache: "no-store" });
      if (!response.ok) return;
      const stats = await response.json();
      if (typeof stats.now === "number") clockOffset = stats.now - Math.floor(Date.now() / 1000);
      for (const field of document.querySelectorAll("[data-stat]")) {
        const value = stats[field.dataset.stat];
        if (typeof value === "string") field.textContent = value;
      }
      showBlocks(stats.blocks);
    } catch {
      // offline or the explorers unreachable: the last figures stay
    }
  }
  const page = document.documentElement;
  if (page.dataset.now) clockOffset = Number(page.dataset.now) - Math.floor(Date.now() / 1000);
  setInterval(refresh, REFRESH_MS);
  setInterval(tick, 10000);
  document.addEventListener("visibilitychange", () => {
    if (!document.hidden) refresh();
  });

  // ------------------------------------------------------------------ cards rise into view
  const selector = ".reveal-me, .grid > li, .roadmap > li, .guide > li, .stat-card, .join-steps > li, .steps > li";
  if ("IntersectionObserver" in window && !reducedMotion) {
    page.classList.add("reveal-on");
    const seen = new IntersectionObserver(
      (entries) => {
        for (const entry of entries) {
          if (!entry.isIntersecting) continue;
          entry.target.classList.add("in");
          seen.unobserve(entry.target);
        }
      },
      { rootMargin: "0px 0px -6% 0px" }
    );
    for (const item of document.querySelectorAll(selector)) {
      item.classList.add("reveal");
      seen.observe(item);
    }
  }

  // ------------------------------------------------------------------ screenshots, full size
  // A screenshot opens over the page; a tap or Escape closes it.
  const zoom = document.getElementById("zoom");
  if (zoom && typeof zoom.showModal === "function") {
    const big = zoom.querySelector("img");
    document.addEventListener("click", (event) => {
      const shot = event.target.closest("a.shot");
      if (!shot) return;
      event.preventDefault();
      const small = shot.querySelector("img");
      big.src = shot.getAttribute("href");
      big.alt = small ? small.alt : "";
      zoom.showModal();
    });
    zoom.addEventListener("click", () => zoom.close());
    zoom.addEventListener("close", () => big.removeAttribute("src"));
  }

  // ------------------------------------------------------------------ light / dark
  // The choice is saved in this site's own cookie (not shared with the explorer, the pool or
  // id.debitmydata.io, which remember their own).
  const themeButton = document.getElementById("theme-toggle");
  const themeColor = document.querySelector('meta[name="theme-color"]');
  const isDark = () => page.getAttribute("data-theme") === "dark";
  function showTheme() {
    if (themeColor) themeColor.setAttribute("content", isDark() ? themeColor.dataset.dark : themeColor.dataset.light);
    if (!themeButton) return;
    themeButton.setAttribute("aria-label", isDark() ? "Switch to the light theme" : "Switch to the dark theme");
    themeButton.title = isDark() ? "Light theme" : "Dark theme";
  }
  function saveTheme(theme) {
    try {
      localStorage.setItem("dmd-theme-site", theme);
    } catch {
      // private browsing: the cookie below is enough
    }
    const secure = location.protocol === "https:" ? "; secure" : "";
    document.cookie = `dmd-theme-site=${theme}; path=/; max-age=31536000; samesite=lax${secure}`;
  }
  showTheme();
  if (themeButton) {
    themeButton.addEventListener("click", () => {
      const theme = isDark() ? "light" : "dark";
      page.setAttribute("data-theme", theme);
      saveTheme(theme);
      showTheme();
    });
  }

  // ------------------------------------------------------------------ in-page links
  // Links to a part of this page scroll there without adding "#about", "#top"... to the
  // address, which stays https://debitmydata.io/. Without JavaScript they are ordinary links.
  const cleanAddress = () => history.replaceState(null, "", location.pathname + location.search);
  function goTo(id) {
    const target = id === "top" ? document.body : document.getElementById(id);
    if (!target) return false;
    if (id === "top") {
      window.scrollTo({ top: 0 });
    } else {
      target.scrollIntoView();
      // Keyboard and screen-reader users continue from the section, as with a normal link.
      if (!target.hasAttribute("tabindex")) target.setAttribute("tabindex", "-1");
      target.focus({ preventScroll: true });
    }
    return true;
  }
  document.addEventListener("click", (event) => {
    const link = event.target.closest ? event.target.closest('a[href^="#"]') : null;
    if (!link || event.defaultPrevented || event.button !== 0) return;
    if (event.metaKey || event.ctrlKey || event.shiftKey || event.altKey) return;
    const id = link.getAttribute("href").slice(1);
    if (!id || !goTo(id)) return;
    event.preventDefault();
    if (location.hash) cleanAddress();
  });
  // Opened with a "#part" address (a link from the pool, the explorer or id.debitmydata.io):
  // go there, then tidy the address.
  const tidy = () => {
    if (location.hash.length > 1 && goTo(decodeURIComponent(location.hash.slice(1)))) cleanAddress();
  };
  window.addEventListener("load", tidy);
  window.addEventListener("hashchange", tidy);

  // On a phone, choosing a section closes the menu.
  const toggle = document.getElementById("menu-toggle");
  for (const link of document.querySelectorAll("#site-menu a")) {
    link.addEventListener("click", () => {
      if (toggle) toggle.checked = false;
    });
  }
})();
