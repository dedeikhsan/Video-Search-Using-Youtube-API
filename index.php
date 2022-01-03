<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/ef76144caf.js" crossorigin="anonymous"></script>


    <title>Youtube API</title>
</head>

<body>

    <?php
    if (isset($_POST['submit'])) {
        $keyword = $_POST['keyword'];

        if (empty($keyword)) {
            $response = array(
                "type" => "error",
                "message" => "Please enter the keyword."
            );
        }
    }

    ?>

    <div class="container mt-5">
        <h4 class="text-center" style="font-family: Viga, Cursive; font-size: 32px;">Youtube API</h4>
        <hr style="width: 250px; border: px solid;">

        <form action="" method="POST" id="keywordForm">
            <div class="row text-center">
                <div class="col-md-6 shadow-lg p-3 mb-5 bg-white rounded mx-auto">
                    <input type="text" class="form-control mt-3" placeholder="Masukkan pencarian..." name="keyword" id="keyword">
                    <input type="text" class="form-control mt-2" placeholder="Jumlah video yang ditampilkan.." name="max_result" id="max_result">
                    <div class="input-group-append mt-1">
                        <input class="btn btn-primary" type="submit" name="submit" value="Search">
                    </div>
                </div>
            </div>
        </form>
    </div>

    <?php
    if (!empty($response)) {
    ?>
        <div class="response <?php echo $response["type"]; ?>
    ">
            <?php echo $response["message"]; ?>
        </div>
    <?php
    }
    ?>

    <?php
    if (isset($_POST['submit'])) {

        $max_result = $_POST['max_result'];
        if (!empty($keyword)) {
            $apikey = 'AIzaSyAysk-72VcqnAmY0_CpMXutjso5adMPWYY';
            $googleApiUrl = 'https://www.googleapis.com/youtube/v3/search?part=snippet&q=' . str_replace(' ', '', $keyword) . '&maxResults=' . $max_result . '&key=' . $apikey . '&type=video';

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_URL, $googleApiUrl);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_VERBOSE, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $response = curl_exec($ch);

            curl_close($ch);
            $data = json_decode($response);
            $value = json_decode(json_encode($data), true);
    ?>

            <div class="container">
                <hr>
                <div class="modal-body">
                    <div class="row">

                        <?php
                        for ($i = 0; $i < $max_result; $i++) {
                            $thumbnails = $value['items'][$i]['snippet']['thumbnails']['medium']['url'];
                            $publish = $value['items'][$i]['snippet']['publishTime'];
                            $videoId = $value['items'][$i]['id']['videoId'];
                            $title = $value['items'][$i]['snippet']['title'];
                            $description = $value['items'][$i]['snippet']['description'];
                        ?>
                            <div class="col-md-4 mt-4">
                                <div class="card" style="width: 18rem;">
                                    <iframe id="iframe" style="width:100%;" src="https://www.youtube.com/embed/<?php echo $videoId; ?>" data-autoplay-src="https://www.youtube.com/embed/<?php echo $videoId; ?>"></iframe>
                                    <div class="card-body">
                                        <p class="card-text text-center" style="font-weight: bold;"><?php echo $title; ?></p>
                                        <p class="card-text" style="font-size: 14px;"><?php echo $description; ?></p>
                                        <p class="card-text" style="font-size: 10px;"><?php echo $publish; ?></p>
                                    </div>
                                </div>
                            </div>

                <?php
                        }
                    }
                }
                ?>
                    </div>
                </div>
            </div>

            <!-- Optional JavaScript -->
            <!-- jQuery first, then Popper.js, then Bootstrap JS -->
            <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>