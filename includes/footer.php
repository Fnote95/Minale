    <script src="admin/js/vendor/jquery-1.11.3.min.js"></script>
    <!-- bootstrap JS
		============================================ -->
    <script src="admin/js/bootstrap.min.js"></script>
    <!-- meanmenu JS
		============================================ -->
    <script src="admin/js/jquery.meanmenu.js"></script>
    <!-- mCustomScrollbar JS
		============================================ -->
    <script src="admin/js/jquery.mCustomScrollbar.concat.min.js"></script>
    <!-- sticky JS
		============================================ -->
    <script src="admin/js/jquery.sticky.js"></script>
    <!-- scrollUp JS
		============================================ -->
    <script src="admin/js/jquery.scrollUp.min.js"></script>
    <!-- form validate JS
		============================================ -->
    <script src="admin/js/jquery.form.min.js"></script>
    <script src="admin/js/jquery.validate.min.js"></script>
    <script src="admin/js/form-active.js"></script>
    
    <!-- counterup JS
		============================================ -->
    <script src="admin/js/counterup/jquery.counterup.min.js"></script>
    <script src="admin/js/counterup/waypoints.min.js"></script>
    <script src="admin/js/counterup/counterup-active.js"></script>
    <!-- jvectormap JS
		============================================ -->
    <script src="admin/js/jvectormap/jquery-jvectormap-2.0.2.min.js"></script>
    <script src="admin/js/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <script src="admin/js/jvectormap/jvectormap-active.js"></script>
    <!-- peity JS
		============================================ -->
    <script src="admin/js/peity/jquery.peity.min.js"></script>
    <script src="admin/js/peity/peity-active.js"></script>
    <!-- sparkline JS
		============================================ -->
    <script src="admin/js/sparkline/jquery.sparkline.min.js"></script>
    <script src="admin/js/sparkline/sparkline-active.js"></script>

    <!-- input-mask JS
        ============================================ -->
    <script src="admin/js/input-mask/jasny-bootstrap.min.js"></script>
    <!-- chosen JS
        ============================================ -->
    <script src="admin/js/chosen/chosen.jquery.js"></script>
    <script src="admin/js/chosen/chosen-active.js"></script>
    <!-- select2 JS
        ============================================ -->
    <script src="admin/js/select2/select2.full.min.js"></script>
    <script src="admin/js/select2/select2-active.js"></script>
      <!-- modal JS
        ============================================ -->
    <script src="admin/js/modal-active.js"></script>
     <!-- datapicker JS
        ============================================ -->
    <script src="admin/js/datapicker/bootstrap-datepicker.js"></script>
    <script src="admin/js/datapicker/datepicker-active.js"></script>
    <!-- data table JS
        ============================================ -->
    <!-- modal JS
        ============================================ -->
    <script src="admin/js/modal-active.js"></script>
    <!-- main JS
    ============================================ -->
    <script src="admin/js/main.js"></script>

    <script src="admin/js/data-table/bootstrap-table.js"></script>
    <script src="admin/js/data-table/tableExport.js"></script>
    <script src="admin/js/data-table/data-table-active.js"></script>
    <script src="admin/js/data-table/bootstrap-table-editable.js"></script>
    <script src="admin/js/data-table/bootstrap-editable.js"></script>
    <script src="admin/js/data-table/bootstrap-table-resizable.js"></script>
    <script src="admin/js/data-table/colResizable-1.5.source.js"></script>
    <script src="admin/js/data-table/bootstrap-table-export.js"></script>

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