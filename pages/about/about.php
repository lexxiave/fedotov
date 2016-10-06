<?php
 /* Fedotov Vitaliy (c) Ulan-Ude 2016 | kursruk@yandex.ru */
  class about extends wPage
  {  function about($cfg, $path, $seg=null)
     {  $cfg->title = 'О системе';
        $this->path = $path.'/index.php';
        $this->cfg = $cfg;
     }
       
     function display()
     {  echo '<table class="table table-striped"><tr>';
        $cf = $this->cfg;
        $qr = $this->cfg->db->query('select * from md_conf where id=:id', array('id'=>$cf->md_conf) );
        $conf = $this->cfg->db->fetchSingle($qr);
        echo "<tr><th>Разработчик</th><td>$cf->author</td></tr>";
        echo "<tr><th>Наименование</th><td>$cf->description</td></tr>";
        echo "<tr><th>Конфигурация</th><td>$conf->conf</td></tr>";
        echo "<tr><th>Версия</th><td>$conf->version.$conf->minor_version</td></tr>";
        echo '</table>';   
     }
  }
?>
