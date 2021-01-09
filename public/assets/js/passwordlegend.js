var myInput = $("#password");
var letter = $("#letter");
var capital = $("#capital");
var number = $("#number");
var length = $("#length");
var punctuation = $("#punctuation");
// When the user clicks on the password field, show the message box
myInput.focus(function() {
$('#message').show();
});
// When the user clicks outside of the password field, hide the message box
myInput.blur(function() {
$('#message').hide();
});
// When the user starts to type something inside the password field
myInput.keyup(function() {
 var lengthicon = "";
 $('.validsecnew').hide();
  // Validate lowercase letters
  var lowerCaseLetters = /[a-z]/g;
  if(myInput.val().match(lowerCaseLetters)) {  
    letter.removeClass("invalid");
    letter.addClass("valid");
    lowerCaseLetters = true;
  } else {
    letter.removeClass("valid");
    letter.addClass("invalid");
    lowerCaseLetters = false;
  }
  
  // Validate capital letters
  var upperCaseLetters = /[A-Z]/g;
  if(myInput.val().match(upperCaseLetters)) {  
    capital.removeClass("invalid");
    capital.addClass("valid");
    upperCaseLetters = true;
  } else {
    capital.removeClass("valid");
    capital.addClass("invalid");
    upperCaseLetters = false;
  }

  // Validate numbers
  var numbers = /[0-9]/g;
  if(myInput.val().match(numbers)) {  
    number.removeClass("invalid");
    number.addClass("valid");
    numbers = true;
  } else {
    number.removeClass("valid");
    number.addClass("invalid");
    numbers = false;
  }
  var punctuations = /[ !@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/g;
  if(myInput.val().match(punctuations)) {  
    punctuation.removeClass("invalid");
    punctuation.addClass("valid");
    punctuations = true;
  } else {
    punctuation.removeClass("valid");
    punctuation.addClass("invalid");
    punctuations = false;
  }
  
  // Validate length
  if(myInput.val().length >= 8) {
    length.removeClass("invalid");
    length.addClass("valid");
    lengthicon = true;
  } else {
    length.removeClass("valid");
    length.addClass("invalid");
    lengthcon = false;
  }
  if(lowerCaseLetters && upperCaseLetters && numbers && punctuations && lengthicon) {
    $('.validsecnew').show();
    } else {
   $('.validsecnew').hide();
    }
});