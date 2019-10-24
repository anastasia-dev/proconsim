$(document).ready(function(){
    $("div[id^='reg_']").on('click', function(e){
        var divID = this.id; 
        var d_d =divID.replace('reg_','');
        var splitDD = d_d.split("_");
        var priceID = splitDD[1];        
        var sectionID = splitDD[0];  
        var regionCode = $(this).attr('data-regioncode');
        var regionPhone = $(this).attr('data-phone');
        var regionEmail = $(this).attr('data-email');      
        
        console.log(priceID);
        console.log(sectionID);  
                $.ajax({
					async: false,
					url:     'create-pdf.php', 
					type:     "POST", //метод отправки
					data: "sectionid="+sectionID+"&priceid="+priceID+"&code="+regionCode+"&phone="+regionPhone+"&email="+regionEmail,					
					success: function(response) { //Данные отправлены успешно
						console.log(response);
                        if(response=="err"){
                            
                        }else{
                            //window.open('https://proconsim.ru'+response, '_blank');
                        }						
					},
					error: function(response) { // Данные не отправлены
					}
				});
    });
   
   
   $("#res").html("Идет загрузка разделов и регионов...");  
   loadGroups(); 
   
    
    
});   
function loadGroups(){
    //$("#res").html("Идет загрузка разделов и регионов...");
    $.ajax({
					async: false,
					url:     'groups.php', 
					type:     "POST", //метод отправки
					data: "",	                    			
					success: function(response) { //Данные отправлены успешно
						//console.log(response);
                        if(response=="err"){
                            
                        }else{
                            //window.open('https://proconsim.ru'+response, '_blank');
                            $("#res").html(response);  
                            $("#res").prepend("Начинаем создавать файлы..");
                            createPDF();  
                                                     
                        }						
					},
					error: function(response) { // Данные не отправлены
					}
    });
}    

function createPDF(){
    $("#resPDF").prepend("Идет создание pdf-файлов...");
    $("div[id^='reg_']").each(function(){  
        var divID = this.id; 
        var d_d =divID.replace('reg_','');
        var splitDD = d_d.split("_");
        var priceID = splitDD[1];        
        var sectionID = splitDD[0];
        var regionCode = $(this).attr('data-regioncode');
        var regionPhone = $(this).attr('data-phone');
        var regionEmail = $(this).attr('data-email'); 
        
        //console.log(priceID);
        //console.log(sectionID);
        
        $.ajax({
					async: false,
					url:     'create-pdf.php', 
					type:     "POST", //метод отправки
					data: "sectionid="+sectionID+"&priceid="+priceID+"&code="+regionCode+"&phone="+regionPhone+"&email="+regionEmail,					
					success: function(response) { //Данные отправлены успешно
						console.log(response);
                        if(response=="err"){
                            
                        }else{
                            //window.open('https://proconsim.ru'+response, '_blank');
                            $("#res_"+sectionID+"_"+priceID).html(" - "+response);
                        }						
					},
					error: function(response) { // Данные не отправлены
					}
				});
        
    });    
} 