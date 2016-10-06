<?php
  /* Fedotov Vitaliy (c) Ulan-Ude 2016 | kursruk@yandex.ru */
  class vipreserv extends wPage
  {  function vipreserv($cfg, $path, $seg=null)
     {  $cfg->title = 'Book Your VIP Reservation';
        $this->path = $path.'/index.php';
        $this->cfg = $cfg;
        $this->cfg->addJs('lib','moment-with-locales.min.js');
        $this->cfg->addJs('lib','bootstrap-datetimepicker.js');
        $this->cfg->addCSS('lib','bootstrap-datetimepicker.css');
        $this->cfg->addJs('lib','formvalidator.js');
        $this->cfg->addJs($path, 'vipreserv.js');

     }
  }
?>
