<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- SEO & Social Sharing Purposes, For study -->
	<meta name="description" content="A brief description of your site.">
	<meta name="keywords" content="HTML, CSS, website, tutorial">
	<meta name="author" content="Your Name">

	<!-- open Graph -->
	<meta property="og:title" content="Your Page Title">
	<meta property="og:description" content="Description of the page">
	<meta property="og:image" content="image.jpg">
	<meta property="og:url" content="https://yourwebsite.com">

	<!-- custom Fonts-->
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

	<!--Cross-Browser Compatibility-->
	<meta http-equiv="X-UA-Compatible" content="IE=edge">



	<title>StepX</title>
	<link rel="stylesheet" href="styles/mystyles.css">
	<link rel="icon" href="img/icon.png">
	<script src="js/global.js"></script>
</head>
<body class="indexBody">
	<div class="Navigation" id = "navbar">
		<h1><a href="index.php">StepX</a></h1>
		<nav class="ClassForNav">
			<?php include "nav.php"; ?>
		</nav>
	</div>
	
<div class="BoxForPopups">
	<dialog id="popup" open>
		<h2>Welcome to <strong>StepX</strong></h2>
		<p>We have added a new <b>Products Page</b> to our website. Click Go to check it!</p>
			<button onclick="window.location.href = 'products.php'">Go</button>
			<button onclick="document.getElementById('popup').close()">Close</button>
	</dialog>

	
</div>

<img src = "img/Sneaker.jpg" alt = "Sneaker Image" class="IndexImage" id="indexImg">
</body>
</html>