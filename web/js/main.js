$(document).ready(function(){
    $(".buttOpen").click(function(){
        var id = $(this).attr("data-id");
        var test = $("#detailStatistic"+id).css("display");

        if(test == "none"){
            $(this).removeClass('btn-info').addClass('btn-primary').val('Скрыть');
            $("#detailStatistic"+id).show();
        }else{
            $(this).removeClass('btn-primary').addClass('btn-info').val('Показать');
            $("#detailStatistic"+id).hide();
        }
    });


    $(".anchor").click(function(){
        var test = $(this).attr("data-field");
        $('[name='+test+']').focus();
    });


});