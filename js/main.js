document.addEventListener("DOMContentLoaded", () => {
  const navItems = document.querySelector(".nav__items");
  const openNavBtn = document.querySelector("#open__nav-btn");
  const closeNavBtn = document.querySelector("#close__nav-btn");

  function getWidth() {
    return Math.max(
      document.body.scrollWidth,
      document.documentElement.scrollWidth,
      document.body.offsetWidth,
      document.documentElement.offsetWidth,
      document.documentElement.clientWidth
    );
  }

  function getHeight() {
    return Math.max(
      document.body.scrollHeight,
      document.documentElement.scrollHeight,
      document.body.offsetHeight,
      document.documentElement.offsetHeight,
      document.documentElement.clientHeight
    );
  }

  //opening dropdown menu
  openNavBtn.addEventListener("click", () => {
    navItems.style.display = "flex";
    openNavBtn.style.display = "none";
    closeNavBtn.style.display = "inline-block";
  });

  //closing dropdown menu
  closeNavBtn.addEventListener("click", () => {
    navItems.style.display = "none";
    closeNavBtn.style.display = "none";
    openNavBtn.style.display = "inline-block";
  });

  const sidebar = document.querySelector("aside");
  const showSidebarBtn = document.querySelector("#show__sidebar-btn");
  const hideSidebarBtn = document.querySelector("#hide__sidebar-btn");

  //opening sidebar menu
  showSidebarBtn.addEventListener("click", () => {
    sidebar.style.left = "0";
    showSidebarBtn.style.display = "none";
    hideSidebarBtn.style.display = "inline-block";
  });

  //closing sidebar menu
  hideSidebarBtn.addEventListener("click", () => {
    sidebar.style.left = "-100%";
    hideSidebarBtn.style.display = "none";
    showSidebarBtn.style.display = "inline-block";
  });

  // if (
  //   document.querySelector(".container.nav__container").offsetWidth <= "1440px"
  // ) {
  //   document.querySelector(".nav__items").style.display = "flex";
  // }
});
