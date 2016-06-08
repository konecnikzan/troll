<?php
include_once 'header.php';
include_once 'database.php';
include_once 'session.php';
$user = $_SESSION['user_id'];
$query1 = "SELECT administrator FROM users WHERE (id = $user)";
$result1 = mysqli_query($link, $query1);
while($row = mysqli_fetch_array($result1))
{
    $admin = $row['administrator'];
}

//phpinfo();
?>
<div class="tabs">
    <ul class="tab-links">
        <li class="active"><a href="#tab1">New</a></li>
        <li><a href="#tab2">Top</a></li>
        <li><a href="#tab3">Worst</a></li>
        <li><a href="#tab4">My</a></li>
    </ul>

    <div class="tab-content">
        <div id="tab1" class="tab active">
            <?php 
                $query2 = "SELECT p.*, u.username,u.id AS user_id,u.avatar AS avatar
                    FROM posts p INNER JOIN users u ON p.user_id=u.id 
                    ORDER BY p.date_add DESC";
                $result2 = mysqli_query($link, $query2);
                    while ($row = mysqli_fetch_array($result2)) {
                        //shrani id uporabnika posta in avatar uporabnika
                        $user_id = $row['user_id'];
                        $avatar2 = $row['avatar'];
                        if($admin == 1){?>
                        <div class="trollPicture">
                            Number of posts: 
                                <?php 
                                    $avatar = 0;
                                    //izračuna število vseh postov uporabnika
                                    $query4 = "SELECT COUNT(p.id) FROM posts p INNER JOIN users u ON p.user_id=u.id WHERE u.id=".$row['user_id'].";";
                                    $result4 = mysqli_query($link, $query4);
                                    while($row2 = mysqli_fetch_array($result4))
                                    { 
                                        //izpiše število postov
                                        echo $row2[0];
                                        //shrani število v novo spremenljivko
                                        $avatar = $row2[0];
                                        //če je število postov večje od 10 ali 50 ali 100, se jim vstavi ustrezen avatar, kjer je id enak id posta
                                        if($avatar > 10)
                                        {
                                            $query5 = "UPDATE users SET avatar='https://pbs.twimg.com/profile_images/443706288967393281/MdTpGPiJ.jpeg' WHERE id=$user_id;";
                                            $result5 = mysqli_query($link, $query5);
                                        }
                                        else if($avatar > 50)
                                        {
                                            $query6 = "UPDATE users SET avatar='http://www.funoverfifty.com.au/wp-content/uploads//2012/07/main_logo.png' WHERE id=$user_id;";
                                            $result6 = mysqli_query($link, $query6);
                                        }
                                        else if($avatar > 100)
                                        {
                                            $query7 = "UPDATE users SET avatar='http://emojipedia-us.s3.amazonaws.com/cache/42/6d/426d5d9155c35c44e66980c4187f6bab.png' WHERE id=$user_id;";
                                            $result7 = mysqli_query($link, $query7);
                                        }
                                        //posodobi num_posts na število iz postov iz spremenljivke
                                        $query8 = "UPDATE users SET num_posts=$avatar WHERE id=$user_id;";
                                        $result8 = mysqli_query($link, $query8);
                                    }
                                    ?><br />
                                    <!--if stavek če ni prazen se vstavi slika, če pa je pa nič ne naredi-->
                            <span class="trollAvatar"><?php echo !empty($avatar2) ? '<img name="avatar" src='.$avatar2.' width="25" height="25" alt="avatar" />':'';?></span>    
                            <span class="trollUser"><?php echo $row['username']; ?>,</span>
                            <span class="trollDate"><?php echo $row['date_add']; ?></span>
                            <br />
                            <a href="post.php?id=<?php echo $row['id']; ?>">
                                <img src="<?php echo $row['url']; ?>" alt="<?php echo $row['title']; ?>" width="200"/>
                            </a>
                            <br />
                            DISABLED: <?php echo $row['disabled'];?>
                            <a href="post_vote.php?post_id=<?php echo $row['id']; ?>&vote=1">Upvote (<?php echo $row['upvote']; ?>)</a>
                            <a href="post_vote.php?post_id=<?php echo $row['id']; ?>&vote=0">Downvote (<?php echo $row['downvote']; ?>)</a>
                            <a href="admin_post_reset.php?post_id=<?php echo $row['id']; ?>">Reset votes</a>
                            <?php
                                $enc = $row['id'];
                                if($row['disabled'] == 0)
                                {
                                    echo '<a href="disable.php?post_id=',urlencode($enc),'">Disable</a>';
                                }
                                if($row['disabled'] == 1)
                                {
                                    echo '<a href="enable.php?post_id=',urlencode($enc),'">Enable</a>';
                                }                           
                            ?>
                            <hr />
                        </div> 
                <?php
                }
                else{
                    if($row['disabled'] == 0){
                        $user_id = $row['user_id'];
                        $avatar2 = $row['avatar'];?>
                    <div class="trollPicture">
                            Number of posts: 
                                <?php 
                                    $avatar = 0;
                                    $query4 = "SELECT COUNT(p.id) FROM posts p INNER JOIN users u ON p.user_id=u.id WHERE u.id=".$row['user_id'].";";
                                    $result4 = mysqli_query($link, $query4);
                                    while($row2 = mysqli_fetch_array($result4))
                                    { 
                                        echo $row2[0];  
                                        $avatar = $row2[0];
                                        if($avatar > 10)
                                        {
                                            $query5 = "UPDATE users SET avatar='https://pbs.twimg.com/profile_images/443706288967393281/MdTpGPiJ.jpeg' WHERE id=$user_id;";
                                            $result5 = mysqli_query($link, $query5);
                                        }
                                        else if($avatar > 50)
                                        {
                                            $query6 = "UPDATE users SET avatar='http://www.funoverfifty.com.au/wp-content/uploads//2012/07/main_logo.png' WHERE id=$user_id;";
                                            $result6 = mysqli_query($link, $query6);
                                        }
                                        else if($avatar > 100)
                                        {
                                            $query7 = "UPDATE users SET avatar='http://emojipedia-us.s3.amazonaws.com/cache/42/6d/426d5d9155c35c44e66980c4187f6bab.png' WHERE id=$user_id;";
                                            $result7 = mysqli_query($link, $query7);
                                        }
                                    }
                                    ?><br />
                            <span class="trollAvatar"><?php echo !empty($avatar2) ? '<img name="avatar" src='.$avatar2.' width="25" height="25" alt="avatar" />':'';?></span>    
                            <span class="trollUser"><?php echo $row['username']; ?></span>
                            <span class="trollDate"><?php echo $row['date_add']; ?></span>
                            <br />
                            <a href="post.php?id=<?php echo $row['id']; ?>">
                                <img src="<?php echo $row['url']; ?>" alt="<?php echo $row['title']; ?>" width="200"/>
                            </a>
                            <br />
                            <a href="post_vote.php?post_id=<?php echo $row['id']; ?>&vote=1">Upvote (<?php echo $row['upvote']; ?>)</a>
                            <a href="post_vote.php?post_id=<?php echo $row['id']; ?>&vote=0">Downvote (<?php echo $row['downvote']; ?>)</a>
                            <hr />
                    </div>   
            <?php 
                    }
                    else{
                        
                    }
                }
            }
            ?> 
        </div>

        <div id="tab2" class="tab">
            <?php
            $query3 = "SELECT p.*, u.* 
              FROM posts p INNER JOIN users u ON p.user_id=u.id 
              ORDER BY p.upvote DESC";
            $result3 = mysqli_query($link, $query3);
            while ($row = mysqli_fetch_array($result3)) {
                $user_id = $row['user_id'];
                $avatar2 = $row['avatar'];
                if($admin == 1){?>
                <div class="trollPicture">
                    Number of posts: 
                        <?php 
                            $query4 = "SELECT COUNT(p.id) FROM posts p INNER JOIN users u ON p.user_id=u.id WHERE u.id=".$row['user_id'].";";
                            $result4 = mysqli_query($link, $query4);
                            while($row2 = mysqli_fetch_array($result4))
                            { 
                                echo $row2[0];
                                $avatar = $row2[0];
                                    if($avatar > 10)
                                    {
                                        $query5 = "UPDATE users SET avatar='https://pbs.twimg.com/profile_images/443706288967393281/MdTpGPiJ.jpeg' WHERE id=$user_id;";
                                        $result5 = mysqli_query($link, $query5);
                                    }
                                    else if($avatar > 50)
                                    {
                                        $query6 = "UPDATE users SET avatar='http://www.funoverfifty.com.au/wp-content/uploads//2012/07/main_logo.png' WHERE id=$user_id;";
                                        $result6 = mysqli_query($link, $query6);
                                    }
                                    else if($avatar > 100)
                                    {
                                        $query7 = "UPDATE users SET avatar='http://emojipedia-us.s3.amazonaws.com/cache/42/6d/426d5d9155c35c44e66980c4187f6bab.png' WHERE id=$user_id;";
                                        $result7 = mysqli_query($link, $query7);
                                    }
                                    $query8 = "UPDATE users SET num_posts=$avatar WHERE id=$user_id;";
                                    $result8 = mysqli_query($link, $query8);
                            }
                        ?><br />
                    <span class="trollAvatar"><?php echo !empty($avatar2) ? '<img name="avatar" src='.$avatar2.' width="25" height="25" alt="avatar" />':'';?></span>        
                    <span class="trollUser"><?php echo $row['username']; ?></span>
                    <span class="trollDate"><?php echo $row['date_add']; ?></span>
                    <br />
                    <a href="post.php?id=<?php echo $row['id']; ?>">
                                <img src="<?php echo $row['url']; ?>" alt="<?php echo $row['title']; ?>" width="200"/>
                    </a>
                    <br />
                    DISABLED: <?php echo $row['disabled'];?>
                    <a href="post_vote.php?post_id=<?php echo $row['id']; ?>&vote=1">Upvote (<?php echo $row['upvote']; ?>)</a>
                    <a href="post_vote.php?post_id=<?php echo $row['id']; ?>&vote=0">Downvote (<?php echo $row['downvote']; ?>)</a>
                    <a href="admin_post_reset.php?post_id=<?php echo $row['id']; ?>">Reset votes</a>
                    <?php
                        $enc = $row['id'];
                        if($row['disabled'] == 0)
                        {
                            echo '<a href="disable.php?post_id=',urlencode($enc),'">Disable</a>';
                        }
                        if($row['disabled'] == 1)
                        {
                            echo '<a href="enable.php?post_id=',urlencode($enc),'">Enable</a>';
                        }
                    ?>
                    <hr />
                </div>
                <?php
            }
            else{
                if($row['disabled'] == 0){
                    $user_id = $row['user_id'];
                    $avatar2 = $row['avatar'];?>
                        <div class="trollPicture">
                             Number of posts: 
                        <?php 
                            $query4 = "SELECT COUNT(p.id) FROM posts p INNER JOIN users u ON p.user_id=u.id WHERE u.id=".$row['user_id'].";";
                            $result4 = mysqli_query($link, $query4);
                            while($row2 = mysqli_fetch_array($result4))
                            { 
                                echo $row2[0];
                                $avatar = $row2[0];
                                    if($avatar > 10)
                                    {
                                        $query5 = "UPDATE users SET avatar='https://pbs.twimg.com/profile_images/443706288967393281/MdTpGPiJ.jpeg' WHERE id=$user_id;";
                                        $result5 = mysqli_query($link, $query5);
                                    }
                                    else if($avatar > 50)
                                    {
                                        $query6 = "UPDATE users SET avatar='http://www.funoverfifty.com.au/wp-content/uploads//2012/07/main_logo.png' WHERE id=$user_id;";
                                        $result6 = mysqli_query($link, $query6);
                                    }
                                    else if($avatar > 100)
                                    {
                                        $query7 = "UPDATE users SET avatar='http://emojipedia-us.s3.amazonaws.com/cache/42/6d/426d5d9155c35c44e66980c4187f6bab.png' WHERE id=$user_id;";
                                        $result7 = mysqli_query($link, $query7);
                                    }
                            }
                        ?><br />
                        <span class="trollAvatar"><?php echo !empty($avatar2) ? '<img name="avatar" src='.$avatar2.' width="25" height="25" alt="avatar" />':'';?></span>    
                            <span class="trollUser"><?php echo $row['username']; ?></span>
                            <span class="trollDate"><?php echo $row['date_add']; ?></span>
                            <br />
                            <a href="post.php?id=<?php echo $row['id']; ?>">
                                <img src="<?php echo $row['url']; ?>" alt="<?php echo $row['title']; ?>" width="200"/>
                            </a>
                            <br />
                            <a href="post_vote.php?post_id=<?php echo $row['id']; ?>&vote=1">Upvote (<?php echo $row['upvote']; ?>)</a>
                            <a href="post_vote.php?post_id=<?php echo $row['id']; ?>&vote=0">Downvote (<?php echo $row['downvote']; ?>)</a>
                            <hr />
                </div>   
            <?php
                }
                else{
                        
                    }
                }
            }
            ?>
        </div>

        <div id="tab3" class="tab">
            <?php
            $query = "SELECT p.*, u.* 
              FROM posts p INNER JOIN users u ON p.user_id=u.id 
              ORDER BY p.downvote DESC";
            $result = mysqli_query($link, $query);
            while ($row = mysqli_fetch_array($result)) {
                $user_id = $row['user_id'];
                $avatar2 = $row['avatar'];
                if($admin == 1){?>
                <div class="trollPicture">
                    Number of posts: 
                        <?php 
                            $query4 = "SELECT COUNT(p.id) FROM posts p INNER JOIN users u ON p.user_id=u.id WHERE u.id=".$row['user_id'].";";
                            $result4 = mysqli_query($link, $query4);
                            while($row2 = mysqli_fetch_array($result4))
                            { 
                                echo $row2[0];
                                $avatar = $row2[0];
                                    if($avatar > 10)
                                    {
                                        $query5 = "UPDATE users SET avatar='https://pbs.twimg.com/profile_images/443706288967393281/MdTpGPiJ.jpeg' WHERE id=$user_id;";
                                        $result5 = mysqli_query($link, $query5);
                                    }
                                    else if($avatar > 50)
                                    {
                                        $query6 = "UPDATE users SET avatar='http://www.funoverfifty.com.au/wp-content/uploads//2012/07/main_logo.png' WHERE id=$user_id;";
                                        $result6 = mysqli_query($link, $query6);
                                    }
                                    else if($avatar > 100)
                                    {
                                        $query7 = "UPDATE users SET avatar='http://emojipedia-us.s3.amazonaws.com/cache/42/6d/426d5d9155c35c44e66980c4187f6bab.png' WHERE id=$user_id;";
                                        $result7 = mysqli_query($link, $query7);
                                    }
                                    $query8 = "UPDATE users SET num_posts=$avatar WHERE id=$user_id;";
                                    $result8 = mysqli_query($link, $query8);
                            }
                        ?><br />
                    <span class="trollAvatar"><?php echo !empty($avatar2) ? '<img name="avatar" src='.$avatar2.' width="25" height="25" alt="avatar" />':'';?></span>        
                    <span class="trollUser"><?php echo $row['username']; ?></span>
                    <span class="trollDate"><?php echo $row['date_add']; ?></span>
                    <br />
                    <a href="post.php?id=<?php echo $row['id']; ?>">
                        <img src="<?php echo $row['url']; ?>" alt="<?php echo $row['title']; ?>" width="200"/>
                    </a>
                    <br />
                    DISABLED: <?php echo $row['disabled'];?>
                    <a href="post_vote.php?post_id=<?php echo $row['id']; ?>&vote=1">Upvote (<?php echo $row['upvote']; ?>)</a>
                    <a href="post_vote.php?post_id=<?php echo $row['id']; ?>&vote=0">Downvote (<?php echo $row['downvote']; ?>)</a>
                    <a href="admin_post_reset.php?post_id=<?php echo $row['id']; ?>">Reset votes</a>
                    <?php
                        $enc = $row['id'];
                        if($row['disabled'] == 0)
                        {
                            echo '<a href="disable.php?post_id=',urlencode($enc),'">Disable</a>';
                        }
                        if($row['disabled'] == 1)
                        {
                            echo '<a href="enable.php?post_id=',urlencode($enc),'">Enable</a>';
                        }
                    ?>
                    <hr />
                </div>
             <?php
            }
            else{
                if($row['disabled'] == 0){
                $user_id = $row['user_id'];
                $avatar2 = $row['avatar']; ?>
                 <div class="trollPicture">
                      Number of posts: 
                        <?php 
                            $query4 = "SELECT COUNT(p.id) FROM posts p INNER JOIN users u ON p.user_id=u.id WHERE u.id=".$row['user_id'].";";
                            $result4 = mysqli_query($link, $query4);
                            while($row2 = mysqli_fetch_array($result4))
                            { 
                                echo $row2[0];
                                $avatar = $row2[0];
                                    if($avatar > 10)
                                    {
                                        $query5 = "UPDATE users SET avatar='https://pbs.twimg.com/profile_images/443706288967393281/MdTpGPiJ.jpeg' WHERE id=$user_id;";
                                        $result5 = mysqli_query($link, $query5);
                                    }
                                    else if($avatar > 50)
                                    {
                                        $query6 = "UPDATE users SET avatar='http://www.funoverfifty.com.au/wp-content/uploads//2012/07/main_logo.png' WHERE id=$user_id;";
                                        $result6 = mysqli_query($link, $query6);
                                    }
                                    else if($avatar > 100)
                                    {
                                        $query7 = "UPDATE users SET avatar='http://emojipedia-us.s3.amazonaws.com/cache/42/6d/426d5d9155c35c44e66980c4187f6bab.png' WHERE id=$user_id;";
                                        $result7 = mysqli_query($link, $query7);
                                    }
                            }
                        ?><br />
                            <span class="trollAvatar"><?php echo !empty($avatar2) ? '<img name="avatar" src='.$avatar2.' width="25" height="25" alt="avatar" />':'';?></span>    
                            <span class="trollUser"><?php echo $row['username']; ?></span>
                            <span class="trollDate"><?php echo $row['date_add']; ?></span>
                            <br />
                            <a href="post.php?id=<?php echo $row['id']; ?>">
                                <img src="<?php echo $row['url']; ?>" alt="<?php echo $row['title']; ?>" width="200"/>
                            </a>
                            <br />
                            <a href="post_vote.php?post_id=<?php echo $row['id']; ?>&vote=1">Upvote (<?php echo $row['upvote']; ?>)</a>
                            <a href="post_vote.php?post_id=<?php echo $row['id']; ?>&vote=0">Downvote (<?php echo $row['downvote']; ?>)</a>
                            <hr />
                </div>   
                <?php
                }
                else{                       
                    }
                }
            }
            ?>
        </div>

        <div id="tab4" class="tab">
            <?php
            $query = "SELECT p.*, u.username,u.id AS user_id,u.avatar AS avatar
              FROM posts p INNER JOIN users u ON p.user_id=u.id
              WHERE p.user_id = ".$_SESSION['user_id']."
              ORDER BY p.date_add DESC";
            $result7 = mysqli_query($link, $query);
            while ($row = mysqli_fetch_array($result7)) {
                $user_id = $row['user_id'];
                $avatar2 = $row['avatar']; 
                if($admin == 1){?>
                <div class="trollPicture">
                    Number of posts: 
                        <?php 
                            $query4 = "SELECT COUNT(p.id) FROM posts p INNER JOIN users u ON p.user_id=u.id WHERE u.id=".$row['user_id'].";";
                            $result4 = mysqli_query($link, $query4);
                            while($row2 = mysqli_fetch_array($result4))
                            { 
                                echo $row2[0];
                                $avatar = $row2[0];
                                    if($avatar > 10)
                                    {
                                        $query5 = "UPDATE users SET avatar='https://pbs.twimg.com/profile_images/443706288967393281/MdTpGPiJ.jpeg' WHERE id=$user_id;";
                                        $result5 = mysqli_query($link, $query5);
                                    }
                                    else if($avatar > 50)
                                    {
                                        $query6 = "UPDATE users SET avatar='http://www.funoverfifty.com.au/wp-content/uploads//2012/07/main_logo.png' WHERE id=$user_id;";
                                        $result6 = mysqli_query($link, $query6);
                                    }
                                    else if($avatar > 100)
                                    {
                                        $query7 = "UPDATE users SET avatar='http://emojipedia-us.s3.amazonaws.com/cache/42/6d/426d5d9155c35c44e66980c4187f6bab.png' WHERE id=$user_id;";
                                        $result7 = mysqli_query($link, $query7);
                                    }
                                    $query8 = "UPDATE users SET num_posts=$avatar WHERE id=$user_id;";
                                    $result8 = mysqli_query($link, $query8);
                            }
                        ?><br />
                    <span class="trollAvatar"><?php echo !empty($avatar2) ? '<img name="avatar" src='.$avatar2.' width="25" height="25" alt="avatar" />':'';?></span>        
                    <span class="trollUser"><?php echo $row['username']; ?></span>
                    <span class="trollDate"><?php echo $row['date_add']; ?></span>
                    <br />
                    <a href="post.php?id=<?php echo $row['id']; ?>">
                        <img src="<?php echo $row['url']; ?>" alt="<?php echo $row['title']; ?>" width="200"/>
                    </a>
                    <br />
                    DISABLED: <?php echo $row['disabled'];?>
                    <a href="post_vote.php?post_id=<?php echo $row['id']; ?>&vote=1">Upvote (<?php echo $row['upvote']; ?>)</a>
                    <a href="post_vote.php?post_id=<?php echo $row['id']; ?>&vote=0">Downvote (<?php echo $row['downvote']; ?>)</a>
                     <a href="admin_post_reset.php?post_id=<?php echo $row['id']; ?>">Reset votes</a>
                     <?php
                        $enc = $row['id'];
                        if($row['disabled'] == 0)
                        {
                            echo '<a href="disable.php?post_id=',urlencode($enc),'">Disable</a>';
                        }
                        if($row['disabled'] == 1)
                        {
                            echo '<a href="enable.php?post_id=',urlencode($enc),'">Enable</a>';
                        }
                    ?>
                    <hr />
                </div>
                <?php
                }
                else{
                $query = "SELECT p.*, u.username,u.id AS user_id,u.avatar AS avatar
                    FROM posts p INNER JOIN users u ON p.user_id=u.id
                    WHERE p.user_id = ".$_SESSION['user_id']."
                    ORDER BY p.date_add DESC";
                $result8 = mysqli_query($link, $query);
                while ($row = mysqli_fetch_array($result8)) {
                    $user_id = $row['user_id'];
                    $avatar2 = $row['avatar']; ?>
                <div class="trollPicture">
                    Number of posts: 
                        <?php 
                            $query4 = "SELECT COUNT(p.id) FROM posts p INNER JOIN users u ON p.user_id=u.id WHERE u.id=".$row['user_id'].";";
                            $result4 = mysqli_query($link, $query4);
                            while($row2 = mysqli_fetch_array($result4))
                            { 
                                echo $row2[0];
                                $avatar = $row2[0];
                                    if($avatar > 10)
                                    {
                                        $query5 = "UPDATE users SET avatar='https://pbs.twimg.com/profile_images/443706288967393281/MdTpGPiJ.jpeg' WHERE id=$user_id;";
                                        $result5 = mysqli_query($link, $query5);
                                    }
                                    else if($avatar > 50)
                                    {
                                        $query6 = "UPDATE users SET avatar='http://www.funoverfifty.com.au/wp-content/uploads//2012/07/main_logo.png' WHERE id=$user_id;";
                                        $result6 = mysqli_query($link, $query6);
                                    }
                                    else if($avatar > 100)
                                    {
                                        $query7 = "UPDATE users SET avatar='http://emojipedia-us.s3.amazonaws.com/cache/42/6d/426d5d9155c35c44e66980c4187f6bab.png' WHERE id=$user_id;";
                                        $result7 = mysqli_query($link, $query7);
                                    }
                            }
                        ?><br />
                    <span class="trollAvatar"><?php echo !empty($avatar2) ? '<img name="avatar" src='.$avatar2.' width="25" height="25" alt="avatar" />':'';?></span>        
                    <span class="trollUser"><?php echo $row['username']; ?></span>
                    <span class="trollDate"><?php echo $row['date_add']; ?></span>
                    <br />
                    <a href="post.php?id=<?php echo $row['id']; ?>">
                        <img src="<?php echo $row['url']; ?>" alt="<?php echo $row['title']; ?>" width="200"/>
                    </a>
                    <br />
                    DISABLED: <?php echo $row['disabled'];?>
                    <a href="post_vote.php?post_id=<?php echo $row['id']; ?>&vote=1">Upvote (<?php echo $row['upvote']; ?>)</a>
                    <a href="post_vote.php?post_id=<?php echo $row['id']; ?>&vote=0">Downvote (<?php echo $row['downvote']; ?>)</a>
                    <hr />
                </div>
            <?php
            } } }?>   
    </div>
    <?php
        if($admin == 1)
        {
            echo '<a href="send_message.php">Send Email to users for troll leaderboard</a>';
        }
    ?>
</div>

<?php
include_once 'footer.php';
?>