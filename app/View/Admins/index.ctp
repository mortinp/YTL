<?php $this->layout = 'Admin/admin'; ?>
<script type="text/javascript">
 var active = 'main';
 var active2 = 'panel';
</script>
<?php

if($userLoggedIn) {
    $user = AuthComponent::user();
    $userRole = $user['role'];
    $pretty_user_name = User::prettyName($user, true);
}
?>
<div class=" border-bottom white-bg wrapper">
             <h2>Bienvenido(a) <?php echo $pretty_user_name; ?></h2>
                <div class="col-md-12">
                    
                    <small>Tienes <?=$total_unread_messages ?> nuevas conversaciones y <?=$total_new_testimonials ?> nuevos testimonios.</small>
                    
                </div>
             
           <div class="row">
            <div class="col-lg-3">
                <div class="widget style1 red-bg">
                        <div class="row">
                            <div class="col-xs-4 text-center">
                                <i class="fa fa-money fa-5x"></i>
                            </div>
                            <div class="col-xs-8 text-right">
                                <span> Pagos atrazados </span>
                                <h2 class="font-bold"><?=$total_delayed ?></h2>
                            </div>
                        </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="widget style1 navy-bg">
                    <div class="row">
                        <div class="col-xs-4">
                            <i class="fa fa-edit fa-5x"></i>
                        </div>
                        <div class="col-xs-8 text-right">
                            <span> Testimonios </span>
                            <h2 class="font-bold"><?=$total_new_testimonials ?></h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="widget style1 lazur-bg">
                    <div class="row">
                        <div class="col-xs-4">
                            <i class="fa fa-envelope-o fa-5x"></i>
                        </div>
                        <div class="col-xs-8 text-right">
                            <span> Conversaciones </span>
                            <h2 class="font-bold"><?=$total_unread_messages ?></h2>
                        </div>
                    </div>
                </div>
            </div>
           <div class="col-lg-3">
            <div class="widget style1 yellow-bg">
                    <div class="row">
                        <div class="col-xs-4 text-center">
                            <i class="fa fa-car fa-5x"></i>
                        </div>
                        <div class="col-xs-8 text-right">
                            <span> Viajes dados </span>
                            <h2 class="font-bold"><?=$total_done ?></h2>
                        </div>
                    </div>
            </div>
          </div>
          </div>
         <div class="row">
             <div class="col-md-12">
                 <h3> Estad&iacute;sticas r&aacute;pidas</h3>
             </div>
             <div class="col-lg-3">
                        <div class="ibox">
                            <div class="ibox-content">
                                <h5>Visits in last 24h</h5>
                                <h2>9</h2>
                                <div id="sparkline1"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="ibox">
                            <div class="ibox-content">
                                <h5>Visits week</h5>
                                <h2>60</h2>
                                <div id="sparkline2"></div>
                            </div>
                        </div>
                    </div>

         </div>
                

</div>