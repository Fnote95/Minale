<script>
	var element = document.getElementById('back');
	element.setAttribute('href', document.referrer);
	element.onclick = function() {
	  history.back();
	  return false;
	} 

	function increment(){
		var element = jQuery('#quan').val();
		var result=parseInt(element)+1;
		jQuery('#quan').val(result);
	}
	function decrement(){
		var element = jQuery('#quan').val();
		var result=parseInt(element)-1;
		if (result<=0) {
			var result=1;
		}
		jQuery('#quan').val(result);
	}
	function review(){
		jQuery('#body').html('<div class="container-fluid"><div style="width: 100%; height=50%;"><h1>review</h1></div></div>');
	}
</script>
</body>
</html>