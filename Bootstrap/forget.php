<?php 
if (isset($_POST['forget'])) {
        try {
        $bdd = new PDO('mysql:host=localhost;dbname=fisheyes;charset=utf8', 'root', 'root');
        } 
        catch (Exception $e) {
        die('Erreur : ' .$e->getMessage());
        } 
        $usermail = htmlspecialchars($_POST['usermail']);

        // check if the user/email exists

        $req = $bdd->prepare('SELECT COUNT(*) FROM users WHERE email = :email OR username = :username');
        $req->execute(array('email' => $usermail,'username' => $usermail));
        $nombre = $req->fetch();
        $req->closeCursor(); 

        if ($nombre[0] != 0) {

            // get user's email

            $req = $bdd->prepare('SELECT email FROM users WHERE email = :email OR username = :username');
            $req->execute(array('email' => $usermail,'username' => $usermail));
            $email = $req->fetch();
            $req->closeCursor(); 

            // generate new password

            $newPassword = bin2hex(openssl_random_pseudo_bytes(4));
            $newPassword_hash = password_hash($newPassword, PASSWORD_DEFAULT);
            $req = $bdd->prepare('UPDATE users SET password = :password WHERE email = :email OR username = :username');
            $req->execute(array('email' => $usermail, 'username' => $usermail, 'password' => $newPassword_hash));
            $req->closeCursor();

            // send new password to user 

            $to_email = $email[0];
            $subject = 'Password change succeeded';
            $message = 'Hello, this is your new password : ' . $newPassword;
            $headers = 'From: shaoyuan.weng@gmail.com';
            mail($to_email,$subject,$message,$headers);

            header('location: index.php?passwordchangedPassword='.$newPassword);            
        } else {
            header('location: index.php?useroremailnotfound');
        }
} 
else {
    header('location: index.php');
}