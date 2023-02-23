document.addEventListener("DOMContentLoaded", () => {
  if (document.getElementById("avatar") == null) {
    var id = document.getElementById("thumbnail");
  } else {
    var id = document.getElementById("avatar");
  }
  const here = document.querySelector(".here");
  id.addEventListener("change", (e) => {
    here.innerHTML = "";
    var name = e.target.files[0].name;
    here.append(name);
  });
});
