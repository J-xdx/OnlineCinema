//Модальное окно авторизации
if(document.getElementById("authorization_button") !== null)
{
    var modal = document.getElementById("authorization_modal");
    var btn = document.getElementById("authorization_button");
    var span = document.getElementsByClassName("close")[0];
    
    btn.onclick = function(){
        modal.style.display = "block";
    };
    span.onclick = function(){
        modal.style.display = "none";
    };
    window.onclick = function(event){
        if(event.target == modal){
            modal.style.display = "none";
        }
    };
}

//Модальное окно покупки
if(document.getElementById("shopping_button") !== null)
{
    var Shop_modal = document.getElementById("shopping_modal");
    var Shop_span = document.getElementsByClassName("close")[1];
    
    Shop_span.onclick = function(){
        Shop_modal.style.display = "none";
    };
    window.onclick = function(event){
        if(event.target == Shop_modal){
            Shop_modal.style.display = "none";
        }
    };
}
function shop_btn(){
    Shop_modal.style.display = "block";
}

//Ajax
function search_choise(){
    xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if(xhttp.readyState == 4 && xhttp.status == 200){ 
			document.getElementById('search_template').innerHTML = xhttp.responseText;
		}
	};
	xhttp.open('GET', 'assets/php/Ajax.php?method=search&search_filter='+document.getElementById('filter').value, true);
	xhttp.send();
}

function SearchResult(){
    xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if(xhttp.readyState == 4 && xhttp.status == 200){ 
	        document.getElementById('search_choise').innerHTML = xhttp.responseText;
		}
	};
	switch(document.getElementById('filter').value)
	{
	    case 'film_genre':
	        var genres = "%";
	        var i;
	        for(i = 1; i <= document.getElementsByName('genre_check').length; i++){
	            if(document.getElementsByName('genre_check')[i-1].checked === true){
	                genres = genres  + document.getElementById('genre_check_'+i).innerHTML + "%";
	            }
	        }
	        xhttp.open('GET', 'assets/php/Ajax.php?method=search_result&search_choise=search_'+document.getElementById('filter').value+'&find='+genres, true); 
	   break;
	    default: xhttp.open('GET', 'assets/php/Ajax.php?method=search_result&search_choise=search_'+document.getElementById('filter').value+'&find='+document.getElementById('search_choise').firstChild.value, true); break;
	}
	xhttp.send();
}

function authorization(authorization_method){
    xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if(xhttp.readyState == 4 && xhttp.status == 200){ 
			document.getElementById('authorization_form').innerHTML = xhttp.responseText;
		}
	};
	xhttp.open('GET', 'assets/php/authorization.php?authorization_method='+authorization_method, true);
	xhttp.send();
}

function registration(nickname, password, name, surname){
    xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if(xhttp.readyState == 4 && xhttp.status == 200){ 
			document.getElementById('authorization_form').innerHTML = xhttp.responseText;
		}
	};
	xhttp.open('GET', 'assets/php/Ajax.php?method=registration&nickname='+nickname+'&password='+password+'&name='+name+'&surname='+surname, true);
	xhttp.send();
}

function signin(nickname, password){
    xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if(xhttp.readyState == 4 && xhttp.status == 200){ 
			document.getElementById('authorization_form').innerHTML = xhttp.responseText;
		}
	};
	xhttp.open('GET', 'assets/php/Ajax.php?method=signin&nickname='+nickname+'&password='+password, true);
	xhttp.send();
}

function signout(){
    xhttp = new XMLHttpRequest();
    xhttp.open('GET', 'assets/php/Ajax.php?method=signout', true);
    xhttp.send();
}

function buying(film_id){
    xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if(xhttp.readyState == 4 && xhttp.status == 200){ 
			document.getElementById('shopping_form').innerHTML = xhttp.responseText;
		}
	};
	xhttp.open('GET', 'assets/php/buying.php?film_id='+film_id, true);
	xhttp.send();
}

function buying_choice(film_id, method){
    xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if(xhttp.readyState == 4 && xhttp.status == 200){ 
			document.getElementById('shop_result').innerHTML = xhttp.responseText;
		}
	};
	xhttp.open('GET', 'assets/php/buying.php?film_id='+film_id+'&method='+method, true);
	xhttp.send();
}

function accept_purchase(film_id){
    xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if(xhttp.readyState == 4 && xhttp.status == 200){ 
			document.getElementById('shopping_form').innerHTML = xhttp.responseText;
		}
	};
	xhttp.open('GET', 'assets/php/Ajax.php?method=accept_purchase&film_id='+film_id, true);
	xhttp.send();
}

function sub_time(film_cost){
    document.getElementById('final_cost').innerHTML = Math.round((film_cost * 0.1 * document.getElementById('days_count').value)) + '₽';
}

function accept_subscription(film_id, days){
    xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if(xhttp.readyState == 4 && xhttp.status == 200){ 
			document.getElementById('shopping_form').innerHTML = xhttp.responseText;
		}
	};
	xhttp.open('GET', 'assets/php/Ajax.php?method=accept_subscription&film_id='+film_id+'&days='+days, true);
	xhttp.send();
}