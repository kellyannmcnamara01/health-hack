
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

    // Bryan ==> Form Validation (for landing.php)
    // access form arrays for each form on page
    var loginForm = document.forms[0];
    var signupForm = document.forms[1];
    var resetForm = document.forms[2];

    console.log(loginForm,signupForm,resetForm);
    // 1.) loginForm validation
    if(loginForm){
    loginForm.onsubmit = processLogin;

    function processLogin()
    {
        var loginUser = document.querySelector("input[name=loginUser]").value;
        var loginPass =document.querySelector("input[name=loginPass]").value;

        if ((loginUser === '' || loginUser === null) && (loginPass === '' || loginPass === null))
        {
            //console.log(loginUser, loginPass);
            document.querySelector(".errorLogin").innerHTML = "Please enter a valid email and password";
            //$("#loginModal").modal({"backdrop": "static"});
            return false;
        }
    }// end of processLogin()
    }// end of condition check (if loginForm is on page)

    //2.) signupForm validation
    if(signupForm)
    {
        signupForm.onsubmit = processSignup;

        function processSignup()
        {
            var signUpFirst = document.querySelector("input[name=fName]").value;
            var signUpLast = document.querySelector("input[name=lName]").value;
            var signUpEmail = document.querySelector("input[name=email]").value;
            var signUpPass = document.querySelector("input[name=password]").value;
            //console.log(signUpFirst,signUpLast,signUpEmail,signUpPass);
            if ((signUpFirst === '' || signUpFirst === null) && (signUpLast === '' || signUpLast === null) && (signUpEmail === '' || signUpEmail === null) && (signUpPass === '' || signUpPass === null))
            {
                document.querySelector(".errorSignup").innerHTML = "Please ensure all fields are filled out before submitting the form.";
                return false;
            }
        }// end of ProcessSignup()
    }//end of condition check (if signupForm is on page)

    // 3.) resetForm validation

    if(resetForm)
    {
        resetForm.onsubmit = processReset;

        function processReset()
        {
            var Email = document.querySelector("input[name=emailReset]").value;

            if (Email === null || Email === '')
            {
                document.querySelector(".errorReset").innerHTML = "Please provide an email.";
                return false;
            }
        }// end of processRest
    }// end of condition check (if processSignup is on page)
});

//console.log("Hello World");