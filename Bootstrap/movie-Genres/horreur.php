<?php

$API_key = "4af2589deef3c4d1a028374023d93f3e";

    $pageNumber = '1';

    // ID assigned to each genre
    $genreNumber = "28";

    //different API CALLs
    $movieDetails = 'discover/movie';
    
    $curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api.themoviedb.org/3/$movieDetails?api_key=$API_key&language=en-US&sort_by=popularity.desc&include_adult=false&include_video=false&page=1&with_genres=$genreNumber',
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

    ?>
