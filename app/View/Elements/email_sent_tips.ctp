<div class="alert alert-warning">
    <p>
        <?php echo __('<b>IMPORTANTE</b>: Si no recibes un correo de <em>YoTeLlevo</em> en pocos minutos, revisa tu carpeta de correos spam o no deseados. Si esto no funciona, configura las opciones de correos entrantes, habilita el dominio <em>%s</em> y vuelve a <span style="display:inline-block"><b>%s</b></span>.', Configure::read('domain_name'), $link)?>
    </p>
    <br/>
    <p>
        <?php echo __('<b>%s</b> si los problemas persisten', $this->Html->link(__('Contáctanos'), array('controller'=>'pages', 'action'=>'contact')))?>.
    </p>
</div>