$(function(){

  $('[placeholder]').focus (function(){
    
    $(this).attr("data-text" , $(this).attr("placeholder"));
    $(this).attr("placeholder", "");
    
  }); 

  $('[placeholder]').blur (function(){
            
    $(this).attr('placeholder',$(this).attr('data-text'));
 
  });


});