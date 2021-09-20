function onClickBtnFollow(event) {
  event.preventDefault();

  const url = this.href;
  const text = this.querySelector("span.follow");
  const spanCount = document.getElementsByClassName("span.countFollow");

  axios.get(url).then(function (response) {
    spanCount.textContent = response.data.count;
    console.log(response);
    if (text.textContent == "Suivre cette personne") {
      text.textContent = "Ne plus suivre cette personne";
    } else {
      text.textContent = "Suivre cette personne";
    }
  });
}

document.querySelectorAll("a.js-follow").forEach(function (link) {
  link.addEventListener("click", onClickBtnFollow);
});
