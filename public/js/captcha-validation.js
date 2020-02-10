$(document).ready(function ($) {
    $('form').submit(function (event) {
        $.each($(this).find('input, textarea'), function (i, e) {
            if ($(this).hasClass('required')){
                if ($(this).val() == '') {
                    event.preventDefault();
                    $(this).removeClass('is-valid').addClass('is-invalid');
                    $.notify("The " + $(this).attr('name') + " field is required.", {position: "bottom right"});
                    return false;
                } else {
                    if ($(this).hasClass('email-true')) {
                        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                        if (regex.test($(this).val())) $(this).removeClass('is-invalid').addClass('is-valid');
                        else {
                            $(this).removeClass('is-valid').addClass('is-invalid');
                            event.preventDefault();
                            $.notify("Enter valid email.", {position: "bottom right"});
                            return false;
                        }
                    } else $(this).removeClass('is-invalid').addClass('is-valid');
                }
                
            }
            else if ($(this).hasClass('CaptchaValue')) captchaValidation();
            
            else $(this).removeClass('is-invalid').addClass('is-valid');
        });
    });

    function captchaValidation(){
        var CaptchaValue = $('.CaptchaValue').val();
        if (CaptchaValue) {
            if ((parseInt($('.valueOne').text()) + parseInt($('.valueTwo').text())) != parseInt(CaptchaValue)) {
                event.preventDefault();
                $('.CaptchaValue').removeClass('is-valid').addClass('is-invalid');
                $.notify("Captcha Error...!!", {position: "bottom right"});
                return false;
            } else $(this).removeClass('is-invalid').addClass('is-valid');
        } else {
            event.preventDefault();
            $('.CaptchaValue').removeClass('is-valid').addClass('is-invalid');
            $.notify("The captcha field is required.", {position: "bottom right"});
            return false;
        }
    }
});