$(function() {


	//SVG Fallback
	if(!Modernizr.svg) {
		$("img[src*='svg']").attr("src", function() {
			return $(this).attr("src").replace(".svg", ".png");
		});
	};

	new mlPushMenu( document.getElementById( 'mp-menu' ), document.getElementById( 'trigger' ) );


	$('.slider-for').slick({
		slidesToShow: 1,
		slidesToScroll: 1,

		asNavFor: '.slider-nav'
	});
	$('.slider-nav').slick({
		slidesToShow: 4,
		slidesToScroll: 1,
		asNavFor: '.slider-for',
		focusOnSelect: true
	});


	/*jVForms.initialize();*/

	$(".table_compare button.btn-bye").on("click", function() {
		let count = parseInt($(".cart-box .total").text());
		count++;
		$(".cart-box .total").text(count);
	});


	$(".popup-form").animated("bounceInDown", "fadeInDown");
	$(".accordeon dd").hide().prev().click(function() {
		$(this).parents(".accordeon").find("dd").not(this).slideUp().prev().removeClass("active");
		$(this).next().not(":visible").slideDown().prev().addClass("active");
	});


	$(".filter-box .filtr-btn").click(function() {

		$(this).parents(".filter-box").find(".filter-wrap").slideToggle();
		$(this).toggleClass("active")
	});


	$(".tab_item").not(":first").hide();
	$(".wrapper .tab").click(function() {
		$(".wrapper .tab").removeClass("active").eq($(this).index()).addClass("active");
		$(".tab_item").hide().eq($(this).index()).fadeIn()
	}).eq(0).addClass("active");
	
	$('.popup-gallery').magnificPopup({
		delegate: 'a',
		type: 'image',
		tLoading: 'Загрузка изображения #%curr%...',
		mainClass: 'mfp-fade mfp-img-mobile',
		gallery: {
			enabled: true,
			navigateByImgClick: true,
							preload: [0,1] // Will preload 0 - before current, and 1 after the current image
						},
						image: {
							tError: '<a href="%url%">Изображение #%curr%</a> не загружено.',
							titleSrc: function(item) {
								return '';
							}
						}
					});

	$(".nav-btn").click(function() {
		$("nav > ul").slideToggle();
	});


	$('.popup-with-form').magnificPopup({
		type: 'inline',
		preloader: false,
		focus: '#name',
		mainClass: 'mfp-fade',
		// When elemened is focused, some mobile browsers in some cases zoom in
		// It looks not nice, so we disable it:
		callbacks: {
			beforeOpen: function() {
				if($(window).width() < 700) {
					this.st.focus = false;
				} else {
					this.st.focus = '#name';
				}
			}
		}
	});



	$('.popup').magnificPopup({
		type: 'image',
		closeOnContentClick: true,
		closeBtnInside: false,
		fixedContentPos: true,
			mainClass: 'mfp-fade mfp-no-margins mfp-with-zoom', // class to remove default margin from left and right side
			image: {
				verticalFit: true
			},
			zoom: {
				enabled: true,
				duration: 300 // don't foget to change the duration also in CSS
			}
		});


	//Каруселька
	//Документация: http://owlgraphic.com/owlcarousel/
	$('.owl-carousel').owlCarousel({
		loop:true,
		margin:10,
		autoplay:true,
		autoplayTimeout:4000,
		pagination: true,
		responsive:{
			0:{
				items:1
			},
			600:{
				items:1
			},
			1000:{
				items:1
			}
		}
	})


	//Каруселька
	//Документация: http://owlgraphic.com/owlcarousel/
	$('.slider-category').owlCarousel({
		loop:true,
		margin:10,
		autoplay:true,
		autoplayTimeout:4000,
		pagination: true,
		responsive:{
			0:{
				items:1
			},
			600:{
				items:1
			},
			1000:{
				items:1
			}
		}
	})
	

	//Каруселька
	//Документация: http://owlgraphic.com/owlcarousel/
	$('.owl-carousel2').owlCarousel({
		loop:true,
		margin:0,
		autoplay:true,
		nav:true,
		navText:['<span><i class="fa fa-angle-left" aria-hidden="true"></i></span>','<span><i class="fa fa-angle-right" aria-hidden="true"></i></span>'],
		autoplayTimeout:4000,
		pagination: true,
		responsive:{
			0:{
				items:1
			},
			600:{
				items:2
			},
			1000:{
				items:3
			}
		}
	})

	//Каруселька
	//Документация: http://owlgraphic.com/owlcarousel/
	$('.owl-carousel3').owlCarousel({
		loop:true,
		margin:30,
		autoplay:true,
		nav:true,
		navText:['<span><i class="fa fa-angle-left" aria-hidden="true"></i></span>','<span><i class="fa fa-angle-right" aria-hidden="true"></i></span>'],
		pagination: true,
		responsive:{
			0:{
				items:1
			},
			600:{
				items:2
			},
			1000:{
				items:4
			}
		}
	})
	$('.owl-carousel4').owlCarousel({
		loop:true,
		margin:10,
		autoplay:false,
		nav:true,
		navText:['<span><i class="fa fa-angle-left" aria-hidden="true"></i></span>','<span><i class="fa fa-angle-right" aria-hidden="true"></i></span>'],
		pagination: true,
		responsive:{
			0:{
				items:1
			},
			600:{
				items:4
			},
			1000:{
				items:6
			}
		}
	})
	//Кнопка "Наверх"
	//Документация:
	//http://api.jquery.com/scrolltop/
	//http://api.jquery.com/animate/
	$("#top").click(function () {
		$("body, html").animate({
			scrollTop: 0
		}, 800);
		return false;
	});



	//E-mail Ajax Send
	//Documentation & Example: https://github.com/agragregra/uniMail
	/*$("form :not(.not-send)").submit(function() { //Change
		var th = $(this);
		$.ajax({
			type: "POST",
			url: "assets/templates/mail.php", //Change
			data: th.serialize()
		}).done(function() {
			$(".done-w").fadeIn();
			setTimeout(function() {
				// Done Functions
				$(".done-w").fadeOut();
				$.magnificPopup.close();
				th.trigger("reset");
			}, 3000);
		});
		return false;
	});*/

	//Chrome Smooth Scroll
	try {
		$.browserSelector();
		if($("html").hasClass("chrome")) {
			$.smoothScroll();
		}
	} catch(err) {

	};

	$("img, a").on("dragstart", function(event) { event.preventDefault(); });
	
	
	$('.gallery-big').slick({
		slidesToShow: 1,
		slidesToScroll: 1,
		arrows: true,
		fade: true,
		asNavFor: '.gallery-nav',
		prevArrow:'<button type="button" class="slick-prev"><i class="fa fa-angle-left" aria-hidden="true"></i></button>',
		nextArrow:'<button type="button" class="slick-next"><i class="fa fa-angle-right" aria-hidden="true"></i></button>'
	});
	$('.gallery-nav').slick({
		slidesToShow: 6,
		slidesToScroll: 6,
		asNavFor: '.gallery-big',

		focusOnSelect: true,
		responsive: [
		{
			breakpoint: 1024,
			settings: {
				slidesToShow: 3,
				slidesToScroll: 3,
			}
		},
		{
			breakpoint: 600,
			settings: {
				slidesToShow: 2,
				slidesToScroll: 2
			}
		},
		{
			breakpoint: 480,
			settings: {
				slidesToShow: 1,
				slidesToScroll: 1
			}
		}
		]
	});

	$('.hidden-client-button').click(function(){
		$('.hidden-client').fadeToggle(600);
		$('.hidden-client-button.more').fadeToggle(1);
		return false;
	});

	$("#mobFilter").click(function(){ 
		$("#mobFilterForm").toggle(); 
	});

	$("#sendCall").click(function(){
		var name = $("#name").val();
		var phone = $("#phone").val();
		var question = $("#question").val();
		var agreement = $("#agreement").val();
		var error = 0;
		$("#name").parent("div").removeClass('has-error');
		$("#phone").parent("div").removeClass('has-error');
		$(".checkbox").removeClass('checkbox-error'); 

		if(name.length==0 || name==""){
			$("#name").parent("div").addClass('has-error');
			error = 1;
		}
		if ( (phone.indexOf("_") != -1) || phone == '' ) {
			$("#phone").parent("div").addClass('has-error');
			error = 1;
		}
		if (!$('#agreement').is(':checked')){
			$(".checkbox").addClass('checkbox-error'); 
			error = 1;  
		}
		if (error == 0) { 
			$.ajax({
				url:     '/ajax/callback.php', 
				type:     "POST", 
				data: "name="+name+"&phone="+phone+"&question="+question,  
				success: function(response) { 
					if(response == "ok"){
						$(".show-form").html('<p class="is-send bold">Спасибо за заявку!</p><p class="is-send">Мы свяжемся с Вами в ближайшее время.</p>');
						ingEvents.listTrackers();
						ingEvents.dataLayerPush('dataLayer', {'event': 'zvonok_na'});
					}
				},
				error: function(response) {
				}
			});
		} 
	});
});
$(document).on("click",".remove_compare", function() {
		let count = parseInt($(".compare_counter .total").text());
		count--;
		console.log(count);
		$(".compare_counter .total").text(count);
	});
