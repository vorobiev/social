$(document).ready(function(){
  $('#mark_submit').click(function(){
    
   site_id = $('input[name="site_id"]').val(); 
   
   $.post("/site/mark/id/" + site_id , 
   	  { value: $('input[name="mark"]:checked').val() },
      function(data) {
        alert(data);
      });    
    
   });
});

function delete_comment( id )
{
	$('#comment' + id).hide();	
	$.post("/site/deletecomment/" , 
	  { comment_id: id },
   function(data) {
     alert(data);
   });    
  
}
