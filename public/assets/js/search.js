$("#searchForm").keyup(function () {
  var term = $("#searchForm").val();
  var DATA = { libelle: term };
  $.ajax({
    type: "GET",
    url: "/autocomplete",
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
            data.firstname +
            " " +
            data.lastname +
            "</a></li>"
        );
      });
    },
    error: function () {
      console.log("error " + DATA);
    },
  });
});

// $("#searchForm").autocomplete({
//   source: function (request, response) {
//     $.ajax({
//       url: "/autocomplete",
//       data: {
//         query: request.term,
//       },
//       dataType: "json",
//       method: "GET",
//     }).done(function (data) {
//       response(data);
//     });
//   },
//   minLength: 3,
// });
