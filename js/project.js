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
$(document).ready(function(){
    $("#comments1").hide(); 

    $("#a1").toggle( function(){
        $("#comments1").slideDown(300);
        
    },
    function()
    {
        $("#comments1").slideUp(300);
     
    }
   ); 
});

$(document).ready(function(){
    $("#comments2").hide(); 

    $("#a2").toggle( function(){
        $("#comments2").slideDown(300);
        
    },
    function()
    {
        $("#comments2").slideUp(300);
     
    }
   ); 
});
$(document).ready(function(){
    $(".todolist").hide();
    $("#todoicon").toggle(function(){
        $(".todolist").show();
    },
    function()
    {
        $(".todolist").hide();
    }
    );
});
$(document).ready(function(){
    $(".todo").hide();
    $(".box").click(function(){
        $(".todo").show();
    });
    $(".outbox").click(function(){
        $(".todo").hide();
    });
    
});
$(document).ready(function(){
    $("#styl").hide(); 

    $(".btn1").toggle( function(){
        $("#styl").slideDown(300);
        
    },
    function()
    {
        $("#styl").slideUp(300);
     
    }
   ); 
});
