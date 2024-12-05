/** Blog */

jQuery(document).ready(function(){

	/* Feature */
	$fteSlide = $('.fte-carousel');
	if($(window).width() > 991){
		$fteSlide.on('initialized.owl.carousel translate.owl.carousel', function(e){
	        idx = e.item.index;
	        $('.fte-carousel .owl-item').removeClass('in-center');
	        $('.fte-carousel .owl-item').eq(idx+1).addClass('in-center');
	    });
	}

    $fteSlide.owlCarousel({
        items: 3,
        rewind: false,
        margin: 80,
        nav: false,
        dots: true,
        loop: true,
        autoplay: true,
        autoplayTimeout: 6000,
        autoplayHoverPause: false,
        smartSpeed: 1500,
        animateOut: 'fadeOut',
        animateIn: 'fadeIn',
        navText: ['<i class="faw-angle-left"></i>', '<i class="faw-angle-right"></i>'],
        responsive : {
            0 : {
                items: 1,
                margin: 20,
            },
            576 : {
                items: 2,
                margin: 20,
            },
            768 : {
                items: 2,
                margin: 20,
            },
            992 : {
                items: 3,
                margin: 40,
            },
            1024 : {
                items: 3,
            }
        }
    });

    /* Loading */
	$('.btn-loading').on('click', function(){
		var $offset = $(this).attr('data-offset');
		console.log($offset);
		
		$.ajax({
	        type: 'POST',
	        dataType: 'json',
	        url: Gv_Main_Object.ajaxurl,
	        async: false,
	        cache: false,
	        timeout: 3000,
	        data: {
	            action: 'ajaxloadpost',
	           	offset: $offset,
	            security: Gv_Main_Object.nonce
	        },
	        beforeSend: function() {
		        $('.pst-loading').show();
		    },
	        success: function (data) {
	        	//console.log(data.result);
	            $('#pst-result').append(data.result);
	            $('.btn-loading').attr('data-offset', data.offset);
	            if(data.status == false){
	        		$('.btn-loading').attr('disabled', 'disabled');
	        	}
	        },
		    complete: function() {
		        $('.pst-loading').hide();
		    },
		    error: function(xhr) { // if error occured
	        	alert("Error occured.please try again");
	    	},
	    });
	});
});

jQuery(document).ready(function(){
    
});