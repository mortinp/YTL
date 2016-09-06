<?php
$imgBaseUrl = '/img';
if(Configure::read('debug') > 0) {
    $imgBaseUrl = '/yotellevo'.$imgBaseUrl;
}
?>

<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <h1><?php echo __('Testimonios de viajeros sorprendentes')?></h1>
            <span><?php echo __('Algunos viajeros como Paul, Mabel o Cristina tienen historias interesantes que contar sobre su experiencia con nuestros choferes. Nos encantan estos testimonios honestos e interesantes :)')?></span>
            <span><?php echo __('Lee algo de lo que dijeron ellos aquí')?>:</span>
            <hr/>
        </div>
        
    </div>
    <div class="row">        
        <?php if(Configure::read('Config.language') == 'en'):?>
        <div class="col-md-8 col-md-offset-1 panel" style="font-family:'Engagement', cursive">
            <blockquote class="bg-info">
                <footer>
                    <big>Paul Rogers</big>
                </footer>
                <br/>
                
                <p>This was my 4th trip to Cuba and it did not disappoint, we loved our time in Havana & Cayo Santa Maria. The weather was poor for the first 3 days but at this time of year you run that risk.</p>
                <p>All of our friends and family asked about our visit and experiences and we had plenty of photos to share with them. If only we lived in Canada rather than Europe then we would be there all the time.</p>
                <p>Your service was great and Lois was amazing, he kept in contact for the three weeks in the run up to the ride and met us at exactly the time required. I felt sorry for Lois as it was a very long trip for us and we only went one way, i would love to know what Lois thought of the trip and would he do it again?  In terms of the service that you offer i definitely believe that it was worth it, the cost was 50% less than using a conventional agent and the standard of Lois vehicle was better than most we have had in Cuba.</p>
                <p>My only request is that when drivers respond they also describe what the vehicle is, one of the other drivers that responded drove a Peugeot 207 which whilst being a great car i dont believe would accommodate our luggage and be comfortable for a 4 - 5 hour drive.</p>
            </blockquote>
            <div class="alert alert-success"><img src="<?php echo $imgBaseUrl.'/avatar-martin-bgsuccess.jpg'?>"/> <span style="display: inline-block">Thanks to Paul we created a new feature in our service: <a href="http://yotellevocuba.com/blog/en/how-we-turned-one-customer-review-into-a-feature-in-our-webapp/">Read the article »</a></span></div>
        </div>
            
        <div class="col-md-8 col-md-offset-3 panel" style="font-family:'Engagement', cursive">    
            <blockquote class="blockquote-reverse bg-default">
                <footer>
                    <big>Jaimi Cyrus</big>
                </footer>
                <br/>
                
                <p>My family had a great experience in Cuba, I just wish that I could have joined them and that the trip had been longer.  One week is not enough time in such an interesting country!</p>
                <p>I have been telling everyone about yotellevocuba, which I think is a great example of entrepreneurial spirit and an extremely valuable service. Fidel was absolutely first-rate in his communication with me, organization and I appreciated his initiative in checking on what else he could do to make the visit great (overnight accomodation, activities/sites, etc).  The driver Hector was friendly, helpful and overall my family was happy with him.  His english was limited and it was disappointing to not be able to converse more easily with him - they would have loved to get more of a local persons' viewpoint, understanding of the culture, etc.  I told my husband that they should have learned spanish.. :)</p>

            </blockquote>
        </div>
        
        <div class="col-md-8 col-md-offset-1 panel" style="font-family:'Engagement', cursive">
            <blockquote class="bg-info">
                <footer>
                    <big>Alan Dowie</big>
                </footer>
                <br/>
                
                <p>We used the transport 4 times and it was faultless.</p>
                <p>I was worried on arrival if we would get all our cases in the vehicle, but the Toyota had plenty of space and when the rain shower came on Felipe stopped and covered the cases with black bags.</p>
                <p>We had a great time in Cuba and would love to come back. Once again thanks to you and your drivers for the help and time in Cuba.</p>

            </blockquote>
        </div>
        
        <div class="col-md-8 col-md-offset-3 panel" style="font-family:'Engagement', cursive">    
            <blockquote class="blockquote-reverse bg-default">
                <footer>
                    <big>Zachary Chaltiel</big>
                </footer>
                <br/>
                
                <p>The trip was amazing and everything went smoothly. Abel, a cousin, i think, of Lois meet us at the airport and was very helpful the entire time. He brought us around everywhere we needed to go, suggested places to check out and places to eat and overall it was a great experience.</p>
                <p>Abel had the classic car that Lois emailed me a picture of and it was really a cool experience to spend a week traveling around in that car. We all took a bunch of beautiful pictures and loved our time there.</p>
                <p>I am definitely looking to go back to Cuba in the Fall, and I will be in touch regarding that trip as well. Thank you for all your help, your service was great and saved me some money.</p>

            </blockquote>
        </div>
        
        <div class="col-md-8 col-md-offset-1 panel" style="font-family:'Engagement', cursive">
            <blockquote class="bg-info">
                <footer>
                    <big>Cristina Rayeb and Raúl</big>
                </footer>
                <br/>
                
                <p>Our trip was wonderful. This year was the fourth time we visit your wonderful country and we always come home wishing to go back, which we will certainly do in the short term.</p>
                <p>Our experience with you was very nice. Ernesto the driver was very attentive and warm. Highly recommendable, everything. In fact, we already recommend you to some friends that are traveling there in January.</p>
                <p>I wish you the best for you and your country.</p>

            </blockquote>
        </div>
        
        <div class="col-md-8 col-md-offset-3 panel" style="font-family:'Engagement', cursive"> 
            <blockquote class="blockquote-reverse bg-default">
                <footer>
                    <big>Mabel Iglesias</big>
                </footer>
                <br/>
                
                <p>Our journey was great, and yes, we took lots of pictures and told our stories to our friends and family.</p>
                <p>The experience with Lois was very nice, he always followed what we had already arranged, schedules, prices. There is no doubt I would repeat the experience. I wish I could come back soon and see everything we missed.</p>
                <p>Cheers from Uruguay.</p>
            </blockquote>
        </div>
        
        <div class="col-md-8 col-md-offset-1 panel" style="font-family:'Engagement', cursive">
            <blockquote class="bg-info">
                <footer>
                    <big>Ariana and Bernardo</big>
                </footer>
                <br/>
                
                <p>I wanted to thank Ernesto Hernández for his kindness and professionalism.</p> 
                <p>Thanks to him we had an unforgettable trip to Trinidad. He didn't limit our trip to take us to Trinidad, but he was our guide and we could visit other places on our way, like Ciénaga de Zapata and Cienfuegos. All among interesting talks and laughters. He is a marvelous person and a great driver. I highly recommend his services.</p>
                <p>Thank you Ernesto! A big hug from Spain.</p>
            </blockquote>
        </div>
        
        <div class="col-md-8 col-md-offset-3 panel" style="font-family:'Engagement', cursive"> 
            <blockquote class="blockquote-reverse bg-default">
                <footer>
                    <big>Ana Garrido</big>
                </footer>
                <br/>
                
                <p>Hi,</p>
                <p>I'm Ana Garrido, we hired your services for a 10 persons trip during the last week of February.</p>
                <p>I send this email to thank you for your attention, especially our driver's service, Juan Carlos, because he turned our travel into an amazing experience. He always gave us good advice, told us funny stories and gave us very interesting historic facts. In case we come back we will certainly repeat this.</p>
                <p>Sorry for writting this late. We send hugs from Spain to you and Juan Carlos.</p>
                <p>Until next time!</p>
            </blockquote>
            <div class="alert alert-success"><img src="<?php echo $imgBaseUrl.'/avatar-martin-bgsuccess.jpg'?>"/> This message was sent to Ovidio, the Chief of Operations of a taxi agency associated to YoTeLlevo. Ovidio was contacted via our platform, but all the credit for the organization and the work goes to him and his driver, Juan Carlos.<span style="display: inline-block"></span></div>
        </div>
        
        <div class="col-md-8 col-md-offset-1 panel" style="font-family:'Engagement', cursive">
            <blockquote class="bg-info">
                <footer>
                    <big>Liam Barret</big>
                </footer>
                <br/>
                
                <p>We arranged our trip from Havana to Trinidad with Elmer by email from the UK and he was bang on time to collect us from our Casa. He's a good driver, knowledgeable, reliable, honest and excellent value.</p> 
                <p>We needed subsequent taxi journeys from Trinidad to Playa Larga and then Playa Larga to Havana. Elmer was happy to drive from Havana on each occasion and ferry us around for reasonable cost.</p>
                <p>More than that, he is a great laugh. You're hiring more than just a taxi driver and our holiday was better for having spent  all the hours on the road with him.</p>
                <p>I recommend using a taxi in Cuba even on the longer trips. We were a party of 4 and the taxi worked out around 50% more than taking a bus. It was more comfortable, we were able to stop along the way when we wanted and it felt more in touch with the country. If you are going to take a taxi, then I thoroughly recommend Elmer Lores!</p>
            </blockquote>
        </div>
            
        <?php else:?>
        <div class="col-md-8 col-md-offset-1 panel" style="font-family:'Engagement', cursive">
            <blockquote class="bg-info">
                <footer>
                    <big>Paul Rogers</big>
                </footer>
                <br/>
                
                <p>Este fue mi cuarto viaje a Cuba y no me decepcionó, nos encantó nuestro tiempo en La Habana & Cayo Santa Maria. El clima estaba pobre durante los primeros 3 días pero en este tiempo del año corríamos ese riesgo.</p>
                <p>Nuestros amigos y familia preguntaron por nuestra visita y experiencias y nosotros teníamos unas cuantas fotos para compartir con ellos. Si sólo viviéramos en Canadá en vez de en Europa estaríamos allá todo el tiempo.</p>
                <p>Su servicio fue magnífico y Lois fue lo mejor, mantuvo el contacto con nosotros durante las tres semanas y nos recogió exactamente a la hora acordada. Yo me sentí apenado con Lois porque fue un viaje muy largo y solo fuimos en una dirección, me encantaría saber que pensó Lois del viaje y si lo haría con nosotros de nuevo? En cuanto al servicio que ustedes ofrecen definitivamente creo que vale la pena, el costo fue 50% más barato que usando un agente convencional y el standard del vehículo de Lois era mejor que muchos que hemos tenido en Cuba.</p>
                <p>Mi única petición es que cuando los choferes respondan, también describan el vehículo. Uno de los otros choferes que respondieron manejaba un Peugeot 207 que aunque es un gran auto, no creo que pudiera llevar todo nuestro equipaje y ser a la vez cómodo para un viaje de 4-5 horas.</p>

            </blockquote>
            <div class="alert alert-success"><img src="<?php echo $imgBaseUrl.'/avatar-martin-bgsuccess.jpg'?>"/> <span style="display: inline-block">Gracias a Paul creamos una nueva funcionalidad en nuestro servicio: <a href="http://yotellevocuba.com/blog/es/de-una-resena-de-un-viajero-a-una-funcionalidad-en-nuestra-plataforma/">Lee el artículo »</a></span></div>
        </div>
            
        <div class="col-md-8 col-md-offset-3 panel" style="font-family:'Engagement', cursive">    
            <blockquote class="blockquote-reverse bg-default">
                <footer>
                    <big>Jaimi Cyrus</big>
                </footer>
                <br/>
                
                <p>Mi familia tuvo una gran experiencia en Cuba, solamente hubiera deseado haberme unido a ellos y que el viaje hubiese sido más largo. Una semana no es suficiente tiempo en un país tan interesante!</p>
                <p>Le he estado diciendo a todos sobre yotellevocuba, que creo que es un gran ejemplo de espíritu emprendedor y un servicio extremadamante valioso.</p>
                <p>Fidel fue absolutamente de primera calidad en su comunicación conmigo, su organización y yo aprecié mucho su iniciativa en verificar qué más podía hacer para que la visita fuera genial (estancias por la noche, actividades/sitios, etc). El chofer Hector era muy amigable, le gustaba ayudar y mi familia estuvo muy contenta con él. Su inglés era limitado y fue decepcionante no pder conversar más fácilmente con él -a ellos les hubiera encantado poder conocer más del punto de vista de un local, entender su cultura, etc. Yo le dije a mi esposo que debieron haber aprendido Español antes de ir.. :)</p>

            </blockquote>
        </div>
        
        <div class="col-md-8 col-md-offset-1 panel" style="font-family:'Engagement', cursive">
            <blockquote class="bg-info">
                <footer>
                    <big>Alan Dowie</big>
                </footer>
                <br/>
                
                <p>Nosotros usamos el transporte 4 veces y fue magnífico.</p>
                <p>Yo estaba preocupado si en el arribo nuestros equipajes cabrían en el vehículo, pero el Toyota tenía suficiente espacio y cuando empezó a llover Felipe se detuvo y cubrió todos los equipajes con unas mantas negras.</p>
                <p>Tuvimos un excelente viaje a Cuba y nos encantaría regresar. Una vez más gracias a tí y a tus choferes por la ayuda y el tiempo en Cuba.</p>
                
            </blockquote>
        </div>
        
        <div class="col-md-8 col-md-offset-3 panel" style="font-family:'Engagement', cursive">    
            <blockquote class="blockquote-reverse bg-default">
                <footer>
                    <big>Cristina Rayeb y Raúl</big>
                </footer>
                <br/>
                
                <p>El viaje fue maravilloso. Este año fue la cuarta vez que visitamos ese entrañable país y siempre volvemos con ganas de regresar, cosa que seguramente haremos a corto plazo.</p>
                <p>La experiencia con Uds fue muy buena. Ernesto el chofer ha sido muy servicial y muy cálido. Altamente recomendable todo. De hecho ya los hemos recomendado a amigos que viajarán en Enero.</p>
                <p>Les deseo lo mejor para Uds y su país.</p>

            </blockquote>
        </div>
        
        <div class="col-md-8 col-md-offset-1 panel" style="font-family:'Engagement', cursive">
            <blockquote class="bg-info">
                <footer>
                    <big>Mabel Iglesias</big>
                </footer>
                <br/>
                
                <p>Nuestro recorrido por Cuba fue estupendo y si, sacamos muchas fotos y contamos nuestras vivencias a nuestros amigos y familiares.</p>
                <p>Nuestra experiencia con Lois fue muy buena, siempre cumplió con lo pactado de antemano, horarios, precios. Sin duda volvería a repetir la experiencia. Ojalá pueda volver pronto y conocer todo lo que nos faltó.</p>
                <p>Saludos desde Uruguay.</p>
            </blockquote>
        </div>
        
        <div class="col-md-8 col-md-offset-3 panel" style="font-family:'Engagement', cursive">    
            <blockquote class="blockquote-reverse bg-default">
                <footer>
                    <big>Zachary Chaltiel</big>
                </footer>
                <br/>
                
                <p>El viaje fue genial y todo fue bien. Abel, un primo, creo, de Lois nos buscó en el aeropuerto y nos ayudó todo el tiempo. Nos llevó por todos lados, donde queríamos ir, sugirió lugares para ver y para comer y todo fue una agradable experiencia.</p>
                <p>Abel tenía el auto clásico del que Lois nos había enviado una foto y fue realmente estupendo pasarnos una semana viajando por ahí en ese auto. Todos tomamos unas cuantas fotos y nos encantó nuestra estancia allá.</p>
                <p>Definitivamente espero volver a Cuba luego del verano, y me pondré en contacto con ustedes nuevamente para el viaje. Muchas gracias por toda su ayuda, su servicio fue excelente y nos ahorró algo de dinero.</p>

            </blockquote>
        </div>
        
        <div class="col-md-8 col-md-offset-1 panel" style="font-family:'Engagement', cursive">
            <blockquote class="bg-info">
                <footer>
                    <big>Ariana y Bernardo</big>
                </footer>
                <br/>
                
                <p>Quería agradecer a Ernesto Hernández su profesionalidad y amabilidad.</p> 
                <p>Gracias a él tuvimos un viaje inolvidable a Trinidad. No se limitó a llevarnos, sino que nos hizo de guía y pudimos conocer más de Cuba visitando la Ciénaga de Zapata y Cienfuegos de camino a Trinidad. Todo acompañado de interesantes charlas y risas. Es una persona maravillosa y un gran conductor. Sin duda recomiendo sus servicios.</p>
                <p>Gracias Ernesto!! Un fuerte abrazo desde España</p>
            </blockquote>
        </div>
        
        <div class="col-md-8 col-md-offset-3 panel" style="font-family:'Engagement', cursive"> 
            <blockquote class="blockquote-reverse bg-default">
                <footer>
                    <big>Ana Garrido</big>
                </footer>
                <br/>
                
                <p>Hola,</p>
                <p>Soy Ana Garrido, contratamos sus servicios para un viaje de diez personas la última semana de febrero.</p>
                <p>El motivo de este correo es agradecerle el servicio prestado, en especial en cuanto al trato con nuestro chofer Juan Carlos porque hizo de nuestro viaje una experiencia estupenda. Siempre nos daba buenos consejos, nos contaba divertidas anécdotas y datos de historia muy interesantes. En caso de volver repetiríamos sin ningún tipo de duda.</p>
                <p>Disculpas por escribir con tanta tardanza, les mandamos un saludo desde España a usted y a Juan Carlos.</p>
                <p>¡Hasta otra!</p>
            </blockquote>
            <div class="alert alert-success"><img src="<?php echo $imgBaseUrl.'/avatar-martin-bgsuccess.jpg'?>"/> Este es un mensaje enviado a Ovidio, el Jefe de Operaciones de una agencia de taxi asociada a YoTeLlevo. Aunque Ovidio fue contactado a través de nuestra plataforma, todo el crédito de la organización y realización del viaje van para él y Juan Carlos, su chofer.<span style="display: inline-block"></span></div>
        </div>
        
        <?php endif?>
        
    </div>
</div>