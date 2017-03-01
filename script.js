
/* Mobile Menu Toggle */
$(function() {
    $('.toggle-nav').click(function() {
        toggleNav();
    });
});
function toggleNav() {
    if ($('#wrapper').hasClass('show-nav')) {
        $('#wrapper').removeClass('show-nav');
    } else {
        $('#wrapper').addClass('show-nav');
    }
}
$(function() {
    $('#main').click(function() {
        toggleMain();
    });
});
function toggleMain() {
    if ($('#wrapper').hasClass('show-nav')) {
        $('#wrapper').removeClass('show-nav');
    }
}
$(function() {
    $('#mobile-menu').click(function() {
        toggleMobileMenu();
    });
});
function toggleMobileMenu() {
    if ($('#wrapper').hasClass('show-nav')) {
        $('#wrapper').removeClass('show-nav');
    }
}
