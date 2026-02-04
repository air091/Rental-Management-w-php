const sidebarLinks = document.querySelectorAll("a");

sidebarLinks.forEach((sidebarLink) => {
  sidebarLink.addEventListener("click", () => {
    sidebarLink.classList.add("active");
  });
});
