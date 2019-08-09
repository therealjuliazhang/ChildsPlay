$(document).ready(function() {
    // console.log(!($("select.materialSelect")[0].value == ""));
    // $.validator.addMethod("notEqual", function() {
    //     console.log(value);
    //     return !(value == "Choose your location");
    // }, "Pick your location from the drop down menu.");
    // jQuery.validator.addMethod(
    //     "notEqualTo",
    //     function(elementValue,element,param) {
    //       return elementValue != param;
    //     },
    //     "Value cannot be {0}"
    //   );

    //Places error element next to invalid inputs
    $.validator.setDefaults({
        errorElement : 'div',
        errorClass: 'invalid',
        errorPlacement: function(error, element) {
            if(element.attr('type') == "text" || element.attr('type') == "number"){
                $(element)
                .closest("form")
                .find("label[for='" + element.attr("id") + "']")
                .attr('data-error', error.text());
            }
            else if(element.hasClass("materialSelect")){
                element.after(error);
            }   
            else if(element.attr('type')=="radio"){
                element.before(error);
            } 
        }
    })
    //set up rules and messages for errors
    $("#form").validate({
        rules: {
            groupName: {
                required: true,
                remote: {
                    url: "checkGroupName.php",
                    type: "post"
                }
            }
            // locationSelect: {
            //     notEqualTo: "Choose your location"
            // }
        },
        messages: {
            groupName: {
                required: "Enter a group name.",
                remote: jQuery.validator.format("{0} is already used by an existing group.")
            },
            locationSelect: "Pick your location from the drop down menu."
        }
    });
});