<?php
ob_start();?>

<div class="container-fluid" style="background-image:linear-gradient(to top, rgba(252,84,4,1) 1%, rgba(255,0,0,1) 100%) ;">
	<div class="row pull-right" style="padding: 15px" >
		<a href="">
			<i class="fa fa-close" style="font-size: 25px; color: white;"></i>
		</a>
	</div>	
	<div style="padding-top: 50%; padding-bottom: 100%; color: white">
		<a href="review" style="color: white"><h1 class="text-center" style="padding: 15px"><b>REVIEW</b></h1></a>
		<a href="main" style="color: white"><h1 class="text-center" style="padding: 15px"><b>MAIN MENU</b></h1></a>
		<a href="index" style="color: white"><h1 class="text-center" style="padding: 15px"><b>HOME</b></h1></a>
	</div>
</div>
<?php echo ob_get_clean();?>