<?php

function commentaire($id) {
    //condtion pour afficher le boutton des commentaires ou non.
  if (!empty($_SESSION['user'])) {
      return   '<form action="./movie-Genres/commentaire.php" method="GET" class="form-inline row d-flex justify-content-center">
             <button class="btn btn-film ml-3 mr-3"type="submit" name="id_movies" value="'.$id.'">Go to comment page</button>
             </form>';
  } else {
      return 'You are not logged in';
  }
}


$API_key = "4af2589deef3c4d1a028374023d93f3e";

// if search input exists
if (!empty($_POST['searchInput']) && !isset($_POST['genre'])) {
    // Search bar get data
    $searchInput =  $_POST["searchInput"];
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
                                                <p>'.$info['vote_average'].'/10</p>
                                            </div>
                                            <div class="d-flex justify-content-center">
                                              <button type="submit" name="add" class="btn btn-dark" value='.$info['id'].'>Add to cart</button>'
                                                .commentaire($info['id']).//fonction pour afficher le bouton commentaires ou non.
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
    $genreNumber = "27";
    include "movie-Genres/movieSearch.php";
}

else if (isset($_POST['genre']) && $_POST['genre'] == 'Comedy') {
    $genreNumber = "35";
    include "movie-Genres/movieSearch.php";
}

else if (isset($_POST['genre']) && $_POST['genre'] == 'Thriller') {
    $genreNumber = "53";
    include "movie-Genres/movieSearch.php";
}

else if (isset($_POST['genre']) && $_POST['genre'] == "Guerre") {
    $genreNumber = "10752";
    include "movie-Genres/movieSearch.php";
}
else if (isset($_POST['genre']) && $_POST['genre'] == "SF") {
    $genreNumber = "878";
    include "movie-Genres/movieSearch.php";
}

// default setting
else {
    include "movie-Genres/popular.php";
}
