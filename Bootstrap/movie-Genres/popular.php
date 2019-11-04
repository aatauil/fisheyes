<?php

$pageNumber = 0;
// one page = 20 movies , 5 pages = 100movies
$maxPages = 3;
//for loop to get more movies shown on same page
$comptage = 0;
for($y = 1; $y < $maxPages ; $y++){
    $API_key = "4af2589deef3c4d1a028374023d93f3e";
    $pageNumber++;
    // Search bar get data
    //different API CALLs
    $movieDetails = 'movie/popular';
    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.themoviedb.org/3/$movieDetails?api_key=$API_key&language=en-US&page=$pageNumber",
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
    $imgSize = "/w300";
    $poster = 'poster_path';
    $overview = 'overview';
    foreach($movieInfo as $info){
    //$idMovies = $info['id'];
    $PosterPath = $info[$poster];
    // PUT CARD ON SCREEN WITH EACH MOVIE
    echo 
        '<div class="col-lg-2 col-md-6 mb-4">
            <div class="card movie">
                <img class="img-fluid" src="https://image.tmdb.org/t/p'.$imgSize.$PosterPath.'">
                    <div class="card-footer text-white text-left">
                        <p><bold>'.$info['title'].'</bold></p>
                        <p>'.$info['vote_average'].'/10</p>
                    </div>
            </div>
        </div>
        <div class="modal fade" id="movieModal'.$comptage.'" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body container">
                        <div class="row">
                            <div class="col">
                                <img class="img-fluid" src="https://image.tmdb.org/t/p'.$imgSize.$PosterPath.'">
                            </div>
                            <div class="col">
                            <div>
                                <h2>'.$info['title'].'</h2>
                                <p> '.$info['overview'].'</p>
                                <p>'.$info['vote_average'].'/10</p>
                                </div>
                                <div>'
                                    .commentaire($info['id']).//fonction pour afficher le bouton commentaires ou non.
                                '</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>';
    $comptage += 1;
    }
    } 
} 

?>
