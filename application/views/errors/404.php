<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Page Not Found</title>
<link rel="icon" href="/Aplikasi_CBT/assets/img/logo undip.png" type="image/x-icon">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<style type="text/css">

::selection { background-color: #E13300; color: white; }
::-moz-selection { background-color: #E13300; color: white; }
*, *::before, *::after {
    box-sizing: border-box;
}

html{
	height: 100%;
}
body {
	position:absolute; 
	top:0; 
	bottom:0; 
	right:0; 
	left:0; 
	background: linear-gradient(to right, #212121,#3D3A3A,#575755,#808180,#9C9C9C); 
	margin: 40px;
	font: 13px/20px normal Helvetica, Arial, sans-serif;
	color: #4F5155;
}

a {
	color: #003399;
	background-color: transparent;
	font-weight: normal;
}

h1 {
	color: #fff;
	background-color: transparent;
	font-size: 2.5em;
	font-weight: bold;
	margin: 10 0 14px 0;
	padding: 14px 15px 10px 15px;
	text-align: center;
}

code {
	font-family: Consolas, Monaco, Courier New, Courier, monospace;
	font-size: 12px;
	background-color: #f9f9f9;
	border: 1px solid #D0D0D0;
	color: #002166;
	display: block;
	margin: 14px 0 14px 0;
	padding: 12px 10px 12px 10px;
}

#container {
	margin: 10px;
    position: relative;
    min-height: 100%;
    text-align: center;
    vertical-align: middle;
    padding: 5%;
}

p {
	color: #fff;
	font-size: 1.5em;
	margin: 12px 15px 12px 15px;
}

img{
	max-width: 100%;
    height: auto;
    width: 100px;
}

.btn {
    background-color: #2C5BF3; /* Green */
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    cursor: pointer;
    margin-top: 20px;
}

.btn:hover{
	transition-duration: 0.4s;
	box-shadow: 0 12px 16px 0 rgba(0,0,0,0.24), 0 17px 50px 0 rgba(0,0,0,0.19);
}

</style>
</head>
<body>
	<div id="container">
		<img src="/Aplikasi_CBT/assets/img/logo undip.png" alt="">
		<h1><?php echo $heading; ?></h1>
		<?php echo $message; ?>
		<button class="btn" onclick="history.go(-1)">Go Back</button>
	</div>
</body>
</html>