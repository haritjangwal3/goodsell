<?php $this->setSiteTitle('Home'); ?>


<?php $this->start('head'); ?>

<?php $this->end(); ?>

<?php 
$this->start('body'); ?>

    <div class="container">
        <div class="row">
        <?php
            $goods = Goods::getAllGoods();
            if($goods):
                $images = [];
                foreach($goods as $good_id => $good):
                    if($good->price == '' || null){
                        $good->price = 'Contact for price';
                    }
                    else{
                        $good->price = '$' . $good->price;
                    }
                    $imageString = $good->good_images;
                    $images = explode(', ', $imageString);
        ?>
        <div class="col-12 col-sm-4 border rounded">
                <div class="products ">
                        <!-- images setup START -->
                        <div id="<?=$good_id?>_carouselControls" class="carousel slide goodsImgDiv" data-ride="carousel">
                            <div class="carousel-inner">
                                <?php
                                $i = 0;

                                if(count($images) > 1) {
                                    //start
                                    foreach($images as $img){
                                        $root = SROOT . 'app/data/' . $img;
                                        if($i > 0){
                                            echo "<div class='carousel-item'>
                                            <img class='d-block' src='{$root}' alt='secondary slide'>
                                            </div>";
                                        }
                                        else {
                                            echo "<div class='carousel-item active'>
                                            <img class='d-block' src='{$root}' alt='main slide'>
                                            </div>";
                                            $i ++;
                                        }
                                    } /// end
                                }
                                else {
                                    echo "<div class='carousel-item active'>
                                            <img class='d-block' src='". SROOT . 'app/data/default.jpg'. "' alt='main slide'>
                                            </div>";
                                }
                                $images = null;
                                ?>
                            </div>
                        </div>
                        <!-- images setup END -->
                    <a class="link" href="<?=SROOT.'home/view/' . $good_id?>" >
                        <h4 class="text-info"><?=$good->good_title?></h4>
                    </a>
                    <p class="">Date Posted: <?=$good->post_date?></p>
                    <h4><?=$good->price?></h4>
                    <p class="text-right">By <?=$good->username?></p>
                </div>         
        </div>
        
        <?php
                endforeach;
            endif;
        ?>
        </div>
    </div>
<?php $this->end(); ?>