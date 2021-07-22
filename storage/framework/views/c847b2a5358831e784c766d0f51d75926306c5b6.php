<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>iPMIS</title>
    <?php $noCache = rand(); ?>

    <style>
        body, html {
            background: #000;
            font-family: "Segoe UI","Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
            font-size: 12px;
        }

        img.compare {
            max-width: 100%;
            max-height: 100%;
            height: auto;
            width: auto;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        div.description {
            position: absolute;
            padding: 10px 25px;
            background-color: rgba(0, 0, 0, 0.5);
            color: #fff;
            bottom: 0;
            left: 50%;
            transform: translate(-50%, -50%);
            max-width: 75%;
        }

        .description img {
            float: left;
            max-height: 25px;
        }

        .description span {
            display: inline-block;
            position: relative;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <img src="<?php echo e(url('uploads/geotag/img/' . $photo)); ?>" class="compare" />
    <div class="description">
        <img src="<?php echo e(asset('img/map_pin_orange.png')); ?>" />
        <span><?php echo e($desc); ?></span>
    </div>
</body>
</html>
