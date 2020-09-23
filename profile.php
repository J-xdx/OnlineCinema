<?php
    session_start();
    include "assets/php/main.php";
    ?>
    <!DOCTYPE HTML>
    <html>
    	<head>
    		<title>Мой онлайн-кинотеатр</title>
    		<meta charset="utf-8" />
    		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    		<link rel="stylesheet" href="assets/css/main.css" />
    		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
    	</head>
    	<body class="is-loading">
    
    		<!-- Wrapper -->
    			<div id="wrapper">
    
    				<!-- Header -->
    					<header id="header">
    						<span class="logo">Приятного просмотра</span>
    					</header>
    
    				<!-- Navigation -->
    					<nav id="nav">
    						<ul class="links">
    							<li><a href="http://p92105m2.beget.tech/">Главная</a></li>
    							<li><a href="search.php">Поиск</a></li>
    							<li class="active"><a>Личный профиль</a></li>
    						</ul>
    					</nav>
    				
    				<!-- Main -->
					<div id="main">

						<!-- Post -->
							<section class="post">
								<header class="major">
									<h1>Ваш профиль</h1>
									<?
									    print '<p>Вы вошли как: '.$_SESSION['user_name'].' '.$_SESSION['user_surname'].' ['.$_SESSION['user_nick'].']</p>';
									?>
								</header>
								<p><h6>Купленные фильмы</h6></p>
								<?
								    $DB->user_library($_SESSION['user_nick']);
								?>
								<hr>
								<p><h6>Подписка</h6></p>
								<?
								    $DB->user_subscription($_SESSION['user_nick']);
								?>
								<br><a href="http://p92105m2.beget.tech/"><input type="button" class="button special small" value="Выйти из аккаунта" onclick="signout();" /></a>
							</section>
					</div>
					
				<!-- Copyright -->
					<div id="copyright">
    						<ul><li>&copy; Коптяев Павел</li><li>Электронная почта: pavel-koptyaev@mail.ru</li></ul>
    					</div>
    					
				</div>	
					
                <!-- Scripts -->
                    <script src="assets/js/jquery.min.js"></script>
                    <script src="assets/js/jquery.scrollex.min.js"></script>
                    <script src="assets/js/jquery.scrolly.min.js"></script>
                    <script src="assets/js/skel.min.js"></script>
                    <script src="assets/js/util.js"></script>
                    <script src="assets/js/main.js"></script>
                    <script src="assets/js/myFunctions.js"></script>
    	</body>
    </html>
    <?
?>