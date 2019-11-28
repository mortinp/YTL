<?php App::uses('Travel', 'Model')?>
<?php App::uses('DriverTravel', 'Model')?>
<?php App::uses('User', 'Model')?>

<?php
$userLoggedIn = AuthComponent::user('id') ? true : false;

if($userLoggedIn) {
    $user = AuthComponent::user();
    $userRole = $user['role'];
    $pretty_user_name = User::prettyName($user, true);
}
?>

<?php     
    $other = array('en' => 'es', 'es' => 'en');
    $lang = $this->Session->read('Config.language');
 
    $lang_changed_url             = $this->request['pass'];
    $lang_changed_url             = array_merge($lang_changed_url, $this->request['named']);
    $lang_changed_url['?']        = $this->request->query;
    $lang_changed_url['language'] = $other[$lang];
?>

<!DOCTYPE html>
<html>
    <head>        
        <?php echo $this->Html->charset(); ?>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <title><?php echo $page_title." | YoTeLlevo" ?></title>
        <meta name="description" content="<?php echo $page_description?>"/>
        
        <style type="text/css">
            
            #navbar #nav a.nav-link{
                /*color:white;*/
                font-family:'Montserrat', sans-serif;
                font-size:13px;
                /*margin-top:4px;*/
                text-transform:uppercase
            }
            #navbar #nav a.nav-link:hover,#navbar #nav a.nav-link:focus{
                background-color:transparent;
                text-decoration:none
            }
        </style>
        
        <?php
        // META
        $this->Html->meta('icon');
        
        $this->Html->css('default-bundle', array('inline' => false));
        
        $this->Html->script('default-bundle', array('inline' => false));
        $this->Html->css('/assets/datepicker/css/datepicker', array('inline' => false));
        $this->Html->css('font-awesome/css/font-awesome.min', array('inline' => false));
              
        echo $this->fetch('meta');
        echo $this->fetch('css');        
        $this->Html->script('/assets/jquery-validation-1.10.0/dist/jquery.validate.min', array('inline' => false));
        $this->Html->script('/assets/datepicker/js/datepicker', array('inline' => false));        
        echo $this->fetch('script');
        
        ?>
        
        <script type="text/javascript">
            $(document).ready(function() {
                
                /*Logica para el mensaje directo en conv. cerrada*/
                $('.datepicker').datepicker({
                format: "dd/mm/yyyy",
                language: '<?php echo Configure::read('Config.language')?>',
                startDate: 'today',
                todayBtn: "linked",
                autoclose: true,
                todayHighlight: true
            });

            
                //$('.info').tooltip({placement:'bottom', html:true});
            })
        </script>
    </head>
    <body>
        <div id="container">
            
            <div style="height: 80px;width:100%;clear:both"></div>
            <?php echo $this->Session->flash('auth'); ?>
            <div id="content" class="container-fluid">
                
                <?php echo $this->Session->flash(); ?>
                <?php echo $this->fetch('content'); ?>
                         
                
            </div>

            <div id="footer">
                <div class="container-fluid">
                    <?php echo $this->element('footer')?>
                </div>
            </div>
            
            
        </div>
        
     
        
    </body>
</html>