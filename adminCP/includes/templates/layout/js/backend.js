$(function(){

  $('[placeholder]').focus (function(){
    
    $(this).attr("data-text" , $(this).attr("placeholder"));
    $(this).attr("placeholder", "");
    
  }); 

  $('[placeholder]').blur (function(){
            
    $(this).attr('placeholder',$(this).attr('data-text'));
 
  });

   $("input").each(function(){
     
    if($(this).attr("required") === "required")
    {
         $(this).after("<span class='ask'>*</span>");
    }
 
  });


  $(".showpass").hover(function(){
      
    $("input[type='password']").attr("type","text");
    $(this).css({
      color: "#080",
    })

  });
  
  $("input[type='password']").blur(function(){
      
    $(this).attr("type","password");
    $(".showpass").css({
      color: "#000",
    })

  });

  $(".confirm").click(function(){

      return confirm("are you sure sir ?");
  });

  $(".cats h3").click(function(){
  
    $(this).next(".full_view").fadeToggle();

  });
   
  $(".ord span").click(function(){

     $(this).addClass("active").siblings("span").removeClass("active");
     
     if($(this).data("view") === "full")
     {
       $(".cats .full_view").fadeIn();
     }
     else
     {
      $(".cats .full_view").fadeOut();
     }
     
  });

  $('.toggleplus').click(function() {

    $(this).toggleClass('min').parent().next('.panel_body').fadeToggle(100);

    
    if ($(this).hasClass('min')) {
        $(this).html('<i class="fa fa-minus"></i>');
    } else {
        $(this).html('<i class="fa fa-plus "></i>');
    }
    
});

  $(".child").hover(function(){
    
    $(this).find(".child_de").fadeIn(400);

  },function(){
        
    $(this).find(".child_de").fadeOut(400);

  });
  
});