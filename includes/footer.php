<script>
	var element = document.getElementById('back');
	element.setAttribute('href', document.referrer);
	element.onclick = function() {
	  history.back();
	  return false;
	} 

	function increment(ids){
		var element = jQuery('#quan'+ids).val();
		var result=parseInt(element)+1;

		jQuery('#quan'+ids).val(result);
	}
	function decrement(ids){
		var element = jQuery('#quan'+ids).val();
		var result=parseInt(element)-1;
		if (result<=0) {
			var result=1;
		}

		jQuery('#quan'+ids).val(result);
	}
	function review(){
		jQuery.ajax({
                url: 'api/corner_menu.php',
                type: 'POST',
                data: {},
                success: function(data){
                    jQuery('#body').html(data);
                },
                error: function(){alert("something went wrong!")},
            });
	}
</script>
</body>
</html>