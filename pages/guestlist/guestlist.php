<?php
  /* Fedotov Vitaliy (c) Ulan-Ude 2016 | kursruk@yandex.ru */
  class guestlist extends wPage
  {  function guestlist($cfg, $path, $seg=null)
     {  $cfg->title = 'Event Name Guest List';
        $this->path = $path.'/index.php';
        $this->cfg = $cfg;
        $this->cfg->addJs('lib','formvalidator.js');
        $this->cfg->addJs($path, 'guestlist.js');
     }
  }
?>
