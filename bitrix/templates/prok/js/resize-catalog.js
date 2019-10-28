function ResizeMenuBlock(){
	var menu_width = $('.mp-wrap').width();
	$('.submenu').css('width',menu_width+"px");
	$('#horizontal-multilevel-menu .submenu .active').each(function(index, value){
		var object = $(value).parent('.submenu');
		$(object).addClass('showity');
		$('#menu-slick').css('margin-top','43px');
    });
}
function PositionMenuBlock(){
	var menu_width = $('.mp-wrap').width();
	var menu_width_small = $('#horizontal-multilevel-menu').width();
	var smesh = menu_width_small - menu_width + 78;
	var ob_smesh = -smesh;
	/*$('.submenu').css('left',smesh+'px');*/
	/*$('.submenu li:first-child').css('margin-left',ob_smesh+"px");*/
}
function ResizeCatalogBlock(){
	var wid = getPageSize();
	if(wid < 769){
		$('.cat-box').css('height','auto');
		return false;
	}else if(wid < 993){
		var max = $('#count_two').val();
		ResizeModification(max,'second_line_');
	}else{
		var max = $('#count_four').val();
		ResizeModification(max,'fourth_line_');
	}
}
function ResizeModification(max,inline){
	var i = 1;
	while (i <= max){
		$("."+inline+i+"").css('height',"auto");
		var maxHeight = 1;
		$("."+inline+i+"").each(function(j,elem) {
			if(maxHeight<$(elem).height()){
				maxHeight = $(elem).height();
			}
		});
		maxHeight = maxHeight + 32;
		$("."+inline+i+"").css('height',maxHeight+"px");
		i++;	
	}
}
function getPageSize(){
	var xScroll, yScroll;
	if (window.innerHeight && window.scrollMaxY) {
		xScroll = document.body.scrollWidth;
	} else if (document.body.scrollHeight > document.body.offsetHeight){ // all but Explorer Mac
		xScroll = document.body.scrollWidth;
	} else if (document.documentElement && document.documentElement.scrollHeight > document.documentElement.offsetHeight){ // Explorer 6 strict mode
		xScroll = document.documentElement.scrollWidth;
	} else { // Explorer Mac...would also work in Mozilla and Safari
		xScroll = document.body.offsetWidth;
	}
	var windowWidth;
	if (self.innerHeight) { // all except Explorer
		windowWidth = self.innerWidth;
	} else if (document.documentElement && document.documentElement.clientHeight) { // Explorer 6 Strict Mode
		windowWidth = document.documentElement.clientWidth;
	} else if (document.body) { // other Explorers
		windowWidth = document.body.clientWidth;
	}
	// for small pages with total width less then width of the viewport
	if(xScroll < windowWidth){
		pageWidth = windowWidth;
	} else {
		pageWidth = xScroll;
	}
	return pageWidth;
}
function headGlue(){
	var head_pos,height_h;
	if(getPageSize() > 992){
		head_pos = $('.falshe-head').offset().top - $(window).scrollTop();
		if(head_pos<1){
			$('.scrolled-head').addClass('fixed');
			height_h = $('.scrolled-head').height();
			$('.falshe-head').height(height_h);
		}else{
			$('.scrolled-head').removeClass('fixed');
			$('.falshe-head').height(0);
		}
	}
}
$(document).ready(function(){
	ResizeCatalogBlock();
	ResizeMenuBlock();
	headGlue();
	/*PositionMenuBlock();*/
	window.onscroll = function() {
		headGlue();
	}
});
$(window).resize(function(){
	ResizeCatalogBlock();
	ResizeMenuBlock();
	headGlue();
})
