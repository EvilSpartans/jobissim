// Set cookie
$(".toggle-switch input").on("change", function () {
  if (this.checked) {
    $.cookie("layout_mood", "dark", { expires: 365, path: "/" });
    $("#template-color").attr("href", "../assets/css/dark.css");
    $(".custom-logo-link img").attr("src", "../assets/images/logo-alt.png");
  } else {
    $.removeCookie("layout_mood", { path: "/" });
    $("#template-color").attr("href", "");
    $(".custom-logo-link img").attr("src", "../assets/images/logo.png");
  }
});

if ($.cookie("layout_mood") == "dark") {
  $('.toggle-switch input[type="checkbox"]').prop("checked", true);
  $("#template-color").attr("href", "../assets/css/dark.css");
  $(".custom-logo-link img").attr("src", "../assets/images/logo-alt.png");
}
