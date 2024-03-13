@extends('scripts.script')

@section('scriptContent')
if ($('#check').is(':checked'))
{
    $('#displayVat').removeClass('displayVat');
}
else {
    $('#displayVat').addClass('displayVat');
}

$(document).on('click', '.checkVat' ,function(e) {
    if ($('#check').is(':checked'))
    {
        $('#displayVat').removeClass('displayVat');
    }
    else{
        $('#displayVat').addClass('displayVat');
        $('#nip').val('');
        $('#vatName').val('');
        $('#vatStreet').val('');
        $('#vatCity').val('');
        $('#vatPost').val('');
    }

});

$("input[type='radio']").click(function(){
    var totalCart = $('.totalCart').val();
     var shippingCost = $(this).closest('tr').find('.ship').val();
    var total = parseInt(totalCart) + parseInt(shippingCost);
    $('#toPay').html((total / 100).toLocaleString('pl-PL', {minimumFractionDigits: 2}) + ' zł');
    $('.kolor').removeClass('enabled');
    $(':radio').each(function () {
        if ($(this).is(':checked'))
        {
             $(this).closest('tr').find('.kolor').addClass('enabled');
        }
    });
});

$("#btnSubmit").click(function(){
    if ($('#checkReg').is(':checked'))
    {
        $("#orderForm").submit();
    }
    else
    {
        $.iaoAlert({
            msg: "Proszę potwierdzić postaniowienia regulaminu.",
            mode: "dark",
            type:"error",
            position: 'top-left'
        })
    }
});
@endsection
