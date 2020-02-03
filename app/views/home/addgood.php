<?php
    // test
    //dnd($this->currentUser->username);
    
    ?>


<?php $this->setSiteTitle('Add Good'); ?>


<?php $this->start('head'); ?>
<link rel="stylesheet" href="<?=SROOT?>css/custom.css" media="screen" title="no title" charset="utf-8">
<?php $this->end(); ?>

<?php $this->start('body'); ?>
    <h1 class="text-center blue">Add Your Item</h1>
    <div class="col-md-6 col-md-offset-3 well mx-auto">
        <form class="form" action="" method="post">
            <div class="bg-danger">
                <?=$this->displayErrors?>
            </div>
            <div class="form-group">
                <label for="gtitle">Title</label>
                <input  type="text" id="good_title" name="good_title" placeholder="Enter title." value="<?=$this->post['good_title']?>">
            </div>
            <div class="form-group">
                <!-- UPLOAD FILE CODE -->
                <div class="d-flex flex-row">
                    <div class="dropzone p-2" id="dropzone" style="background-image: url('<?=SROOT.'app/views/home/images/images.png'?>'); background-size: 100% 100%;">
                    </div>
                    <input  type="text" hidden id="good_images" name="good_images" placeholder="" value="">
                    <div id="uploads" class="p-2">
                        <!-- <progress id="progressBar" value="0" max="100" style="width:300px;">></progress>
                        <h6 id="Status"></h6>
                        <p id='Loaded'></p> -->
                        <?php
                        $dir = ROOT . '\app\data\current_temp\\'.$this->currentUser->username;
                            if(scandir($dir)){
                                $inFiles = scandir($dir);
                                foreach($inFiles as $fileName){
                                    if(strlen($fileName) > 3){
                                        unlink($dir . '\\'. $fileName);
                                    }
                                }
                            }
                        ?>
                    </div>
                </div>
                <script>
                    (function(){
                        var dropzone = document.getElementById('dropzone');

                        var upload = function(files){
                            document.getElementById("uploads").innerHTML = '';
                            var jpgFiles = 0;
                            for(x = 0; x < files.length; x = x +1){
                                var filen = files[x]['name'].toLowerCase();
                                if(filen.endsWith(".jpg") && files.length < 6) {
                                    document.getElementById("uploads").innerHTML += '<progress id="progressBar'+ x +'" value="0" max="100" style="width:300px;"></progress>';
                                    document.getElementById("uploads").innerHTML += '<h6 id="Status'+ x +'" style="color:green;"></h6>';
                                    // upload event handlers
                                    function progressHandler(e){
                                        //document.getElementById("Loaded").innerHTML = "Uploaded " + e.loaded + "bytes of " + e.total;
                                        var percent = (e.loaded/e.total) * 100;
                                        var id = "progressBar" + x;
                                        document.getElementById("progressBar" + x).value = Math.round(percent); 
                                        document.getElementById("Status"+ x).innerHTML = Math.round(percent) + "% uploaded...";
                                    }
                                    function completeHandler(e){
                                        let num = x + 1;
                                        var images = document.getElementById("good_images");
                                        images.value += "img" + num + ".jpg, "
                                        document.getElementById("Status"+ x).innerHTML = e.target.responseText;
                                        document.getElementById("progressBar" + x).value = 100;

                                    }

                                    function errorHandler(e){
                                        document.getElementById("Status"+ x).innerHTML = "Upload Failed!";
                                    }

                                    function abortHandler(e, x){
                                        document.getElementById("Status" + x).innerHTML = "Upload Aborted!";
                                        }
                                    // ends handlers
                                    
                                    var fromDataUpload =  new FormData(),
                                    xhr = new XMLHttpRequest(),
                                    x;

                                    xhr.upload.addEventListener("progress", progressHandler, false);
                                    xhr.addEventListener("load", completeHandler, false);
                                    xhr.addEventListener("error", errorHandler, false);
                                    xhr.addEventListener("abort", abortHandler, false);

                                    fromDataUpload.append('file', files[x]);
                                    fromDataUpload.append('username', "<?=$this->currentUser->username?>");

                                    xhr.open('post', '<?=SROOT.'core//'?>upload.php', false);
                                    xhr.send(fromDataUpload);
                                }
                                else{
                                    if(files.length > 6)
                                    {
                                        document.getElementById("uploads").innerHTML += '<h6 id="Status" style="color:red;"> 6 Max number of images.</h6>';
                                        break;
                                    }
                                    else{
                                        document.getElementById("uploads").innerHTML += '<progress id="progressBar'+ x +'" value="0" max="100" style="width:300px;"></progress>';
                                        document.getElementById("uploads").innerHTML += '<h6 id="Status'+ x +'" style="color:red;"> '+ filen +' not supported.</h6>';
                                    }
                                    
                                }
                            }
                            
                        }
                        

                        dropzone.ondrop = function(e) {
                            e.preventDefault(); // prevent the default behaviour of the event
                            this.className = 'dropzone';
                            upload(e.dataTransfer.files);
                            
                        }

                        dropzone.ondragover = function(){
                            this.className = 'dropzone dragover';
                            return false;
                        }
                        dropzone.ondragleave = function(){
                            this.className = 'dropzone';
                            return false;
                        }
                    }());
                </script>
                <!-- UPLOAD FILE CODE ENDS -->
            </div>
            <div class="form-group">
                <?php 
                    $json = json_encode($this->categories);
                ?>
                <script>
                    function updateSubCategory(){
                        var list_category = <?=$json?>;
                        for (let item of Object.keys(list_category)){
                            let category = list_category[item]
                           
                            var dropdown = document.getElementById("category");
                            var selectedCategory = dropdown.options[dropdown.selectedIndex].value;
                            if(category.category_id == selectedCategory){
                                console.log(category);
                                document.getElementById("sub_category_id").innerHTML += '<option value="'+ category.sub_category_id +'">'+ category.sub_category_name +'</option>';
                            }
                        }
                    }
                </script>
                <select id="category" name="category" onchange="updateSubCategory()">
                <option value="null">Select the Category</option>
                <?php 
                    foreach($this->main_Categories as $key => $value){
                        if($this->post['category'] != 'null' && $this->post['category'] == $key){
                            echo '<option value="'.$key.'" selected>'.$value.'</option>';
                        }
                        echo '<option value="'.$key.'" >'.$value.'</option>';
                    }
                ?>
                </select>
            </div>
            <div class="form-group">
                <select id="sub_category_id" name="sub_category_id" >
                    <option value="null" selected>Select the Sub-category</option>
                </select>
            </div>
            <div class="form-group">
                <label for="good_des">Description:</label><br/>
                <textarea name="good_des" rows="10" cols="100%"></textarea>
            </div>
            <div class="form-group d-flex">
                <label for="good_cond">Condition: </label>
                <input type="radio" class="m-2" name="good_cond" value="0" checked> Used<br>
                <input type="radio" class="m-2" name="good_cond" value="1"> New<br>
            </div>
            <div class="form-group">
                <label for="good_quality">Good quality</label>
                <input  type="text" id="good_quality" name="good_quality" placeholder="Describe the quality of product." value="<?=$this->post['good_quality']?>">
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input  type="text" id="price" name="price" placeholder="Set your price." value="<?=$this->post['price']?>">
            </div>
            <div class="form-group d-flex">
                <label for="good_cond">Negotiable: </label>
                <input type="radio" class="m-2" name="nego" value="1"> Yes<br>
                <input type="radio" class="m-2" name="nego" value="0" checked> No<br>
            </div>
            <div class="pull-right">
                <input type="submit" class="btn btn-primary btn-large" value="Submit" >
            </div>
        </form>
    </div>
    
<?php $this->end(); ?>