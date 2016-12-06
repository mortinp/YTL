<?php 
   $webroot        = $this->request->webroot;
   
   $imagen_path = 'files/driver_default_jpg';
   if( isset($driver_profile['avatar_filepath']) ) 
      $imagen_path = str_replace('\\', '/', $driver_profile['avatar_filepath']);
   
   $driver_name = ( isset($driver_profile['driver_name']) ) ? $driver_profile['driver_name'] : null;
?>

<?php
   $titulo = __("HAGA PERDURAR SU VIAJE <br><small>ESCRIBA UN TESTIMONIO<small>");
   $title1 = __("Autor/Título:");
   $text1  = __("¿A nombre de quién estará la nota? <br>".
                "<i class='glyphicon glyphicon-share-alt'></i> Puede compartir el nombre de todos los participantes en el viaje.<br>".
                "<i class='glyphicon glyphicon-share-alt'></i> Puede dar un título a su Testimonio.<br>".
                "<i class='glyphicon glyphicon-share-alt'></i> O simplemente díganos su nombre o apodo."
               );
   $title2 = __("Su opinión del viaje:");
   $text2  = __("¿Como fue su experiencia en Cuba? <br>".
                "<i class='glyphicon glyphicon-share-alt'></i> Cuente una anécdota, describa la isla, solamente desate su imaginación.<br>".
                "<i class='glyphicon glyphicon-share-alt'></i> Permita que otras personas puedan valorar a su chofer a través de su historia."
               );
   $title3 = __("Comparta una foto del viaje:");
   $text3  = __("<i class='glyphicon glyphicon-share-alt'></i> Si tuviera que resumir el viaje en una imagen. ¿Cuál usaría?");
   
   $title4 = __("Su dirección de correo:");
   $text4  = __("<i class='glyphicon glyphicon-share-alt'></i> Solamente usted podrá modificar su comentario.");
?>

<?php
   echo $this->Form->create('Testimonial', array('type'=>'file', 'role' => 'form'));
   echo $this->Form->input('lang', array('type' => 'hidden', 'value' =>  Configure::read('Config.language')));
?>	

<div class="container">
  <table class="table">
    <thead>
      <tr>
        <th width="5%"></th>
        <th width="80%"> <h2 style="font-family: algerian, impact;" align="center"> <?php echo $titulo; ?> </h2> </th>
        <th width="15%"> 
           <center> <img src="<?php echo "{$webroot}{$imagen_path}"; ?>" /> </center> 
        </th>
      </tr>  
    </thead>
    
    <tbody>
      <tr>
        <td></td>
        <td>
          <b> <?php echo $title1; ?> </b> <br/>
          <p class="alert alert-info">
            <b> <?php echo $text1; ?> </b>
          </p>
          <?php echo $this->Form->input('author', array( 'class' => 'form-control', 'label' => false, 'placeholder'=>__('Autor/Título') )); ?>
        </td>
        <td><h6 align="center"> <?php echo $driver_name; ?> </h6></td>
      </tr>
      
      <tr>
        <td></td>
        <td>
          <b> <?php echo $title2; ?> </b> <br/>
          <p class="alert alert-info">
            <b> <?php echo $text2; ?> </b>
          </p>
          <?php echo $this->Form->input('text', array('class' => 'form-control', 'rows' => '5', 'label' => false, 'placeholder'=>__('Su opinión del viaje') )); ?>
        </td>
        <td></td>
      </tr>
      
      <tr>
        <td></td>
        <td>
          <b> <?php echo $title3; ?> </b> <br/>
          <p class="alert alert-info"> 
            <b> <?php echo $text3; ?> </b> 
          </p>
          <?php 
            if( isset($this->request->data['Testimonial']['image_filepath']) ){
              $src = str_replace('\\', '/', $this->request->data['Testimonial']['image_filepath']);
              echo "<img src='{$webroot}{$src}' class='img-responsive img-thumbnail' style='width: 300px' />";
            } 
            echo $this->Form->file('image', array('label' => 'Image'));  
          ?>
        </td>
        <td></td>
      </tr>
      
      <tr>
        <td></td>
        <td> <?php echo $this->Form->end( __('Guardar') ); ?> </td>
        <td></td>
      </tr>
    </tbody>
  </table>    
</div>