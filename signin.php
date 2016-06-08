<?php
    include_once 'session.php';
    include_once 'database.php';

    //sprejmem podatke s prejšnje strani
    $username = $_POST['username'];    
    $pass = $_POST['pass'];
    //geslo zakodiram s salt
    $pass = sha1($db_salt.$pass);
    
    $query = sprintf("SELECT * FROM users 
                      WHERE username = '%s' AND pass = '%s'",
                mysqli_real_escape_string($link, $username),
                mysqli_real_escape_string($link, $pass));
    //v result si shranim rezultat SELECT stavka, 
    //ki ga pošljem nad bazo
    $result = mysqli_query($link, $query);
    //preverim, če je le en takšen uporabnik
    if (mysqli_num_rows($result) != 1) {
        //napaka
        header("Location: login.php");
        die();
    }
    else {
        //vse je ok
        $user = mysqli_fetch_array($result);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        //shranimo uporabnika, ki se je prijavil v spremenljivko
        $user2 = $_SESSION['user_id'];
        //s tem selectom poiščemo ban_date, kjer je id v bazi enak id-ju prijavlenega
        $query2 = "SELECT ban_date FROM users WHERE (id=$user2);";
        //rezultat izvede
        $result2 = mysqli_query($link, $query2);
        //uporabimo funkcijo date,ki izpiše trenutni datum in jo shrani v spremenljivko
        $date = date("Y-m-d H:i:s");    
        while($row = mysqli_fetch_array($result2))
        {
            //če ban_date ni enako 0000...to pomeni,da je uporabnik bannan
            if($row['ban_date'] !== '0000-00-00 00:00:00')
            {
                //če je ban_date večji od trenutnega data, je uporabnik bannan in mu izpiše do kdaj
               if($row['ban_date'] > $date)
               {
                    $message = "Bannani ste od strani do: ".$row['ban_date'];
                    //sporočilo z potrditvenim oknom
                    echo "<script>confirm('$message');</script>";
                    //ob kliku na VREDO uporabnika vrže nazaj na login.php
                    echo '<script>window.location= "login.php"</script>';
               }
               //drugače pa ga prijavi in pošlje v index.php, ter mu posodobi ban_date na 0...
               else
               {                   
                    $query = "UPDATE users SET ban_date='0000-00-00 00:00:00' WHERE (id=$user2);";
                    $result = mysqli_query($link, $query);
                    header("Location: index.php");
                    die();
               }
            }
            //drugače pa ga prijavi in pošlje v index.php
            else
            {
                header("Location: index.php");
                die();
            }
        }
    }
    
?>