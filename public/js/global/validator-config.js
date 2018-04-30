jQuery.validator.setDefaults({
    debug:false,
    errorClass: "invalid-feedback",
    validClass: "is-valid",
    errorElement: "div",
    ignore: ":hidden",
    success: function ( label,element ) {
        //var form_group = label.closest( ".form-group" );
        $(element).removeClass( 'is-invalid' ).addClass( 'is-valid' );

    },
    errorPlacement: function ( error, element ) {
        //var input = element.closest(".input");
        var form_group= element.closest(".form-group");
        form_group.append(error);
    },
    highlight: function ( element, errorClass, validClass ) {
        // var form_group = element.closest( ".form-group");
        // form_group.classList.add(errorClass);
        // form_group.classList.remove(validClass);
        $(element).removeClass('is-valid').addClass( 'is-invalid' );
    },
    unhighlight: function (element, errorClass, validClass) {
        // var form_group = element.closest(".form-group");
        // form_group.classList.add('is-valid');
        // form_group.classList.remove('is-invalid');
        $(element).removeClass('is-invalid').addClass( 'is-valid' );
    }

});