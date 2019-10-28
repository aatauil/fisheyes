<?php
$API_key = "4af2589deef3c4d1a028374023d93f3e";

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

        foreach($movieInfo[$i] as $info){

            $PosterPath = $movieInfo[$i][$poster];

            if ($movieInfo[$i]['backdrop_path'] == "") {
                $image = "<p>Image non disponible</p>";
            } else {
                $image = '<img class="img-fluid" src="https://image.tmdb.org/t/p'.$imgSize.$PosterPath.'">';
            }

            echo 
            '<div class="col-lg-2 col-md-6 mb-4">
                <div class="card border-dark movie">
                    <div style="height : 18rem;" class="d-flex align-items-center justify-content-center">
                        '.$image.'
                    </div>
                    <div class="card-footer bg-secondary text-white text-left">
                        <p>'.$movieInfo[$i]['title'].'</p>
                        <p>'.$movieInfo[$i]['vote_average'].'/10</p>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="movieModal'.$i.'" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered modal-xl" role="document">
                    <div class="film">
                        <div class="modal-body container">
                            <div class="row">
                                <div class="col-6">
                                    '.$image.'
                                </div>
                                <div class="col-6 pr-5 pt-5">
                                    <p class="text-justify">'.$movieInfo[$i]['overview'].'</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>';
        $i += 1;
        }

        
            
    }