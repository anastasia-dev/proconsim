$(document).ready(function() {
    
    $("tr[id^='compl']").on("click", function(){    
        var trid = this.id;
        var num=trid.replace('compl','');
        $("tr[id^='h_"+num+"_']").each(function(){
            $(this).toggle();
        });        
  });
});

