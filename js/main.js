$(document).ready(function() {
    try {
        $.browserSelector();
        if ($("html").hasClass("chrome")) {
            $.smoothScroll();
        }
    } catch (err) {

    };

});
$(document).ready(function() {
    $('a[href*=#].href').bind("click", function(e) {
        var anchor = $(this);
        $('html, body').stop().animate({
            scrollTop: $(anchor.attr('href')).offset().top
        }, 1000);
        e.preventDefault();
    });
    return false;
});
jQuery( document ).ready(function( $ ) {
    $( '#item-five-slider' ).sliderPro({
        width: 1170,
        height: 500,
        arrows: true,
        fadeArrows: false,
        buttons: true,
        waitForLayers: true,
        autoplay: false,
        autoScaleLayers: false,
        breakpoints: {
            960: {
                width: '98%',
                height: 300
            },
            480: {
                width: '96%',
                height: 180
            }
        }
    });
    $( '#item-six-slider' ).sliderPro({
        width: '25%',
        height: 300,
        arrows: true,
        fadeArrows: false,
        buttons: false,
        startSlide: 1,
        aspectRatio: 1,
        visibleSize: '100%',
        forceSize: 'none',
        breakpoints: {
            960: {
                width: '33%'
            },
            480: {
                width: '50%',
                slideDistance: 20
            }
        }
    });
    $(".fancybox").fancybox();
});
document.getElementById('formmail').addEventListener('submit', function(evt){
    var http = new XMLHttpRequest(), f = this;
    evt.preventDefault();
    http.open("POST", "form.php", true);
    http.onreadystatechange = function() {
        if (http.readyState == 4 && http.status == 200) {
            $('.result p').html('Ваш запрос отправлен куратору. Ответ придет вам на e-mail.')
            $('#formmail').fadeOut(800);
            setTimeout(function() {
                $('.result').fadeIn(800);
            }, 800);
        }
    }
    http.onerror = function() {
        $('.result p').html('Ваше сообщение не отправлено!');
        $('#formmail').fadeOut(800);
        setTimeout(function() {
            $('.result').fadeIn(800);
        }, 800);
    }
    http.send(new FormData(f));
}, false);