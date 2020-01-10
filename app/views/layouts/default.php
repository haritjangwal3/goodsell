<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> 
    <title><?= $this->sitetitle(); ?></title>

    <!-- CSS -->
    <link rel="stylesheet" href="<?=SROOT?>css/bootstrap.min.css" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="<?=SROOT?>css/custom.css" media="screen" title="no title" charset="utf-8">
    
    <!-- JS -->
    <script type='text/javascript' src="<?=SROOT?>js/jQuery-2.2.4.min.js"></script>
    <script type='text/javascript' src="<?=SROOT?>js/bootstrap.min.js"></script>

    <?= $this->content('head'); ?>
  </head>
  <body>
    <?= $this->content('body'); ?>
  </body>
</html>