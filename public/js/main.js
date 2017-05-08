$(function () {
  
  
  $(window).scroll( function() {
  // apply css classes based on the situation
  if ($(".nav-bar").offset().top > 100) {
    $("html").addClass("nav-bar-opaque");
  } else {
    $("html").removeClass("nav-bar-opaque");
  }
});	
	$('.nav-bar__trigger').click(function() {
		if ($('.nav-bar').hasClass('nav-bar--mobile-show')) {
			$('.nav-bar').removeClass('nav-bar--mobile-show');
		} else {
			$('.nav-bar').addClass('nav-bar--mobile-show');
		}
	});
	
	$('.nav-bar__call').click(function() {
		if ($('.nav-bar').hasClass('nav-bar--mobile-show-call')) {
			$('.nav-bar').removeClass('nav-bar--mobile-show-call');
		} else {
			$('.nav-bar').addClass('nav-bar--mobile-show-call');
		}
	});
});


