
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

/* Rahul Ajax Function*/
function LoadDoc(url, cFunction) {
  var xhttp;
  xhttp=new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      cFunction(this);
    }
  };
  xhttp.open("GET", url, true);
  xhttp.send();
}
/* End Here */
/* adding an exercise JOSH MCCORMICK */
$(document).ready(function(){
    var ex_Reg_Ex = /^[a-z]+\s?[a-z]+\s?[a-z]+\s?$/i;
    var number = 1;
    $('#add_ex').click(function(){
        var addEx = $('input[name=exer' +
            'cise_name]').val();
        if (!ex_Reg_Ex.test(addEx)){
            $(".exercise_error").html("You must enter a value containing only letters and a maxiumum of 3 words for the exercise name");
        }
        else {
            $(".exercise_error").html("");
            $('#ex_list').append("<input type='hidden' name='exercises[]' value='" + addEx +"'/>"
            + "<li class='exercises'>" +number + ") " +  addEx + "</li>");
            $('input[name=exercise_name]').val("");
            number ++;
        }

    });
$("#delete_ex").click(function(){
   $("#ex_list").html("");
   number = 1;
});
});

