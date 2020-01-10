<?php $this->setSiteTitle('Login'); ?>


<?php $this->start('head'); ?>

<?php $this->end(); ?>

<?php $this->start('body'); ?>
<div  class="container bg-secondary" style="width:800px">
    <h2 class="text-center p-2">Log In</h2> <hr>
    <div class="bg-danger">
        <?=$this->displayErrors ?>
    </div>
    <form class="form" action="<?=SROOT?>register/login" method="post">
            <div class="form-group d-flex p-2">
                <label class="control-label col-sm-2 reglbl" style="font-size:22px;" for="username">Username </label>
                <input  type="text" class="form-control" id="username" placeholder="Enter username" name="username">
            </div>
            <div class="form-group d-flex p-2">
                <label class="control-label col-sm-2" style="font-size:22px;" for="password">Password </label>
                <input type="password" class="form-control" id="password" placeholder="Enter password" name="password">
            </div>
            <div class="form-group d-flex p-2">        
                <label for="remember_me"><input id="remember_me" type="checkbox" name="remember_me"> Remember me</label>
            </div>
        <div class="form-group pl-4">        
            <button type="submit" class="btn btn-large text-white bg-primary">Login</button>
        </div>
        <div class="text-right p-4">
            <a class="text-primary text-light" href="<?=SROOT?>register/register">Register</a> <br />
        </div>
    </form>
</div>
<?php $this->end(); ?>