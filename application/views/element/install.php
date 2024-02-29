<!DOCTYPE html>
<html>
	<head>
		<title>Install</title>
		<style>
			body {
			height: 100%;
			margin: 0;
			}
			
			.gradient-button {
			position: absolute;
			z-index: 1000000000;
			display: block;
			top: calc(50% - 2.5rem - 5px);
			left: calc(50% - 6rem - 5px);
			height: 5rem;
			width: 12rem;
			margin: auto;
			background: transparent linear-gradient(to top left, rgba(249, 208, 129, 0.2) 0%, rgba(227, 2, 62, 0.2) 40%, rgba(49, 128, 135, 0.2) 100%);
			border: 5px solid transparent;
			border-image-source: linear-gradient(to top left, #f9d081 0%, #e3023e 40%, #318087 100%);
			border-image-slice: 1;
			transition: transform 0.25s;
			letter-spacing: 0.2rem;
			font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
			font-size: 1.25rem;
			font-weight: 300;
			text-align: center;
			text-decoration: none;
			text-transform: uppercase;
			color: #333;
			}
			.gradient-button::after {
			content: "";
			position: absolute;
			top: -5px;
			left: -5px;
			width: 100%;
			height: 100%;
			margin: auto;
			border: 5px solid transparent;
			opacity: 0;
			pointer-events: none;
			border-image-slice: 1;
			z-index: -1;
			background: transparent linear-gradient(to bottom left, rgba(249, 208, 129, 0.25) 10%, rgba(227, 2, 62, 0.25) 30%, rgba(49, 128, 135, 0.25) 90%);
			border-image-source: linear-gradient(to bottom left, #f9d081 10%, #e3023e 30%, #318087 90%);
			transition: opacity 1s;
			}
			.gradient-button:active {
			transform: scale(0.96);
			}
			.gradient-button:active::before {
			opacity: 1;
			}
			.gradient-button::before {
			content: "";
			position: absolute;
			top: -5px;
			left: -5px;
			width: 100%;
			height: 100%;
			margin: auto;
			border: 5px solid transparent;
			opacity: 0;
			pointer-events: none;
			border-image-slice: 1;
			z-index: 0;
			border-image-source: linear-gradient(to bottom left, #f9d081 20%, #e3023e 40%, #318087 70%);
			transition: opacity 0.5s;
			}
			.gradient-button:hover::after {
			opacity: 1;
			cursor: pointer;
			}
			
			body {
			/* forgive me for this junk */
			background: url("data:image/png;base64,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") center center;
			}			@import url("https://fonts.googleapis.com/css?family=Nunito:400,600,700|Roboto:300,400,500,700");
			body {
			margin: 0;
			padding: 0;
			overflow: hidden;
			}
			body.loaded {
			overflow-y: auto;
			}
			
			.overlay {
			position: fixed;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			z-index: 100000000;
			}
			.overlay .overlayDoor:before, .overlay .overlayDoor:after {
			content: "";
			position: absolute;
			width: 50%;
			height: 100%;
			background: #111;
			transition: 0.5s cubic-bezier(0.77, 0, 0.18, 1);
			transition-delay: 0.8s;
			}
			.overlay .overlayDoor:before {
			left: 0;
			}
			.overlay .overlayDoor:after {
			right: 0;
			}
			.overlay.loaded .overlayDoor:before {
			left: -50%;
			}
			.overlay.loaded .overlayDoor:after {
			right: -50%;
			}
			.overlay.loaded .overlayContent {
			opacity: 0;
			margin-top: -15px;
			}
			.overlay .overlayContent {
			position: relative;
			width: 100%;
			height: 100%;
			display: flex;
			justify-content: center;
			align-items: center;
			flex-direction: column;
			transition: 0.5s cubic-bezier(0.77, 0, 0.18, 1);
			}
			.overlay .overlayContent .skip {
			display: block;
			width: 130px;
			text-align: center;
			margin: 50px auto 0;
			cursor: pointer;
			color: #fff;
			font-family: "Nunito";
			font-weight: 700;
			padding: 12px 0;
			border: 2px solid #fff;
			border-radius: 3px;
			transition: 0.2s ease;
			}
			.overlay .overlayContent .skip:hover {
			background: #ddd;
			color: #444;
			border-color: #ddd;
			}
			
			.loader {
			width: 128px;
			height: 128px;
			border: 3px solid #fff;
			border-bottom: 3px solid transparent;
			border-radius: 50%;
			position: relative;
			-webkit-animation: spin 1s linear infinite;
			animation: spin 1s linear infinite;
			display: flex;
			justify-content: center;
			align-items: center;
			}
			.loader .inner {
			width: 64px;
			height: 64px;
			border: 3px solid transparent;
			border-top: 3px solid #fff;
			border-radius: 50%;
			-webkit-animation: spinInner 1s linear infinite;
			animation: spinInner 1s linear infinite;
			}
			
			@-webkit-keyframes spin {
			0% {
			transform: rotate(0deg);
			}
			100% {
			transform: rotate(360deg);
			}
			}
			
			@keyframes spin {
			0% {
			transform: rotate(0deg);
			}
			100% {
			transform: rotate(360deg);
			}
			}
			@-webkit-keyframes spinInner {
			0% {
			transform: rotate(0deg);
			}
			100% {
			transform: rotate(-720deg);
			}
			}
			@keyframes spinInner {
			0% {
			transform: rotate(0deg);
			}
			100% {
			transform: rotate(-720deg);
			}
			}
			body {
			background: #eee;
			}
			
			.header {
			background: url("https://picsum.photos/4096/2160?random=1") center/cover;
			background-size: cover;
			height: 100vh;
			}
			.header .darken {
			background: rgba(0, 0, 0, 0.5);
			width: 100%;
			height: 100%;
			display: flex;
			justify-content: center;
			align-items: center;
			flex-direction: column;
			}
			.header .darken h1 {
			font-family: "Nunito";
			font-weight: 700;
			color: #fff;
			margin: 0 0 20px 0;
			text-align: center;
			}
			.header .darken h1 span {
			font-size: 12px;
			top: -10px;
			position: relative;
			}
			.header .darken p {
			color: #fff;
			font-family: "Roboto";
			font-weight: 700;
			text-align: center;
			width: 500px;
			margin: 0 auto;
			line-height: 25px;
			}
			
			.contentOther {
			background: #fff;
			width: 900px;
			margin: 0 auto;
			padding: 20px;
			box-sizing: border-box;
			box-shadow: 0 3px 5px rgba(0, 0, 0, 0.1);
			}
			.contentOther .video {
			height: 484px;
			width: 100%;
			border-radius: 5px;
			}
			.contentOther h1 {
			font-family: "Roboto";
			margin: 0 0 10px 0;
			font-weight: 400;
			}
			.gradient-button.install{cursor: pointer;}
		</style>
		<script src="<?= base_url('assets/'); ?>vendor/jquery/jquery.min.js"></script>
	</head>
	<body>
		<button class="gradient-button install" type="button" type="button" id="isntall">INSTALL</button>
		
		<div class="overlay">
			<div class="overlayDoor"></div>
			<div class="overlayContent">
				<div class="loader">
					<div class="inner"></div>
				</div>
			</div>
		</div>
		
	</body>
	<script>
		$(document).ready(function() {
		$('.overlay, body').addClass('loaded');
		
		})
		var base_url = '<?= base_url(); ?>';
		$(document).on('click', '.install', function() {
		$('.install').css({'display':'none'})
		$('.overlay, body').removeClass('loaded');
		$.ajax({
		'url': base_url + 'migrate',
		'method': 'POST',
		'dataType':'json',
		beforeSend: function(){	 
		$(".loadings").show();
		},
		success: function(data) {
		if(data.status==200){
		install();
		// $('.overlay, body').addClass('loaded');
		// setInterval('location.reload()', 5000);
		}else{
		$('.install').css({'display':'block'})
		$('.overlay, body').removeClass('loaded');
		}
		},
		error: function(xhr, status, error) {
		var err = xhr.responseText ;
		alert(err)
		$('.overlay, body').addClass('loaded');
		}
		})
		});
		
		function install()
		{
			$.ajax({
				'url': base_url + 'install',
				'method': 'POST',
				'dataType':'json',
				beforeSend: function(){	 
					$(".loadings").show();
				},
				success: function(data) {
				console.log(data);
					if(data.status==200){
						$('.overlay, body').addClass('loaded');
						setInterval('location.reload()', 2000);
						}else{
						$('.install').css({'display':'block'})
						$('.overlay, body').removeClass('loaded');
					}
				},
				error: function(xhr, status, error) {
					var err = xhr.responseText ;
					alert(err)
					$('.overlay, body').addClass('loaded');
				}
			})
		}
	</script>
</html>