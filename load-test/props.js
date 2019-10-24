$(document).ready(function(){
    $('#sendProps').on('click', function(e){        
             $('input[type="checkbox"]:checked').each(function() { 
                $.ajax({
					url:     '/load-test/clear-props.php', 
					type:     "POST", //метод отправки
					data: "prop="+$(this).val(),					
					success: function(response) { //Данные отправлены успешно
						console.log(response);						
						$("#resClear").html(response);
					},
					error: function(response) { // Данные не отправлены
					}
				});
             });  
    });
});    