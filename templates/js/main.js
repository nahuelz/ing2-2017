$(document).ready(function() {
    var caracteres = /^[a-zA-ZáéíóúàèìòùÀÈÌÒÙÁÉÍÓÚñÑüÜ_\s]+$/;
    var numeros = /^[0-9]+$/;
    rows = 2;


    $(".usuario").click(function (){ 
        $(".error").remove();
        if( $("#nombre").val().length < 4 || !caracteres.test($("#nombre").val())) {
            $("#nombre").focus().after("<p class='error'>Ingrese un nombre valido</p>");
            return false;  
        }
        if( $("#apellido").val().length < 4 || !caracteres.test($("#apellido").val())) {
            $("#apellido").focus().after("<p class='error'>Ingrese un apellido valido</p>");
            return false;  
        }
        if( $("#telefono").val().length < 7 || !numeros.test($("#telefono").val())) {
            $("#telefono").focus().after("<p class='error'>Ingrese un telefono valido</p>");
            return false;  
        }
        if( $("#ccv").val().length < 3 || !numeros.test($("#ccv").val() || $("#ccv").val().length > 3) ) {
            $("#ccv").focus().after("<p class='error'>Ingrese un ccv valido</p>");
            return false;  
        }

    });

    $(".creditos").click(function (){ 
        $(".error").remove();
        if( $("#nombre").val().length < 4 || !caracteres.test($("#nombre").val())) {
            $("#nombre").focus().after("<p class='error'>Ingrese un nombre valido</p>");
            return false;  
        }
        
    });
});

