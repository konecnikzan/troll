<?php
include_once 'header.php';
include_once 'database.php';

//nekdo pošilja sporočilo za oglas
$sporocilo_uporabniku = 0;
if (!empty($_GET['ad_id'])) {
    $ad_id = (int) $_GET['ad_id'];
    $sporocilo_uporabniku = 1;

    $query_select_ad_info = sprintf("SELECT a.id, a.title, u.email FROM ads a 
            INNER JOIN users u ON a.user_id=u.id WHERE ((a.id='%s'));", mysqli_real_escape_string($link, $ad_id));
    $result_select_ad_info = mysqli_query($link, $query_select_ad_info);
    //echo $query_select_ad_info;    die();

    if (mysqli_num_rows($result_select_ad_info) == 1) {
        $ad = mysqli_fetch_array($result_select_ad_info);
    } else {
        header("Location: ad_list.php");
        exit();
    }
}
    $odgovor_uporabniku = 0;
    if (!empty($_GET['response_id'])) {
        $response_id = (int) $_GET['response_id'];
        $odgovor_uporabniku = 1;

        $query_select_user_info = sprintf("SELECT * FROM messages m
                INNER JOIN users u ON u.id=m.user_id WHERE ((m.id='%s') AND (m.prejemnik_id='%s'));",
                mysqli_real_escape_string($link, $response_id),
                mysqli_real_escape_string($link, $_SESSION['user_id']));
        $result_select_user_info = mysqli_query($link, $query_select_user_info);
        //echo $query_select_user_info;    die();
        
        //WHERE ((m.id='%s') AND (m.prejemnik_id='%s'))
        /*SELECT a.id, a.title, u.email, m.zadeva, m.user_id FROM ads a
            INNER JOIN users u ON a.user_id=u.id
            INNER JOIN messages m ON m.user_id=u.id WHERE (m.id>0);*/
        if (mysqli_num_rows($result_select_user_info) == 1) {
            $user = mysqli_fetch_array($result_select_user_info);

            $query_select_prejemnik_email = "SELECT email FROM users WHERE (id='" . $user['user_id'] . "');";
            $result_select_prejemnik_email = mysqli_query($link, $query_select_prejemnik_email);
            //echo $query_select_prejemnik_email; die();

            if (mysqli_num_rows($result_select_prejemnik_email) == 1) {
                $prejemnik = mysqli_fetch_array($result_select_prejemnik_email);
            }
        } else {
            header("Location: ad_list.php");
            exit();
        }
    }
    ?>




    <h1>Pošlji sporočilo</h1><br><br>
    <form action="send_message.php" id="sendMessage" method="POST">
        <label>Vnesite email uporabnika:</label><br>
        <input type="text" name="email" 
    <?php
    if ($sporocilo_uporabniku == 1) {
        echo 'value="' . $ad['email'] . '"';
    }
    if ($odgovor_uporabniku == 1) {
        echo 'value="' . $prejemnik['email'] . '"';
    }
    ?> 
               placeholder="Email prejemnika"><br><br>
        <label>Vnesite zadevo:</label><br>
        <input type="text" name="subject" 
    <?php
    if ($sporocilo_uporabniku == 1) {
        echo 'value="Zanima me oglas: ' . $ad['title'] . '"';
    }
    if ($odgovor_uporabniku == 1) {
        echo 'value="RE: ' . $user['zadeva'] . '"';
    }

    /* $odgovor_uporabniku=0;
      $sporocilo_uporabniku=0; */
    ?> placeholder="Zadeva"><br><br>

        <label>Vnesite sporočilo:</label><br>
        <textarea form="sendMessage" name="message" cols="50" rows="30"></textarea><br><br>
        <input type="submit" value="Pošlji">
    </form>

    <?php
    include_once 'footer.php';