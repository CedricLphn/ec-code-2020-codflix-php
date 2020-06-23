<?php ob_start(); ?>
<div class="navbar" style="clear: both;"> 
<span style="float:left;">                <a class="btn btn-danger text-white" href=""><i class="fas fa-chevron-left"></i></a></span>
<span><center>Naruto Episode 1</center></span>
</p>
</div>
<div id="movie">
    <iframe class="fullscreen" width="560" height="315" src="https://www.youtube.com/embed/8C08z4d1FQg" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    </header>

    <?php $content = ob_get_clean(); ?>

    <?php require('base.php'); ?>