<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> 
    
    <title><?= $this->sitetitle(); ?></title>

    <!-- CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?=SROOT?>css/bootstrap.min.css" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="<?=SROOT?>css/custom.css" media="screen" title="no title" charset="utf-8">
    
    <!-- JS -->
    <script type="text/javascript" src="<?=SROOT?>js/jQuery-2.2.4.min.js"></script>
    <script type="text/javascript" src="<?=SROOT?>js/bootstrap.min.js"></script>

    <?= $this->content('head'); ?>
  </head>
  <body>
    <?php include 'main_menu.php'; ?>
    <div class="container-fluid" style="min-height:cal(100% - 125px);">
      <?= $this->content('body'); ?>
    </div>
  </body>
</html>