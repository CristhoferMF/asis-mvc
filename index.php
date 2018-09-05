<?php
if(isset($_GET['url'])){
    $view=$_GET['url'];
    switch ($view) {
        case 'home': 
        include './app/view/home.php';
        default:
        echo "ERROR 404";
    }
}else{
   echo "<a href='./home'>home</a>";
}
