<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form method="POST">
    <label>Entrez votre Pseudo:<input type="text" name="pseudo"></label> <br>
    <label>Entrez votre commentaire:<textarea name="comment" id="comment" cols="30" rows="10"></textarea></label>
    <input type="submit" value="Envoyez">

    </form>

    <p>commentaire</p>


<?php 

$bdd = new PDO("mysql:host=localhost;dbname=FIshe_eyes", "root", "");
if (isset($_POST["pseudo"]) && isset($_POST["comment"])  && !empty($_POST["pseudo"]) && !empty($_POST["pseudo"])) {

    $pseudo = htmlspecialchars($_POST["pseudo"]);
    $comment = htmlspecialchars($_POST["comment"]);
        if(strlen($pseudo)<12){
            $ins = $bdd->prepare("INSERT INTO commentaires ( pseudo, commentaire) VALUES (?,?)");
            
            $ins->execute(array($pseudo,$comment));
            $c_msg = "<span style='color:green'>Votre commentaire a bien été posté</span>";
            
        } else {
            $c_msg = "Erreur: Le pseudo doit faire moins de 12 caractères";
            
        }
} 
echo "$c_msg";
?>

</body>
</html>