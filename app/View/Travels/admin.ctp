<div class="container">
<div class="row">
    <div class="col-md-6 col-md-offset-3 well">
        <?php echo $this->element('travel', array('actions'=>false, 'details'=>true))?>
    </div>
    
    
    <div class="col-md-6 col-md-offset-3"> 
        <br/>
        <?php if(count($travels_by_same_user) > 0):?>        
        <span>Otros viajes del mismo usuario</span>
        <br/>
        <br/>
        <ul style="list-style-type: none;padding: 0px">
        <?php foreach ($travels_by_same_user as $t) :?>                
            <li style="margin-bottom: 60px">
                <?php echo $this->element('travel', array('travel'=>$t, 'actions'=>false, 'details'=>true))?>
            </li>                
        <?php endforeach?>
        </ul>
        <?php else:?>
        <span>Este usuario no tiene más viajes</span>
        <?php endif?>
    </div>
</div>
</div>

<?php echo $this->element('addon_scripts_notify_driver')?>