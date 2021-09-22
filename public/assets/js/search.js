$("#searchForm").keyup(function () {
  var term = $("#searchForm").val();
  var DATA = { libelle: term };
  $.ajax({
    type: "POST",
    url: "{{ path('autocomplete')}}",
    data: DATA,
    success: function (data) {
      $.each(data, function (k, el) {
        $(".datafetch").html("<ul></ul>");
        $("ul").append(
          '<li><a href="/account_' +
            data.id +
            '"><img src="/uploads/avatars/' +
            data.image +
            '" class="avatar" /> @ ' +
            data.title +
            "</a></li>"
        );
      });
    },
    error: function () {
      console.log("error " + DATA);
    },
  });
});
