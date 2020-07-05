
$(document).ready(function () {


    $('.btn-click').on('click', function (event) {

        var ruta = Routing.generate('clicks')
        var id = $(this).attr('data-rel');
        var clicks = $(this).parent().parent().find('.nClicks');

        $.ajax({
            type: 'POST',
            url: ruta,
            dataType: "json",
            async: true,
            data: ({id: id}),
            success: function (data) {

                clicks.html(data['clicks']);
            }

        });


    });


});

/*
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

 */