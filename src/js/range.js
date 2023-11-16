function updateTextInput(val) {
  document.getElementById("textInput").value = val;
  document.getElementById("travel-results").value =
    "$" + Math.round(val * 0.01);
  document.getElementById("cash-back-results").value =
    "$" + Math.round(val * 0.0055);
  document.getElementById("gift-cards-results").value =
    "$" + Math.round(val * 0.01);
  document.getElementById("statement-credit-results").value =
    "$" + Math.round(val * 0.0065);
}

jQuery(document).ready(function($) {
  $(".Count").each(function(index, value) {
    jQuery({ Counter: 0 }).animate(
      { Counter: value.text() },
      {
        duration: 1000,
        easing: "swing",
        step: function() {
          value.text(Math.ceil(this.Counter));
        }
      }
    );
  });

  $(".js-range-slider").ionRangeSlider({
    min: 0,
    max: 100,
    // from: 777,
    step: 25, // default 1 (set step)
    grid: true, // default false (enable grid)
    grid_num: 4, // default 4 (set number of grid cells)
    grid_snap: true // default false (snap grid to step)
  });
});
// jQuery(document).ready(function($){
//   $('[data-calc]').each(function(index, element){
//     var type = $(this).data();
//     console.log(element);
//   });
// });