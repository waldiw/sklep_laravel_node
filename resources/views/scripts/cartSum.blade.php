<script>
    $(document).ready(function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
  

        cartload();

        function cartload() {

            $.ajax({
                url: '/load-cart-data',
                method: "GET"
            }).done(function (response) {
                var value = jQuery.parseJSON(response); //Single Data Viewing
                $('.basketItemCount').html((value['totalCart'] / 100).toLocaleString('pl-PL', {minimumFractionDigits: 2}) + " zł");

            });
        }

    });
</script>