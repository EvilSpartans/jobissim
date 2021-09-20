(function ($) {
  "use strict";

  //Preloader
  $(window).on("load", function () {
    $("#preloader").delay(350).fadeOut("slow");
  });

  // Set cookie
  $(".toggle-switch input").on("change", function () {
    if (this.checked) {
      $.cookie("layout_mood", "dark", { expires: 365, path: "/" });
      $("#template-color").attr("href", "assets/css/dark.css");
      $(".custom-logo-link img").attr("src", "assets/images/logo-alt.png");
    } else {
      $.removeCookie("layout_mood", { path: "/" });
      $("#template-color").attr("href", "");
      $(".custom-logo-link img").attr("src", "assets/images/logo.png");
    }
  });

  if ($.cookie("layout_mood") == "dark") {
    $('.toggle-switch input[type="checkbox"]').prop("checked", true);
    $("#template-color").attr("href", "assets/css/dark.css");
    $(".custom-logo-link img").attr("src", "assets/images/logo-alt.png");
  }

  // .popup-video
  $(".popup-video").magnificPopup({
    disableOn: 700,
    type: "iframe",
    mainClass: "mfp-fade",
    removalDelay: 160,
    preloader: false,

    fixedContentPos: false,
  });

  // Slick RTL Support
  function rtl_slick() {
    if ($("body").hasClass("rtl")) {
      return true;
    } else {
      return false;
    }
  }

  // Banners
  $(".banners").slick({
    arrows: false,
    dots: true,
    infinite: true,
    autoplay: true,
    autoplaySpeed: 2000,
    infinite: true,
    speed: 2000,
    fade: true,
    rtl: rtl_slick(),
    slidesToShow: 1,
    slidesToScroll: 1,
    nextArrow: '<i class="fas fa-chevron-right"></i>',
    prevArrow: '<i class="fas fa-chevron-left"></i>',
  });

  // product items
  $(".video-items").slick({
    arrows: true,
    infinite: true,
    autoplay: true,
    rtl: rtl_slick(),
    slidesToShow: 3,
    slidesToScroll: 3,
    responsive: [
      {
        breakpoint: 1200,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 3,
        },
      },
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2,
        },
      },
      {
        breakpoint: 600,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
        },
      },
    ],
    nextArrow: '<i class="fas fa-chevron-right"></i>',
    prevArrow: '<i class="fas fa-chevron-left"></i>',
  });

  // Slideshow Gallery
  $(".slider-for").slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    speed: 1000,
    arrows: false,
    fade: true,
    dots: false,
    asNavFor: ".slider-nav",
    nextArrow: '<i class="fas fa-chevron-right"></i>',
    prevArrow: '<i class="fas fa-chevron-left"></i>',
  });
  $(".slider-nav").slick({
    slidesToShow: 4,
    slidesToScroll: 1,
    speed: 1000,
    asNavFor: ".slider-for",
    arrows: false,
    infinite: true,
    centerMode: true,
    focusOnSelect: true,
    responsive: [
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2,
        },
      },
      {
        breakpoint: 600,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2,
        },
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
        },
      },
    ],
  });

  $(".slider-for-vertical").slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: false,
    fade: true,
    dots: false,
    asNavFor: ".slider-nav-vertical",
    nextArrow: '<i class="fas fa-chevron-right"></i>',
    prevArrow: '<i class="fas fa-chevron-left"></i>',
  });

  $(".slider-nav-vertical").slick({
    slidesToShow: 6,
    slidesToScroll: 1,
    infinite: true,
    asNavFor: ".slider-for-vertical",
    vertical: true,
    verticalSwiping: true,
    arrows: false,
    focusOnSelect: true,
  });

  // product items tab
  $('a[data-toggle="tab"]').on("shown.bs.tab", function (e) {
    $(".product-items").slick("setPosition");
  });

  // Countdown
  $("[data-date]").each(function (i, obj) {
    var CounterID = "#" + this.id;
    // Countdown
    var countDownDate = new Date($(this).data("date")).getTime();

    // Update the count down every 1 second
    var x = setInterval(function () {
      // Get today's date and time
      var now = new Date().getTime();

      // Find the distance between now and the count down date
      var distance = countDownDate - now;

      // Time calculations for days, hours, minutes and seconds
      var days = Math.floor(distance / (1000 * 60 * 60 * 24));
      var hours = Math.floor(
        (distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
      );
      var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
      var seconds = Math.floor((distance % (1000 * 60)) / 1000);

      $(CounterID).html(`
            <div class="countdown-date">
                <span>${hours}</span> <b>:</b> <span>${minutes}</span> <b>:</b> <span>${seconds}</span>
            </div>
            `);

      // If the count down is finished, write some text
      if (distance < 0) {
        clearInterval(x);
        $(CounterID).html("EXPIRED");
      }
    }, 1000);
  });

  // Plyr
  Plyr.setup(".viewtube-player-single");

  Plyr.setup(".viewtube-player", {
    controls: ["play-large", "fullscreen", "pip"],
  });

  // My Account menu button
  $(function () {
    $(".my-account-button").on("click", function (event) {
      event.preventDefault();

      const dropdown = $(this).closest(".my-account-widget");

      if (dropdown.is(".open")) {
        dropdown.removeClass("open");
      } else {
        dropdown.addClass("open");
      }
    });

    $(document).on("click", function (event) {
      $(".my-account-widget")
        .not($(event.target).closest(".my-account-widget"))
        .removeClass("open");
    });
  });

  // Sidebar toggle
  $(".sidebar-toggle").on("click", function (event) {
    event.preventDefault();

    const dropdown = $(".sidebar-menu");

    if (dropdown.is(".open")) {
      dropdown.removeClass("open");
      $(".banners,.video-items").slick("slickRemove");
    } else {
      dropdown.addClass("open");
      $(".banners,.video-items").slick("slickRemove");
    }
  });

  $(
    ".single-video .sidebar-menu,.page-template-video-upload .sidebar-menu"
  ).removeClass("open");

  //Sidebar position Fixed after scroll
  $(window).on("scroll", function () {
    if (
      $(document).scrollTop() >
      $(".main-container").height() - $(".site-footer").height() + 100
    ) {
      $(".desktop-menu").css({
        position: "sticky",
        top: 0,
      });
    } else {
      $(".desktop-menu").css({
        position: "fixed",
        top: "unset",
      });
    }
  });

  // Newsletter Modal
  var storage = window.localStorage;
  $(window).on("load", function () {
    setTimeout(function () {
      if (storage.getItem("modal_stop") !== "true") {
        $("#newsletterModal").modal("show");
      }
    }, $("#newsletterModal").data("time"));

    $("#dont-show").on("click", function () {
      if ($(this).is(":checked")) {
        storage.setItem("modal_stop", true);
      }
    });

    $("#dont-show-hour").on("click", function () {
      storage.setItem("modal_stop", true);
    });
  });

  // Departments menu button
  $(function () {
    $(".departments-menu-button").on("click", function (event) {
      event.preventDefault();

      const dropdown = $(this).closest(".departments-container");

      if (dropdown.is(".open")) {
        dropdown.removeClass("open");
      } else {
        dropdown.addClass("open");
      }
    });

    $(document).on("click", function (event) {
      $(".departments-container")
        .not($(event.target).closest(".departments-container"))
        .removeClass("open");
    });
  });

  //Mobile Nav Hide Show
  if ($(".off-canvas-menu").length) {
    var mobileMenuContent = $(".desktop-menu>ul").html();
    $(".off-canvas-menu .navigation").append(mobileMenuContent);

    //Menu Toggle Btn
    $(".mobile-nav-toggler").on("click", function () {
      $("body").addClass("off-canvas-menu-visible");
    });

    //Menu Toggle Btn
    $(".off-canvas-menu .menu-backdrop,.off-canvas-menu .close-btn").on(
      "click",
      function () {
        $("body").removeClass("off-canvas-menu-visible");
      }
    );
  }

  $(".off-canvas-menu li.menu-item-has-children").append(
    '<div class="dropdown-btn"><span class="fa fa-angle-down"></span></div>'
  );
  $(".off-canvas-menu li.menu-item-has-children .dropdown-btn").on(
    "click",
    function () {
      $(this).prev("ul").slideToggle(500);
    }
  );

  //Back to top
  $(window).on("scroll", function () {
    if ($(this).scrollTop() >= 700) {
      $("#backtotop").fadeIn(500);
    } else {
      $("#backtotop").fadeOut(500);
    }
  });

  $("#backtotop").on("click", function () {
    $("body,html").animate(
      {
        scrollTop: 0,
      },
      500
    );
  });

  //File upload
  $("#post_videoFile_file").on("change", function (e) {
    var file = this.files[0];
    if (file) {
      $("#file-name").text(this.files[0].name);
    } else {
      alert("Fichier non valide");
    }
  });

  $("#post_imageFile_file").on("change", function (e) {
    var file = this.files[0];
    if (file) {
      $("#image-name").text(this.files[0].name);
    } else {
      alert("Fichier non valide");
    }
  });

  $("#user_avatarFile_file").on("change", function (e) {
    var file = this.files[0];
    if (file) {
      $("#avatar-name").text(this.files[0].name);
    } else {
      alert("Fichier non valide");
    }
  });

  $("#user_coverFile_file").on("change", function (e) {
    var file = this.files[0];
    if (file) {
      $("#cover-name").text(this.files[0].name);
    } else {
      alert("Fichier non valide");
    }
  });

  // Drag and drop
  $(".dropzone.video")
    .on("dragover dragenter", function () {
      $(this).addClass("is-dragover");
    })
    .on("dragleave dragend drop", function () {
      $(this).removeClass("is-dragover");
    });

  $(".dropzone.image")
    .on("dragover dragenter", function () {
      $(this).addClass("is-dragover");
    })
    .on("dragleave dragend drop", function () {
      $(this).removeClass("is-dragover");
    });
})(jQuery);
