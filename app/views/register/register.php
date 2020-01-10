<?php $this->setSiteTitle('Register'); ?>


<?php $this->start('head'); ?>

<?php $this->end(); ?>

<?php $this->start('body'); ?>
    <h1 class="text-center blue">Registration</h1> <hr>
    <div class="col-md-6 col-md-offset-3 well mx-auto">
        <form class="form" action="" method="post">
            <div class="bg-danger">
                <?= $this->displayErrors ?>
            </div>
            <div class="form-group">
                <label for="fname">First Name</label>
                <input  type="text" id="fname" name="fname" placeholder="Enter first name." value="<?=$this->post['fname']?>">
            </div>
            <div class="form-group">
                <label for="lname">Last Name</label>
                <input  type="text" id="lname" name="lname" placeholder="Enter last name." value="<?=$this->post['lname']?>">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input  type="email" id="email" name="email" placeholder="Enter your email." value="<?=$this->post['email']?>">
            </div>
            <div class="form-group">
                <label for="username">Username</label>
                <input  type="text" id="username" name="username" placeholder="Enter your username." value="<?=$this->post['username']?>">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input  type="password" id="password" name="password" placeholder="Enter your password." value="<?=$this->post['password']?>">
            </div>
            <div class="form-group">
                <label for="confirm">Password</label>
                <input  type="password" id="confirm" name="confirm" placeholder="Enter your password again." value="<?=$this->post['confirm']?>">
            </div>
            <div class="pull-right">
                <input type="submit" class="btn btn-primary btn-large" value="Register" >
            </div>
        </form>
    </div>
    
<?php $this->end(); ?>