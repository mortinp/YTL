<?php
    $mainCTA = __d('mobirise/default', 'Contactar choferes en Cuba');
    if(isset($cta)) $mainCTA = $cta;
?>

<?php
$userLoggedIn = AuthComponent::user('id') ? true : false;

if($userLoggedIn) {
    $user = AuthComponent::user();
    $userRole = $user['role'];
    $pretty_user_name = User::prettyName($user, true);
}
?>

<section class="menu cid-qTkzRZLJNu" once="menu" id="menu1-0">

    <nav class="navbar navbar-expand beta-menu navbar-dropdown align-items-center navbar-fixed-top navbar-toggleable-sm bg-color">
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <div class="hamburger">
                <span></span>
                <span></span>
                <span></span>
                <span></span>
            </div>
        </button>
        <div class="menu-logo">
            <div class="navbar-brand">
                <span class="navbar-logo">
                    <?php echo $this->Html->link($this->Html->image('logo37.png', array('alt'=>'Yo Te Llevo Cuba logo', 'style'=>'height:3.8rem')), '/'.SessionComponent::read('Config.language'), array('escape'=>false));?>
                </span>
                <span class="navbar-caption-wrap">
                    <?php echo $this->Html->link('YO TE LLEVO - CUBA', '/'.SessionComponent::read('Config.language'), array('class'=>'navbar-caption text-white display-4'));?>
                </span>
                
                <ul class="navbar-nav">
                    <li class="nav-item">
                    <?php echo $this->element('mobirise/widgets/lang-link')?>
                    </li>
                </ul>
            </div>
        </div>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav nav-dropdown" data-app-modern-menu="true">
                <li class="nav-item">
                    <?php echo $this->Html->link(__d('mobirise/default', 'Sobre Nosotros'), array('controller'=>'testimonials', 'action'=>'featured', '?'=>array('also'=>Configure::read('Config.language') == 'es'?'en':'es')), array('class'=>'nav-link link text-white display-4', 'escape'=>false)); ?>
                </li>
                
                <?php if ($userLoggedIn): ?>
                <li class="nav-item dropdown navbar-right">
                    <a class="nav-link link text-white dropdown-toggle display-4" href="#" data-toggle="dropdown-submenu" aria-expanded="true">
                         <?php echo $pretty_user_name;?>
                    </a>
                    <div class="dropdown-menu">
                        <?php echo $this->Html->link(__('Perfil'), array('controller' => 'users', 'action' => 'profile'), array('class'=>'text-white dropdown-item display-4', 'aria-expanded'=>'true')) ?>
                        <div class="dropdown-divider"></div>
                        <?php echo $this->Html->link(__('Salir'), array('controller' => 'users', 'action' => 'logout'), array('class'=>'text-white dropdown-item display-4', 'aria-expanded'=>'true')) ?>
                    </div>
                </li>
                <?php endif?>
            </ul>
        </div>
    </nav>
</section>