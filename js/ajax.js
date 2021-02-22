$(document).ready(function(){
    
    $('.row:first').css('background','#ccc').css('border','none');
    
    var c=$('.row').length;
    $(".delitem").live('click',function()
    {
     
       $('#delid').val($(this).attr('name'));
       $('#delform').ajaxSubmit();
       var i=$(this).index(".delitem");
    
       $('.row').eq(i+1).css('background','#ffcccc');
       $('.row').eq(i+1).fadeOut('slow',function(){
                  $('.row').eq(i+1).remove();
      c--;
      if (c==1) $('.row:first').html('Нет ни одного товара!');  
       });
         
       
    })
     
})


