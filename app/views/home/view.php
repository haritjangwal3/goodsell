<?php $good = $this->data;
$imageString = $good->good_images;
$images = explode(', ', $imageString);
if($good->price == '' || null){
    $good->price = 'Contact for price';
}
else{
    $good->price = '$' . $good->price;
}
?>
<?php $this->setSiteTitle('View Good'); ?>


<?php $this->start('head'); ?>
<style>
.carousel-indicators{
    list-style: none;
}
.carousel-indicators li, .carousel-indicators li.active{
    width: 70px;
    height: 70px;
    background-color: #fff;
    position: relative;
    margin: 10px;           
}
.carousel-indicators img{
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;            
}

.goodsImgDiv {
    width: 100%;
    height: 400px;
    overflow:hidden;
}

.fill {
    object-fit: cover;
    object-position: center;
}
</style>
<?php $this->end(); ?>

<?php $this->start('body');?>
    <div class="container">
        <div class="row">
            <div class="col-8 border rounded">
                <div id="carouselExampleIndicators" class="carousel slide goodsImgDiv" data-ride="carousel">
                    <ol class="carousel-indicators">
                    <?php
                            $x = 0;
                            foreach($images as $image){ 
                                if($x===0){
                                    echo '<li data-target="#carouselExampleIndicators" data-slide-to="0" class="active">
                                    <img class="img-thumbnail" src="' . SROOT . "app/data/" . $image . '" alt="0">
                                    </li>';
                                    $x=1;
                                }
                                else {
                                    echo '<li data-target="#carouselExampleIndicators" data-slide-to="'. $x .'">
                                    <img class="img-thumbnail" src="' . SROOT . "app/data/" . $image . '" alt="0">
                                    </li>';
                                    $x++;
                                }
                            }
                        ?>
                    </ol>
                    <div class="carousel-inner ">
                        <?php
                            $x = 0;
                            foreach($images as $image){ 
                                if($x===0){
                                    echo '<div class="carousel-item active">
                                    <img class="d-block w-100" src="' . SROOT . "app/data/" . $image . '" alt="First slide">
                                    </div>';
                                    $x=1;
                                }
                                else {
                                    echo '<div class="carousel-item">
                                <img class="d-block w-100" src="' . SROOT . "app/data/" . $image . '" alt="First slide">
                                </div>';
                                }
                            }
                        ?>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
            <div class="col-4 border rounded">
                <h1 class="display-4 m-2 text-center border rounded"><?=$good->price?></h1>
                <h1 class="text"><?=$good->good_title?></h1>
                <h6 class="text-right p-2" style="position: absolute;bottom: 0; right:0;">By <?=$good->username?></h6>
                <h6 class="text-right p-2 blue" style="position: absolute;bottom: 0; right:1;">Views: <?=$good->views?></h6>
            </div>
        </div>
        <div class="row">
            <h4 class="col-12 p-4">Details</h4>
            <h6 class="col-4">Condition: <?php if($good->good_cond == 0){ echo 'Used';} else { echo 'New'; }  ?></h6>
            <h6 class="col-4">Good Quality: <?=$good->good_quality?></h6>
            <h6 class="col-4">Negotiable: <?php if($good->nego == 1){ echo 'Yes';} else { echo 'No'; }  ?></h6>
            
        </div>
        <div class="row">
            <h4 class="text-right p-4">Description</h4>
            <p>
                <?=$good->good_des?>
            </p>
        </div>
    </div>
    <!-- 
  public 'good_id' => int 1001
  public 'good_title' => string 'old car' (length=7)
  public 'sub_category_id' => int 102
  public 'good_des' => string 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor.' (length=254)
  public 'good_images' => string 'harit/1001/img1.jpg, harit/1001/img2.jpg, harit/1001/img3.jpg' (length=61)
  public 'good_cond' => int 0
  public 'good_quality' => string 'average' (length=7)
  public 'price' => string '$4000' (length=5)
  public 'nego' => int 1
  public 'user_id' => int 1
  public 'views' => int 34
  public 'post_date' => string '2020-01-17' (length=10)
  public 'username' => string 'harit' (length=5) -->
<?php $this->end(); ?>

