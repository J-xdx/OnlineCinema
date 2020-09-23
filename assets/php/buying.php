<?php
    session_start();
    include "../../assets/php/main.php";
    switch($_GET['method'])
    {
        case '': ?>
                    <h4>Выберите способ оплаты</h4>
                    <div class="4u 12u$(small)">
                        <? print '<input type="radio" id="radio_buy" name="radio_choice" onchange="buying_choice('.$_GET['film_id'].', 1);">' ?>
                        <label for="radio_buy">Купить</label>
                    </div>
                    <div class="4u 12u$(small)">
                        <? print '<input type="radio" id="radio_sub" name="radio_choice" onchange="buying_choice('.$_GET['film_id'].', 2);">' ?>
                        <label for="radio_sub">Подписка</label>
                    </div>
                    
                    <div id="shop_result"></div>
                <? break;
        /*Покупка*/
        case '1': 
            $stmt = $DB->conn->prepare('SELECT name, cost FROM film_list WHERE film_id = '.$_GET['film_id'].''); 
            $stmt->execute(); 
            $row = $stmt->fetch(PDO::FETCH_NUM); 
            print '<br><p>Вы действительно хотите купить фильм <i>"'.$row[0].'"</i>?<br><u>Стоимость:</u> '.$row[1].'</p><input type="button" class="button small" onclick="accept_purchase('.$_GET['film_id'].')" value="Подтверждаю" />'; 
        break;
        /*Подписка*/
        case '2':  
            $stmt = $DB->conn->prepare('SELECT name, cost FROM films WHERE film_id = '.$_GET['film_id'].''); 
            $stmt->execute(); 
            $row = $stmt->fetch(PDO::FETCH_NUM); 
            print '<p>Вы действительно хотите оформить подписку на <i>"'.$row[0].'"</i>?<br><u>Длительность: </u><textarea placeholder="Дни" style="width: 5em; height: 4em; resize: none; overflow: hidden;" id="days_count" onchange="sub_time('.$row[1].')"></textarea></p>
            <p><u>Итого стоимость:</u><div id="final_cost">0₽</div></p>
            <input type="button" class="button small" onclick=accept_subscription('.$_GET['film_id'].',document.getElementById("days_count").value); value="Подтверждаю" />';
        break;
    }
?>