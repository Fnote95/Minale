</div>
<hr>
<hr>
    <!-- Footer Start-->
    <div class="footer-copyright-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="footer-copy-right">
                        <p>Copyright &#169; 2018 Powered by <a href="https://signumtechplc.com">Signum Technologies</a>.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End-->
    <!-- jquery
		============================================ -->

    <script src="js/vendor/jquery-1.11.3.min.js"></script>
    <!-- bootstrap JS
		============================================ -->
    <script src="js/bootstrap.min.js"></script>
    <!-- meanmenu JS
		============================================ -->
    <script src="js/jquery.meanmenu.js"></script>
    <!-- mCustomScrollbar JS
		============================================ -->
    <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
    <!-- sticky JS
		============================================ -->
    <script src="js/jquery.sticky.js"></script>
    <!-- scrollUp JS
		============================================ -->
    <script src="js/jquery.scrollUp.min.js"></script>
    <!-- scrollUp JS
        ============================================ -->
    <script src="js/wow/wow.min.js"></script>
    <!-- form validate JS
		============================================ -->
    <script src="js/jquery.form.min.js"></script>
    <script src="js/jquery.validate.min.js"></script>
    <script src="js/form-active.js"></script>
    
    <!-- counterup JS
		============================================ -->
    <script src="js/counterup/jquery.counterup.min.js"></script>
    <script src="js/counterup/waypoints.min.js"></script>
    <script src="js/counterup/counterup-active.js"></script>
    <!-- jvectormap JS
		============================================ -->
    <script src="js/jvectormap/jquery-jvectormap-2.0.2.min.js"></script>
    <script src="js/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <script src="js/jvectormap/jvectormap-active.js"></script>
    <!-- peity JS
		============================================ -->
    <script src="js/peity/jquery.peity.min.js"></script>
    <script src="js/peity/peity-active.js"></script>
    <!-- sparkline JS
		============================================ -->
    <script src="js/sparkline/jquery.sparkline.min.js"></script>
    <script src="js/sparkline/sparkline-active.js"></script>
    <!-- flot JS
		============================================ -->
    <script src="js/flot/Chart.min.js"></script>
    <script src="js/flot/dashtwo-flot-active-range.js"></script>
    <script src="js/flot/dashtwo-flot-active.js"></script>

  
    <!-- Charts JS
        ============================================ -->
    <script src="js/charts/Chart.js"></script>

    <!-- input-mask JS
        ============================================ -->
    <script src="js/input-mask/jasny-bootstrap.min.js"></script>
    <!-- chosen JS
        ============================================ -->
    <script src="js/chosen/chosen.jquery.js"></script>
    <script src="js/chosen/chosen-active.js"></script>
    <!-- select2 JS
        ============================================ -->
    <script src="js/select2/select2.full.min.js"></script>
    <script src="js/select2/select2-active.js"></script>
      <!-- modal JS
        ============================================ -->
    <script src="js/modal-active.js"></script>
     <!-- datapicker JS
        ============================================ -->
    <script src="js/datapicker/bootstrap-datepicker.js"></script>
    <script src="js/datapicker/datepicker-active.js"></script>
    <!-- data table JS
        ============================================ -->
    <!-- modal JS
        ============================================ -->
    <script src="js/modal-active.js"></script>
    <!-- main JS
    ============================================ -->
    <script src="js/main.js"></script>

    <script src="js/data-table/bootstrap-table.js"></script>
    <script src="js/data-table/tableExport.js"></script>
    <script src="js/data-table/data-table-active.js"></script>
    <script src="js/data-table/bootstrap-table-editable.js"></script>
    <script src="js/data-table/bootstrap-editable.js"></script>
    <script src="js/data-table/bootstrap-table-resizable.js"></script>
    <script src="js/data-table/colResizable-1.5.source.js"></script>
    <script src="js/data-table/bootstrap-table-export.js"></script>
<script>

	function disapear(){
		jQuery('#dis').html(" ");
	}
     function updateComp(){
            var compString='';
            for (var i = 1; i <11; i++) {
                if(jQuery('#comp'+i).val()!=''){
                    compString+=''+jQuery('#comp'+i).val()+':'+jQuery('#quantity'+i).val()+',';
                }
                }
                jQuery('#comps').val(compString);
            }

    function update_orders(){

        
         setInterval(function(){
            jQuery.ajax({
                url: 'api/update_orders.php',
                type: 'POST',
                data: {},
                success: function(data){
                    jQuery('#ord').html(data);
                },
                error: function(){alert("something went wrong!")},
            });
         }, 500);
    }
	
</script>
</body>
</html>