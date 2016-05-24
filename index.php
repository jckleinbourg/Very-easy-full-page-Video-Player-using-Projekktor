<!DOCTYPE html>
<html>
<head>
    <!-- Load player theme -->
    <link rel="stylesheet" href="assets/libs/projekktor/theme/projekktor.style.css" type="text/css" media="screen" />
    <!-- Load jquery -->
    <script type="text/javascript" src="assets/libs/jquery/jquery-1.9.1.min.js"></script>
    <!-- load projekktor -->
    <script type="text/javascript" src="assets/libs/projekktor/js/projekktor-1.3.09.min.js"></script>
	<style>

		body {
			background-color: #000000;
			color: #FFFFFF;
			font-family: Courier New,Courier,Lucida Sans Typewriter,Lucida Typewriter,monospace;
		}
		
		#wrapper {
			width: 100%;
			height: 100%;
			left: 50%;
			top: 50%;
			position: absolute;
		}

	</style>
</head>
<body>
<?php

	//get first .mp4 file from root folder :
	$search_dir = getcwd();
	$video_files_Ar = glob("$search_dir/*.mp4");
	sort($video_files_Ar);
	if (count($video_files_Ar) >0) {
		$video_filename = basename($video_files_Ar[0]);
	} else {
		echo 'no mp4 video in folder   : /';
		die();
	}
	
?>
	<div id="wrapper" class="projekktor"></div>
</body>
<script>

	//this maximizes the div to full window :
	function resize(){
		var wWidth = $(window).width();
		var wHeight = $(window).height();
		$('#wrapper').css('width',wWidth);
		$('#wrapper').css('height',wHeight);
		$('#wrapper').css('marginLeft',wWidth/-2);
		$('#wrapper').css('marginTop',wHeight/-2);
	}
	$(window).load(function(){
		resize();
	});
	$(window).resize(function(){
		resize();
	});

	//instanciates projekktor on document ready :
    $(document).ready(function() {
        projekktor('#wrapper', {
			autoplay: true,
			poster: 'media/intro.png',
			title: 'this is projekktor',
			playerFlashMP4: 'assets/libs/projekktor/swf/StrobeMediaPlayback/StrobeMediaPlayback.swf',
			playerFlashMP3: 'assets/libs/projekktor/swf/StrobeMediaPlayback/StrobeMediaPlayback.swf',
			<?='playlist: [ { 0: {src: "'  .  $video_filename  .  '", type: "video/mp4"}, } ]'?>//php write $video_filename
        }, function(player) {} // on ready
		);
		projekktor().setVolume(100);
		<?php
		
			//set play head to start position if specified <-- ex: index.php?start=42:03
			if (isset($_GET['start'])) {
				$str_time = $_GET['start'];
				sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
				$time_seconds = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;
				echo 'projekktor().setPlayhead('  .  $time_seconds  .  ');';
			}
			
		?>
    });

</script>
</html>