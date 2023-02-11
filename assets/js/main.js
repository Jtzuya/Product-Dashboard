$(document).ready(function() {
    $('.delete--product').click(function(e) {
        e.stopPropagation();
        // console.log($(this).attr('data-product-id'));
        create_modal($(this).attr('data-product-id'), $(this).attr('data-url'));
    })

    function create_modal(props, url) {
        var div = document.getElementsByClassName('popup_modal')[0];
        div.classList.add('activate--styles');

        var pTag = document.querySelector('.popup_modal p');
        var msg = `Do you really want to delete product ID no.${props}?`;
        pTag.innerText = msg;

        var noBtn = document.createElement('a');
        noBtn.setAttribute('href', '/dashboard/admin');
        noBtn.innerText = `No`;

        var yesBtn = document.createElement('a');
        yesBtn.innerText = `Yes remove this product`;
        yesBtn.setAttribute('href', url);

        div.appendChild(noBtn);
        div.appendChild(yesBtn);
    }
})