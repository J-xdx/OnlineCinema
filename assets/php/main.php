<?php
    class edit
    {
        public $conn;
    
        public function __construct($dbname, $dbuser, $dbpass) 
        {
            try {
                $this->conn = new PDO($dbname, $dbuser, $dbpass);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            catch (PDOException $e) {
                echo 'Error: '.$e->getMessage();
            }
            return $this->conn;
        }
        
        public function film_list() //Вывод всех фильмов
        {
            $stmt = $this->conn->prepare('CALL film_list()');
            $stmt->execute();
            while ($row = $stmt->fetch(PDO::FETCH_NUM))
            {
                print "<article><header><h2>".$row[1]."</h2><p>".$row[6]."</p></header>
                <a href='watch.php?film=".$row[0]."' class='image fit'><img src='images/films/".$row[0].".jpg'></a>
                <table class = 'alt'><tbody><tr><td>Режиссёр</td><td>".$row[2]."</td></tr>
                <tr><td>Дата выхода</td><td>".$row[3]."</td></tr></tbody>
                <tfoot><tr><td><b style='border: 3px solid black;'>".$row[4]."</b></td></tr><tr><td></td><td>".$row[5]."</td></tr></tfoot></table>
                <ul class='actions'><li>";
                if(isset($_SESSION['user_nick'])){
                    print '<button onclick="buying('.$row[0].');shop_btn();" id="shopping_button">Купить</button>';
                }
                else{
                    print "<button class='button disabled'>Купить</button>";
                }
                print "</li></ul></article>";
            }
        }
        
        public function genre_list() //Вывод жанров
        {
            $stmt = $this->conn->prepare('SELECT * FROM genre');
            $stmt->execute();
            while ($row = $stmt->fetch(PDO::FETCH_NUM))
            {
                print '<input type="checkbox" id="gchk_'.$row[0].'" name="genre_check"><label id="genre_check_'.$row[0].'" for="gchk_'.$row[0].'">'.$row[1].'</label>';
            }
            print '<br>';
        }
        
        public function search_list($sql) //Вывод таблицы результатов поиска
        {
            $stmt = $this->conn->prepare("SET lc_time_names = 'ru_RU';");
            $stmt->execute();
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            print '<table><thead><tr><th>Фильм</th><th>Режиссёр</th><th>Премьера</th><th>Возратсной рейтинг</th><th>Жанры</th><th>Стоимость</th></tr></thead>';
            while ($row = $stmt->fetch(PDO::FETCH_NUM))
            {
                print '<tbody><tr><td>'.$row[1].'</td><td>'.$row[2].'</td><td>'.$row[3].'</td><td>'.$row[4].'</td><td>'.$row[6].'</td><td>'.$row[5].'</td><td>';
                if(isset($_SESSION['user_nick'])){
                    print '<button onclick="buying('.$row[0].'); shop_btn();" id="shopping_button" class="button">Купить</button></td></tr></tbody>';
                }
                else{
                    print '<a class="button disabled">Купить</a></td></tr></tbody>';
                }
            }
            print '</table>';
        }
        
        public function registration($nickname, $password, $name, $surname) //Регистрация нового пользователя
        {
            if(!empty($nickname) && !empty($password) && !empty($password) && !empty($password))
            {
                try
                {
                    $stmt = $this->conn->prepare('CALL registration("'.$nickname.'","'.$password.'","'.$name.'","'.$surname.'")');
                    $stmt->execute();
                    $_SESSION['user_nick'] = $nickname;
                    $_SESSION['user_name'] = $name;
                    $_SESSION['user_surname'] = $surname;
                    print 'Вы успешно зарегистрировались';
                }
                catch (PDOException $e){
                    print 'Имя пользователя уже занято';
                }
            }
            else{
                print 'Заполните все поля';
            }
        }
        
        public function signin($nickname, $password) //Вход
        {
            $stmt = $this->conn->prepare('SELECT * FROM users');
            $stmt->execute();
            $f = 0;
            while ($row = $stmt->fetch(PDO::FETCH_NUM))
            {
                if ($row[1] == $nickname && $row[2] == $password)
                {
					$_SESSION['user_nick'] = $row[1];
					$_SESSION['user_name'] = $row[3];
					$_SESSION['user_surname'] = $row[4];
					$f = 1;
				}
            }
            if($f == 0){
				print 'Неверный логин или пароль';
			}
			else{
			    print '<p><u>Вы успешно вошли в аккаунт</u></p>Приветствуем, '.$_SESSION['user_name'].' '.$_SESSION['user_surname'];
			}
        }
        
        public function user_library($nickname) //Вывод покупок пользователя
        {
            $stmt = $this->conn->prepare('CALL user_library("'.$nickname.'")');
            $stmt->execute();
            print '<table class = "alt"><thead><tr><th style="width: 50%">Фильм</th><th td style="width: 20%">Дата покупки</th><th></th></tr></thead><tbody>';
            while ($row = $stmt->fetch(PDO::FETCH_NUM)){
                print '<tr><td>'.$row[1].'</td><td>'.$row[2].'</td><td align="right"><a href="watch.php?film='.$row[0].'" class="button">Смотреть</a></td></tr>';
            }
            print '</tbody></table>';
        }
        
        public function user_subscription($nickname) //Вывод подписок пользователя
        {
            $stmt = $this->conn->prepare('CALL user_subscription("'.$nickname.'")');
            $stmt->execute();
            print '<table class = "alt"><thead><tr><th style="width: 50%">Фильм</th><th style="width: 20%">Окончание подписки</th><th></th></tr></thead><tbody>';
            while ($row = $stmt->fetch(PDO::FETCH_NUM))
            {
                if($row[2] < DATE('d F Y')){
                    print '<tr><td><s>'.$row[1].'</s></td><td style="color: red;">'.$row[2].'</td><td align="right"><a href="watch.php?film='.$row[0].'" class="button disabled">Смотреть</a></td></tr>';
                }
                else{
                    print '<tr><td>'.$row[1].'</td><td>'.$row[2].'</td><td align="right"><a href="watch.php?film='.$row[0].'" class="button">Смотреть</a></td></tr>';
                }
            }
            print '</tbody></table>';
        }
        
        public function watching($id_film, $nick) //Страница просмотра
        {
            $stmt = $this->conn->prepare('CALL watching('.$id_film.', "'.$nick.'")');
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_NUM);
            if($stmt->rowCount() > 0){
                print '<header class="major"><h1>'.$row[1].'</h1></header><p style="text-align: center;">'.$row[2].'</p>';
                print '<div align="center"><video width="90%" height="70%" controls="controls" poster="images/films/'.$id_film.'.jpg">
                    <source src="videos/'.$id_film.'.mp4" type=video/mp4; codecs="avc1.42E01E, mp4a.40.2">
                </video></div>';
            }
            else
            {
                if(isset($_SESSION['user_nick'])){
                    print 'Просмотр недоступен! Купите фильм или продлите подписку...';
                }
                else{
                    ?>
                        Для просмотра фильмов <a style="cursor: pointer;" onclick="authorization('signin');">авторизируйтесь</a> на сайте
                    <?
                }
            }
        }
        
        public function buy_film($film_id)
        {
            $stmt = $this->conn->prepare('CALL buy_film("'.$_SESSION['user_nick'].'",'.$film_id.')');
            $stmt->execute();
            if($stmt->rowCount() > 0){
                print 'Покупка успешно выполнена!<br>Посетите личный профиль или кликните на картинку на главной странице для просмотра';
            }
            else{
                print 'Произошла ошибка во время оплаты, убедитесь, что фильм отсутсвует в вашей библиотеке';
            }
        }
        
        public function sub_film($film_id, $days)
        {
            $stmt = $this->conn->prepare('CALL sub_film("'.$_SESSION['user_nick'].'",'.$film_id.','.$days.')');
            $stmt->execute();
            if($stmt->rowCount() > 0){
                print 'Подписка оформена!<br>Посетите личный профиль или кликните на картинку на главной странице для просмотра';
            }
            else{
                print 'Произошла ошибка во время оплаты, убедитесь, что фильм отсутсвует в вашей библиотеке';
            }
        }
    }
    
    $DB = new edit('mysql:host=localhost;dbname=p92105m2_site','...','...'); 
?>
