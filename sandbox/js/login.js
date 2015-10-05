/**
 * Initializes the login form with pre-filled values in case the labels are not displayed.
 */
function init(fieldSelector, defaultValue, bgColor, fgColor) {
    var currentValue = $('.umgt-fe-login ' + fieldSelector).val();

    if (currentValue.length == 0) {
        $('.umgt-fe-login ' + fieldSelector)
            .attr('value', defaultValue)
            .css('color', bgColor);
    }

    $('.umgt-fe-login ' + fieldSelector)
        .focus(function () {
            if ($(this).val() == defaultValue) {
                $(this).attr('value', '').css('color', fgColor);
            }
        })
        .blur(function () {
            if ($(this).val().length < 1) {
                $(this).attr('value', defaultValue).css('color', bgColor);
            }
        });
    $('.umgt-fe-login').submit(function () {
        var field = $(this).find(fieldSelector);
        if (field.val() == defaultValue) {
            field.attr('value', '');
        }
    });
}

/**
 * Transfers the label of the remember-me field to the field's title to keep the log-in form simple.
 */
function initStayLoggedInTitle(labelFieldSelector) {
    $('#umgt-fe-login-remember-me').attr(
        'title',
        $.trim(
            $('.umgt-fe-login label[for="' + labelFieldSelector + '"]').text()
        )
    );
}