//Toggle Class Active
const navbarNav = document.querySelector(".navbar-nav");
//Ketika Hamburger Menu DI Click
document.querySelector("#hamburger-menu").onclick = () => {
  navbarNav.classList.toggle("active");
};

//Click Di luar Sidebar Menghilangkan Navbarx
const hamburger = document.querySelector("#hamburger-menu");
document.addEventListener("click", function (e) {
  if (!hamburger.contains(e.target) && !navbarNav.contains(e.target)) {
    navbarNav.classList.remove("active");
  }
});
