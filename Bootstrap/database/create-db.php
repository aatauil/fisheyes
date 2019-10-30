<?php 

require 'database/database.php';

if ( !empty($_POST)) {
// Saisie des erreurs de validation
$usernameError = null;
$emailError = null;
$passwordError = null;

// Saisie des valeurs d‘entrée
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];

// Valider Engages 
$valid = true;
if (empty($username)) {
    $usernameError = 'Veuillez entrer un username';
    $valid = false;
}

if (empty($email)) {
    $emailError = 'Veuillez entrer une adresse email';
    $valid = false;
} else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
    $emailError = 'Veuillez entrer une adresse email valide';
    $valid = false;
}

if (empty($password)) {
    $passwordError = 'Veuillez entrer un password';
    $valid = false;
} else {
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
}

// Entrer des données
if ($valid) {
     $pdo = Database::connect();
     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     $sql = "INSERT INTO users (username,email,password) values(?, ?, ?)";
     $q = $pdo->prepare($sql);
     $q->execute(array($username,$email,$passwordHash));
     Database::disconnect();
     header("Location: database/index-db.php");
}
      }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title></title>
</head>

<body>
<div class="container">
    <div class="span10 offset1">
        <div class="row">
            <h3>Create a User</h3>
        </div>
        <form class="form-horizontal" action="logSys/create.php" method="post">
            <div class="form-group <?php echo !empty($nameError)?'has-error':'';?>">
                <label class="control-label">Name</label>
                <div class="controls">
                    <input name="username" type="text" placeholder="Username" value="<?php echo !empty($username)?$username:'';?>">
                    <?php if (!empty($usernameError)): ?>
                    <span class="help-inline"><?php echo   $usernameError;?></span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="form-group <?php echo !empty($emailError)?'has-error':'';?>">
                <label class="control-label">E-Mail-Adresse</label>
                <div class="controls">
                    <input name="email" type="text" placeholder="E-Mail-Adresse" value="<?php echo !empty($email)?$email:'';?>">
                    <?php if (!empty($emailError)): ?>
                    <span class="help-inline"><?php echo   $emailError;?></span>
                    <?php endif;?>
                </div>
            </div>
            <div class="form-group <?php echo !empty($passwordError)?'has-error':'';?>">
                <label class="control-label">password</label>
                <div class="controls">
                    <input name="password" type="text" placeholder="password" value="<?php echo !empty($password)?$password:'';?>">
                    <?php if (!empty($passwordError)): ?>
                    <span class="help-inline"><?php echo $passwordError;?></span>
                    <?php endif;?>
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-success">Create</button>
                <a class="btn btn-secondary" href="database/index-db.php">Back</a>
            </div>
        </form>
    </div>
</div> <!-- /container -->
<!-- Bootstrap core JavaScript -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>