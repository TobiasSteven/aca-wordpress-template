/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */
(function ($) {
  "use strict";

  // Site title and description.
  wp.customize("blogname", function (value) {
    value.bind(function (to) {
      $(".site-title a").text(to);
      $("header h1.text-xl").text(to);
    });
  });

  wp.customize("blogdescription", function (value) {
    value.bind(function (to) {
      $(".site-description").text(to);
      $("header p.text-[#A8E6CF]").text(to);
    });
  });

  // Header text color.
  wp.customize("header_textcolor", function (value) {
    value.bind(function (to) {
      if ("blank" === to) {
        $(".site-title, .site-description").css({
          clip: "rect(1px, 1px, 1px, 1px)",
          position: "absolute",
        });
      } else {
        $(".site-title, .site-description").css({
          clip: "auto",
          position: "relative",
        });
        $(".site-title a, .site-description").css({
          color: to,
        });
      }
    });
  });

  // Header background color
  wp.customize("header_background_color", function (value) {
    value.bind(function (to) {
      $("header.bg-[#2D9B8A]").css("background-color", to);
    });
  });

  // Navigation background color
  wp.customize("nav_background_color", function (value) {
    value.bind(function (to) {
      $(".bg-[#1F6B5C]").css("background-color", to);
      $("#mobile-menu").css("background-color", to);
    });
  });

  // CTA button text
  wp.customize("header_cta_text", function (value) {
    value.bind(function (to) {
      $(".header-cta-button").text(to);
    });
  });

  // CTA button color
  wp.customize("header_cta_color", function (value) {
    value.bind(function (to) {
      $(".bg-[#28A745]").css("background-color", to);
    });
  });

  // Primary Color.
  wp.customize("primary_color", function (value) {
    value.bind(function (to) {
      // Update link colors
      $("style#mon-theme-aca-custom-style").remove();
      $("head").append(
        '<style id="mon-theme-aca-custom-style">' +
          "a { color: " +
          to +
          "; }" +
          "a:hover { color: " +
          shadeColor(to, -30) +
          "; }" +
          '.button, button, input[type="button"], input[type="reset"], input[type="submit"] { background-color: ' +
          to +
          "; }" +
          '.button:hover, button:hover, input[type="button"]:hover, input[type="reset"]:hover, input[type="submit"]:hover { background-color: ' +
          shadeColor(to, -15) +
          "; }" +
          "</style>"
      );
    });
  });

  // Footer Text.
  wp.customize("footer_text", function (value) {
    value.bind(function (to) {
      $(".footer-text").html(to);
    });
  });

  // Helper function to adjust color brightness
  function shadeColor(color, percent) {
    let R = parseInt(color.substring(1, 3), 16);
    let G = parseInt(color.substring(3, 5), 16);
    let B = parseInt(color.substring(5, 7), 16);

    R = parseInt((R * (100 + percent)) / 100);
    G = parseInt((G * (100 + percent)) / 100);
    B = parseInt((B * (100 + percent)) / 100);

    R = R < 255 ? R : 255;
    G = G < 255 ? G : 255;
    B = B < 255 ? B : 255;

    const RR =
      R.toString(16).length === 1 ? "0" + R.toString(16) : R.toString(16);
    const GG =
      G.toString(16).length === 1 ? "0" + G.toString(16) : G.toString(16);
    const BB =
      B.toString(16).length === 1 ? "0" + B.toString(16) : B.toString(16);

    return "#" + RR + GG + BB;
  }
})(jQuery);
