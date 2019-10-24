<?php
/* Interrogation de la base de données */
try
{
    $bdd = new PDO('mysql:host=localhost;dbname=fisheyes;charset=utf8', 'root', 'root');
} 
catch (Exception $e) 
{
    die('Erreur : ' .$e->getMessage());
} 
if (isset($_POST['titel']) && !empty($_POST['titel']))
{
    $titel = '%'.$_POST['titel'].'%';
    $req = $bdd->prepare('SELECT movie_ref, titel , rate FROM movies where titel Like ? ORDER BY titel ASC');
    $req->execute(array($titel));
}
elseif (isset($_POST['genre']) && !empty($_POST['genre']))
{
    $genre = $_POST['genre'];
    $req = $bdd->prepare('SELECT movie_ref, titel , rate FROM movies where genre = ? ORDER BY titel ASC');
    $req->execute(array($genre));
} else 
{
    $req = $bdd->query('SELECT movie_ref, titel , rate FROM movies ORDER BY titel ASC');
}

/* Affichage des images sélectionnées*/

echo '<div class="row text-center">';

while ($movie = $req->fetch()) 
    {
    echo '<div class="col-lg-3 col-md-6 mb-4">
            <div class="card border-dark movie">
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item card-img-top" src="'.$movie['movie_ref'].'" allowfullscreen></iframe>
                </div>
                <div class="card-footer bg-secondary text-white text-left">
                    <a>'.$movie['titel'].'</a><br>
                    <a>'.$movie['rate'].'/10</a>
                </div>
            </div>
        </div>
        <div class="modal fade" id="movieModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body container">
                        <div class="row">
                            <div class="embed-responsive embed-responsive-16by9">
                                <iframe class="embed-responsive-item card-img-top" src="'.$movie['movie_ref'].'" allowfullscreen></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>';
    }
echo '</div>'; 
$req->closeCursor(); 
?>
