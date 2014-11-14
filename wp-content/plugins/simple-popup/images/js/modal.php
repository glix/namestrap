<?php
function SimplePopup_javascript($delay=10)
	{
?>
<script type="text/javascript">

$(document).ready(function() {	

	
	$('#simple-popup').click(function(e) {
		e.preventDefault();
		
		
		var id = $(this).attr('href');
		var maskHeight = $(document).height();
		var maskWidth = $(window).width();
		$('#spmask').css({'width':maskWidth,'height':maskHeight});
		$('#spmask').fadeIn(1000);	
		$('#spmask').fadeTo("slow",0.8);	
		var winH = $(window).height();
		var winW = $(window).width();
		$(id).css('top',  winH/2-$(id).height()/2);
		$(id).css('left', winW/2-$(id).width()/2);
		$(id).fadeIn(600);
	
	});
	$('.window .close').click(function (e) {
		e.preventDefault();
		$.cookie('popup_hide','true');
		$('#spmask').hide();
		$('.window').hide();
	});		
	
	$(document).keyup(function(e) {
  	if (e.keyCode == 27) { $('.window .close').click(); }
});

$("#simple-popup").bind('click',function()
{
	return false;
});
var SimplePopup_delay = setTimeout("$('#simple-popup').trigger('click')",<?php echo $delay; ?>);
});



</script>

<?php
}
?>