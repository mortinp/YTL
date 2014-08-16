<div class="alert alert-warning">
    <p>
        <?php echo __('<b>IMPORTANTE</b>: Si no recibes un correo de <em>YoTeLlevo</em> en pocos minutos, revisa tu carpeta de correos spam o no deseados. 
        Si esto no funciona, configura las opciones de correos entrantes, habilita el dominio <em>yotellevo.ahiteva.net</em> y vuelve a')?> <b><?php echo $link?></b>.
    </p>
    <br/>
    <p>
        <b><?php echo $this->Html->link(__('Contáctanos'), array('controller'=>'pages', 'action'=>'contact'))?></b> <?php echo __('si los problemas persisten')?>.
    </p>

</div>