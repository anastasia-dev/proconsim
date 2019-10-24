$(document).ready(function() {
    
    $("#addForm").on("click", function(){    
    var count = $("input[name=count]").val(); 
    count++;     
    //var row = ('<div class=\"row\" id=\"new'+count+'\"></div>');
    //$(row).insertBefore($("#addForm"));
    //$("#new"+count).html("NEW"); 
    $("input[name=count]").val(count); 
    
    $.ajax({  
            url: "ajax_add.php" ,
            type: "POST",                              
            data: "count="+count,
            success: function(data){  
            //console.log(data);
            //$("#new"+count).html(data);  
            $(data).insertBefore($("#addForm"));                                 
            } 
        });
        
  });


  $("#shipmentDate").on("blur", function(){ 
    var value = $(this).val();
     //$(this).css('border','1px solid #dddddd');
	  if(!ValidateDate(value)){
		alert("Неверная дата!");
        //$(this).css('border','1px solid #ff0000');
	  }
  });  


  $("form[id='complaints']").on("blur", "input[id^='artikul_']", function(){    
    var inputid = this.id; 
    var count = inputid.replace('artikul_','');
    var value = $(this).val();
    var filialPriceID = $("#filialPriceID").val();
    $.ajax({  
            url: "ajax_product.php" ,
            type: "POST", 
            dataType: "json",                             
            data: "artikul="+value+"&filialPriceID="+filialPriceID,
            success: function(json){  
            //console.log(json);
            if(json['err']==1){
                alert("Нет товара!");
            }else{
                if(json['err']==2){
                    alert("Нет цены!");
                }else{    
                    $("#productID_"+count).val(json['ID']);
                    $("#product_"+count).val(json['NAME']);
                    $("#price_"+count).val(json['PRICE']);
                }
            }
                                           
            } 
        });
  });
  
  $("form[id='complaints']").on("blur", "input[id^='quantity_']", function(){ 
    var inputid = this.id; 
    var count = inputid.replace('quantity_','');
    var value = $(this).val();
    var price = $("#price_"+count).val();
    var summa = number_format(value*price, 0, '.', '');
    $("#summa_"+count).val(summa);
    //console.log(summa);
  });  
  
   $("#sendComplaint").on("click", function(){
        $(".required").css('border','1px solid #dddddd');
        var err=0;
        $("#resErr").hide();         
        $('form#complaints input,select,textarea').each(function(n,element){
            if($("#"+element.id).hasClass('required')){
                //console.log($("#"+element.id).val());
                if($("#"+element.id).val()==''){
                    $("#"+element.id).css('border','1px solid #ff0000');
                    err=1;
                } 
				if(element.id=="shipmentDate"){
                    if(!ValidateDate($("#"+element.id).val())){
                       $("#"+element.id).css('border','1px solid #ff0000');
                       err=1;
					}
				}               
            }
        });   
        if(err==1){
            $("#resErr").show();
        }else{
            $("#complaints").submit();
        } 
   });  
   $("form[id='complaints']").on("change", "input[type='file']", function () {    
     if(this.files[0].size > 10000000) {
       alert("Превышен допустимый размер файла. Разрешены файлы не более 10Mb.");
       $(this).val('');
     }else{
        var name = this.files[0].name;
        var ext = name.split('.');
        ext = ext[ext.length-1].toLowerCase();      
        var arrayExtensions = ['png','jpg','jpeg','pdf','xls','xlsx','doc','docx','tiff'];        
        if (arrayExtensions.lastIndexOf(ext) == -1) {
            alert("Загрузить можно только файлы изображений (jpg, jpeg, png, tiff) и документов (pdf, xls, xlsx, doc, docx)");
            $(this).val('');
        }
     }
    });  
});    

function ValidateDate(dateStr){  
    var str = dateStr.split(".");
    dateStr = str[2]+"."+str[1]+"."+str[0];
    var inDate = new Date(dateStr);    
    if(inDate=='Invalid Date'){return false;}
    return true;
} 

function number_format(number, decimals, dec_point, thousands_sep) {
  number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
  var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
    s = '',
    toFixedFix = function(n, prec) {
      var k = Math.pow(10, prec);
      return '' + (Math.round(n * k) / k)
        .toFixed(prec);
    };
  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n))
    .split('.');
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
  }
  if ((s[1] || '')
    .length < prec) {
    s[1] = s[1] || '';
    s[1] += new Array(prec - s[1].length + 1)
      .join('0');
  }
  return s.join(dec);
}   