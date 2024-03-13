@extends('scripts.script')

@section('scriptContent')
// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("articleBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal
var art = document.getElementById('articleDescription');
var photo = document.getElementById('modalPhoto');
var artN = document.getElementById('articleName');
var artP = document.getElementById('articlePrice');

$('.showArticle').click(function (e) {
    e.preventDefault();

    userURL = this.getAttribute('data-article');
    $.ajax({
        url: userURL,
        method: "GET"
    }).done(function (response) {
        artN.innerHTML = response.name;
        art.innerHTML = response.description;
        var price = (response.price / 100).toLocaleString('pl-PL', {minimumFractionDigits: 2});
        artP.innerHTML = "Cena: " + price + " zł";
        $("#articleId").val(response.id);
        photo.innerHTML = "<img src=\"" + response.image + "\" class=\"modalImg\">";
        modal.style.display = "block";
    });
});

// When the user clicks on <span> (x), close the modal
span.onclick = function () {
    modal.style.display = "none";

}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function (event) {
    if (event.target === modal) {
        modal.style.display = "none";
    }
}

// click button add to cart
$('.btnAddCart').click(function (e) {
    e.preventDefault();

    var productId = $(this).closest('.articleDetails').find('.productId').val();
    var quantity = 1;
    $.ajax({
        url: "/add-to-cart",
        method: "POST",
        data: {
            'quantity': quantity,
            'product_id': productId,
        }
    }).done(function (response) {
        cartload();
        $.iaoAlert({
            msg: "Produkt został dodany do koszyka.",
            mode: "dark",
            position: 'top-left'
        })
    });
});

@endsection