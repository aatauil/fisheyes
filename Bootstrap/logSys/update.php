<?php 
if (isset($_POST['update'])) {
        try {
            $bdd = new PDO('mysql:host=localhost;dbname=fisheyes;charset=utf8', 'root', '');
        } 
        catch (Exception $e) {
        die('Erreur : ' .$e->getMessage());
        } 
        $usermail = htmlspecialchars($_POST['usermail']);
        $password = $_POST['password'];
        $newPassword = password_hash($_POST['newpassword'], PASSWORD_DEFAULT);

        $req = $bdd->prepare('SELECT COUNT(*) FROM users WHERE email = :email OR username = :username');
        $req->execute(array('email' => $usermail,'username' => $usermail));
        $nombre = $req->fetch();
        if ($nombre[0] != 0) {
            $req = $bdd->prepare('SELECT password, username FROM users WHERE username = :username');
            $req->execute(array('username' => $usermail,));
            $infos = $req->fetch();
            if (password_verify($password, $infos[0])) {
                $req->closeCursor(); 
                $req = $bdd->prepare('UPDATE users SET password = :password WHERE email = :email OR username = :username');
                $req->execute(array('email' => $usermail, 'username' => $usermail, 'password' => $newPassword));
                $req->closeCursor();
                header('location: ../index.php?changesuccess');

            } else {
                $req->closeCursor(); 
                header('location: ../index.php?userpassworddoesnotmatch');
            }
        } else {
            $req->closeCursor(); 
            header('location: ../index.php?useroremailnotfound');
        }
} 
else {
    header('location: ../index.php');
}
