<?php
    include_once 'database.php';
    /*shranimo userja iz selecta in date*/
    $username = $_GET['user'];
    $date = $_GET['date'];
    /*posodobimo uporabnike (kjer je ban_date enak date-u, ki ga je uproabnik nastavil),kjer je id=id uporabnika*/
    $query = "UPDATE users SET ban_date='$date' WHERE (id=$username);";
    $result = mysqli_query($link, $query);
    header("Location: index.php");
    exit();
