<?php 
session_start();
if (!empty($_SESSION['user'])) {
    $display = $_SESSION['user'];
} else {
    $display = 'LOG IN';
}
if (isset($_GET['success'])) {
    $status = 'Login success';
} else if (isset($_GET['useroremailnotfound'])) {
    $status = 'User or mail not found';
} else if (isset($_GET['userpassworddoesnotmatch'])) {
    $status = "The password does not match";
} else if (isset($_GET['logoutsuccess'])) {
    $status = "You have logged out successfully";
} else if (isset($_GET['passwordchanged'])) {
    $status = "Password changed successfully, your new password is".$_GET['password'];
} else if (isset($_GET['userexistalready'])) {
    $status = "The user name already existed";
} else if (isset($_GET['createsuccess'])) {
    $status = "You have created a account";
}
?>

<nav class="navbar navbar-expand-lg navbar-light navbar-1">
    <button class="navbar-toggler" data-toggle="collapse" data-target=".navbars">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse navbars justify-content-between" id="collapse_target1">
        <!-- logo -->
        <a class="navbar-brand text-white" href="#">FishEyes</a>
        <p><?=$status?></p>
        <div class="d-flex">
            <!-- searchBar -->
            <form method="post" id="searchBar" class="searchBar">
                <input type="text" class="form-control" name="searchInput">
            </form>
            <button class="btn text-white shadow-none"><i class="fas fa-search text-white" id="search"></i></button>
            <!-- login button -->
            <button class="btn text-white shadow-none" data-toggle="modal" data-target="#Modal"><?=$display?></button>
        </div>
    </div>
</nav>
<nav class="navbar navbar-expand-lg mb-4">
    <div class="collapse navbar-collapse navbars justify-content-between" id="collapse_target2">
        <div class="d-flex">
            <!-- category -->
            <form method="post"><button type="submit" name="genre" value="Comédie" class="btn text-white shadow-none pl-0">Comédie</button></form>
            <form method="post"><button type="submit" name="genre" value="Horreur" class="btn text-white shadow-none">Horreur</button></form>
            <form method="post"><button type="submit" name="genre" value="Thriller" class="btn text-white shadow-none">Thriller</button></form>
            <form method="post"><button type="submit" name="genre" value="Guerre" class="btn text-white shadow-none">Guerre</button></form>
            <form method="post"><button type="submit" name="genre" value="SF" class="btn text-white shadow-none">SF</button></form>
        </div>
        <div class="d-flex">
            <button class="btn text-white shadow-none" data-toggle="modal" data-target="#Modal2">Settings</button>
            <!-- logout button -->
            <form action="login.php" method="post"><button class="btn text-white shadow-none" type="submit" name="logout">Logout</button></form>
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
                        <form method="post" action="create.php" class="d-flex flex-column ml-3" oninput='password2.setCustomValidity(password2.value != password.value ? "Passwords do not match." : "")'>
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
                        <form method="post" action="login.php" class="d-flex flex-column">
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

<!-- settings modal -->
<div class="modal fade" id="Modal2" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body container">
                <div class="row">
                    <div class="col-6 d-flex flex-column align-items-center justify-content-center">
                        <!-- change password -->
                        <h3 class="text-center mb-4">Change password</h3>
                        <form method="post" action="update.php" class="d-flex flex-column" oninput='newpassword2.setCustomValidity(newpassword2.value != newpassword.value ? "Passwords do not match." : "")'>
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
                        <!-- forget password -->
                        <h3 class="text-center mb-4">Forget password</h3>
                        <form method="post" action="forget.php" class="d-flex flex-column">
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

