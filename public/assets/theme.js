// Light or dark, applied before the page is drawn: the visitor's choice (this site's own
// "dmd-theme-site" cookie: the explorer, the pool and id.debitmydata.io keep their own), else light.
(function () {
  var t = null;
  try {
    var m = document.cookie.match(/(?:^|;\s*)dmd-theme-site=(light|dark)/);
    t = m ? m[1] : localStorage.getItem("dmd-theme-site");
  } catch (e) {}
  if (t !== "light" && t !== "dark") t = "light";
  document.documentElement.setAttribute("data-theme", t);
})();
