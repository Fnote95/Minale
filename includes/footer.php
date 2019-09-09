    <script src="admin/js/vendor/jquery-1.11.3.min.js"></script>
    <!-- bootstrap JS
		============================================ -->

 
    <script src="admin/js/jquery.form.min.js"></script>
    <script src="admin/js/jquery.validate.min.js"></script>
    <script src="admin/js/form-active.js"></script>

    <!-- select2 JS
        ============================================ -->
    <script src="admin/js/select2/select2.full.min.js"></script>
    <script src="admin/js/select2/select2-active.js"></script>
  
      <!-- modal JS
        ============================================ -->

    <script src="admin/js/modal-active.js"></script>
    <!-- main JS
    ============================================ -->
         

    <script src="admin/js/main.js"></script>


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
	function update_price(price,ids){
		var quantity = jQuery('#quan'+ids).val();

		var result = parseInt(price)*parseInt(quantity);
		result=result + ' Br.'
		jQuery('#price'+ids).html(result);
	}
	function update_orders(){
		setInterval();
	}
</script>
</body>
</html>