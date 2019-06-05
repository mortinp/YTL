<?php     
    $other = array('en' => 'es', 'es' => 'en');
    $lang = $this->Session->read('Config.language');

    $lang_changed_url             = $this->request['pass'];
    $lang_changed_url             = array_merge($lang_changed_url, $this->request['named']);
    $lang_changed_url['?']        = $this->request->query;
    $lang_changed_url['language'] = $other[$lang];    
    
    if($lang != null && $lang == 'en') echo $this->Html->link($this->Html->image('Spain.png', array('style'=>'max-width:21px;max-height:16px')).'&nbsp;'.'Español', $lang_changed_url, array('class' => 'nav-link link text-white display-4', 'title'=>'Traducir al Español', 'escape'=>false));
    else echo $this->Html->link($this->Html->image('UK.png', array('style'=>'max-width:21px;max-height:16px')).'&nbsp;'.'English', $lang_changed_url, array('class' => 'nav-link link text-white display-4', 'title'=>'Translate to English', 'escape'=>false));
?>