$(document).ready(function() {


	// FastClick
	FastClick.attach(document.body);





	// Přepínač mobilní navigace
	// $('.nav-mobile-toggle').click(function(e) {
	// 	$('.nav-mobile').slideToggle(500);
	// 	$(this).toggleClass('open');
	// 	e.preventDefault();
	// });






	// Inicializace Swiperu
	var mySwiper = new Swiper('.swiper-container',{
		// pagination: '.swiper-pagination',
		autoplay: 4000,
		speed: 800,
		paginationClickable: true,
		nextButton: '.swiper-button-next',
    	prevButton: '.swiper-button-prev',
	});





	// Fancybox
	// $("[data-fancybox]").fancybox({
	// 	// hash: true,
	// 	focus: false
	// });

	// K odkazům obrázků v galerii přidej title dle jejich caption pro zobrazení ve Fancyboxu
	// $('.gallery-item').each(function(){
	// 	var link = $(this).find('a');
	// 	var caption = $(this).find('.gallery-caption');
	// 	link.attr('data-caption', caption.text());
	// });


});