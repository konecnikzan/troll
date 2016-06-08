<?php
    include_once 'database.php';
    //uzame post_id 
    $post_id = $_GET['post_id'];
    //posodobi poste (upvote in downvote na 0),kjer je id od posta enak id izbranega posta
    $query = "UPDATE posts SET upvote=0,downvote=0 WHERE (id=$post_id);";
    $result = mysqli_query($link, $query);
    header("Location: index.php");

