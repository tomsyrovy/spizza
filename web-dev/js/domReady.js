/**
 * Created by Tomas on 30.05.17.
 */

$(document).ready(function () {

    /**
     * Po odeslání formuláře se přidá zvolené zboží do košíku.
     */
    $(document).on('submit', '#formConfigurator', function (e) {
        e.preventDefault(); // avoid to execute the actual submit of the form.
        var url = "/cart-item/add-to-cart"; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            data: $("#formConfigurator").serialize(), // serializes the form's elements.
            success: function (data) {
                if (data.text == 'added') {
                    alert('Zboží bylo přidáno do košíku.');
                } else {
                    alert('Zboží nebylo přidáno. Změňte typ vyzvednutí.');
                }
                loadCart();
                closeModal();
            }
        });
    });

    /**
     * Po odeslání formuláře se odstraní zboží z košíku
     */
    $(document).on('submit', '.formRemoveCartItem', function (e) {
        $(this).closest('.cartItem').remove();
        alert('Zboží bylo odebráno z košíku.');
        e.preventDefault(); // avoid to execute the actual submit of the form.
        var url = "/cart-item/remove-from-cart"; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            data: $(this).serialize(), // serializes the form's elements.
            success: function () {
                loadCart();
            }
        });
    });

    $("button.productCategory").on('click', function () {
        $("button.productCategory").removeClass("active");
        $(this).addClass("active");
        showProductsViaCategory($(this).attr("data-slug"));
        if($(this).attr("data-slug") === "pizza"){
            $("button.productAttribute:eq(0)").trigger("click");
        }
    });

    $("button.productAttribute").on('click', function () {
        $("button.productAttribute").removeClass("active");
        $(this).addClass("active");
        showProductsViaCategoryAndAttribute($("button.productCategory.active:eq(0)").attr("data-slug"), $(this).attr("data-slug"));
    });

    $("button.productTakeoverType").on('click', function () {

        var $cart = $("#cartContent");

        if($cart.attr("data-cartCartItems") != 0){ //v košíku už je nějaké zboží

            if($(this).attr("data-slug") != $cart.attr("data-cartTakeOverTypeSlug")){

                alert('Nemůžete změnit typ vyzvednutí, máte-li již nějaké zboží v košíku.');

            }

        }else{ //v košíku není zboží

            var selectedProductTakeoverTypeSlug = $(this).attr("data-slug");
            changeClassProductTakeOverType(selectedProductTakeoverTypeSlug);
            showFirstVariantOfAllProducts(selectedProductTakeoverTypeSlug);

            var url = "/cart/choose-takeover"; // the script where you handle the form input.
            $.ajax({
                type: "POST",
                url: url,
                data: {
                    takeoverSlug: $(this).attr("data-slug")
                },
                success: function (data) {

                }
            });

        }

    });

    //After click on localBusiness
    $(".localBusiness-btn").on('click', function () {

        $(".localBusiness-btn").removeClass("active");
        $(this).addClass("active");

        $(".takeOver-spinner").hide();
        $(".spinner-stanek").show();

        $("#openingHours").html('');

        var url = "/cart/choose-localbusiness"; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            data: {
                localBusinessSlug: $(this).attr("data-slug")
            },
            success: function (data) {
                $(".takeOver-spinner").hide();
                $("#openingHours").html(data);
            }
        });

    });

    $(".productTakeoverContainer[data-rel='necham-si-dovezt'] form").on("submit", function(e){
        e.preventDefault();
        var address = $(this).find("#form_address").val();
        if(address.length < 2){
            alert("Zadejte prosím svoji adresu.");
        }else{

            $(".takeOver-spinner").hide();
            $(".spinner-rozvoz").show();

            $("#deliveryInfo").html('');

            var url = "/cart/send-address"; // the script where you handle the form input.
            $.ajax({
                type: "POST",
                url: url,
                data: {
                    address: address
                },
                success: function (data) {
                    $(".takeOver-spinner").hide();
                    $("#deliveryInfo").html(data);
                }
            });

        }
        return false;
    });

    //Show product variants of product
    $(".dropbtn").on('click', function () {
        $("#" + $(this).attr('data-rel')).toggle();
        var arrow = $(this).find(".arrow i");
        if(arrow.hasClass("fa-caret-down")){
            arrow.removeClass("fa-caret-down").addClass("fa-caret-left");
        }else{
            arrow.removeClass("fa-caret-left").addClass("fa-caret-down");
        }
    });

    //Choose product variant of product
    $(".dropdown-option").on('click', function () {
        $(this).closest(".dropdown").find(".dropbtn .arrow i").removeClass("fa-caret-left").addClass("fa-caret-down");
        $(this).closest(".dropdown").find(".dropbtn .text").text($(this).text());
        $(this).closest(".product").find(".chooseProduct").text("Vybrat za " + cleanPrice($(this).attr("data-price")));
        $(this).closest(".product").find(".chooseProduct").attr("data-product-id", $(this).attr("data-id"));
        $(".dropdown-content").hide();
    });

    $(".chooseProduct").on('click', function () {
        $("#modal_productConfigure").show();
        $.get("/cart-item/configure", {
            product_id: $(this).attr('data-product-id')
        }).done(function (data) {
            $(".spinner").hide();
            $("#modal_productConfigure .modal-content .modal-content-inner").html(data);
            loadProductDataSet();
        }).fail(function(){
            closeModal();
            $(".spinner").show();
            alert("Položku není možné vybrat.");
        });

    });

    $(document).on('change', '#formConfigurator input', function () {
        calculateTotalProductPrice();
    });

    $(".modal").on('click', '.close', function () {
        closeModal();
        $(".spinner").show();
    });

    // Close the dropdown if the user clicks outside of it
//            $(window).on('click', function(e){
//                if(!e.target.matches('.dropbtn') && !e.target.matches('.dropdown-option')){
//                    $(".dropdown-content").hide();
//                }
//            });

    //Click on first buttons of category, attribute, takeover
    $("button.productCategory:eq(0)").trigger("click");
    $("button.productAttribute:eq(0)").trigger("click");

    var selectedProductTakeoverTypeSlug = $("#cartContent").attr("data-cartTakeOverTypeSlug");
    // $("button.productTakeoverType[data-slug='" + selectedProductTakeoverTypeSlug + "']").trigger("click");
    changeClassProductTakeOverType(selectedProductTakeoverTypeSlug);
    showFirstVariantOfAllProducts(selectedProductTakeoverTypeSlug);

});
