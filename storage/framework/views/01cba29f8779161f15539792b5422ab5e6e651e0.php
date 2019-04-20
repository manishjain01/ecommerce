<head>
    <meta charset="utf-8" name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="title" content="<?php echo e(config('settings.CONFIG_META_TITLE')); ?>">
    <meta name="keywords" content="<?php echo e(config('settings.CONFIG_META_KEYWORDS')); ?>">
    <meta name="description" content="<?php echo e(config('settings.CONFIG_META_DESCRIPTION')); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
	<meta name=”viewport” content=”width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;” />
	<meta name=”viewport” content=”width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=false;” />
	<meta name=”viewport” content=”width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=no;” />
    <title><?php echo e(isset($title) ? config('settings.CONFIG_SITE_TITLE')." :: ".$title : config('settings.CONFIG_SITE_TITLE')); ?></title>

    <link rel="shortcut icon" href="<?php echo e(asset('img/logo_icon.png')); ?>" type="image/x-icon"/>
    <?php echo Html::style( asset('css/bootstrap.min.css')); ?>

    <?php echo Html::style( asset('css/dl-icon.css')); ?>

    <?php echo Html::style( asset('css/style.min.css')); ?>

    <?php echo Html::style( asset('css/plugins.css')); ?>

    <?php echo Html::style( asset('css/animate.css')); ?>

    <?php echo Html::style( asset('js/bootstrap-fileupload/bootstrap-fileupload.css')); ?>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <?php echo Html::script( asset('js/jquery-3.3.1.min.js')); ?>

    <?php echo Html::script( asset('js/bootstrap.min.js')); ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
      
    <?php echo Html::style( asset('css/jquery-ui.css')); ?>

    <?php echo Html::script( asset('js/jquery-2.1.3.js')); ?>

    <?php echo Html::script( asset('js/jquery-ui.js')); ?>

    <?php echo Html::script( asset('js/plugins.js')); ?>

    <?php echo Html::script( asset('js/active.min.js')); ?>

    <?php echo Html::script( asset('js/bootstrap-fileupload/bootstrap-fileupload.js')); ?>


</head>
