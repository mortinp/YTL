<?php
$driver_intro = __d('conversation', 'El chofer');
$driver_desc = '#' . $driver['id'];
$driver_avatar = null;
$show_profile = false;

if (isset($driver['DriverProfile']) && !empty($driver['DriverProfile'])) {
    $driver_intro = $driver['DriverProfile']['driver_name'];
    $driver_desc = $driver['DriverProfile']['driver_name'];
    if (isset($driver['DriverProfile']['show_profile']) && $driver['DriverProfile']['show_profile'])
        $show_profile = true;

    $fullBaseUrl = Configure::read('App.fullBaseUrl');
    if (Configure::read('debug') > 0)
        $fullBaseUrl .= '/yotellevo'; // HACK: para poder trabajar en mi PC y que pinche en el server tambien

    $driver_avatar = $fullBaseUrl . '/' . str_replace('\\', '/', $driver['DriverProfile']['avatar_filepath']);
}
?>



<table class="body" style="border-spacing: 0;border-collapse: collapse;padding: 0;vertical-align: top;text-align: left;height: 100%;width: 100%;color: #222222;font-family: &quot;Helvetica&quot;, &quot;Arial&quot;, sans-serif;font-weight: normal;margin: 0;line-height: 19px;font-size: 14px;">
    <tr style="padding: 0;vertical-align: top;text-align: left;">
        <td class="center" align="center" valign="top" style="word-break: break-word;-webkit-hyphens: auto;-moz-hyphens: auto;hyphens: auto;padding: 0;vertical-align: top;text-align: center;color: #222222;font-family: &quot;Helvetica&quot;, &quot;Arial&quot;, sans-serif;font-weight: normal;margin: 0;line-height: 19px;font-size: 14px;border-collapse: collapse !important;">
    <center style="width: 100%;min-width: 580px;">

        <table class="row header" style="border-spacing: 0;border-collapse: collapse;padding: 0px;vertical-align: top;text-align: left;background: #999999;width: 100%;position: relative;">
            <tr style="padding: 0;vertical-align: top;text-align: left;">
                <td class="center" align="center" style="word-break: break-word;-webkit-hyphens: auto;-moz-hyphens: auto;hyphens: auto;padding: 0;vertical-align: top;text-align: center;color: #222222;font-family: &quot;Helvetica&quot;, &quot;Arial&quot;, sans-serif;font-weight: normal;margin: 0;line-height: 19px;font-size: 14px;border-collapse: collapse !important;">
            <center style="width: 100%;min-width: 580px;">

                <table class="container" style="border-spacing: 0;border-collapse: collapse;padding: 0;vertical-align: top;text-align: inherit;width: 580px;margin: 0 auto;">
                    <tr style="padding: 0;vertical-align: top;text-align: left;">
                        <td class="wrapper last" style="word-break: break-word;-webkit-hyphens: auto;-moz-hyphens: auto;hyphens: auto;padding: 10px 20px 0px 0px;vertical-align: top;text-align: left;color: #222222;font-family: &quot;Helvetica&quot;, &quot;Arial&quot;, sans-serif;font-weight: normal;margin: 0;line-height: 19px;font-size: 14px;position: relative;padding-right: 0px;border-collapse: collapse !important;">

                            <table class="twelve columns" style="border-spacing: 0;border-collapse: collapse;padding: 0;vertical-align: top;text-align: left;margin: 0 auto;width: 580px;">
                                <tr style="padding: 0;vertical-align: top;text-align: left;">                            
                                    <td style="word-break: break-word;-webkit-hyphens: auto;-moz-hyphens: auto;hyphens: auto;padding: 0px 0px 10px;vertical-align: top;text-align: left;color: #222222;font-family: &quot;Helvetica&quot;, &quot;Arial&quot;, sans-serif;font-weight: normal;margin: 0;line-height: 19px;font-size: 14px;border-collapse: collapse !important;">


                                        <p style="margin: 0;margin-bottom: 10px;color: #222222;font-family: &quot;Helvetica&quot;, &quot;Arial&quot;, sans-serif;font-weight: normal;padding: 0;text-align: left;line-height: 19px;font-size: 14px;">
                                            <span class="template-label" style="color: #ffffff;font-weight: bold;font-size: 12px;">
                                                <?php echo __d('conversation', 'Hola, tienes un mensaje del chofer <b>%s</b> de YoTeLlevo, notificado con los datos de tu viaje <span style="display:inline-block"><b>%s</b></span>.', $driver_desc, $travel['origin'] . ' - ' . $travel['destination']) ?>
                                            </span>
                                        </p>
                                        <p style="margin: 0;margin-bottom: 10px;color: #222222;font-family: &quot;Helvetica&quot;, &quot;Arial&quot;, sans-serif;font-weight: normal;padding: 0;text-align: left;line-height: 19px;font-size: 14px;">
                                            <span class="template-label big" style="color: #ffffff;font-weight: bold;font-size: 18px;">
                                                <?php echo __d('conversation', 'Para enviar tu respuesta <b>responde este correo sin modificar el asunto</b>.')?>
                                            </span>
                                        </p>


                                    </td>
                                    <td class="expander" style="word-break: break-word;-webkit-hyphens: auto;-moz-hyphens: auto;hyphens: auto;padding: 0 !important;vertical-align: top;text-align: left;color: #222222;font-family: &quot;Helvetica&quot;, &quot;Arial&quot;, sans-serif;font-weight: normal;margin: 0;line-height: 19px;font-size: 14px;visibility: hidden;width: 0px;border-collapse: collapse !important;"></td>
                                </tr>
                            </table>

                        </td>
                    </tr>
                </table>

            </center>
            </td>
            </tr>
        </table>

        <table class="container" style="border-spacing: 0;border-collapse: collapse;padding: 0;vertical-align: top;text-align: inherit;width: 580px;margin: 0 auto;">
            <tr style="padding: 0;vertical-align: top;text-align: left;">
                <td style="word-break: break-word;-webkit-hyphens: auto;-moz-hyphens: auto;hyphens: auto;padding: 0;vertical-align: top;text-align: left;color: #222222;font-family: &quot;Helvetica&quot;, &quot;Arial&quot;, sans-serif;font-weight: normal;margin: 0;line-height: 19px;font-size: 14px;border-collapse: collapse !important;">

                    <table class="row" style="border-spacing: 0;border-collapse: collapse;padding: 0px;vertical-align: top;text-align: left;width: 100%;position: relative;display: block;">
                        <tr style="padding: 0;vertical-align: top;text-align: left;">
                            <td class="wrapper last" style="word-break: break-word;-webkit-hyphens: auto;-moz-hyphens: auto;hyphens: auto;padding: 10px 20px 0px 0px;vertical-align: top;text-align: left;color: #222222;font-family: &quot;Helvetica&quot;, &quot;Arial&quot;, sans-serif;font-weight: normal;margin: 0;line-height: 19px;font-size: 14px;position: relative;padding-right: 0px;border-collapse: collapse !important;">

                                <table class="twelve columns" style="border-spacing: 0;border-collapse: collapse;padding: 0;vertical-align: top;text-align: left;margin: 0 auto;width: 580px;">
                                    <tr style="padding: 0;vertical-align: top;text-align: left;">
                                        <td style="word-break: break-word;-webkit-hyphens: auto;-moz-hyphens: auto;hyphens: auto;padding: 0px 0px 10px;vertical-align: top;text-align: left;color: #222222;font-family: &quot;Helvetica&quot;, &quot;Arial&quot;, sans-serif;font-weight: normal;margin: 0;line-height: 19px;font-size: 14px;border-collapse: collapse !important;">
                                            
                                            
                                            <?php if($show_profile):?>    
                                                <?php $profile_path = $fullBaseUrl.'/driver_traveler_conversations/show_profile/'.$conversation_id;?>
                                                <div class="clear" style="clear: both;">
                                                    <p class="lead" style="margin: 0;margin-bottom: 10px;color: #222222;font-family: &quot;Helvetica&quot;, &quot;Arial&quot;, sans-serif;font-weight: normal;padding: 0;text-align: left;line-height: 21px;font-size: 18px;">
                                                        <a href="<?php echo $profile_path?>" style="color: #2ba6cb;text-decoration: none;">
                                                            <?php echo __d('conversation', 'Mira fotos de %s y su auto', $driver_intro)?> »
                                                        </a>
                                                    </p>
                                                </div>
                                            <?php endif;?>
                                            
                                            <?php if($driver_avatar != null):?>
                                                <div class="clear" style="clear: both;">
                                                    <p style="margin: 0;margin-bottom: 10px;color: #222222;font-family: &quot;Helvetica&quot;, &quot;Arial&quot;, sans-serif;font-weight: normal;padding: 0;text-align: left;line-height: 19px;font-size: 14px;">
                                                        <img class="driver-avatar" src="<?php echo $driver_avatar?>" alt="<?php echo $driver['DriverProfile']['driver_name']?>" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;width: auto;max-width: 100%;float: left;clear: both;display: block;">
                                                    </p>
                                                </div>
                                            <?php endif;?>
                                            
                                            
                                        </td>
                                        <td class="expander" style="word-break: break-word;-webkit-hyphens: auto;-moz-hyphens: auto;hyphens: auto;padding: 0 !important;vertical-align: top;text-align: left;color: #222222;font-family: &quot;Helvetica&quot;, &quot;Arial&quot;, sans-serif;font-weight: normal;margin: 0;line-height: 19px;font-size: 14px;visibility: hidden;width: 0px;border-collapse: collapse !important;"></td>
                                    </tr>
                                </table>				  

                            </td>
                        </tr>
                    </table>

                    <table class="row callout" style="border-spacing: 0;border-collapse: collapse;padding: 0px;vertical-align: top;text-align: left;width: 100%;position: relative;display: block;">
                        <tr style="padding: 0;vertical-align: top;text-align: left;">
                            <td class="wrapper last" style="word-break: break-word;-webkit-hyphens: auto;-moz-hyphens: auto;hyphens: auto;padding: 10px 20px 0px 0px;vertical-align: top;text-align: left;color: #222222;font-family: &quot;Helvetica&quot;, &quot;Arial&quot;, sans-serif;font-weight: normal;margin: 0;line-height: 19px;font-size: 14px;position: relative;padding-bottom: 20px;padding-right: 0px;border-collapse: collapse !important;">

                                <table class="twelve columns" style="border-spacing: 0;border-collapse: collapse;padding: 0;vertical-align: top;text-align: left;margin: 0 auto;width: 580px;">
                                    <tr style="padding: 0;vertical-align: top;text-align: left;">
                                        <td class="panel" style="word-break: break-word;-webkit-hyphens: auto;-moz-hyphens: auto;hyphens: auto;padding: 10px !important;vertical-align: top;text-align: left;color: #222222;font-family: &quot;Helvetica&quot;, &quot;Arial&quot;, sans-serif;font-weight: normal;margin: 0;line-height: 19px;font-size: 14px;background: #ECF8FF;border: 1px solid #d9d9d9;border-color: #b9e5ff;border-collapse: collapse !important;">
                                            <div class="clear" style="clear: both;">
                                                <p style="margin: 0;margin-bottom: 10px;color: #222222;font-family: &quot;Helvetica&quot;, &quot;Arial&quot;, sans-serif;font-weight: normal;padding: 0;text-align: left;line-height: 19px;font-size: 14px;"><b><?php echo __d('conversation', '%s dice', $driver_intro)?>:</b></p>
                                                <p style="margin: 0;margin-bottom: 10px;color: #222222;font-family: &quot;Helvetica&quot;, &quot;Arial&quot;, sans-serif;font-weight: normal;padding: 0;text-align: left;line-height: 19px;font-size: 14px;">
                                                    <?php echo preg_replace("/(\r\n|\n|\r)/", "<br/>", $response);?>
                                                </p>
                                            </div>
                                        </td>
                                        <td class="expander" style="word-break: break-word;-webkit-hyphens: auto;-moz-hyphens: auto;hyphens: auto;padding: 0 !important;vertical-align: top;text-align: left;color: #222222;font-family: &quot;Helvetica&quot;, &quot;Arial&quot;, sans-serif;font-weight: normal;margin: 0;line-height: 19px;font-size: 14px;visibility: hidden;width: 0px;border-collapse: collapse !important;"></td>
                                    </tr>
                                </table>

                            </td>
                        </tr>
                    </table>

                </td>
            </tr>
        </table>



        <table class="row header" style="border-spacing: 0;border-collapse: collapse;padding: 0px;vertical-align: top;text-align: left;background: #999999;width: 100%;position: relative;">
            <tr style="padding: 0;vertical-align: top;text-align: left;">
                <td class="center" align="center" style="word-break: break-word;-webkit-hyphens: auto;-moz-hyphens: auto;hyphens: auto;padding: 0;vertical-align: top;text-align: center;color: #222222;font-family: &quot;Helvetica&quot;, &quot;Arial&quot;, sans-serif;font-weight: normal;margin: 0;line-height: 19px;font-size: 14px;border-collapse: collapse !important;">
            <center style="width: 100%;min-width: 580px;">

                <table class="container" style="border-spacing: 0;border-collapse: collapse;padding: 0;vertical-align: top;text-align: inherit;width: 580px;margin: 0 auto;">
                    <tr style="padding: 0;vertical-align: top;text-align: left;">
                        <td class="wrapper last" style="word-break: break-word;-webkit-hyphens: auto;-moz-hyphens: auto;hyphens: auto;padding: 10px 20px 0px 0px;vertical-align: top;text-align: left;color: #222222;font-family: &quot;Helvetica&quot;, &quot;Arial&quot;, sans-serif;font-weight: normal;margin: 0;line-height: 19px;font-size: 14px;position: relative;padding-right: 0px;border-collapse: collapse !important;">

                            <table class="twelve columns" style="border-spacing: 0;border-collapse: collapse;padding: 0;vertical-align: top;text-align: left;margin: 0 auto;width: 580px;">
                                <tr style="padding: 0;vertical-align: top;text-align: left;">                            
                                    <td style="word-break: break-word;-webkit-hyphens: auto;-moz-hyphens: auto;hyphens: auto;padding: 0px 0px 10px;vertical-align: top;text-align: left;color: #222222;font-family: &quot;Helvetica&quot;, &quot;Arial&quot;, sans-serif;font-weight: normal;margin: 0;line-height: 19px;font-size: 14px;border-collapse: collapse !important;">


                                        <div class="email-salute">
                                            <p class="template-label" style="margin: 0;margin-bottom: 10px;color: #ffffff;font-family: &quot;Helvetica&quot;, &quot;Arial&quot;, sans-serif;font-weight: bold;padding: 0;text-align: left;line-height: 19px;font-size: 12px;">
                                                <?php echo __d('conversation', 'Atentamente, el equipo de') ?> <a href="http://yotellevocuba.com" style="color: #ffffff !important;text-decoration: none;text-style: underline;">YoTeLlevo</a>
                                            </p>	
                                            <p class="template-label" style="margin: 0;margin-bottom: 10px;color: #ffffff;font-family: &quot;Helvetica&quot;, &quot;Arial&quot;, sans-serif;font-weight: bold;padding: 0;text-align: left;line-height: 19px;font-size: 12px;">
                                                <a href="http://yotellevocuba.com/blog/<?php echo Configure::read('Config.language')?>" style="color: #ffffff !important;text-decoration: none;text-style: underline;">Blog</a> | <a href="https://twitter.com/yotellevocuba" style="color: #ffffff !important;text-decoration: none;text-style: underline;">Twitter</a> | <a href="https://www.facebook.com/yotellevoTaxiCuba" style="color: #ffffff !important;text-decoration: none;text-style: underline;">Facebook</a>
                                            </p>
                                        </div>



                                    </td>
                                    <td class="expander" style="word-break: break-word;-webkit-hyphens: auto;-moz-hyphens: auto;hyphens: auto;padding: 0 !important;vertical-align: top;text-align: left;color: #222222;font-family: &quot;Helvetica&quot;, &quot;Arial&quot;, sans-serif;font-weight: normal;margin: 0;line-height: 19px;font-size: 14px;visibility: hidden;width: 0px;border-collapse: collapse !important;"></td>
                                </tr>
                            </table>

                        </td>
                    </tr>
                </table>

            </center>
            </td>
            </tr>
        </table>



    </center>
</td>
</tr>
</table>