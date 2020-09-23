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
    			<div id="wrapper" class="fade-in">
    
    				<!-- Intro -->
    					<div id="intro">
    						<h1>PROJECT<br/>
    						Онлайн-кинотеатр</h1>
    						<p>Здесь вы найдёте <b>лучшие</b> фильмы и мультфильмы <b>лучших</b> жанров на <strong>русском языке</strong> по <u>лучшим ценам</u></p>
    						<ul class="actions">
    							<li><a href="#film_list" class="button icon solo fa-arrow-down scrolly">Начать просмотр</a></li>
    						</ul>
    					</div>
    
    				<!-- Header -->
    					<header id="header">
    						<span class="logo">Приятного просмотра</span>
    					</header>
    
    				<!-- Navigation -->
    					<nav id="nav">
    						<ul class="links">
    							<li class="active"><a>Главная</a></li>
    							<li><a href="search.php">Поиск</a></li>
    							<?
    							    if (isset($_SESSION['user_nick'])){
    							        print '<li><a href="profile.php">Личный профиль</a></li>';
    							    }
    							?>
    						</ul>
    						<?
    						    if (empty($_SESSION['user_nick']))
    						    {
    						        ?>
    						            <ul class="actions">
    						                <li onclick="authorization('signin');"><button class="button small" id="authorization_button">Авторизация</button></li>
    						            </ul>
    						        <?
    						    }
    						?>
    					</nav>
    					
    				<!-- Main -->
    					<div id="main">
    
    						<!-- Featured Post -->
    							<article class="post featured">
    								<header class="major">
    									<h2>Список <br />
    									фильмов</h2>
    									<p>Перед вами представлены все фильмы на нашем сайте в алфавитном порядке. Для удобной навигации по сайту воспользуйтесь <a href="search.php">Поиском</a></p>
    								</header>
    								<img class="image main" src="images/site/pic01.jpg" alt="" />
    							</article>
    
    						<!-- Films -->
    							<section class="posts" id="film_list">
    								<?
    								    $DB->film_list();
    								?>
    							</section>
    
    						<!-- Footer -->
    							<footer>
    								<div class="box">
    									<p>Автор сайта не владеет правами на фильмы и изображения, и использует их в качестве ознакомления и учебных целях.</p>
    									<p>Надеемся на хорошую отметку :0</p>
    								</div>
    							</footer>
    							
    							<!-- authorization window -->
    							<div class="modal" id="authorization_modal">
    							    <div class="modal-content">
    							        <form style="" class="alt">
    							            <div class="close" align="right">&times;</div>
    							             <div id="authorization_form" class="6u 12u$(xsmall)" style="margin-left: 5%;">
    							                 
    							             </div>
    							         </form>
    							    </div>
    							</div>
    							
    							<!-- shopping window -->
    							<div class="modal" id="shopping_modal">
    							    <div class="modal-content">
    							        <form class="alt">
    							            <div class="close" align="right">&times;</div>
    							             <div id="shopping_form" class="6u 12u$(xsmall)" style="margin-left: 5%;">
    							                 
    							             </div>
    							         </form>
    							    </div>
    							</div>
    
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