<?php
require_once "core/init.php";
include "includes/head.php";
//header('Access-Control-Allow-Origin: *');
?>
<audio id="chatAudio">
    <source src="sound.ogg" type="audio/ogg">
    <source src="sound.mp3" type="audio/mpeg">
</audio>

<button onclick="notif()">play</button>

<script>
	function notif(){
		jQuery('#chatAudio')[0].play();
	}
	
</script>