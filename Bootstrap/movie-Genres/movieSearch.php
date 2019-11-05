<?php

$API_key = "4af2589deef3c4d1a028374023d93f3e";

    $pageNumber = '1';

    // ID assigned to each genre

    //different API CALLs
    $movieDetails = 'discover/movie';

    $curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.themoviedb.org/3/$movieDetails?api_key=$API_key&language=en-US&sort_by=popularity.desc&include_adult=false&include_video=false&page=1&with_genres=$genreNumber",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 100,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_POSTFIELDS => "{}",
    ));

$response = json_decode(curl_exec($curl),true);
$movieInfo = $response["results"];
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
                                        <div>
                                        <form method="post" action="#">
                                          <button type="submit" name="add" class="btn btn-dark" value='.$info['id'].'>Add to cart</button>
                                        </form>'
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
    ?>
