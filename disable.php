<?php
    include_once 'session.php';
    include_once 'database.php';
    //shrani post id, ki ga je poslalo
    $post_id = $_GET['post_id'];
    //posodobi poste (disabled na 1) kjer je id posta enak id-ju poslanega posta
    $query="UPDATE posts SET disabled=1 WHERE (id=$post_id)";
    $result=  mysqli_query($link, $query);
    header("Location: index.php");
