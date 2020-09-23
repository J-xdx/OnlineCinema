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
    							<li class="active"><a>Поиск</a></li>
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

						<!-- Post -->
							<section class="post">
								<header class="major">
									<h1>Удобный поиск</h1>
									<p>Выберите фильтр поиска:</p>
								</header>
								<form>
								    <div class="select-wrapper">
    								    <select id="filter" onChange="search_choise()">
    								         <option disabled selected value="">- Укажите фильтр -</option>
    								         <option value="film_name">По названию</option>
    								         <option value="film_genre">По жанру</option>
    								         <option value="film_director">По режиссёру</option>
    								         <option value="film_pg">По возрастному рейтингу</option>
    								    </select>
								    </div>
								</form><div id="search_template" style="position: relative; width: 70%; "></div>
							</section>
							
							<div class="modal" id="authorization_modal">
    							    <div class="modal-content">
    							        <form style="" class="alt">
    							            <div class="close" align="right">&times;</div>
    							             <div id="authorization_form" class="6u 12u$(xsmall)" style="margin-left: 5%;">
    							                 
    							             </div>
    							         </form>
    							    </div>
    							</div>
    							
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