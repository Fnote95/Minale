</div>
<hr>
<hr>
    <!-- Footer Start-->
    <audio id="chatAudio">

        <source src="sounds/note.mp3" type="audio/mpeg">
    </audio>
    <div class="footer-copyright-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="footer-copy-right">
                        <p>Copyright &#169; 2019 Powered by <a href="https://signumtechplc.com">Signum Technologies</a>.</p>
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
    <script src="js/Lobibox.js"></script>
    <script type="js/notification-active.js"></script>
    <script src="js/data-table/bootstrap-table.js"></script>
    <script src="js/data-table/tableExport.js"></script>
    <script src="js/data-table/data-table-active.js"></script>
    <script src="js/data-table/bootstrap-table-editable.js"></script>
    <script src="js/data-table/bootstrap-editable.js"></script>
    <script src="js/data-table/bootstrap-table-resizable.js"></script>
    <script src="js/data-table/colResizable-1.5.source.js"></script>
    <script src="js/data-table/bootstrap-table-export.js"></script>

<script>
function check_request(){
           setInterval(function(){
           jQuery.ajax({
              url: 'api/check_req_num.php',
              type: 'POST',
              data: {},
              success: function(data){
                  jQuery('#req_num').html(data);
              },
              error: function(){alert("something went wrong!")},
          });  
         }, 100);
  
}
function request(){
   setInterval(function(){
   jQuery.ajax({
      url: 'api/check_request.php',
      type: 'POST',
      data: {},
      success: function(data){
          jQuery('#req').html(data);
      },
      error: function(){alert("something went wrong!")},
  });
  }, 100);    
}
function notify(){
         var check=0;
         var num2
         setInterval(function(){
              jQuery.ajax({
                url: 'api/check_orders.php',
                type: 'POST',
                data: {},
                success: function(data){
                    var check2=data[0];
                    var check3=data[1];
                    if (check!=check2) {
                      var audio = new Audio('sounds/sound.mp3');
                      audio.play();
                      check=check2;
                    }
                    if (num2!=check3) {
                      var audio = new Audio('sounds/sound.mp3');
                      audio.play();
                      num2=check3;
                    }
                    var num=data.split(",");
                    jQuery('#ei').html(num[0]);
                    jQuery('#to').html(num[1]);

                },
                error: function(){alert("something went wrong!")},
            });
         }, 100);
}
jQuery('#ei').change(function(){
  jQuery('#chatAudio')[0].play();
});
function update_btn_status(){

  var ing_type=jQuery('#ing_type').val();
  
  if(ing_type==1||ing_type==2){
    jQuery('#comp').attr("disabled", false);
  }
  else{
    jQuery('#comp').attr("disabled", true);
  }
}
function update_review_status(){
  var ing_type=jQuery('#ing_type').val();
  if(ing_type==3){
    jQuery('#comps').val("None");
  }
  else{
    jQuery('#comps').val("");
  }
}
function update_modal(){
  var ing_type=jQuery('#ing_type').val();
  if(ing_type==2){
    for (var i = 1; i <11; i++) {
      jQuery('#quantity'+i).attr("disabled", true);
      jQuery('#label'+i).html("");
    }
  }
    else{
    for (var i = 1; i <11; i++) {
      jQuery('#quantity'+i).attr("disabled", false);
    }
  }
  
}
jQuery('select[name="ing_type"]').change(function(){
  update_btn_status();
  update_review_status();
  update_modal();
});


jQuery('input[name="comp_kitchens"]').change(function(){
  var num_kitchens=jQuery('#comp_kitchens').val();
             jQuery.ajax({
                url: '../api/update_kitchens.php',
                type: 'POST',
                data: {num_kitchens : num_kitchens},
                success: function(data){
                    jQuery('#kit_form').html(data);
                },
                error: function(){alert("something went wrong!")},
            });
});








    ///////////////////////////////////////////////////////////////////////////////
   
    function msToTime(duration) {
      var milliseconds = parseInt((duration % 1000) / 100),
        seconds = Math.floor((duration / 1000) % 60),
        minutes = Math.floor((duration / (1000 * 60)) % 60),
        hours = Math.floor((duration / (1000 * 60 * 60)) % 24);

      hours = (hours < 10) ? "0" + hours : hours;
      minutes = (minutes < 10) ? "0" + minutes : minutes;
      seconds = (seconds < 10) ? "0" + seconds : seconds;

      return hours + ":" + minutes + ":" + seconds + "." + milliseconds;
    }
   
    
