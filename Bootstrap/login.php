<?php 
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
                session_start();
                $_SESSION['user'] = $infos[1];
                header('location: index.php?success' . $_SESSION['user']);

            } else {
                $req->closeCursor(); 
                header('location: index.php?userpassworddoesnotmatch');
            }
        } else {
            $req->closeCursor(); 
            header('location: index.php?useroremailnotfound');
        }

    } else {
        session_destroy();
        header('location: index.php?logoutsuccess' . $_SESSION['user']);
    } 

} 
else {
    header('location: index.php');
}
