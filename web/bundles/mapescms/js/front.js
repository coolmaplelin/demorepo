
$(document).ready(function() {  
	$(document).foundation();
	
	$('a[href*=#]:not([href=#])').click(function() {
		if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
			var target = $(this.hash);
			target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
			if (target.length) {
				$('html,body').animate({
					scrollTop: target.offset().top
				}, 1000);
				return false;
			}
		}
	});	
	$('.main-slider').iosSlider({
		snapToChildren: true,
		autoSlide: true,
		autoSlideTimer: 5000,
		desktopClickDrag: true,
		infiniteSlider: true,
		snapSlideCenter: true,
		onSliderLoaded: slideLoaded,
		onSlideChange: slideChange,
        navSlideSelector: $(".indicator")
	});	
	
	$('.previewme[type=file]').each(function(){
            var theID =  $(this).attr("ID");

			$(this).parent().prepend('<div id="' + theID + '_preview" class="image-preview"></div>');

			var theValue = $(this).attr("imagevalue");
			if(theValue != ""){
				$("#" + theID + '_preview').css('background-image', 'url("' + theValue + '")');
			}

			$(this).change(function(){
				previewImage(this, theID + '_preview');
			});

    });  
});


function slideLoaded(args) {

	$('.dotnav .indicator:eq(' + (args.currentSlideNumber - 1) + ')').addClass('selected');
}

function slideChange(args) {
	$('.dotnav .indicator').removeClass('selected');
	$('.dotnav .indicator:eq(' + (args.currentSlideNumber - 1) + ')').addClass('selected');
}

function previewImage(input, preview_container_id) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $("#" + preview_container_id).css('background-image', 'url("' + e.target.result + '")');
        }

        reader.readAsDataURL(input.files[0]);
    }
}

