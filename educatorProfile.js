
/*
Author: Phuong Linh Bui (5624095)
 */
$(document).ready(function () {
    $("#username").prop("disabled", true);
    $("#password1").prop("disabled", true);
    $("#email").prop("disabled", true);
    $("#location").prop('disabled', true);
    $(".validate").prop('disabled', true);
    $("#changeButton").addClass("hide");
    $(".removeCell").addClass("hide");
    $(".addCell").addClass("hide");
    $(".saveButtonDiv").addClass("hide");
    $(".passwordComfirmationRow").addClass("hide");
    $("#saveButtonDiv").addClass("hide");
    $("#editButtonDiv").removeClass("hide");
    $('#location').material_select();

    //Places error element next to invalid inputs
    $.validator.setDefaults({
        errorElement: 'div',
        errorClass: 'invalid',
        errorPlacement: function (error, element) {
            var e = document.createElement("div");
            $(e).append(error.text()).addClass("showError");
            if (element.attr('type') == "text" || element.attr('type') == "email" || element.attr('type') == "password") {
                $(element).nextAll("div").remove();
                $(element)
                    .closest("form")
                    .find("input[name='" + element.attr("id") + "']")
                    .after(e);
            } else if (element.hasClass("materialSelect")) {
                $(element).next("div").remove();
                $(element).after(e);
            }
        },
        success: function (div) {
            $(div).remove();
        }
    });
    //password regular expressions
    $.validator.addMethod("pwcheck", function (value) {
        var regex = /^(?!.*\s)(?=.*\d)(?=.*[a-z]).{5,}$/;
        return regex.test(value);
    });
    //email regular expressions
    $.validator.addMethod("emailvalidate", function (value) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(value);
    });
    //username validation not allow space
    $.validator.addMethod("usernamevalidate", function (value) {
        var regex = /^(?!.*\s)([a-zA-Z0-9_.+-])+$/;
        return regex.test(value);
    });
});