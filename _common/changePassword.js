"use strict";

$(document).ready(function () {
    $('#btnChangePassword').on('click', function (){
        var upperCase= new RegExp('[A-Z]'),
            lowerCase= new RegExp('[a-z]'),
            numbers = new RegExp('[0-9]'),
            specialChars = "<>@!#$%^&*()_+[]{}?:;|'\"\\,./~`-=",
            hasSpecial = false;

        var currentpassword = $('#currentpassword').val(),
            newpassword = $('#newpassword').val(),
            confirmpassword = $('#confirmpassword').val()
        
        for(var i = 0; i < specialChars.length; i++) {
            if(newpassword.indexOf(specialChars[i]) > -1){
                hasSpecial = true;
            }
        }

        if(newpassword.match(upperCase) &&
            newpassword.match(lowerCase) &&
            newpassword.match(numbers) &&
            hasSpecial) {
            
            if (newpassword != confirmpassword) {
                swal({
                    title: 'Warning!',
                    text: 'New password and confirm password does not match!',
                    icon: 'warning',
                });
            }
            else {
                $.ajax({
                    url: "changePassword_ajax.php",
                    data: {
                        currentpassword: currentpassword,
                        newpassword: newpassword
                    },
                    success: function(response) {
                        var jsonData = JSON.parse(response);
                        if (jsonData == "success") {
                            swal({
                                title: 'Success!',
                                text: 'Password has been changed!',
                                icon: 'success',
                            });
                        }
                        else {                        
                            swal({
                                title: 'Error!',
                                text: 'Old password does not match!',
                                icon: 'error',
                            });
                        }
                    }
                })
            }
        }
        else {
            swal({
                title: 'Warning!',
                text: 'Password must have 1 uppercase, 1 lowercase, 1 number and 1 special character!',
                icon: 'warning',
            });
        }
    });
});