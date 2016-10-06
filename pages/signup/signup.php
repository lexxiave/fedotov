<?php
  /* Fedotov Vitaliy (c) Ulan-Ude 2016 | kursruk@yandex.ru */
  class signup extends wPage
  {  function signup($cfg, $path, $seg=null)
     {  $cfg->title = 'Sign up';
        $this->path = $path.'/index.php';
        $this->cfg = $cfg;
        $this->cfg->addJs('lib','formvalidator.js');
        $this->cfg->addJs($path, 'signup.js');
     }
  }
?>
