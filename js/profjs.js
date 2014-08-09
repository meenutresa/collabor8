
$(document).ready(function(){
	             
    $(".nav1").hide(); 

    $(".container").toggle( function(){
        $(".nav1").slideDown(300);
        
    },
    function()
    {
        $(".nav1").slideUp(300);
     
    }); 
                $(".test1").hover(function()
                {
                    $(".tilecolor1").css("background", "#BC8F8F");
                }, function()
                {
                    $(".tilecolor1").css("background", "#F0F0F0");
                });
           
                $(".test2").hover(function()
                {
                    $(".tilecolor2").css("background", "#BC8F8F");
                }, function()
                {
                    $(".tilecolor2").css("background", "#F0F0F0");
                });
            
                $(".test3").hover(function()
                {
                    $(".tilecolor3").css("background", "#BC8F8F");
                }, function()
                {
                    $(".tilecolor3").css("background", "#F0F0F0");
                });
            
   
});