////////////////////////////////////////////////////////////////////////////////////////
   // alert();

	function disapear(){
		jQuery('#dis').html(" ");
	}
     function updateComp(){
            var ing_type=jQuery('#ing_type').val();
            var compString='';
            for (var i = 1; i <11; i++) {
                if (ing_type == 1) {
                  if(jQuery('#comp'+i).val()!=''){
                      compString+=''+jQuery('#comp'+i).val()+':'+jQuery('#quantity'+i).val()+',';
                  }
                              
                }
                else{
                    if(jQuery('#comp'+i).val()!=''){
                      compString+=''+jQuery('#comp'+i).val()+':'+'NA'+',';
                    }
                  }      
                }
                jQuery('#comps').val(compString);
            }
/////////////////////////////////////////////////////
        function update_takeout(){

        
        
            jQuery.ajax({
                url: 'api/update_takeouts.php',
                type: 'POST',
                data: {},
                success: function(data){
                    jQuery('#take_out').html(data);
                    update_takeouts_processed();
                },
                error: function(){alert("something went wrong!")},
            });
    }
    //////////////////////////////////////////////////////////
    function update_queued(){

        
        
            jQuery.ajax({
                url: 'api/update_orders.php',
                type: 'POST',
                data: {},
                success: function(data){
                    jQuery('#ord').html(data);
                    update_orders();
                },
                error: function(){alert("something went wrong!")},
            });
    }
    //////////////////////////////////////////////////////////////////////////
        function update_process(){

        
        
            jQuery.ajax({
                url: 'api/update_processed.php',
                type: 'POST',
                data: {},
                success: function(data){
                    jQuery('#pro').html(data);
                    update_processed();
                },
                error: function(){alert("something went wrong!")},
            });
    }
////////////////////////////////////////////////////////////////////////
    function update_takeouts_processed(){

        
         setInterval(function(){
            jQuery.ajax({
                url: 'api/update_takeouts.php',
                type: 'POST',
                data: {},
                success: function(data){
                    jQuery('#take_out').html(data);
                },
                error: function(){alert("something went wrong!")},
            });
         }, 5000);
    }
    //////////////////////////////////////////////////////////////////////////////
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
         }, 5000);
    }
    function update_processed(){
               setInterval(function(){
            jQuery.ajax({
                url: 'api/update_processed.php',
                type: 'POST',
                data: {},
                success: function(data){
                    jQuery('#pro').html(data);
                    
                },
                error: function(){alert("something went wrong!")},
            });
         }, 5000);
    }



var canvas = document.getElementById("canvas2");
var ctx = canvas.getContext("2d");
var radius = canvas.height / 2;
ctx.translate(radius, radius);
radius = radius * 0.90
setInterval(drawClock, 1000);

function drawClock() {
  drawFace(ctx, radius);
  drawNumbers(ctx, radius);
  drawTime(ctx, radius);
}

function drawFace(ctx, radius) {
  var grad;
  ctx.beginPath();
  ctx.arc(0, 0, radius, 0, 2*Math.PI);
  ctx.fillStyle = 'white';
  ctx.fill();
  grad = ctx.createRadialGradient(0,0,radius*0.95, 0,0,radius*1.05);
  grad.addColorStop(0, '#333');
  grad.addColorStop(0.5, 'white');
  grad.addColorStop(1, '#333');
  ctx.strokeStyle = grad;
  ctx.lineWidth = radius*0.1;
  ctx.stroke();
  ctx.beginPath();
  ctx.arc(0, 0, radius*0.1, 0, 2*Math.PI);
  ctx.fillStyle = '#333';
  ctx.fill();
}

function drawNumbers(ctx, radius) {
  var ang;
  var num;
  ctx.font = radius*0.15 + "px arial";
  ctx.textBaseline="middle";
  ctx.textAlign="center";
  for(num = 1; num < 13; num++){
    ang = num * Math.PI / 6;
    ctx.rotate(ang);
    ctx.translate(0, -radius*0.85);
    ctx.rotate(-ang);
    ctx.fillText(num.toString(), 0, 0);
    ctx.rotate(ang);
    ctx.translate(0, radius*0.85);
    ctx.rotate(-ang);
  }
}

function drawTime(ctx, radius){
    var now = new Date();
    var hour = now.getHours();
    var minute = now.getMinutes();
    var second = now.getSeconds();
    //hour
    hour=hour%12;
    hour=(hour*Math.PI/6)+
    (minute*Math.PI/(6*60))+
    (second*Math.PI/(360*60));
    drawHand(ctx, hour, radius*0.5, radius*0.07);
    //minute
    minute=(minute*Math.PI/30)+(second*Math.PI/(30*60));
    drawHand(ctx, minute, radius*0.8, radius*0.07);
    // second
    second=(second*Math.PI/30);
    drawHand(ctx, second, radius*0.9, radius*0.02);
}

function drawHand(ctx, pos, length, width) {
    ctx.beginPath();
    ctx.lineWidth = width;
    ctx.lineCap = "round";
    ctx.moveTo(0,0);
    ctx.rotate(pos);
    ctx.lineTo(0, -length);
    ctx.stroke();
    ctx.rotate(-pos);
}






	
</script>
</body>
</html>