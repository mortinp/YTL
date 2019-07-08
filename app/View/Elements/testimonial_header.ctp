<?php /* --  $travel, $driver, $driver_profile, $user -- */ ?>
<?php 
   $webroot = $this->request->webroot;
?>

<?php 
   //--------------------------Viajero----------------------------
   if(isset($user)){
      $nombreViajero = ( $user['display_name'] ) ? $user['display_name'] : $user['username'];
      $urlViajero = array('controller' => 'users', 'action' => "admin", $user['id']);
   }   
   
   //--------------------------Chofer----------------------------
   $nombreChofer = 'Perfil En Construcción';
   if( isset($driver_profile['driver_nick']) ){
      $nombreChofer = $driver_profile['driver_nick'];
      $urlPerfil = array('controller' => 'drivers', 'action' => 'profile', $nombreChofer);
   }
   
   if(isset( $driver_profile['driver_name'] ) )
      $nombreChofer = $driver_profile['driver_name'];
   
   $role =  AuthComponent::user('role');

   $imagen_path = 'files/driver_default_jpg';
   if( isset($driver_profile['avatar_filepath']) ) 
      $imagen_path = str_replace('\\', '/', $driver_profile['avatar_filepath']);

   //--------------------------Viaje----------------------------
   if( isset($travel) )
      $urlViaje = array('controller' => 'travels', 'action' => "admin", $travel['id']);
?>

<div class="row"> 
    <div class="col-md-6">
        <div class="col-md-2">  
           <?php echo "<img src='{$webroot}{$imagen_path}' style='max-height: 50px; max-width: 50px' />"; ?>
        </div>
          
        <div class="col-md-10">  
           <ul class="list-unstyled">
              <li> <?php echo "$nombreChofer"; ?> </li>
             
              <li> <?php if( in_array($role, array('admin', 'operator') ) )
                      echo "<b>Email:</b> {$driver['username']}<br>";  
                   ?>
              </li>
              
              <li>
              <?php if( isset($urlPerfil) ): ?>
                  <a href="<?php echo $this->html->url($urlPerfil, true); ?>" >
                    <i class='glyphicon glyphicon-picture'></i>
                    Ver Perfil
                  </a>  
              <?php endif; ?> </li>
              <li>
              <?php if( isset($urlPerfil) ): ?>
                  <a href="<?php echo $this->html->url($urlPerfil, true); ?>" >
                    <i class='glyphicon glyphicon-picture'></i>
                    Ver Perfil
                  </a>  
              <?php endif; ?> </li>
           </ul>    
        </div>
      </div>    
      
      <div class="col-md-6">
        <ul class="list-unstyled">
          <?php if( isset($nombreViajero) ): ?>
             <li>
               <a href="<?php echo $this->html->url($urlViajero, true); ?>" title="Administrar Usuario" > <?php echo "<i class='glyphicon glyphicon-user'></i> <b>Usuario {$user['id']}:</b>" ?> </a>   
               <?php echo $nombreViajero; ?>
             </li>  
          <?php endif; ?>
         
          <?php if( isset($travel) ): ?>
             <li>
                <a href="<?php echo $this->html->url($urlViaje, true); ?>" title="Administrar Viaje" > <?php echo "<i class='glyphicon glyphicon-road'></i> <b>Viaje {$travel['id']}:</b> " ?> </a>
                <?php echo "{$travel['origin']} <i class='glyphicon glyphicon-arrow-right'></i> {$travel['destination']}"; ?>
             </li>  
             
             <li>
                <?php echo "con fecha <b class='text-muted'>{$travel['date']}</b> y un total de <b class='text-muted'>{$travel['people_count']} pasajeros</b>"; ?>
             </li>  
          <?php endif; ?>
        </ul>    
      </div> 
</div>