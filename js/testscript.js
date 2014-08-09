$(document).ready(function() {
$('.tile7').cycle({

fx:'uncover',
direction:"up"


        
});

});
$(document).ready(function(){
    
    $(".bigtile").hide(); 

    $(".lartile").toggle( function(){
        $(".bigtile").slideDown(300);
        
    },
    function()
    {
        $(".bigtile").slideUp(300);
     
    }
   );
   }); 
   



