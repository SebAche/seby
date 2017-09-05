
window.setTimeout(function () {
    $(".flash").fadeTo(600, 0).slideUp(600, function () {
        $(this).remove();
    });
}, 4000);


