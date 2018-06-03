jQuery.validator.setDefaults({
    debug:false,
    errorClass: "invalid-tooltip",
    validClass: "is-valid",
    errorElement: "div",
    ignore: ":hidden",
    success: function ( label,element ) {
        //var form_group = label.closest( ".form-group" );
        $(element).removeClass( 'is-invalid' ).addClass( 'is-valid' );
        $(element).closest('.form-group').find('.invalid-tooltip').remove();
        $(element).closest('.form-group').append('<div class="valid-tooltip" style="display:block"><i class="fas fa-check"></i></div>');

    },
    errorPlacement: function ( error, element ) {
        //var input = element.closest(".input");
        var form_group= element.closest(".form-group");
        form_group.append(error);
        $(element).closest('.form-group').find('.valid-tooltip').remove();
    },
    highlight: function ( element, errorClass, validClass ) {
        // var form_group = element.closest( ".form-group");
        // form_group.classList.add(errorClass);
        // form_group.classList.remove(validClass);
        $(element).removeClass('is-valid').addClass( 'is-invalid' );
        $(element).parent().find('button').css('border','1px solid #dc3545');
    },
    unhighlight: function (element, errorClass, validClass) {
        // var form_group = element.closest(".form-group");
        // form_group.classList.add('is-valid');
        // form_group.classList.remove('is-invalid');
        $(element).removeClass('is-invalid').addClass( 'is-valid' );
    }

});