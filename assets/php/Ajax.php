<?php
    session_start();
    include "../../assets/php/main.php";
    switch($_GET['method'])
    {
        case 'search':
            print "<div id='search_choise'>";
            switch($_GET['search_filter'])
            {
                case 'film_name': print '<input type=text id="search_film_name" placeholder="Введите название фильма">'; break;
                case 'film_genre': $DB->genre_list(); break;
                case 'film_director': print '<input type=text id="search_film_director" placeholder="Введите имя режиссёра">'; break;
                case 'film_pg': print "<select id='search_film_pg'><option value=0>Фильмы для всей семьи</option><option value=6>Фильмы для детей</option><option value=12>Для подростков</option><option value=16>Фильмы для молодёжи</option><option value=18>Только для взрослых</option></select></div>"; break;
            }
            print '<button class="button special icon fa-search" onClick="SearchResult()"></div>';
        break;
        
        case 'search_result':
            switch($_GET['search_choise'])
            {
                case 'search_film_name': $DB->search_list('CALL searchBYname("name", "'.$_GET['find'].'");'); break;
                case 'search_film_director': $DB->search_list('CALL searchBYname("director", "'.$_GET['find'].'");'); break;
                case 'search_film_pg': $DB->search_list('SELECT * FROM film_list WHERE pg = '.$_GET['find']); break;
                case 'search_film_genre': $DB->search_list('CALL searchBYname("genre", "'.$_GET['find'].'");'); break;
            }
        break;
        
        case 'registration': $DB->registration($_GET['nickname'], $_GET['password'], $_GET['name'], $_GET['surname']); break;
        
        case 'signin': $DB->signin($_GET['nickname'], $_GET['password']); break;
        
        case 'signout': unset($_SESSION['user_nick']); unset($_SESSION['user_name']); unset($_SESSION['user_surname']); break;
        
        case 'accept_purchase': $DB->buy_film($_GET['film_id']); break;
        
        case 'accept_subscription': $DB->sub_film($_GET['film_id'], $_GET['days']); break;
    }
?>