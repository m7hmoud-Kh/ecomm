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


  $("h1 span").on("click",function(){
  
    $(this).addClass("active").siblings().removeClass("active");
  
    if($(this).data("class") === ".login")
    {
      $(".singup").hide();
      $(".login").fadeIn();
    }
    else
    {
      $(".singup").fadeIn();
      $(".login").hide();
    }
    
  });

  $(".live_name").keyup(function(){
  
    $(".card-body h5").text($(this).val());

  });

  $(".live_desc").keyup(function(){
  
    $(".card-body p").text($(this).val());

  });
  $(".live_price").keyup(function(){

   $(".live-pre li").text("$"+$(this).val());
  });

});