function sendTender(){
	var tender = $('.tender-link').val();
	$.ajax({
		url:     '/ajax/tender.php', 
        type:     "POST", //метод отправки
        dataType: "html", //формат данных
        data: "tender="+tender,  // Сеарилизуем объект
        success: function(response) { //Данные отправлены успешно
        	if(response == "ok"){
        		$('.tender-paty .success').css('display','block');
        		$('.tender-paty .error').css('display','none');
        		$('.tender-link').val('');
        	}else{
        		$('.tender-paty .error').css('display','block');
        		$('.tender-paty .success').css('display','none');
        	}
        },
    	error: function(response) { // Данные не отправлены
    		$('.tender-paty .error').css('display','block');
    		$('.tender-paty .success').css('display','none');
    	}
    });
	return false;
}
function sendRegistr(){
	var n_o = $('#organiz-name').val();
	var inn = $('#organiz-inn').val();
	var ogrn = $('#organiz-ogrn').val();
	var u_a = $('#organiz-u-adr').val();
	var f_a = $('#organiz-f-adr').val();
	var email = $('#organiz-email').val();
	var phone = $('#organiz-phone').val();
	var k_l = $('#organiz-k-liz').val();
	$.ajax({
		url:     '/ajax/registr.php', 
        type:     "POST", //метод отправки
        dataType: "html", //формат данных
        data: "n_o="+n_o+"&inn="+inn+"&ogrn="+ogrn+"&u_a="+u_a+"&f_a="+f_a+"&email="+email+"&phone="+phone+"&k_l="+k_l,  // Сеарилизуем объект
        success: function(response) { //Данные отправлены успешно
        	if(response == "ok"){
        		$('.user-reg .success').css('display','block');
        		$('.user-reg .error').css('display','none');
        		$('#organiz-name').val('');
        		$('#organiz-inn').val('');
        		$('#organiz-ogrn').val('');
        		$('#organiz-u-adr').val('');
        		$('#organiz-f-adr').val('');
        		$('#organiz-email').val('');
        		$('#organiz-phone').val('');
        		$('#organiz-k-liz').val('');
        	}else{
        		$('.user-reg .error').css('display','block');
        		$('.user-reg .success').css('display','none');
        	}
        },
    	error: function(response) { // Данные не отправлены
    		$('.user-reg .error').css('display','block');
    		$('.user-reg .success').css('display','none');
    	}
    });
	return false;
}
function sendSubs(){
	var email = $('#subs-email').val();
	$.ajax({
		url:     '/ajax/subs.php', 
        type:     "POST", //метод отправки
        dataType: "html", //формат данных
        data: "mail="+email,  // Сеарилизуем объект
        success: function(response) { //Данные отправлены успешно
        	if(response == "ok"){
        		$('.tender-paty .success').css('display','block');
        		$('.tender-paty .error').css('display','none');
        		$('.tender-link').val('');
        	}else{
        		$('.tender-paty .error').css('display','block');
        		$('.tender-paty .success').css('display','none');
        	}
        },
    	error: function(response) { // Данные не отправлены
    		$('.tender-paty .error').css('display','block');
    		$('.tender-paty .success').css('display','none');
    	}
    });
	return false;
}
$(document).on("click", ".bx_catalog-compare-list a", function(e) {
	let id = $(this).data("id");
	$("#compareid_"+id).prop("checked", false);
	$("label[for=compareid_"+id).html('<span>Сравнить</span> <i class="compare_icon"></i>');
	let compare_count = parseInt($(".compare_counter .total").text());
	if (!compare_count) {
		$(".compare_counter a").attr("href", "#");
	} else {
		compare_count--;
		$(".compare_counter .total").text(compare_count);
		$(".compare_counter a").attr("href", "/catalog/compare.php");
	}
});

