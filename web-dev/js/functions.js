/**
 * Skryje všechny produkty na stránce
 */
function hideProductsAll() {
    $(".product").hide();
}

/**
 * Vrátí čistý tvar ceny
 * @param price
 * @returns {string}
 */
function cleanPrice(price){
    // return price;
    if(price == Math.round(price)){
        return Math.round(price) + " Kč";
    }else{
        price = price + "";
        price = parseFloat(price).toFixed(2);
        price = price.replace(".", ",");
        return  price + " Kč";
        // return price.formatMoney(2, ",", " ") + " Kč";
    }
}

/**
 * Skryje všechny možnosti produktových variant (tlačítka)
 */
function hideProductVariantsAll() {
    $(".product-variant").hide();
}

/**
 * Zobrazí produkty podle zadané kategorie
 *
 * @param categorySlug
 */
function showProductsViaCategory(categorySlug) {
    hideProductsAll();
    $(".product[data-productCategories*='" + categorySlug + "']").show();

    if (categorySlug == "pizza") {
        $(".productAttributes").show();
    } else {
        $(".productAttributes").hide();
    }

}

/**
 * Zobrazí produkty podle zadané kategorie a atributu
 *
 * @param categorySlug
 * @param attributeSlug
 */
function showProductsViaCategoryAndAttribute(categorySlug, attributeSlug) {
    hideProductsAll();
    $(".product[data-productCategories*='" + categorySlug + "'][data-productAttributes*='" + attributeSlug + "']").show();
}

/**
 * Zobrazí produktové varianty (tlačítka)
 *
 * @param productTakeoverTypeSlug
 */
function showProductVariants(productTakeoverTypeSlug) {
    hideProductVariantsAll();
    $(".product-variant[data-productVariant*='" + productTakeoverTypeSlug + "']").show();
}

/**
 * Načte dataset z HTML prvku
 */
var productDataSet;
function loadProductDataSet() {
    productDataSet = JSON.parse($("#productDataSet").html());
    calculateTotalProductPrice();
}

/**
 * Spočítá konečnou cenu produktu vč. doplňků
 */
function calculateTotalProductPrice() {
    var basePrice = productDataSet['product_price'] * 1;
    var surcharge = 0;
    $('#formConfigurator input:checked').each(function () {
        surcharge = surcharge + productDataSet['product_addition_items'][$(this).attr('value')] * 1;
    });
    var totalProductPrice = basePrice + surcharge;

    $("#totalProductPrice").html(cleanPrice(totalProductPrice));
}

/**
 * Zavře modální okno
 */
function closeModal() {
    $('.modal').hide();
    $('.modal .modal-content .modal-content-inner').html('');
}

/**
 * Načte obsah košíku a vloží jej do HTML
 */
function loadCart() {

    $.get("/cart")
        .done(function (data) {
            $("#cart").html(data);
        });

}

function showProductTakeoverContainer(productTakeoverTypeSlug){
    $(".productTakeoverContainer[data-rel!='" + productTakeoverTypeSlug + "']").hide();
    $(".productTakeoverContainer[data-rel='" + productTakeoverTypeSlug + "']").show();
}

function showFirstVariantOfAllProducts(selectedProductTakeoverTypeSlug){

    //Choose first product variant of each product
    $(".dropdown").each(function () {
        var firstOption = $(this).find(".dropdown-content .dropdown-option[data-productVariant*='" + selectedProductTakeoverTypeSlug + "']:first");
        $(this).find(".dropbtn .text").text(firstOption.text());
        $(this).closest(".product").find(".chooseProduct").text("Vybrat za " + cleanPrice(firstOption.attr("data-price")));
        $(this).closest(".product").find(".chooseProduct").attr("data-product-id", firstOption.attr("data-id"));
    });

}

function changeClassProductTakeOverType(selectedProductTakeoverTypeSlug){

    $("button.productTakeoverType").removeClass("active");
    $("button.productTakeoverType[data-slug='" + selectedProductTakeoverTypeSlug + "']").addClass("active");

    if(selectedProductTakeoverTypeSlug === 'vezmu-si-na-stanku'){
        $(".localBusiness-btn:eq(0)").trigger("click");
    }

    showProductTakeoverContainer(selectedProductTakeoverTypeSlug);
    showProductVariants(selectedProductTakeoverTypeSlug);

}