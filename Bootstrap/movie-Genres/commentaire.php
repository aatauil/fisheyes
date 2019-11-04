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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/7b840f6fa2.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
    <link href="../style.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light navbar-1">
            <!-- logo -->
            <a class="navbar-brand text-white" href="../">FishEyes</a>
    </nav>
    <form method="POST" class="form-inline row mt-3">
        <input class="form-control col-8 ml-5" type="text" name="commentaire">
        <button class="btn btn-film ml-3 mr-3"type="submit" name="envoyer">Envoyer</button>
    </form>
    <div class="container ml-3">
        <div class="row mt-4 text-white">
            <div class="col-2 text-center">Id</div>
            <div class="col-5 text-center">Commentaire</div>
            <div class="col-2 text-center">Date du commentaire</div>
        </div>
    <!-- prendre les commentaires dans la base de donnée -->
    <?php
    $idMovies=$_GET['id_movies'];//je prends l'id film de l'url pour le mettre dans une variable.

    $bdd = new PDO('mysql:host=localhost;dbname=id11453176_fisheyes;', 'id11453176_daniel43886', 'c=5CPBky');

    //condition pour envoyer le commentaire dans la base de donnée
    if(!empty($_POST['commentaire']) && filter_var($idMovies, FILTER_VALIDATE_INT)) {

        $commentaire = htmlspecialchars($_POST['commentaire']);
    
        $data=[':id_users'=> $_SESSION['user'],
        ':id_movies'=> $idMovies,
        ':comment'=> $commentaire]; // ceci est un tableau pour les variables de mon "Values()"
        
        $req = $bdd -> prepare('INSERT INTO commentaire(id_users, id_movies, comment, date_commentaire) Values(:id_users,:id_movies,:comment,NOW())');
        $req-> execute($data);
        $req-> closeCursor();

    } 

    $reponse = $bdd->query('SELECT id_users, comment, date_commentaire FROM commentaire WHERE id_movies='.$idMovies.' ORDER BY date_commentaire DESC LIMIT 10');

    while ($donnees = $reponse->fetch()){
        echo  
        '<div class="row mt-2 text-white">
            <div class="col-2 text-center">'.htmlspecialchars($donnees['id_users']).'</div>
            <div class="col-5 text-center">'.htmlspecialchars($donnees['comment']).'</div>
            <div class="col-2 text-center">'.htmlspecialchars($donnees['date_commentaire']).'</div>
        </div>';
    } //ceci affiche les donées que je lui demande d'afficher.
    ?>
    </div>
</body>
</html>





