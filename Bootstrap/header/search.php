<?php 
session_start();
$API_key = "4af2589deef3c4d1a028374023d93f3e";
if (!empty($_SESSION['user'])) {
    $message = '<form class="form-inline row ">
                <input class="form-control col-8" type="text" name="commentaire">
                <button class="btn btn-film ml-3 mr-3"type="submit" name="envoyer">Envoyer</button>
                </form>';
} else {
    $message = 'ERROR';
}
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

} else {
    // Search bar get data
    $pageNumber = '1';

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
}
if ($err) {
    echo "cURL Error #:" . $err;
    } else {
        include 'movie-Genres/popular.php';
    }

?>