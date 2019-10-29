<?php 
session_start();
if (isset($_POST['login']) || isset($_POST['logout'])) {
    if ((isset($_POST['login']))) {
        try {
        $bdd = new PDO('mysql:host=localhost;dbname=fisheyes;charset=utf8', 'root', 'root');
        } 
        catch (Exception $e) {
        die('Erreur : ' .$e->getMessage());
        } 
        $usermail = $_POST['usermail'];
        $password = $_POST['password'];

        $req = $bdd->prepare('SELECT COUNT(*) FROM users WHERE email = :email OR username = :username');
        $req->execute(array('email' => $usermail,'username' => $usermail));
        $nombre = $req->fetch();
        if ($nombre[0] != 0) {
            $req = $bdd->prepare('SELECT password, username FROM users WHERE username = :username');
            $req->execute(array('username' => $usermail,));
            $infos = $req->fetch();
            if (password_verify($password, $infos[0])) {
                $req->closeCursor(); 
                $_SESSION['user'] = $infos[1];
                header('location: index.php?success');

            } else {
                $req->closeCursor(); 
                header('location: index.php?userpassworddoesnotmatch');
            }
        } else {
            $req->closeCursor(); 
            header('location: index.php?useroremailnotfound');
        }

    } else {
        $_SESSION['user'] = '';
        header('location: index.php?logoutsuccess');
    } 

} 
else {
    header('location: index.php');
}
