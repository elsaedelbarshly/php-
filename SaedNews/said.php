<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
    <div class="jumbotron bg-dark text-white text-center">
        <h1>Google News Api</h1>
    </div>

    <?php
        $url = "http://newsapi.org/v2/top-headlines?country=eg&apiKey=dca03dc86ead4371a6de22f68cce5473";
        $response = file_get_contents($url);
        $newsData = json_decode($response);
        // print_r($newsData);
    ?>


<section class="container-fluid">

<?php foreach($newsData->articles as $news): ?>
    <div class="row">
        <div class="col-3">
            <img src="<?=$news->urlToImage?>" class="img-fluid">
        </div><!-- 3 -->

        <div class="col-9 text-right">
            <h3><?=$news->title?></h3>
            <h4><?=$news->description?></h4>
            <h5><?=$news->publishedAt?></h5>
            <p><?=$news->content?></p>
        </div><!-- 9 -->
    </div><!-- row -->
<?php endforeach; ?>

</section>

</body>
</html>