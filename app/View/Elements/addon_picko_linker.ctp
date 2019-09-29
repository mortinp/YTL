<!--Proper style for picko linker-->
<style type="text/css">
    
.picko-linker {
    z-index: 999;
    position: fixed;
    width: 350px;
    background: rgba(255, 255, 255, 1);
    bottom: 0;
    left: 0;
    margin-bottom: 2px;
    margin-left: 2px;
    border: .5px solid #000;
}

.picko-linker p {
    /*color: #EBAB0A;*/
    font-size: 14px;
    /*font-weight: 100;*/
    /*text-shadow: 0 1px 1px rgba(0, 0, 0, .8);*/
    margin-bottom: 6px;
    text-align: center;
}

.picko-linker .btn-outline {
    background: transparent;
    border: 1px solid #000;
    padding: 4px 18px;
    font-size: 12px;
    color: #000;
    text-transform: uppercase;
    transition: all .3s ease;
    background: rgba(225, 149, 194, 1);
}

.picko-linker .btn-outline:hover {
    background: rgba(185, 65, 163, .9);
    color: #000;
}

.download-wrap {
    padding: 4px 4px 4px 10px;
    position: relative;
    display: inline-block;
    width: 100%;
}

.picko-linker .dismiss {
    transition: all .3s linear;
    position: absolute;
    right: 0;
    top: 0;
    cursor: pointer;
    margin-right: 10px;
    margin-top: 6px;
}

.picko-linker .left-part {
    float: left;
}

.picko-linker .right-part .inner {
    padding-left: 10px;
    float: left;
    margin-top: 4px;
}

@media (max-width: 769px) {
    .picko-linker {
        width: 100%;
    }
}

@media (max-width: 640px) {
    .picko-linker {
        width: 100%;
    }

    .download-wrap {
        padding: 10px 0 10px 0;
    }

    .picko-linker .left-part {
        width: 100%;
    }

    .picko-linker .left-part .img-responsive {
        margin: 0 auto;
        width: 38px;
    }

    .picko-linker .right-part .inner {
        padding: 0;
        text-align: center;
        width: 100%;
    }
    
    .picko-icon {
        visibility: hidden;
        height: 0px;
    }
}

@-webkit-keyframes fadeInUp {
    0% {
        opacity: 0;
        -webkit-transform: translate3d(0, 50%, 0);
        transform: translate3d(0, 50%, 0)
    }
    100% {
        opacity: 1;
        -webkit-transform: none;
        transform: none
    }
}

@keyframes fadeInUp {
    0% {
        opacity: 0;
        -webkit-transform: translate3d(0, 50%, 0);
        transform: translate3d(0, 50%, 0)
    }

    100% {
        opacity: 1;
        -webkit-transform: none;
        transform: none
    }
}


</style>
<section class="picko-linker animated" style="visibility: hidden">
    <div class="container">
        <div class="row">
            <div class="col-sm-2 picko-icon">
                <?php echo $this->Html->image('logo43.png', array('class'=>'img-responsive mt-5', 'style'=>'max-height: 50px;'))?>
            </div>
            <div class="col-sm-10">
                <div class="inner mt-4 center mr-3 pb-2" style="text-align: center">
                    <p>
                        <?php echo __d('mobirise/homepage', '¿Compartirías tu taxi <br>con otros 2 pasajeros para <br><b>AHORRAR 50%</b>?')?>
                    </p>
                    <a class="btn btn-outline" href="https://pickocar.com/<?php echo Configure::read('Config.language')?>" target="_blank">
                        PickoCar - <?php echo __d('mobirise/homepage', 'Servicio de taxi colectivo en Cuba')?>
                    </a>
                </div>
                <div class="dismiss">
                    <span class="fa fa-close"></span>            
                </div>
            </div>
        </div>
    </div>
</section>