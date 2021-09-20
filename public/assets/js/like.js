function onClickBtnLike(event) {
  event.preventDefault();

  const url = this.href;
  const icone = this.querySelector("i");
  const spanCount = this.querySelector("span.js-likes");

  axios
    .get(url)
    .then(function (response) {
      spanCount.textContent = response.data.likes;
      console.log(response);
      if (icone.classList.contains("blueIcon")) {
        icone.classList.remove("blueIcon");
        icone.style.color = "#909090";
      } else {
        icone.classList.add("blueIcon");
      }
    })
    .catch(function (error) {
      if (error.response.status === 403) {
        window.alert("Vous devez être connecté pour liker un post");
      }
    });
}

document.querySelectorAll("a.js-like").forEach(function (link) {
  link.addEventListener("click", onClickBtnLike);
});
