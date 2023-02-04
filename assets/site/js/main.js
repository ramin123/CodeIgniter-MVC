/*Copyright (c) 2017
[Master Stylesheet]
Theme Name : AMKON LOGISTIC-HTML Template
Version    : 1.0
Author     : Conquerors Team
Author URI : https://conquerorsmarket.com
Support    : conquerorsmarket@gmail.com*/

/*
---------------------------------------------
Table of Contents
-----------------------------------------------
Slick Slider
Mixitup - Portfolio gallery
Animations wow js
Partners gallery slider
Testimonials slider
Dropdown Menu
----------------------------------------

[Major Colors]
#d00022 ~red
#777777 ~black

[Typography]
font-family: 'Open Sans', sans-serif;
font-family: 'Poppins', sans-serif;
font-family: 'Droid Serif', sans-serif;

----------------------------------------*/


$(document).on('ready', function() {
   	  
      $('.crunch-slider1').slick({
       dots: false,
       infinite: true,
       slidesToShow: 3,
       slidesToScroll: 1,
       autoplay:true,
       arrows:true,
       nextArrow:'<i class="fa fa-angle-left crunch-left" aria-hidden="true"></i>',
       prevArrow:'<i class="fa fa-angle-right crunch-right" aria-hidden="true"></i>',
       autoplaySpeed:3000,
           responsive: [
    {
      breakpoint: 1366,
      settings: {
      arrows:false,
      dots: true,
      slidesToShow: 3,
      slidesToScroll: 1,
      }
    },
    {
      breakpoint: 1200,
      settings: {
        arrows:false,
        dots: true,
        slidesToShow: 3,
        slidesToScroll: 1,
      }
    },
    {
      breakpoint: 1024,
      settings: {
        arrows:false,
        dots: false,
        slidesToShow: 2,
        slidesToScroll: 1,
      }
    },
    {
      breakpoint: 767,
      settings: {
        arrows:false,
        dots: false,
        slidesToShow: 2,
        slidesToScroll: 1,
      }
    },
    {
      breakpoint: 600,
      settings: {
        arrows:false,
        dots: false,
        slidesToShow: 1,
        slidesToScroll: 1,
      }
    },
    {
      breakpoint: 480,
      settings: {
        arrows:false,
        dots: false,
        slidesToShow: 1,
        slidesToScroll: 1,
      }
    },
    {
      breakpoint: 300,
      settings: {
        arrows:false,
        dots: false,
        slidesToShow: 1,
        slidesToScroll: 1,
      }
    }
  ]
     });

});


$(document).on('ready', function() {
   	  
      $('.crunch-items').slick({
       dots: true,
       infinite: true,
       slidesToShow: 4,
       slidesToScroll: 1,
       autoplay:true,
       arrows:false,
       nextArrow:'<i class="fa fa-angle-left ct-left" aria-hidden="true"></i>',
       prevArrow:'<i class="fa fa-angle-right ct-right" aria-hidden="true"></i>',
       autoplaySpeed:3000,
           responsive: [
    {
      breakpoint: 1200,
      settings: {
        arrows:false,
        dots: true,
        slidesToShow: 3,
        slidesToScroll: 1,
      }
    },
      {
      breakpoint: 1024,
      settings: {
        arrows:false,
        dots: false,
        slidesToShow:3,
        slidesToScroll:1,
      }
    },         
    {
      breakpoint: 767,
      settings: {
        arrows:false,
        dots: false,
        slidesToShow:2,
        slidesToScroll:1,
      }
    },
    {
      breakpoint: 600,
      settings: {
        arrows:false,
        dots: false,
        slidesToShow:1,
        slidesToScroll:1,
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow:1,
        slidesToScroll:1,
      }
    },
    {
      breakpoint: 300,
      settings: {
        arrows:false,
        dots: false,
        slidesToShow:1,
        slidesToScroll:1,
      }
    }
  ]
});

});


