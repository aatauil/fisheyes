<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/7b840f6fa2.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
    <link href="../style.css" rel="stylesheet">
    <title>Fish Eyes</title>


</head>
<body>
<!-- navbar HTML -->

<?php include("../header/navbarshop.php"); ?>

<div class="container-fluid">
        <div class="row text-center">
        </div>
    </div>

<!-- liste avec toutes les anciennes commandes -->
<div class="container-fluid">
    <div class="title">
        <h1>Historique de commande</h1>
    </div>
    <!-- on fais le lien avec la BDD -->
    <?php 
    try{
        //On se connecte à MySQL
        $bdd = new PDO('mysql:host=localhost;dbname=fisheyes', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    }catch (Exception $e) {
      
        //En cas d'erreur on affiche un message et on arrete tout
        die('Error : ' . $e->getMessage());
      }

      //on récupère l'id de l'user
      $userid=$_SESSION['id'];
//on prépare la BDD//
        $requete=$bdd->prepare('SELECT id_user, id_commande, id_movie, date_order, c.id FROM commandes c INNER JOIN users u
        ON c.id_user= u.id WHERE id_user = ? ORDER BY date_order DESC');
        $requete->execute(array($userid));
    $ligne= $requete->fetch();
    if(!$ligne)
    {
        echo "<div class='title comand'><p>Vous n'avez encore rien commandé sur notre site! <br>
        rendez vous sur notre catalogue en <a href='http://localhost/fisheyes/Bootstrap'>cliquant ici</a>
        <br>pour commencer 
        vos achats</p></div>";
    }
    else{
        $i=0;
        while($ligne=$requete ->fetch()){
            echo "<br> <br><div class='".$i."'>".$ligne['date_order']."</div> <div> ".$ligne['id_movie']."</div>";
            $i++;
        }
    }

    ?>



</div>






    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

<script>
let movie = document.getElementsByClassName('movie');
for (let i=0; i<movie.length; i++) {
    movie[i].addEventListener('click', function() {
        $(`#movieModal${i}`).modal('toggle')
    })
}
$('#search').on('click', function(e) {
    $('#searchBar').toggleClass('animation');
})

</script>
</body>
</html>