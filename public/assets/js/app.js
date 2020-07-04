$(document).ready(function () {

//console.log('hola mundo');

    $('.btn-click').on('click', function (event) {
        event.preventDefault();
    });


});

function clicks(id) {

    //console.log(id);

    var ruta = Routing.generate('clicks')

    $.ajax({
        type: 'POST',
        url: ruta,
        dataType: "json",
        async: true,
        data: ({id: id}),
        success: function (data) {
            console.log(data['clicks']);

            $('.nClicks').html(data['clicks']);
        }

    });


}