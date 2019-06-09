<div class="container centered"> 
    <h2>Choferes disponibles en <span class="text-muted"><?php echo $province ?></span></h2>
    <div class="row">
        <?php 
        $fullBaseUrl = Configure::read('App.fullBaseUrl');

                 foreach ($drivers_data as $driver) {
                    // print_r($driver);
                        echo "<div class='col-md-4' style='margin-top: 5px'><div class='well'>".
                                "<div class='row panel-title'><div class='col-md-12'><img class='img-thumbnail img-responsive' src='".$fullBaseUrl.$driver['Drivers_Profiles']['featured_img_url']."'></div></div>".
                                "<div class='row'><div class='col-md-12'>".                        
                                "<b>Nombre del chofer:</b>".$driver['Drivers_Profiles']['driver_name']."<br>"."<b>Nick:</b>".$driver['Drivers_Profiles']['driver_nick']."<br>"."Auto para <span class='text-muted'><span class='glyphicon glyphicon-user'></span> ".$driver['Drivers']['max_people_count']."</span> <br>"."<b>Viajes realizados:</b>".$driver[0]['travel_count']."<br>"."<b>Viajeros transportados:</b>".$driver[0]['total_travelers']."<br>"."<b>Testimonios:</b>".$driver[0]['review_count']."</div>".
                                "</div></div></div>";

                  } 



        ?>
    </div>

</div>