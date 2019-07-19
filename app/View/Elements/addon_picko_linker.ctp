<!--Proper style for picko linker-->
<style type="text/css">
    
.picko-linker {
    z-index: 999;
    position: fixed;
    width: 350px;
    background: rgba(0, 0, 1, .8);
    bottom: 0;
    left: 0;
    margin-bottom: 2px;
    margin-left: 2px;
}

.picko-linker p {
    color: #EBAB0A;
    font-size: 14px;
    font-weight: 100;
    text-shadow: 0 1px 1px rgba(0, 0, 0, .8);
    margin-bottom: 6px;
}

.picko-linker .btn-outline {
    background: transparent;
    border: 1px solid #EBAB0A;
    padding: 4px 18px;
    font-size: 12px;
    color: #EBAB0A;
    text-transform: uppercase;
    transition: all .3s ease;
}

.picko-linker .btn-outline:hover {
    background: #EBAB0A;
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
    <div class="download-wrap">
        <div class="left-part">
            <img class="img-responsive" src="assets/images/logo43.png" alt="" width="64">
        </div>
        <div class="right-part">
            <div class="inner">
                <p>
                    <b>Would you like to share your Taxi?</b>
                </p>
                <a class="btn btn-outline" href="https://pickocar.com/en/">Contact Us</a><br/>
            </div>
        </div>
        <div class="dismiss">
            <span class="fa fa-close"></span>            
        </div>
    </div>
</section>