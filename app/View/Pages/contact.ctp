<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <legend>
                <div><big><?php echo __('Contáctanos')?></big></div>
                <div><small class="text-muted">
                    <p>
                        <?php echo __('Escríbenos para saber tu opinión, sugerencia o pregunta sobre <em>YoTeLlevo</em>')?>.
                    </p>
                    <p>
                        <?php echo __('Más que todo, <b>nos gustaría saber qué problemas has tenido con <em>YoTeLlevo</em> y qué podemos hacer para resolverlo</b>.
                        Estamos dispuestos a hacer cualquier cosa: ¿No puedes usarlo porque no tienes correo o Internet? Explícanos aquí
                        y pudiéramos hacer algo por tí')?>.
                    </p>
                </small></div>
            </legend>
            <?php echo $this->element('contact_form')?>
        </div>
    </div>
</div>