<?php
   class pMenu extends wMod
   { function display()
     { // echo 'pMenu';
       foreach($this->data as $r)
       { $ac = '';
         if ($this->cfg->nav==$r->a) $ac=' class="active"';
         if (property_exists($r,'acl'))
         { if ($this->inAcl($r->acl)) echo "<li$ac><a href=\"/index.php/$r->a\">".T($r->t)."</a></li>";
         } else   echo "<li$ac><a href=\"/index.php/$r->a\">".T($r->t)."</a></li>";
       }
      }
      function inAcl($r)
      { foreach($r as $v) 
        { if (!$this->cfg->inGroup($v)) return false;
        }
        return true;
      }
   }
?>
