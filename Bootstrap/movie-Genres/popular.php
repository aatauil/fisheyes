<?php
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

    ?>
