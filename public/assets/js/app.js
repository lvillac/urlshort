
$(document).ready(function () {


    $('.btn-click').on('click', function (event) {

        var ruta = Routing.generate('clicks')
        var id = $(this).attr('data-rel');
        var clicks = $(this).parent().parent().find('.nClicks');
        var date = new Date();
        var dateClick = ( date.getFullYear()+'-'+(date.getMonth()+1) + '-' + (date.getDate()) +' '+ date.getHours()+':'+date.getMinutes()+':'+date.getSeconds());
        console.log(dateClick);

        $.ajax({
            type: 'POST',
            url: ruta,
            dataType: "json",
            async: true,
            data: ({id: id, dateclick: dateClick}),
            success: function (data) {

                clicks.html(data['clicks']);
            }

        });


    });


});
