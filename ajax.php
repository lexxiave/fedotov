<?php
   /* Fedotov Vitaliy (c) Ulan-Ude 2016 | kursruk@yandex.ru */  
   
  include('ajerrors.php');
  // error_reporting(E_ALL);
  include('classes.php');
  
  class wAjax extends wMod
  {  var $res;
     var $seg;
     function wAjax($cfg, $path,$seg=null)
     {  parent::wMod($cfg, $path, $seg);
        $this->seg = $seg;
        $this->res = new stdClass();
        $this->res->error = false;
        
        if (isset($seg[2]))
        {  $fu = 'ajx'.$seg[2];
           if (method_exists($this, $fu))
           { $this->$fu();
           } else $this->error('Method not found: '.$fu, 3003);
        }
     }

     function error($msg, $no)
     { $this->res->error = true;
       $this->res->errmsg = $msg;
       $this->res->errno = $no;
       echo json_encode($this->res);
       return false;
     }
     
     function authGroup($group)
     { if ($this->cfg->inGroup($group)) return true;
       $this->error("Вы не авторизованы для группы $group", 3004);
       return false;
     }
  }
  
  class wMain extends wBase
  {  var $ajax;
     var $db;
     function route()
     {  global $_TRANSLATIONS;
        $this->db = $this->newMod('db');
        $this->user = $this->newMod('auth');
     
        $p = '';
        if (isset($_SERVER['PATH_INFO']))  $p = substr($_SERVER['PATH_INFO'],1);
        $this->nav = $p;
        $a = explode('/',$p);
        if (count($a)<3) 
        { echo '{"error":true,"errmsg":"Неверный адрес запроса '.$p.'","errno":3001}';
          return;
        }
        $type = $a[0];
        $path = $a[1];
        $mod = 'ajx'.$a[1];
                
        if ($p!='')
        { $trfile = $type.'/'.$path.'/ajx'.$this->lang.'.ini';
          if (file_exists($trfile)) $_TRANSLATIONS = parse_ini_file($trfile);
        
          $inc = $type.'/'.$path.'/'.$mod.'.php';
          if (file_exists($inc))
          { include($inc);
            $this->ajax = new $mod($this, $type.'/'.$path ,$a);            
          } else echo '{"error":true,"errmsg":"Файл '.$inc.' не найден!","errno":3002}';
          
        } 
     }
  }

  include('config.php');
  $conf = new wConfig();
  
  $conf->route();

?>
