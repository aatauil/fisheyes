<?php 
session_start();
$API_key = "4af2589deef3c4d1a028374023d93f3e";
//condtion pour afficher la barre des commentaires ou non.
if (!empty($_SESSION['user'])) {
    $message = '<form method="POST" class="form-inline row ">
                <input class="form-control col-8" type="text" name="commentaire">
                <button class="btn btn-film ml-3 mr-3"type="submit" name="envoyer">Envoyer</button>
                </form>';
} else {
    $message = 'ERROR';
}

// if search input exists
if (!empty($_POST['searchInput'])) {
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
    
                foreach($movieInfo[$i] as $info){
                    $PosterPath = $movieInfo[$i][$poster];
    
                    // insert message "image non disponible" when image not found
                    if ($movieInfo[$i]['backdrop_path'] == "") {
                        $image = "<p>Image non disponible</p>";
                    } else {
                        $image = '<img class="img-fluid" src="https://image.tmdb.org/t/p'.$imgSize.$PosterPath.'">';
                    }
    
                // PUT CARD ON SCREEN WITH EACH MOVIE
                    echo 
                    '<div class="col-lg-2 col-md-6 mb-4">
                        <div class="card movie">
                            <img class="img-fluid" src="https://image.tmdb.org/t/p'.$imgSize.$PosterPath.'">
                            <div class="card-footer text-white text-left">
                                <p>'.$movieInfo[$i]['title'].'</p>
                                <p>'.$movieInfo[$i]['id'].'</p>
                                <p>'.$movieInfo[$i]['vote_average'].'/10</p>
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
                                                <h2>'.$movieInfo[$i]['title'].'</h2>
                                                <p> '.$movieInfo[$i]['overview'].'</p>
                                                <p>'.$movieInfo[$i]['vote_average'].'/10</p>
                                            </div>
                                            <div>'
                                                .$message.//variable pour afficher la barre des commentaires ou non.
                                               // $req = $bdd -> prepare('INSERT INTO commentaire (id users, id movies, comment, date) Values(? ,? ,? , NOW())');
                                              //  if(isset($_POST['send'])) {
                                               //     $req = $bdd -> execute(array());
                                               // }
    
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

// default setting
if (empty($_POST['searchInput'])) {
    $pageNumber = 0;
// one page = 20 movies , 5 pages = 100movies
$maxPages = 10;
//for loop to get more movies shown on same page
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
        $i = 0;
        $imgSize = "/w300";
        $poster = 'poster_path';
        $overview = 'overview';
        foreach($movieInfo[$i] as $info){
            
            $PosterPath = $movieInfo[$i][$poster];
        // PUT CARD ON SCREEN WITH EACH MOVIE
            echo 
            '<div class="col-lg-2 col-md-6 mb-4">
                <div class="card movie">
                    <img class="img-fluid" src="https://image.tmdb.org/t/p'.$imgSize.$PosterPath.'">
                    <div class="card-footer text-white text-left">
                        <p><bold>'.$movieInfo[$i]['title'].'</bold></p>
                        <p>'.$movieInfo[$i]['vote_average'].'/10</p>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="movieModal'.$i.'" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-body container">
                            <div class="row">
                                <div class="col">
                                    <img class="img-fluid" src="https://image.tmdb.org/t/p'.$imgSize.$PosterPath.'">
                                </div>
                                <div class="col">
                                    <div>
                                        <h2>'.$movieInfo[$i]['title'].'</h2>
                                        <p> '.$movieInfo[$i]['overview'].'</p>
                                        <p>'.$movieInfo[$i]['vote_average'].'/10</p>
                                    </div>
                                    <div>'
                                        .$message.//variable pour afficher la barre des commentaires ou non.
                                    // $req = $bdd -> prepare('INSERT INTO commentaire (id users, id movies, comment, date) Values(? ,? ,? , NOW())');
                                    //  if(isset($_POST['send'])) {
                                    //     $req = $bdd -> execute(array());
                                    // }
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
}