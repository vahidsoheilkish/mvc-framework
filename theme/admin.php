<html>
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link rel="stylesheet" type="text/css" href="<?= baseUri(); ?>/asset/css/style.css"/>
    <link rel="stylesheet" type="text/css" href="<?= baseUri(); ?>/asset/css/fontawesome-all.css"/>
    <link rel="stylesheet" type="text/css" href="<?= baseUri() ?>/asset/bootstrap/css/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="<?= baseUri() ?>/asset/bootstrap/css/bootstrap-grid.min.css"/>
    <script src="<?= baseUri() ?>/asset/js/jquery-1.11.3.min.js"></script>
    <script src="<?=baseUri()?>/asset/js/index.js"></script>
    <script src="<?=baseUri()?>/asset/js/fontawesome-all.js"></script>
    <script src="<?= baseUri() ?>/asset/bootstrap/js/bootstrap.min.js"></script>
    <title>
        <?php
            if(isset($title)){
                echo $title;
            }
        ?>
    </title>
	<style>
		body{
			background-color:#fff !important;
			color:#000 !important;
		}
	</style>
</head>
<body>
	<?php echo $content ?>
</body>
</html>