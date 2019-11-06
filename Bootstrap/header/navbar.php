<?php
if (!empty($_SESSION['user'])) {
    $affichage = $_SESSION['user'];
} else {
    $affichage = "Log in";
}
if(isset($_POST['buy'])){
  header("Location: ./shop/shop.php");
}
if (isset($_POST['add'])) {
  if(empty($_SESSION['cart'])){
    $_SESSION['cart']=array($_POST['add']);
  }else {
    array_push($_SESSION['cart'],$_POST['add']);
  }
}
if (isset($_POST['empty'])) {
  $_SESSION['cart'] = array();
}
$card="";
if ( !isset($_SESSION['cart'])||!$_SESSION['cart']) {
  $card = "Your cart is empty";
}
else {
  for($i = 0; $i < count($_SESSION['cart']); $i++){

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://api.themoviedb.org/3/movie/".$_SESSION['cart'][$i]."?language=en-US&api_key=b53ba6ff46235039543d199b7fdebd90",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 100,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_POSTFIELDS => "{}",
    ));

    $response = json_decode(curl_exec($curl),true);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
      echo "cURL Error #:" . $err;
    } else {
      $card .= '<div class="card text-center" style="width: 18rem;">
                  <img class="card-img-top img-fluid" src="https://image.tmdb.org/t/p/w185//'.$response['poster_path'].'" alt="Card image cap">
                  <div class="card-body">
                    <p class="card-text">'.$response['title'].'</p>
                  </div>
                </div>';
    }
  }
}

?>

<nav class="navbar navbar-expand-lg navbar-light navbar-1">
    <button class="navbar-toggler" data-toggle="collapse" data-target=".navbars">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse navbars justify-content-between" id="collapse_target1">
        <!-- logo -->
        <a class="navbar-brand text-white" href="../index.php">FishEyes</a>
        <div class="d-flex">
            <!-- searchBar -->
            <form method="post" id="searchBar" class="searchBar">
                <input type="text" class="form-control" name="searchInput">
            </form>
            <button class="btn text-white shadow-none"><i class="fas fa-search text-white" id="search"></i></button>
            <!-- eshop button -->
            <button class="btn text-white shadow-none" type="button" data-toggle="modal" data-target="#cart" ><i class="fas fa-shopping-cart" id="shop"></i></button>
            <!-- login button -->
            <button class="btn text-white shadow-none" data-toggle="modal" data-target="#Modal"><?=$affichage?></button>
        </div>
    </div>
</nav>
<nav class="navbar navbar-expand-lg mb-4">
    <div class="collapse navbar-collapse navbars justify-content-between" id="collapse_target2">
        <div class="d-flex">
            <!-- category -->
            <form method="post"><button type="submit" name="genre" value="Comedy" class="btn text-white shadow-none pl-0">Comédie</button></form>
            <form method="post"><button type="submit" name="genre" value="Horreur" class="btn text-white shadow-none">Horreur</button></form>
            <form method="post"><button type="submit" name="genre" value="Thriller" class="btn text-white shadow-none">Thriller</button></form>
            <form method="post"><button type="submit" name="genre" value="Guerre" class="btn text-white shadow-none">Guerre</button></form>
            <form method="post"><button type="submit" name="genre" value="SF" class="btn text-white shadow-none">SF</button></form>
        </div>
        <div class="d-flex">
            <button class="btn text-white shadow-none" data-toggle="modal" data-target="#Modal2">Settings</button>
            <!-- logout button -->
            <form action="logSys/login.php" method="post"><button class="btn text-white shadow-none" type="submit" name="logout">Logout</button></form>
        </div>
    </div>
</nav>


<!-- login Modal -->

<div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body container">
                <div class="row">
                    <div class="col-6">
                        <!-- register -->
                        <h3 class="text-center mb-4">Register</h3>
                        <form method="post" action="logSys/create.php" class="d-flex flex-column ml-3" oninput='password2.setCustomValidity(password2.value != password.value ? "Passwords do not match." : "")'>
                            <div class="form-group">
                                <label for="">Username</label>
                                <input type="text" name="user" class="form-control" placeholder="" required>
                            </div>
                            <div class="form-group">
                                <label for="">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="" required>
                            </div>
                            <div class="form-group">
                                <label for="">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="" required>
                            </div>
                            <div class="form-group">
                                <label for="">Confirm password</label>
                                <input type="password" name="password2"class="form-control" placeholder="" required>
                            </div>
                            <button type="submit" name="create" class="btn btn-film mt-3">Create account</button>
                            &nbsp;
                        </form>
                    </div>
                    <!-- login -->
                    <div class="col-6 d-flex flex-column align-items-center justify-content-center">
                        <h3 class="text-center mb-4">Login</h3>
                        <form method="post" action="logSys/login.php" class="d-flex flex-column">
                            <div class="form-group">
                                <label for="">Email or Username</label>
                                <input type="text" name="usermail" class="form-control" placeholder="" required>
                            </div>
                            <div class="form-group">
                                <label for="">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="" required>
                            </div>
                            <button type="submit" name="login" class="btn btn-film mt-3">Sign In</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- password change/forget modal -->

<div class="modal fade" id="Modal2" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body container">
                <div class="row">
                    <div class="col-6 d-flex flex-column align-items-center justify-content-center">
                        <h3 class="text-center mb-4">Change password</h3>
                        <form method="post" action="logSys/update.php" class="d-flex flex-column" oninput='newpassword2.setCustomValidity(newpassword2.value != newpassword.value ? "Passwords do not match." : "")'>
                            <div class="form-group">
                                <label for="">Email or Username</label>
                                <input type="text" name="usermail" class="form-control" placeholder="" required>
                            </div>
                            <div class="form-group">
                                <label for="">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="" required>
                            </div>
                            <div class="form-group">
                                <label for="">New password</label>
                                <input type="password" name="newpassword" class="form-control" placeholder="" required>
                            </div>
                            <div class="form-group">
                                <label for="">Confirm new password</label>
                                <input type="password" name="newpassword2" class="form-control" placeholder="" required>
                            </div>
                            <button type="submit" name="update" class="btn btn-film mt-3">Send</button>
                        </form>
                    </div>
                    <div class="col-6 d-flex flex-column align-items-center justify-content-center">
                        <h3 class="text-center mb-4">Forget password</h3>
                        <form method="post" action="logSys/forget.php" class="d-flex flex-column">
                            <div class="form-group">
                                <label for="">Email or Username</label>
                                <input type="text" name="usermail" class="form-control" placeholder="" required>
                            </div>
                            <button type="submit" name="forget" class="btn btn-film mt-3">Send</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="cart" tabindex="-1" role="dialog" aria-labelledby="cartCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="cartLongTitle"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="display:flex;">
        <?php echo $card; ?>
      </div>
      <div class="modal-footer">
        <form method="post">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" name="buy">Buy</button>
          <button type="submit" class="btn btn-danger" name="empty">Empty cart</button>
        </form>

      </div>
    </div>
  </div>
</div>
