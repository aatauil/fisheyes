<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Commentaire</title>

    
</head>
<body>

    <form method="POST" class="form-inline row ">
    <input class="form-control col-8" type="text" name="commentaire">
    <button class="btn btn-film ml-3 mr-3"type="submit" name="envoyer">Envoyer</button>
    </form>

    <?php
    $idMovies=$_GET['id_movies'];//je prends l'id film de l'url pour le mettre dans une variable.

    //condition pour envoyer le commentaire dans la base de donnée
    if(!empty($_POST['commentaire'])) {
        
        $bdd = new PDO('mysql:host=localhost;dbname=fisheyes;', 'root', '');

        $commentaire = htmlspecialchars($_POST['commentaire']);
    
        $data=[':id_users'=> $_SESSION['user'],
        ':id_movies'=> $idMovies,
        ':comment'=> $commentaire]; // ceci est un tableau pour les variables de mon "Values()"
        
        $req = $bdd -> prepare('INSERT INTO commentaire(id_users, id_movies, comment, date_commentaire) Values(:id_users,:id_movies,:comment,NOW())');
        $req-> execute($data);
        $req-> closeCursor();

        $reponse = $bdd->query('SELECT id_users, comment, date_commentaire FROM commentaire WHERE id_movies='.$idMovies.' ORDER BY date_commentaire DESC LIMIT 0, 3');

        while ($donnees = $reponse->fetch()){
            echo '<p><strong>' . htmlspecialchars($donnees['id_users']) . '</strong> : ' . htmlspecialchars($donnees['comment']) . '<strong> <br>' . htmlspecialchars($donnees['date_commentaire']) . ' </strong></p>';
        } //ceci affiche les donées que je lui demande d'afficher.

    } 
    


    ?>
</body>
</html>





