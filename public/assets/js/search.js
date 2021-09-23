$(document).ready(function () {
  $("#tags").autocomplete({
    source: function (request, response) {
      $.ajax({
        type: "GET",
        url: "/autocomplete",
        dataType: "json",
        data: {
          searchText: request.search,
        },
        success: function (data) {
          response(
            $.map(data, function (item) {
              return {
                label: item.name,
                value: item.id,
              };
            })
          );
        },
      });
    },
    appendTo: ".datafetch",
    minLength: 4,
  });
});
