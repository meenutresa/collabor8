// JavaScript Document
$(document).ready(function(){
    $(".menu").hide(); 

    $("#dropdown").toggle( function(){
        $(".menu").slideDown(300);
        
    },
    function()
    {
        $(".menu").slideUp(300);
     
    }
   ); 
});