$(document).ready(function(){
	var coo = getCookie('BITRIX_SM_USER_CITY');

	var del_coo = document.cookie.split(';');
	
	var count=0;
	while(name = del_coo.pop()) {
		var values = name.split('=');
		if(values[0].trim()=="BITRIX_SM_USER_CITY"){
			count++;
		}

	}
	if(count>1){
		var coo2 = getCookie('BITRIX_SM_USER_CITY_NAME');
      var cookie_date = new Date(new Date().getTime()- 60 * 60 * 360 * 24 * 1000*1000);  // Текущая дата и время
      document.cookie = "BITRIX_SM_USER_CITY="+coo+"; path=/; expires=" + cookie_date.toUTCString();
      document.cookie = "BITRIX_SM_USER_CITY_NAME="+coo2+"; path=/; expires=" + cookie_date.toUTCString();
      document.location.reload(true);
  }

  if(coo === undefined){
  	$.ajax({
  		url:     '/SxGeo/index.php', 
			type:     "POST", //метод отправки
			dataType: "html", //формат данных
			success: function(response) { //Данные отправлены успешно
				$('#select_city_top option[value="'+response+'"]').prop('selected', true);
			},
			error: function(response) { // Данные не отправлены
			}
		});
  }
});
function selectCity(val){
	var  name;
	name = $("#select_city_top option:selected").data('value');
	var date = new Date(new Date().getTime() + 60 * 60 * 360 * 24 * 1000*1000);
	document.cookie = "BITRIX_SM_USER_CITY="+val+"; path=/; domain=.proconsim.ru; expires=" + date.toUTCString();
	document.cookie = "BITRIX_SM_USER_CITY_NAME="+name+"; path=/; domain=.proconsim.ru; expires=" + date.toUTCString();
	$.ajax({
		url:     '/ajax/region.php', 
			type:     "POST", //метод отправки
			data: "city_id="+val,
			success: function(response) { //Данные отправлены успешно
			},
			error: function(response) { // Данные не отправлены
			}
		}); 
	document.location.reload(true);
}
function getCookie(name) {
	var matches = document.cookie.match(new RegExp(
		"(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
		));
	return matches ? decodeURIComponent(matches[1]) : undefined;
}
function showHiddFieldFilter(){
	$('.hidden-filter-field').fadeIn('500');
	$('.hidd-f').fadeIn('500');
	$('.show-f').fadeOut('1');
}
function hiddShowFieldFilter(){
	$('.hidden-filter-field').fadeOut('500');
	$('.hidden-filter-field .filter-box').removeClass('bx-active');
	$('.hidden-filter-field .bx-filter-block').css('display','none');
	$('.hidd-f').fadeOut('1');
	$('.show-f').fadeIn('500');
}