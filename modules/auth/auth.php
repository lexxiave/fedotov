<?php
    /* Fedotov Vitaliy (c) Ulan-Ude 2016 | kursruk@yandex.ru */

   class auth extends wMod
   { var $user = null;
   
   
     function getIPAddr()
     {  $ip_rem = '0.0.0.0';
        $ip_loc = '0.0.0.0';
        if (isset($_SERVER['REMOTE_ADDR'])) $ip_rem=$_SERVER['REMOTE_ADDR'];
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))  $ip_loc = $_SERVER['HTTP_X_FORWARDED_FOR'];
        return ip2hex($ip_rem).ip2hex($ip_loc);
     }
     function bkeygen($l)
     {  $r='';
        for ($i=0; $i<$l; $i++) $r.= dechex(rand(0,15));
        return $r;
     }
     
     function inGroup($grp)
     { if ($this->user!=null && isset($this->user->groups[$grp])) return true;
       return false;
     }
     
    function getInf($o)
    {  $user = new StdClass();
       $user->id = filter_var($o->id,FILTER_SANITIZE_NUMBER_INT);
       $user->name = filter_var($o->name, FILTER_SANITIZE_STRING);
       $user->firstname = filter_var($o->firstname, FILTER_SANITIZE_STRING);
       $user->lastname = filter_var($o->lastname, FILTER_SANITIZE_STRING);       
          
       $db = $this->cfg->db;
       $sql = 'select g.grname from mc_usergroups ug '
       .'join mc_users u on ug.user_id=u.id '
       .'join mc_groups g on ug.group_id=g.id '
       .'where u.name = :name';
       $qr = $db->query($sql, array('name'=>$user->name) );
       $groups = array();
       while ( $r = $qr->fetch(PDO::FETCH_OBJ) )       
       { $groups[$r->grname] = 1;
       }
       
       $user->groups = $groups;
       $this->user = $user;
       return $user;
     }
     
     function clearSession()
     { // Удалим старую сессию, чтобы зайти с новым именем
       $db =  $this->cfg->db;
       if (isset($_COOKIE['_usid']))
       { $usid = $_COOKIE['_usid'];
         $db->query("delete from mc_sessions where session=:sid", array('sid'=>$usid) );
         unset($_COOKIE['_usid']);
         setcookie('_usid', null, -1, '/');
       }
     }
     
     function hashPassword($password)
     { return md5($password);
     }
     
     function checkUserPassword($user, $password, &$o)
     {  $db =  $this->cfg->db;        
        $upass = $this->hashPassword($password);
        $sql = "select id, name, lastname, firstname from mc_users where name=:name and pass=:pass";
        $qr = $db->query($sql, array('name'=>$user, 'pass'=>$upass) );
        $o = $db->fetchSingle($qr);
        return (!empty($o));
     }
     
     // Модуль авторизации
     function checkAuth()
     { $db =  $this->cfg->db;
       if ($db==null) return false;
       session_start();       
       if (isset($_POST['uname']) && isset($_POST['upass']))
       {
           $this->clearSession();           
           $uname = filter_var($_POST['uname'], FILTER_SANITIZE_STRING);
           
           if ($this->checkUserPassword($uname, $_POST['upass'],$o))
           {  $u = $this->getInf($o);
              $session = $this->getIPAddr().$this->bkeygen(32);
              $ttl = time()+36000*24*30; // время
              $sql = "insert into mc_sessions (user_id, session, ttl) values (:uid, :sess, :ttl)";
              $db->query($sql, array('uid'=>$u->id, 'sess'=>$session, 'ttl'=>$ttl) );
              setcookie('_usid', $session , $ttl, '/');
              return true;
           }
     } else
     // проверка сессионного ключа
     if (isset($_COOKIE['_usid']))
     {  $usid = $_COOKIE['_usid'];
        $sess = $this->getIPAddr().substr($usid, 16); // сверим IP
            
        $sql = "select * from mc_sessions where session=:sess";
        $qr = $db->query($sql, array('sess'=>$sess) );
        $o = $db->fetchSingle($qr);
        if (!empty($o)) 
        {   $sql = "select id, name, lastname,firstname from mc_users where id=".$o->user_id;
            $qr = $db->query($sql, array('uid'=>$o->user_id) );
            $o = $db->fetchSingle($qr);
            if (!empty($o)) $this->getInf($o);
            return true; 
        }
        sleep(3);
        return false;
     }
    }
    
    function logout()
    { if (isset($_POST['logout']) && ($_POST['logout']==1) ) $this->clearSession();
    }
    
     function auth($cfg, $path, $data='')
     { $this->cfg = $cfg;
       $this->path = $path;
       
       $this->logout();
       $this->checkAuth();       
     }

   }


  // IP адрес в 16-ричное значение
  function ip2hex($ip)
  { $a = explode('.',$ip);
    $r = '';
    if (count($a)<4) return '00000000'; // IPv6 hack
    for ($i=0; $i<4; $i++)
    { $n = (1*$a[$i]) & 0xff;
      $r.=  dechex($n >> 4).dechex($n & 0xf);
     }
     return $r;
   }
?>
