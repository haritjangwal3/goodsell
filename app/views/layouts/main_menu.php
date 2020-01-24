<?php
    $menu = Router::getMenu('menu_acl');

?>
<nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Goodsell</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main_menu">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="main_menu">
        <?php foreach($menu as $key => $val): 
            $active= ''; ?>
            <?php if(is_array($val)): ?>
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?=$key?>
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <?php foreach($val as $key => $dropdownItem):?>
                        <a class="dropdown-item" href="<?=$dropdownItem?>"><?=$key?></a>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <?php else: ?>
                <ul class="navbar-nav md-auto">
                    <li class="nav-item active">
                        <a href="<?=$val?>" class="nav-link"><?=$key?></a>
                    </li>
                </ul>
            <?php endif; ?>
            
        <?php endforeach; ?>

        
    </div>
</nav>
<div class="bg-dark p-1">
    <form class="form-inline justify-content-end">
        <input class="form-control mr-sm-2 pb-2" type="search" 
        placeholder="Search" aria-label="Search">
        <button class="btn btn-light my-sm-0" type="submit" >Search</button>
    </form>
</div>
