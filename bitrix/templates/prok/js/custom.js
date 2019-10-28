$(document).ready(function() {
	 $('a.item-fav').click(function(e) {
		e.preventDefault();
		var thiz = $(this);
		var parent = $(this).closest('.favourites-page');
	 	var item = $(this).attr('data-itemid');
	 	var act = $(this).attr('data-act');
	 	var lnk_like = $(this);
	 	var lnk = '/ajax/fav.php';
	 	$.post(lnk, {
	 		id: item,
	 		act: act
	 	}, function(data) {
	 		// alert(data.res);
			//console.log(data);
	 		if (act == 'add') {
	 			lnk_like.attr('title','В избранном');
	 			lnk_like.attr('data-act', 'del');
				lnk_like.addClass('fav_in');
	 		} else {
	 			lnk_like.attr('title','В избранное');
	 			lnk_like.attr('data-act', 'add');
				lnk_like.removeClass('fav_in');
	 		}

			if(parent.length>0) {
				thiz.closest('.product-card').remove();;
			}

			var fav = $('.top-header a.top-fav');
			var spanfav = fav.find('span');
			if(spanfav.length>0) {
				if(data.count > 0) {
					spanfav.html(data.count);
				} else {
					spanfav.remove();
				}
			} else {
				if(data.count > 0) {
					fav.append('<span>'+data.count+'</span>');
				}
			}

	 	}, "json");
	 	return false;
	});

	$.post('/ajax/getIdsFav.php', {},
		function(data) {
			ids_fav = data.res;
			console.log(data);
			$('.wrapp-fav-izb .item-fav').each(function() {
	 			thiz = $(this);
				//console.log(ids_fav[thiz.attr('data-itemid')]);
	 			if(ids_fav[thiz.attr('data-itemid')]) {
	 				thiz.attr('data-act','del');
	 				thiz.addClass('fav_in');
					thiz.attr('title','В избранном');
	 			}
	 	 });
		}, "json");

	$.post('/ajax/getIdsCompare.php', {},
		function(data) {
			ids_com= data.res;
			$('.wrapp-fav-compare .item-compare').each(function() {
	 			thiz = $(this);
	 			if(ids_com[thiz.attr('data-itemid')]) {
	 				thiz.attr('data-act','del');
	 				thiz.addClass('compare_in');
					thiz.attr('title','Добавлено');
					thiz.find('span').html('В Сравнении');
	 			}
	 	 });
		}, "json");

		$('a.item-compare').click(function(e) {
			e.preventDefault();
			thiz = $(this);
			var AddedGoodId = thiz.attr('data-itemid');
			var act = thiz.attr('data-act');
			if (act == 'add') {
				action = "ADD_TO_COMPARE_LIST";
			} else {
				action = "DELETE_FROM_COMPARE_LIST";
			}

			$.get("/ajax/list_compare.php", {
					action: action,
					id: AddedGoodId
				},
				function(data) {
					data = JSON.parse(data);
					if (act == 'add') {
						thiz.attr('data-act', 'del');
						thiz.addClass('compare_in');
						thiz.attr('title','Добавлено');
						thiz.find('span').html('В Сравнении');
					} else {
						thiz.attr('data-act', 'add');
						thiz.removeClass('compare_in');
						thiz.attr('title','Сравнить');
						thiz.find('span').html('Сравнение');
					}

					var comp = $('.top-header a.top-compare');
					var spanfav = comp.find('span');
					if(spanfav.length>0) {
						if(data.count > 0) {
							spanfav.html(data.count);
						} else {
							spanfav.remove();
						}
					} else {
						if(data.count > 0) {
							comp.append('<span>'+data.count+'</span>');
						}
					}
				}
			);
		});
});
