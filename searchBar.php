<?php
$API_key = "4af2589deef3c4d1a028374023d93f3e";

    // Search bar get data
    $searchInput =  $_GET["searchInput"];
    $queryString = '&query='.$searchInput;

    //Json CALL using cURL

    $curl = curl_init();

    curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.themoviedb.org/3/search/movie?api_key=$API_key&language=en-US$queryString&page=1&include_adult=false",
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
        foreach($movieInfo[$i] as $info ){

            echo '<h2>';
            print_r($movieInfo[$i]['title']);
            echo '</h2>';
            echo '<p>';
            print_r($movieInfo[$i]['overview']);
            echo '</p>';
            $i += 1;
        }

        
            
    }
?>