<section class="testimonials3 cid-r6TeBtPTdm" id="testimonials3-o" style="margin-top: 60px">
    <div class="container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="media-container-column col-lg-8">
                    <span class="alert alert-warning alert-dismissable">
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                        <big>
                            <p>Hola chofer, aquí puedes publicar la disponibilidad de tu taxi para cuando quedes libre y quieras retornar con pasajeros.</p>

                            <p>
                                Por ejemplo, si vives en La Habana y vas a Varadero o Trinidad a dejar clientes, puedes publicar que tu taxi va a quedar libre en Trinidad o Vardero para regresar a La Habana.
                                <br>
                                También puedes publicar si tienes que ir a recoger clientes lejos de tu lugar de residencia y aún no tienes pasajeros.
                            </p>

                            <p>¿Qué haremos cuando publiques tu taxi?</p>

                            <ul>
                                <li>Lo publicaremos en nuestro sitio web, donde muchas casas y guías llegan buscando taxi para sus clientes</li>
                                <li>Te llamaremos si te necesitamos para alguno de nuestros clientes</li>
                                <li>Se lo enviaremos a todos nuestros contactos de casas de alquiler y guías para que te contacten si tienen clientes para tí ese día</li>
                                <li>Lo promocionaremos en más de 15 grupos de WhatsApp de taxi en Cuba</li>
                                <li>Lo publicaremos en grupos de Facebook para viajeros a Cuba</li>
                            </ul>
                        </big>
                    </span>
                </div>
            </div>
        </div>
        
        <div class="container" id="publicar">
            <div class="row justify-content-center bg-light">
                <div class="media-container-column col-lg-8 mt-5 pb-3">
                    <b class="align-center">PUBLICA TU TAXI COMO LIBRE EN ALGÚN DESTINO Y NO VIAJES VACÍO</b>
                    <br>
                    <b class="align-center">Las personas que lo necesiten (casas, guías, recepcionistas de hoteles) te contactarán si les hace falta para sus clientes</b>
                    <br><br>
                    
                    <?php echo $this->Session->flash(); ?>
                    <?php echo $this->element('form_taxi_available_post', array('action'=>'add_new_offer'));?>
                </div>
            </div>
        </div>
    </div>
</section>