// \public\assets\js\function.js
jQuery(document).ready(function() {

  // Tabs
  jQuery('.box-menu a').on('click', function(e) {
    var currentAttrValue = jQuery(this).attr('href');
    jQuery('.tab-content ' + currentAttrValue).slideDown(400).siblings().slideUp(400);
    jQuery(this).parent('li').addClass('active').siblings().removeClass('active');
    e.preventDefault();
  });
  jQuery('.openit').click(function(i) {
    jQuery('#modal-1, #modal-2').addClass('inAnimation');
    jQuery('#modal-1, #modal-2').removeClass('outAnimation');
    jQuery('.box-menu ul li:first-child').addClass('active');
    jQuery('.box').hide();
    jQuery('.box#start').show();
    jQuery('.openit').fadeOut(200);
  });

$('#unit_slider, #breakdown_slider').slick({
  slidesToShow: 3,
  slidesToScroll: 1,
  autoplay: false,
});

$('#handicappers_slider').slick({
  slidesToShow: 5,
  slidesToScroll: 1,
  centerMode: true,
  centerPadding: '0px',
  autoplay: false,
  responsive: [
  {
    breakpoint: 1024,
    settings: {
      slidesToShow: 3,
    }
  },
  {
    breakpoint: 600,
    settings: {
      slidesToShow: 2,
    }
  },
  {
    breakpoint: 480,
    settings: {
      slidesToShow: 1,
    }
  }
  ]
});

$('.packagebox_slider').slick({
  slidesToShow: 3,
  slidesToScroll: 1,
  centerMode: true,
  centerPadding: '0px',
  autoplay: false,
  responsive: [
  {
    breakpoint: 1024,
    settings: {
      slidesToShow: 2,
    }
  },
  {
    breakpoint: 600,
    settings: {
      slidesToShow: 1,
    }
  },
  {
    breakpoint: 480,
    settings: {
      slidesToShow: 1,
    }
  }
  ]
});

function reinitializeSlider(classs) {
  $('.'+classs).slick('unslick'); /* ONLY remove the classses and handlers added on initialize */
  $('.'+classs).slick(getSliderSettings()); /* Initialize the slick again */
}

});
