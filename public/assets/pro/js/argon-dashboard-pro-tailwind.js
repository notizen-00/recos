/*!

=========================================================
* Argon Dashboard 2 Pro Tailwind - v1.0.0
=========================================================

* Product Page: https://www.creative-tim.com/product/argon-dashboard-pro-tailwind
* Copyright 2022 Creative Tim (https://www.creative-tim.com)

* Coded by www.creative-tim.com

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

*/

var page_path = window.location.pathname.split("/");
var current_page = page_path.pop();
var parent_page = page_path.pop();
var root_page = page_path.pop();
var root = page_path.pop();

if (current_page == "documentation.html") {
  var to_build = "../";
} else if (current_page == "index.html" || current_page == "") {
  var to_build = "./";
} else if(root == "pages"){
  var to_build = "../../../";
}
 else {
  var to_build = "../../";
}

loadStylesheet(to_build + "assets/pro/css/perfect-scrollbar.css");
loadJS(to_build + "assets/pro/js/perfect-scrollbar.js", true);

if (document.querySelector("[slider]")) {
  loadJS(to_build + "assets/pro/js/carousel.js", true);
}

if (document.querySelector("canvas")) {
  loadJS(to_build + "assets/pro/js/charts.js", false);
}

if (document.querySelector('[data-toggle="widget-calendar"]')) {
  loadStylesheet(to_build + "assets/pro/css/full-calendar.css");
  loadJS(to_build + "assets/pro/js/full-calendar.js", false);
}

if (document.querySelector('[data-toggle="calendar"]')) {
  loadStylesheet(to_build + "assets/pro/css/full-calendar.css");
  loadJS(to_build + "assets/pro/js/full-calendar.js", false);
}

if (document.querySelector("[data-target='tooltip_trigger']")) {
  loadJS(to_build + "assets/pro/js/tooltips.js", true);
  loadStylesheet(to_build + "assets/pro/css/tooltips.css");
}
if (document.querySelector("#sliderRegular")) {
  loadStylesheet(to_build + "assets/pro/css/noui-slider.css");
  loadJS(to_build + "assets/pro/js/slider.js", true);
}

if (document.querySelector("[choice]")) {
  loadStylesheet(to_build + "assets/pro/css/choices.css");
  loadJS(to_build + "assets/pro/js/choices.js", true);
}

if (document.querySelector("#mapid.leaflet")) {
  loadStylesheet(to_build + "assets/pro/css/leaflet.css");
  loadJS(to_build + "assets/pro/js/map.js", true);
}

if (document.querySelector("[countTo]")) {
  loadJS(to_build + "assets/pro/js/count-to.js", true);
}

if (document.querySelector("[nav-pills]")) {
  if (document.querySelector("[nav-pills][aria-controls='camera-gallery']")) {
    loadJS(to_build + "assets/pro/js/pills-gallery.js", true);
  }
  if (document.querySelector("[nav-pills][aria-controls='pricing-plans']")) {
    loadJS(to_build + "assets/pro/js/pills-pricing.js", true);
  }
  loadJS(to_build + "assets/pro/js/nav-pills.js", true);
}

if (document.querySelector("[fixed-plugin]")) {
  loadJS(to_build + "assets/pro/js/fixed-plugin.js", true);
}

if (document.querySelector("aside")) {
  loadJS(to_build + "assets/pro/js/sidenav.js", true);
  if (current_page != "landing.html") {
    loadJS(to_build + "assets/pro/js/sidenav-burger.js", true);
  }
}

if (document.querySelector("[dropdown-trigger]")) {
  loadJS(to_build + "assets/pro/js/dropdown.js", true);
}

if (document.querySelector("[navbar-main]")) {
  loadJS(to_build + "assets/pro/js/navbar-sticky.js", true);
}

if (document.querySelector(".github-button")) {
  loadJS("https://buttons.github.io/buttons.js", true);
}

if (document.querySelector("[multisteps-form]")) {
  loadJS(to_build + "assets/pro/js/multisteps-form.js", true);
}

if (document.querySelector("[profile-visibility-toggle]")) {
  loadJS(to_build + "assets/pro/js/toggle.js", true);
}

// if (document.querySelector("[editor-quill]")) {
  loadStylesheet(to_build + "assets/pro/css/editor-quill.css");
  loadJS(to_build + "assets/pro/js/editor-quill.js", true);
// }

if (document.querySelector("[datetimepicker]")) {
  loadStylesheet(to_build + "assets/pro/css/flatpickr.css");
  loadJS(to_build + "assets/pro/js/flatpickr.js", true);
}

if (document.querySelector("[dropzone]")) {
  loadStylesheet(to_build + "assets/pro/css/dropzone.css");
  loadJS(to_build + "assets/pro/js/dropzone.js", true);
}

if (document.querySelector("[notification]")) {
  loadJS(to_build + "assets/pro/js/notify.js", true);
}

if (document.querySelector("[alert]")) {
  loadJS(to_build + "assets/pro/js/alert.js", true);
}

if (document.querySelector("[toast]")) {
  loadJS(to_build + "assets/pro/js/toast.js", true);
}

if (document.querySelector("[accordion]")) {
  loadJS(to_build + "assets/pro/js/accordion.js", true);
}

if (document.querySelector("[nav-nested-menu]")) {
  loadJS(to_build + "assets/pro/js/navbar-dropdown.js", true);
}

if (document.querySelector("[nav-collapse-trigger]")) {
  loadJS(to_build + "assets/pro/js/navbar-collapse.js", true);
}

if (document.querySelector("#myKanban")) {
  loadJS(to_build + "assets/pro/js/kanban.js", true);
  loadStylesheet(to_build + "assets/pro/css/kanban.css");
}

if (document.querySelector("[checkbox-color-label]")) {
  loadJS(to_build + "assets/pro/js/label-color.js", true);
}

if (document.querySelector("[data-toggle='modal']")) {
  loadJS(to_build + "assets/pro/js/modal.js", true);
}

if (document.querySelector("[datatable]")) {
  loadStylesheet(to_build + "assets/pro/css/datatable.css");
  loadJS(to_build + "assets/pro/js/datatable.js", true);
}

if (document.querySelector("[onclick^='soft.showSwal']")) {
  loadJS(to_build + "assets/pro/js/sweet-alerts.js", true);
  loadStylesheet(to_build + "assets/pro/css/sweet-alerts.css");
}

if (document.querySelector("[photo-swipe-gallery]")) {
  loadJS(to_build + "assets/pro/js/photo-swipe.js", true);
  loadStylesheet(to_build + "assets/pro/css/photo-swipe.css");
}

function loadStylesheet(FILE_URL) {
  let dynamicStylesheet = document.createElement("link");

  dynamicStylesheet.setAttribute("href", FILE_URL);
  dynamicStylesheet.setAttribute("type", "text/css");
  dynamicStylesheet.setAttribute("rel", "stylesheet");

  document.head.appendChild(dynamicStylesheet);
}

function loadJS(FILE_URL, async) {
  let dynamicScript = document.createElement("script");

  dynamicScript.setAttribute("src", FILE_URL);
  dynamicScript.setAttribute("type", "text/javascript");
  dynamicScript.setAttribute("async", async);

  document.head.appendChild(dynamicScript);
}
