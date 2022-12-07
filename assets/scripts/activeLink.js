let navLinks = document.querySelectorAll(".main-menu a");

for (let link of navLinks) {
  if (link.getAttribute("href") === window.location.pathname) {
    link.classList.add("active");
  } else {
    link.classList.remove("active");
  }
}
