var collapse_triggers = document.querySelectorAll("[collapse_trigger]");
console.log(collapse_triggers)
collapse_triggers.forEach((trigger) => {
  var collapse = trigger.nextElementSibling;

  trigger.addEventListener("click", function () {
    if (trigger.getAttribute("aria-expanded") == "true") {
      var collapse_height = collapse.scrollHeight;
      close_collapse(trigger, collapse, collapse_height);
    } else {
      var collapse_height = collapse.scrollHeight;
      open_collapse(trigger, collapse, collapse_height);
    }
  });
});

function open_collapse(trigger, collapse, height) {
  console.log(trigger)
  if (current_page != "landing.html") {
    trigger.classList.remove("after:text-slate-800/50");
    trigger.classList.add("after:rotate-180", "after:text-slate-800");
  }
  trigger.classList.add("after:rotate-180");

  if (!trigger.hasAttribute("active_primary")) {
    trigger.classList.add("dark:after:text-white");
    trigger.classList.remove("dark:after:text-white/50");
  }

  collapse.classList.remove("max-h-0");
  collapse.style.maxHeight = height + "px";

  if (trigger.getAttribute("collapse_trigger") == "secondary") {
    collapse_parent = trigger.closest("div");
    parent_height = collapse_parent.scrollHeight + height;
    collapse_parent.style.maxHeight = parent_height + "px";
  }

  trigger.setAttribute("aria-expanded", "true");
}

function close_collapse(trigger, collapse, height) {
  if (current_page != "landing.html") {
    trigger.classList.remove("after:rotate-180", "after:text-slate-800");
    trigger.classList.add("after:text-slate-800/50");
  }
  trigger.classList.remove("after:rotate-180");

  if (!trigger.hasAttribute("active_primary")) {
    trigger.classList.add("dark:after:text-white/50");
    trigger.classList.remove("dark:after:text-white");
  }

  collapse.removeAttribute("style");
  collapse.classList.add("max-h-0");

  if (trigger.getAttribute("collapse_trigger") == "secondary") {
    collapse_parent = trigger.closest("div");
    parent_height = collapse_parent.scrollHeight - height;
    collapse_parent.style.maxHeight = parent_height + "px";
  }

  trigger.setAttribute("aria-expanded", "false");
}

var page = window.location.pathname.split("/").pop().split(".")[0];
var aux = window.location.pathname.split("/");

var page_name = window.location.pathname.split("/");
var current_page = page_name.pop();
var parent_page = page_name.pop();
var root_page = page_name.pop();
var root_folder = page_name.pop();



if (root_folder == "pages") {
  var a_href = "../../../pages/" + root_page + "/" + parent_page + "/" + current_page;

  var active_page = document.querySelector('a[href="' + a_href + '"]');
  var active_secondary = active_page.closest("div").previousElementSibling;

  var active_primary = active_secondary.closest("div").previousElementSibling;
  var active_primary_icon = active_primary.querySelector("div");
  var active_primary_icon_fills = active_primary_icon.querySelectorAll(".fill-slate-800");

  active_primary.setAttribute("active_primary", "");

  active_primary.nextElementSibling.style.maxHeight = active_primary.nextElementSibling.scrollHeight + active_secondary.nextElementSibling.scrollHeight + "px";
  active_secondary.nextElementSibling.style.maxHeight = active_secondary.nextElementSibling.scrollHeight + "px";
} else if(aux.includes("pages")) {
  root_folder = root_page;
  root_page = parent_page;
  parent_page = current_page;

  var a_href = "../../pages/" + root_page + "/" + parent_page;

  var active_page = document.querySelector('a[href="' + a_href + '"]');
  active_page.setAttribute("active_page", "");
  active_page.setAttribute("active_secondary", "");

  var active_primary = active_page.closest("div").previousElementSibling;
  var active_primary_icon = active_primary.querySelector("div");
  var active_primary_icon_fills = active_primary_icon.querySelectorAll(".fill-slate-800");

  active_primary.nextElementSibling.style.maxHeight = active_primary.nextElementSibling.scrollHeight + "px";
} else {
  // var a_href = "/";

  // var active_page = document.querySelector('a[href="' + a_href + '"]');
  // active_page.setAttribute("active_page", "");
  // active_page.setAttribute("active_secondary", "");

  // var active_primary = active_page.closest("div").previousElementSibling;
  // var active_primary_icon = active_primary.querySelector("div");
  // var active_primary_icon_fills = active_primary_icon.querySelectorAll(".fill-slate-800");

  // active_primary.nextElementSibling.style.maxHeight = active_primary.nextElementSibling.scrollHeight + "px"; 
}
