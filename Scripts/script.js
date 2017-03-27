
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

/* adding an exercise JOSH MCCORMICK */
$(document).ready(function(){
    var ex_Reg_Ex = /^[a-z]+\s?[a-z]+\s?[a-z]+\s?$/i;
    $('#add_ex').click(function(){
        var addEx = $('input[name=exer' +
            'cise_name]').val();
        if (!ex_Reg_Ex.test(addEx)){
            $(".exercise_error").html("You must enter a value containing only letters and a maxiumum of 3 words for the exercise name");
        }
        else {
            $(".exercise_error").html("");
            $('#ex_list').append("<input type='hidden' name='exercises[]' value='" + addEx +"'/>"
            + "<li class='exercises'>" + addEx + "<input type='button' class='delete_exercise btn btn-danger offset-md-3' value='Remove'/></li>");
            $('input[name=exercise_name]').val("");
        }

    });
$('.delete_exercise').bind('click',function(){
    alert('test');
});
});

