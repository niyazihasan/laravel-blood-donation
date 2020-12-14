$(function () {

    // Home slider
    $('.slider').slick({
        slidesToShow: 1,
        arrows: true,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 3000,
        centerMode: true,
        focusOnSelect: true,
        dots: true,
    });

    // Function to show the Modal Enter
    $(".register").on("click", function () {
        $("#regWrapper").addClass("state");
    });

    // Call the closeModalReg function on the clicks/keyboard
    $("#regModal .modal__close, #regWrapper").on("click", function () {
        $("#regWrapper").removeClass("state");
    });

    // Function to show the Modal Register
    $(".enter").on("click", function () {
        $("#enterWrapper").addClass("state");
    });

    $("#enterModal .modal__close, #enterWrapper").on("click", function () {
        $("#enterWrapper").removeClass("state");
    });

    //user dropdown and main menu under 992px
    $(".profile__name, .angle-down").on("click", function () {
        var rotation = $(".angle-down").rotationDegrees();
        if (rotation == 0) {
            $(".angle-down").css('transform', 'rotate(' + 90 + 'deg)');
        } else {
            $(".angle-down").css('transform', 'rotate(' + 0 + 'deg)');
        }
        if ($(window).width() > 992) {
            $(".profile__menu").slideToggle("swing");
        } else {
            if ($(".profile__menu").css('display') == 'none') {
                $(".profile__menu").slideToggle("swing", function () {
                    $(".first-nav").slideToggle("swing");
                });
            } else {
                $(".first-nav").slideToggle("swing", function () {
                    $(".profile__menu").slideToggle("swing");
                });
            }
        }
    });

    // Burger menu
    $('.burger-menu').click(function () {
        $(this).toggleClass('active');
        if ($(".reg-enter-wrapper").css('display') == 'none') {
            $(".reg-enter-wrapper").slideToggle("swing", function () {
                $(".first-nav").slideToggle("swing");
            });
        } else {
            $(".first-nav").slideToggle("swing", function () {
                $(".reg-enter-wrapper").slideToggle("swing");
            });
        }
    });

    // Finding .angle-down degree
    (function ($) {
        $.fn.rotationDegrees = function () {
            var matrix = this.css("-webkit-transform") ||
                this.css("-moz-transform") ||
                this.css("-ms-transform") ||
                this.css("-o-transform") ||
                this.css("transform");
            if (typeof matrix === 'string' && matrix !== 'none') {
                var values = matrix.split('(')[1].split(')')[0].split(',');
                var a = values[0];
                var b = values[1];
                var angle = Math.round(Math.atan2(b, a) * (180 / Math.PI));
            } else {
                 var angle = 0;
            }
            return angle;
        };
    }(jQuery));

    // Search button "X" functionality
    $(".delete-result").on("click", function () {
        $('#search').val("");
        $('#hiddenVal').val("");
        $('#result').empty();
    });

    // Search button delete value
    $('#search').keyup(function(){
        $('#hiddenVal').val('');
    });

    // Green message functionality
    setTimeout(function () {
        $('.message').slideUp();
    }, 4000);

    // Tabs functionality
    $('.tabs li a').on("click", function (e) {
        e.preventDefault();
        let index = $(e.target).parent("li").index();
        $('.tabs > li a').removeClass('tab-active');
        $(e.target).addClass('tab-active');
        $(".tables").hide();
        $('.tabs-wrapper').find('.tables:eq(' + (index) + ')').show();
    });
});
