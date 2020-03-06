<?php
$userLoggedIn = AuthComponent::user('id') ? true : false;

if($userLoggedIn) {
    $user = AuthComponent::user();
    $userRole = $user['role'];
    $pretty_user_name = User::prettyName($user, true);
}
if(!isset($transparent)) {
    $transparent = true;
}
?>

<section class="menu cid-r8XWEle1z2" once="menu" id="menu1-0">

    <nav class="navbar navbar-expand beta-menu navbar-dropdown align-items-center navbar-fixed-top navbar-toggleable-sm bg-color <?php if($transparent):?>transparent<?php endif?>">
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
            </div>
        </div>
    </nav>
</section>