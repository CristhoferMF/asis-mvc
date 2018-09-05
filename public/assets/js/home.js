let data = new Object();

$(document).on('change', '#select-practicante', function () {
    const divNombre = $('#nombre-practicante p span');
    let selPracticante;
    selPracticante = $("#select-practicante :selected").text();
    if (selPracticante == "Escoger") {
        divNombre.html("Ningun practicante seleccionado");
    } else {
        divNombre.html(selPracticante);
    }

    data.codigo = $(this).val();
    //console.log(data);
    $.ajax({
        url: 'ajax/verificar_asistencia.php',
        dataType: 'Json',
        data: data,
        method: 'POST',
    }).done(function (data) {
        $("#div-button-ingreso").html(data.entrada);
        $("#div-button-salida").html(data.salida);
    })
});

$(document).on('click', '#div-button-ingreso button', function () {
    if ($(this).data("action") == "enable") {
        const hora='ingreso';
        const codigo=$("#select-practicante").val();
        $.ajax({
            url: 'ajax/registrar_entrada_salida.php',
            dataType: 'Json',
            data: {hora:hora,codigo:codigo},
            method: 'POST',
        }).done(function (data) {
            if(data==1){
                $("#div-button-ingreso").html("<button class='btn btn-default active col disabled' data-action='disable'>Ya Registró entrada</button>");
                obtenerHorarioDia();
            }
        })
    }
});
$(document).on('click', '#div-button-salida button', function () {
    if ($(this).data("action") == "enable") {
        const hora='salida';
        const codigo=$("#select-practicante").val();
        $.ajax({
            url: 'ajax/registrar_entrada_salida.php',
            dataType: 'Json',
            data: {hora:hora,codigo:codigo},
            method: 'POST',
        }).done(function (data) {
            if(data==1){
                $("#div-button-salida").html("<button class='btn btn-default col disabled' data-action='disable'>Registrar Salida<div class='ripple-container'></div></button>");
                obtenerHorarioDia();
            }
        })
    }
});
$(function () {
    obtenerHorarioDia();
})

function obtenerHorarioDia() {
    $.ajax({
        url: 'ajax/horario_dia.php',
        dataType: 'Json',
        method: 'POST',
    }).done(function (data) {
        $("#table-body").html("");
        var arr = $.map(data, function (el) {
            return el
        });
        arr.forEach(element => {
            //console.log(element);
            $("#table-body").append('<tr>' +
                '<td align="center" title="Dni">' + element.dni + '</td>' +
                '<td align="center" title="Nombre Completo">' + element.nomCompleto + '</td>' +
                '<td align="center" title="Hora LLegada">' + element.horEntrada + '</td>' +
                '<td align="center" title="Hora Salida">' + element.horSalida + '</td>' +
                '<tr>');
        });
        
    })
}