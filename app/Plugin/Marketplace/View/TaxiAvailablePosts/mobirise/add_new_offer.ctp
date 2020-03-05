<section class="testimonials3 cid-r6TeBtPTdm" id="testimonials3-o" style="margin-top: 60px">
    <div class="container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="media-container-column col-lg-8">
                    <p>Hola chofer, recibiste una opinión de clientes sobre tu servicio y ahora puedes responderla.</p>
                    <p><b>Házlo desde el formulario al final de la opinión</b>. A continuación puedes ver la opinión:</p>
                    <br>
                </div>
            </div>
        </div>
        
        <div class="container">
            <div class="row justify-content-center">
                <div class="media-container-column col-lg-10" data-form-type="formoid">
                    [TESTIMONIO]
                </div>
            </div>
        </div>
        
        <div class="container">
            <div class="row justify-content-center">
                <div class="media-container-column col-lg-8 mt-5">
                    <?php echo $this->Session->flash(); ?>
                    <p>Responder esta opinión:</p>
                    <span class="alert alert-warning alert-dismissable">
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                        IMPORTANTE: 
                        <p>
                            Tu respuesta estará pública en tu perfil y la verán otros clientes potenciales. 
                            Escribe correctamente de manera que los que quieran contratarte les guste tu respuesta.
                        </p>
                        <p>
                            <b>Esta respuesta se la enviaremos al cliente que escribió la opinión!</b>
                        </p>
                    </span>
                    
                    <?php echo $this->element('form_taxi_available_post');?>
                </div>
            </div>
        </div>
    </div>
</section>