$(document).on('ready', function() {
   	  
      $('.crunch-slider').slick({
       dots: true,
       infinite: true,
       slidesToShow:1,
       slidesToScroll:1,
       autoplay:true,
       arrows:false,
       nextArrow:'<i class="fa fa-angle-left ct-left" aria-hidden="true"></i>',
       prevArrow:'<i class="fa fa-angle-right ct-right" aria-hidden="true"></i>',
       autoplaySpeed:9000,
           responsive: [
    {
      breakpoint: 1200,
      settings: {
        arrows:false,
        dots: true,
        slidesToShow:1,
        slidesToScroll:1,
      }
    },
      {
      breakpoint: 1024,
      settings: {
        arrows:false,
        dots: false,
        slidesToShow:1,
        slidesToScroll:1,
      }
    },         
    {
      breakpoint: 767,
      settings: {
        arrows:false,
        dots: false,
        slidesToShow:1,
        slidesToScroll:1,
      }
    },
    {
      breakpoint: 600,
      settings: {
        arrows:false,
        dots:false,
        slidesToShow:1,
        slidesToScroll:1,
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow:1,
        slidesToScroll:1,
      }
    },
    {
      breakpoint: 300,
      settings: {
        arrows:false,
        dots: false,
        slidesToShow:1,
        slidesToScroll:1,
      }
    }
  ]
});

});


/*sliding search box */

  $(document).ready(function(){
            var submitIcon = $('.searchbox-icon');
            var inputBox = $('.searchbox-input');
            var searchBox = $('.searchbox');
            var isOpen = false;
            submitIcon.click(function(){
                if(isOpen == false){
                    searchBox.addClass('searchbox-open');
                    inputBox.focus();
                    isOpen = true;
                } else {
                    searchBox.removeClass('searchbox-open');
                    inputBox.focusout();
                    isOpen = false;
                }
            });  
             submitIcon.mouseup(function(){
                    return false;
                });
            searchBox.mouseup(function(){
                    return false;
                });
            $(document).mouseup(function(){
                    if(isOpen == true){
                        $('.searchbox-icon').css('display','block');
                        submitIcon.click();
                    }
                });
        });
            function buttonUp(){
                var inputVal = $('.searchbox-input').val();
                inputVal = $.trim(inputVal).length;
                if( inputVal !== 0){
                    $('.searchbox-icon').css('display','none');
                } else {
                    $('.searchbox-input').val('');
                    $('.searchbox-icon').css('display','block');
                }
            }


 /*Counter section*/

var count = 1;
    var countEl = document.getElementById("count");
    function plus(){
        count++;
        countEl.value = count;
    }
    function minus(){
      if (count > 1) {
        count--;
        countEl.value = count;
      }  
    }
	

$(document).on('ready', function() {
   	  
      $('.crunch-sliderd').slick({
       dots: false,
       infinite: true,
       slidesToShow: 4,
       slidesToScroll: 1,
       autoplay:true,
       arrows:true,
       nextArrow:'<i class="fa fa-angle-left crunch-left" aria-hidden="true"></i>',
       prevArrow:'<i class="fa fa-angle-right crunch-right" aria-hidden="true"></i>',
       autoplaySpeed:3000,
           responsive: [
    {
      breakpoint: 1366,
      settings: {
      arrows:false,
      dots: false,
      slidesToShow: 4,
      slidesToScroll: 1,
      }
    },
    {
      breakpoint: 1200,
      settings: {
        arrows:false,
        dots: false,
        slidesToShow: 3,
        slidesToScroll: 1,
      }
    },
    {
      breakpoint: 1024,
      settings: {
        arrows:false,
        dots: false,
        slidesToShow: 2,
        slidesToScroll: 1,
      }
    },
    {
      breakpoint: 767,
      settings: {
        arrows:false,
        dots: false,
        slidesToShow: 2,
        slidesToScroll: 1,
      }
    },
    {
      breakpoint: 600,
      settings: {
        arrows:false,
        dots: false,
        slidesToShow: 1,
        slidesToScroll: 1,
      }
    },
    {
      breakpoint: 480,
      settings: {
        arrows:false,
        dots: false,
        slidesToShow: 1,
        slidesToScroll: 1,
      }
    },
    {
      breakpoint: 300,
      settings: {
        arrows:false,
        dots: false,
        slidesToShow: 1,
        slidesToScroll: 1,
      }
    }
  ]
     });

});	
