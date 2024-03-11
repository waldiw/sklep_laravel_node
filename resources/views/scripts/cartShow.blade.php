@extends('scripts.script')

@section('scriptContent')

            $('.articleQuantity').change(function (e) {
                e.preventDefault();

                var productId = $(this).closest('tr').find('.productId').val();
                var quantity = $(this).closest('tr').find('.articleQuantity').val();

                $.ajax({
                    url: '/update-cart',
                    method: "POST",
                    data: {
                        'quantity': quantity,
                        'product_id': productId,
                    },
                    success: function (response) {
                        var value = jQuery.parseJSON(response); //Single Data Viewing
                        $('#' + value['id']).html(numberFormat(value['subtotal']) + ' zł');
                        cartload();
                    },
                });
            });

            $(document).on('click', '.deleteCartData', function (e) {
                e.preventDefault();

                var productId = $(this).closest('tr').find('.productId').val();

                $.ajax({
                    url: '/delete-cart',
                    method: "post",
                    data: {
                        'product_id': productId,
                    },
                    success: function () {
                        $('#tr' + productId).remove();
                        cartload();
                    }
                });

            });

            var modal = document.getElementById("confirmModal");
            var span = document.getElementsByClassName("close")[0];
            var btnNo = document.getElementsByClassName("btnNo")[0];

            $(document).on('click', '.btnDeleteCart', function (e) {
                e.preventDefault();

                modal.style.display = "block";
            });

            $(document).on('click', '.btnYes', function (e) {
                e.preventDefault();

                $.ajax({
                    url: '/clear-cart',
                    method: "post",
                    data: {},
                    success: function () {
                        $('#tableBody').remove();
                        $('#order').remove();
                        cartload();
                        modal.style.display = "none";
                    }
                });
            });

            // When the user clicks anywhere outside of the modal or span, close it
            window.onclick = function (event) {
                if (event.target === modal || event.target === span || event.target === btnNo) {
                    modal.style.display = "none";
                }
            }

            function numberFormat($number) {
                return ($number / 100).toLocaleString('pl-PL', {minimumFractionDigits: 2})
            }

@endsection
