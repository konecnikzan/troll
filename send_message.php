<?php
include_once 'database.php';
require 'PHPMailer/PHPMailerAutoload.php';
$query = "SELECT email,username FROM users";
$result = mysqli_query($link, $query);
while($row = mysqli_fetch_array($result))
{
    $email = $row['email'];
    $username = $row['username'];

    $mail = new PHPMailer;

    //$mail->SMTPDebug = 3;                               // Enable verbose debug output

    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';                       // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'praksamusic@gmail.com';            // SMTP username
    $mail->Password = 'praksamusic123';                   // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to

    $mail->setFrom('praksamusic@gmail.com', 'Admin');
    $mail->addAddress("$email", "$username");             // Add a recipient
    $mail->addCC('cc@example.com');
    $mail->addBCC('bcc@example.com');

    $mail->isHTML(true);                                  // Set email format to HTML

    $mail->Subject = 'Troll leaderboard';
    
    $uporabniki="";
    $st=0;
    $query2 = "SELECT * FROM users ORDER BY num_posts DESC LIMIT 3;";    //razvrsti jih od najmanjšega do največjega, izpiše prve 3 največje
    $result2 = mysqli_query($link, $query2);
    while($row2 = mysqli_fetch_array($result2))
    {    
        $st++;
        $username = $row2['username']; 
        $uporabniki .= "$st. $username<br />";
        echo $uporabniki;
    }
    $mail->Body = "$uporabniki";

    if(!$mail->send()) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        /*echo 'Message has been sent <br />';*/
        header("Location: index.php");
    }
}

