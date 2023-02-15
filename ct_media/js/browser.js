/**
 * @file
 * Behaviors for the Entity Browser-based Media Library.
 */

(function ($, Drupal) {
  "use strict";

  Drupal.behaviors.entityBrowserSelection = {
    attach: function (context) {
      // All selectable elements which should receive the click behavior.
      var $selectables = $("[data-selectable]", context);

      // Selector for finding the actual form inputs.
      var input = 'input[name ^= "entity_browser_select"]';

      $selectables.unbind("click").click(function () {
        // Select or Unselect
        if ($(this).find(input).prop("checked") == false) {
          // Select
          $(this).addClass("selected").find(input).prop("checked", true);
        } else {
          // Unselect
          $(this)
            .addClass("selected")
            .removeClass("selected")
            .find(input)
            .prop("checked", false);
        }
      });
    },
  };
  var debounce = null;
  Drupal.behaviors.changeOnKeyUp = {
    onKeyUp: function () {
      clearTimeout(debounce);
      debounce = setTimeout(function () {
        $(this).trigger("change");
      }, 600);
    },

    attach: function (context) {
      $(".keyup-change", context).on("keyup", this.onKeyUp());
    },

    detach: function (context) {
      $(".keyup-change", context).off("keyup", this.onKeyUp());
    },
  };
})(jQuery, Drupal);
