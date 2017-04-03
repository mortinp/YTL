<?php $user_id = $travels[0]['User']['id']; ?>

<div class="carousel slide" id="carousel<?php echo $user_id ?>" data-interval="false" data-wrap="false">
    <!-- Indicators -->
    <ol class="carousel-indicators">
        <li class="active" data-slide-to="0" data-target="#carousel<?php echo $user_id ?>" style="background-color: cadetblue"></li>
        <?php
            $travels_count = count($travels);
            for($i = 1; $i < $travels_count; $i++)
                echo "<li data-slide-to='$i' data-target='#carousel$user_id' style='background-color: cadetblue'></li>";
        ?>
    </ol> 

    <!-- Wrapper for slides -->
    <div class="carousel-inner">
        <?php foreach($travels as $i => $travel): ?> 
            <div class="item<?php if($i == 0) echo ' active' ?>">
                <?php echo $this->element('travel', array('travel'=>$travel, 'actions'=>$actions, 'details'=>$details)); ?>
            </div>
         <?php endforeach; ?>
    </div>

    <!-- Controls -->
    <a class="left carousel-control" data-slide="prev" href="#carousel<?php echo $user_id ?>">
        <big><span class="glyphicon glyphicon-chevron-left"></span></big>
    </a>
    <a class="right carousel-control" data-slide="next" href="#carousel<?php echo $user_id ?>">
        <big><span class="glyphicon glyphicon-chevron-right"></span></big>
    </a>
</div>

<style type="text/css">

/*#myCarousel {
  margin-left: 110px;
  margin-right: 50px;
  margin-bottom: 50px;
}*/

/*.item img {
  margin-left: auto;
  margin-right: auto;
}

.selected img {
    opacity:0.5;
}*/

.carousel-caption {
    position: relative;
    left: auto;
    right: auto;
}

/*.carousel-control.left,
.carousel-control.right {
  background: none;
  border: none;
}*/

.carousel-control.left {
  margin-left: -80px;
}

.carousel-control.right {
  margin-right: -80px;
}

.carousel-indicators {
  /*margin-bottom: -50px;*/
  position: relative;left: -260px;float: left;top:60px;
  /*text-align: left;
  float: left;
  left: 2% !important;
  right: inherit;*/
}

.carousel-control {
  width: 10%;
}

.glyphicon-chevron-left, .glyphicon-chevron-right {
  color: grey;
  font-size: 40px;
}
</style>

