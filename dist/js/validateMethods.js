//([0-9]{4}-[0-9]{4})|([0-9]{4}\s[0-9]{4})|([0-9]{8})
$(document).ready(function() {
    jQuery.validator.addMethod("phoneSV", function(value, element) {
        return this.optional(element) || /([0-9]{4}-[0-9]{4})|([0-9]{4}\s[0-9]{4})|([0-9]{8})/g.test(value);
    }, "Ingrese un n&uacute;mero de telef&oacute;no valido");
});