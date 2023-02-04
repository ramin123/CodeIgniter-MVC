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
$(document).on('ready', function () {
    $('.ct-home-slider').slick({
        dots: false
        , infinite: true
        , slidesToShow: 1
        , slidesToScroll: 1
        , autoplay: true
        , arrows: true
        , nextArrow: '<i class="fa fa-angle-right ct-right" aria-hidden="true"></i>'
        , prevArrow: '<i class="fa fa-angle-left ct-left" aria-hidden="true"></i>'
        , autoplaySpeed: 3000
        , responsive: [
            {
                breakpoint: 1024
                , settings: {
                    arrows: false
                    , dots: true
                , }
    }
            , {
                breakpoint: 600
                , settings: {
                    slidesToScroll: 1
                , }
    }
            , {
                breakpoint: 480
                , settings: {
                    slidesToScroll: 1
                , }
    }
  ]
    });
    /*Partners Section*/
    $('.ct-partner-slider').slick({
        dots: false
        , infinite: true
        , slidesToShow: 5
        , slidesToScroll: 2
        , autoplay: true
        , arrows: true
        , autoplaySpeed: 3000
        , responsive: [
            {
                breakpoint: 1024
                , settings: {
                    slidesToShow: 4
                    , slidesToScroll: 1
                    , infinite: true
                    , dots: false
                , }
    }
            , {
                breakpoint: 600
                , settings: {
                    slidesToShow: 2
                    , slidesToScroll: 1
                , }
    }
            , {
                breakpoint: 480
                , settings: {
                    slidesToShow: 1
                    , slidesToScroll: 1
                , }
    }
  ]
    });
    /*Partners Section*/
    $('.ct-test-slider').slick({
        dots: false
        , infinite: true
        , slidesToShow: 1
        , slidesToScroll: 1
        , autoplay: true
        , arrows: true
        , autoplaySpeed: 3000
        , responsive: [
            {
                breakpoint: 1024
                , settings: {
                    slidesToShow: 1
                    , slidesToScroll: 1
                    , infinite: true
                    , dots: false
                , }
    }
            , {
                breakpoint: 991
                , settings: {
                    slidesToShow: 1
                    , slidesToScroll: 1
                    , arrows: false
                , }
    }
            , {
                breakpoint: 768
                , settings: {
                    slidesToShow: 1
                    , slidesToScroll: 1
                    , arrows: false
                , }
    }
            , {
                breakpoint: 600
                , settings: {
                    slidesToShow: 1
                    , slidesToScroll: 1
                    , arrows: false
                , }
    }
            , {
                breakpoint: 480
                , settings: {
                    slidesToShow: 1
                    , slidesToScroll: 1
                    , arrows: false
                , }
    }
            , {
                breakpoint: 300
                , settings: {
                    slidesToShow: 1
                    , slidesToScroll: 1
                    , arrows: false
                , }
    }
  ]
    });
    $('.ct-slide-left').slick({
        dots: false
        , infinite: true
        , slidesToShow: 5
        , slidesToScroll: 1
        , autoplay: true
        , arrows: true
        , nextArrow: '<i class="fa fa-angle-right ct-pfolio-r" aria-hidden="true"></i>'
        , prevArrow: '<i class="fa fa-angle-left ct-pfolio-l" aria-hidden="true"></i>'
        , autoplaySpeed: 300000
        , responsive: [
            {
                breakpoint: 1366
                , settings: {
                    slidesToShow: 5
                    , slidesToScroll: 1
                    , infinite: true
                    , dots: false
                    , arrows: false
                , }
    }, {
                breakpoint: 1024
                , settings: {
                    slidesToShow: 5
                    , slidesToScroll: 1
                    , infinite: true
                    , dots: false
                , }
    }
            , {
                breakpoint: 991
                , settings: {
                    slidesToShow: 3
                    , slidesToScroll: 1
                    , infinite: true
                    , dots: false
                    , arrows: false
                , }
    }
            , {
                breakpoint: 768
                , settings: {
                    slidesToShow: 3
                    , slidesToScroll: 1
                    , infinite: true
                    , dots: false
                    , arrows: false
                , }
    }
            , {
                breakpoint: 600
                , settings: {
                    slidesToShow: 2
                    , slidesToScroll: 1
                    , arrows: false
                , }
    }
            , {
                breakpoint: 480
                , settings: {
                    slidesToShow: 1
                    , slidesToScroll: 1
                    , arrows: false
                , }
    }
            , {
                breakpoint: 300
                , settings: {
                    slidesToShow: 1
                    , slidesToScroll: 1
                    , arrows: false
                , }
    }
  ]
    });
    /* Services-Details*/
    $('.slider-for').slick({
        slidesToShow: 1
        , slidesToScroll: 1
        , fade: true
        , prevArrow: $('.prev')
        , nextArrow: $('.next')
        , asNavFor: '.slider-nav'
    });
    $('.slider-nav').slick({
        slidesToShow: 5
        , slidesToScroll: 1
        , asNavFor: '.slider-for'
        , dots: false
        , centerMode: true
        , autoplay: true
        , arrows: true
        , nextArrow: '<i class="fa fa-angle-left ct-pd-l" aria-hidden="true"></i>'
        , prevArrow: '<i class="fa fa-angle-right ct-pd-r" aria-hidden="true"></i>'
        , focusOnSelect: true
    });
});