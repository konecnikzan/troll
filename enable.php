<?php
    include_once 'session.php';
    include_once 'database.php';
    $post_id = $_GET['post_id'];

    $query="UPDATE posts SET disabled = 0 WHERE (id=$post_id)";
    $result=  mysqli_query($link, $query);
    header("Location: index.php");
