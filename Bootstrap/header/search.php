<?php
$API_key = "4af2589deef3c4d1a028374023d93f3e";

//condtion pour afficher la barre des commentaires ou non.
if (!empty($_SESSION['user'])) {
    $message = '<form method="POST" class="form-inline row ">
                <input class="form-control col-8" type="text" name="commentaire">
                <button class="btn btn-film ml-3 mr-3"type="submit" name="envoyer">Envoyer</button>
                </form>';
    //if(isset($_POST['commentaire'])) {
        
        //$bdd = new PDO('mysql:host=localhost;dbname=fisheyes;', 'root', '');
        //$commentaire = htmlspecialchars($_POST['commentaire']);
        
       //$data=[':id_user'=> $_SESSION['user'],
       //':id_movie'=> $info['id'],
       //':commentaire'=> $commentaire];
        
        //$req = $bdd -> prepare('INSERT INTO commentaire(id users, id movies, comment, date_commentaire) Values(:id_user,:id_movie,:commentaire,NOW())');
        //$req-> execute($data);
        
        //$req -> closeCursor();
    //}
} else {
    $message = 'ERROR';
}

// if search input exists
if (!empty($_GET['searchInput']) && !isset($_POST['genre'])) {
    // Search bar get data
    $searchInput =  $_GET["searchInput"];
    $queryString = '&query='.$searchInput;

    //different API CALLs
    $movieDetails = '/search/movie';

    //Json CALL using cURL

    $curl = curl_init();

    curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.themoviedb.org/3$movieDetails?api_key=$API_key&language=en-US$queryString&page=1&include_adult=false",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 100,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_POSTFIELDS => "{}",
    ));

    $response = json_decode(curl_exec($curl),true);
    $movieInfo = $response['results'];
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
                $i = 0;
                $imgSize = "/w300";
                $poster = 'poster_path';
                $overview = 'overview';
                $send = 'method="POST"';
    
                foreach($movieInfo as $info){
                    
                    if(isset($_POST['commentaire'])) {
                        
                        $bdd = new PDO('mysql:host=localhost;dbname=fisheyes;', 'root', '');
                        $commentaire = htmlspecialchars($_POST['commentaire']);
                        
                        $data=[':id_user'=> $_SESSION['user'],
                        ':id_movie'=> $info['id'],
                        ':commentaire'=> $commentaire];
        
                        $req = $bdd -> prepare('INSERT INTO commentaire(id users, id movies, comment, date_commentaire) Values(:id_user,:id_movie,:commentaire,NOW())');
                        $req-> execute($data);
                        $req -> closeCursor();
                        header('location:../index.php?searchInput='.$_GET["searchInput"].'');
                        }
                    $PosterPath = $info[$poster];
    
                    // insert message "image non disponible" when image not found
                    if ($info['poster_path'] == "") {
                        $image = "<p class='text-white'>Image non disponible</p>";
                    } else {
                        $image = '<img class="img-fluid" src="https://image.tmdb.org/t/p'.$imgSize.$PosterPath.'">';
                    }
    
                // PUT CARD ON SCREEN WITH EACH MOVIE
                    echo 
                    '<div class="col-lg-2 col-md-6 mb-4">
                        <div class="card movie">
                            '.$image.'
                            <div class="card-footer text-white text-left">
                                <p>'.$info['title'].'</p>
                                <p>'.$info['id'].'</p>
                                <p>'.$info['vote_average'].'/10</p>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="movieModal'.$i.'" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-body container">
                                    <div class="row">
                                        <div class="col">
                                            <img class="img-fluid" src="https://image.tmdb.org/t/p'.$imgSize.$PosterPath.'">
                                        </div>
                                        <div class="col d-flex flex-column justify-content-between">
                                            <div>
                                                <h2>'.$info['title'].'</h2>
                                                <p> '.$info['overview'].'</p>
                                                <p>'.$info['id'].'</p>
                                                <p>'.$info['vote_average'].'/10</p>
                                            </div>
                                            <div>'
                                                .$message. //variable pour afficher la barre des commentaires ou non.

    
                                            '</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>';
                $i += 1;
                } 
            }
} 


else if (isset($_POST['genre']) && $_POST['genre'] == 'Horreur') {
    include "movie-Genres/horreur.php";
} 

else if (isset($_POST['genre']) && $_POST['genre'] == 'Comedy') {
    include "movie-Genres/comedy.php";
}

else if (isset($_POST['genre']) && $_POST['genre'] == 'Thriller') {
    include "movie-Genres/thriller.php";
}

else if (isset($_POST['genre']) && $_POST['genre'] == "Guerre") {
    include "movie-Genres/war.php";
}
else if (isset($_POST['genre']) && $_POST['genre'] == "SF") {
    include "movie-Genres/scifi.php";
}

// default setting
else {
    include "movie-Genres/popular.php";
}