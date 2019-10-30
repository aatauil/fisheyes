<?php
//nombre page
$pageNumber = 0;
// one page = 20 movies , 5 pages = 100movies
$maxPages = 5;
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
}


    ?>
