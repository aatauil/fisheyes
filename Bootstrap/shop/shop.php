<?php
session_start();
if($_SESSION['user']==""){
    header('location: ../index.php');
    exit;
}else{
if(!$_SESSION['cart']){
    header('location: ../index.php');
    exit;
}
else{


$longeur=count($_SESSION['cart']);
if($longeur>=5){
    $_COOKIE['total']=$_COOKIE['total']-(($_COOKIE['total']/100)*5);
}
if(isset($_POST['pay'])){
  try{

    //Connection to MySQL
    $bdd = new PDO('mysql:host=localhost;dbname=fisheyes;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
  }catch (Exception $e) {

    //If an issue occurs, show a message and stop
    die('Erreur : ' . $e->getMessage());
  }
  
  $id_commande = rand(0,10000);
  $req = $bdd->prepare('INSERT INTO commandes(id_commande,id_user,id_movie,date_order,prix) VALUES (?,?,?,NOW(),?)');

  for ($i=0; $i < count($_SESSION['cart']); $i++) {
    $req->execute(array(
      $id_commande,
      $_SESSION['id'],
      $_SESSION['cart'][$i],
      $_COOKIE['total']
    ));
  
}$_SESSION['cart']=array();

}
}
}
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
</head>
<script>
    var total= 0;
    var prix;
    var list = <?php echo json_encode($_SESSION['cart']); ?>;

    function getDetails(id){
    prix= 0;
    var url = "https://api.themoviedb.org/3/movie/"+id+"?api_key=b53ba6ff46235039543d199b7fdebd90&language=en-US";
    fetch(url)
    .then(reponse =>reponse.json())
    .then (data => {
    var vote =data.vote_average;
    if(vote<5){
        prix=5;
    }
    else if(vote<7.5 && vote>5){
        prix=7.5;
    }
    else if(vote <8.4 && vote>7.5){
        prix=10;
    }
    else{
        prix=12.5;
    }
    total= total+prix;
    var ecris1=document.getElementById('total');
    ecris1.innerHTML="<h1>Total</h1><p>subtotal:"+" "+total+"$"+"</p>";
    var ecris=document.getElementById('shoppingCart');
    ecris.innerHTML+="<div class='object'><img width='20%' src='http://image.tmdb.org/t/p/w185//"+data.poster_path+"'><p id='filmDesc'><b>"+data.title+"</b><br>"+prix+"$</p> </div>";
    console.log(total)


    // create cookie to transfer js variable to php

    $(document).ready(function () {
    createCookie("total", total, "10");
});

// Function to create the cookie
function createCookie(name, value, days) {
    var expires;

    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toGMTString();
    }
    else {
        expires = "";
    }

    document.cookie = escape(name) + "=" +
        escape(value) + expires + "; path=/";
}
    })
    }
    //affichage des elements du panier
    for(var i =0;i<list.length;i++){
        getDetails(list[i]);
    }
    </script>

<?php include("../header/navbarshop.php");  ?>
<body>
  <div class="container">
    <div class="row">
      <div class="col-md-1">
      </div>
      <div class="col-md-5 content" id='shoppingCart'>
        <h1>Shopping Cart</h1>
      <?php
      if (empty($_SESSION['cart'])){
          echo "<span id='emptyCart'>Your shopping cart is empty<span>";
      } else {

      }
      ?>
      </div>
    <div class="col-md-5 content" id="tot" style="height:370px;">
    <div id="total">
    </div>
    <form method="GET">
      <label>Code promo : </label>
      <input type="text" name="promo">
      <label>Choose your country</label>
      <select name="country">
      <option value="Belgium" selected> Belgium(Free)</option>
      <option value="Europe"> Europe(2.50$)</option>
      <option value="Outside"> Outside Europe(5$)</option>
      </select> <br>
      <input id="checkout" name="submit" type="submit" value="Calculate Price">
    </form>
    <?php
    if(isset($_GET['submit'])&& isset($_GET['country'])){
        if($_GET['promo']=="MIKEESTTROPCOOL"){
            if($_GET['country']=="Belgium"){
            $total=$_COOKIE['total']-(($_COOKIE['total']/100)*15);
            echo "<p id='finalPrice'>Total : ".strval($total)."$</p>";
            echo "<form action ='' method='post'><button name='pay' type='submit'>Pay now!</button><br><span>15% off with this coupon</span>";
            if($longeur>=5){
                echo "<br><span id ='off'>5% off for 5 movies</span></form>";
            }

            }
            elseif($_GET['country']!="Belgium"){
                $total=$_COOKIE['total']-(($_COOKIE['total']/100)*10);
                echo "<p id='finalPrice'>Total : ".strval($total)."$</p>";
                echo "<form action ='' method='post'><button name='pay' type='submit'>Pay now!</button><br><span>10% off with this coupon</span>";
                if($longeur>=5){
                    echo "<br><span id ='off'>5% off for 5 movies</span></form>";
                }
            }
        }
        else{
            if($_GET['country']=="Europe"){

            $total=$_COOKIE['total']+2.50;
            echo "<p id='finalPrice'>Total : ".$total."$</p>";
            echo "<form action ='' method='post'><button name='pay' type='submit'>Pay now!</button></form>";
            }
            elseif($_GET['country']=="Outside"){
                $total=$_COOKIE['total']+5;
                echo "<p id='finalPrice'>Total : ".$total."$</p>";
                echo "<form action ='' method='post'><button name='pay' type='submit'>Pay now!</button></form>";
            }
            elseif($_GET['country']=="Belgium"){
                $total=$_COOKIE['total'];
                echo "<p id='finalPrice'>Total : ".$total."$</p>";
                echo "<form action ='' method='post'><button name='pay' type='submit'>Pay now!</button></form>";
            }
        }
    }
    ?>
    </div>
    <div class="col-md-1"
    </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
