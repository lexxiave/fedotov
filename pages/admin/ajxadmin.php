<?php  
 /* Fedotov Vitaliy (c) Ulan-Ude 2016 | kursruk@yandex.ru */
    class ajxadmin extends wAjax
    {  function ajxAll()
       {  if (!$this->authGroup('admin')) return;
          $db = $this->cfg->db;
          $qr = $db->query('select id,name,lastname,firstname,email,phone from mc_users order by lastname, firstname');
          $this->res->data= $qr->fetchAll(PDO::FETCH_OBJ);
          echo json_encode($this->res);
       }
       
       function ajxLoadTmpl()
       {   if (!$this->authGroup('admin')) return;
           $db = $this->cfg->db;
           $tmpl = $this->seg[3];
           $qr = $db->query('select * from templates where name=:name',
           array('name'=>$tmpl));
           $this->res->row = $db->fetchSingle($qr);            
           echo json_encode($this->res);
       }
       
       function ajxSaveTmpl()
       {  if (!$this->authGroup('admin')) return;
          $db = $this->cfg->db;
          $r = (object)$_POST;
          $key = $r->seltmpl;
          unset($r->seltmpl);
          if ($db->updateObject('templates', $r, array('name'=>$key)))
          $this->res->info = T('TEMPLATE_SAVED');
          echo json_encode($this->res);
       }

       function ajxLoadTable()
       {  if (!$this->authGroup('admin')) return;
          $db = $this->cfg->db;
          $r = (object)$_POST;
          $table = $this->seg[3];
          $parent_id = null;
          if (isset($this->seg[4])) $parent_id=$this->seg[4];
          $lim=25;
          $tables = array('signup'=>"select * from signup order by id desc limit $lim",
'evnamegl'=>"select 
    e.id,
    e.created,
    e.firstname,
    e.lastname,
    e.email,
    group_concat(concat(' ',g.firstname,' ',g.lastname)) AS guests
from evnamegl e
join evnamegl_guests g on g.engl_id=e.id
group by g.engl_id
order by id desc limit $lim",
'evnamegl_guests'=>"select * from evnamegl_guests where engl_id=:id order by id",
'vipreserv'=>"select 
    v.id,
    v.created,
    v.firstname,
    v.lastname,
    v.email,
    v.bookdate,
    v.phone,
    v.vippackage_id as package,
    group_concat(concat(' ',g.firstname,' ',g.lastname)) AS guests
from vipreserv v
join vipreserv_guests g on g.vipreserv_id=v.id
group by g.vipreserv_id
order by id desc limit $lim");
          if (isset($tables[$table]))
          {   
              if ($parent_id!=null) $qr = $db->query($tables[$table],
              array('id'=>$parent_id)); else
              $qr = $db->query($tables[$table]);
              $this->res->rows= $qr->fetchAll(PDO::FETCH_OBJ);    
              $qr = $db->query("select count(*) from $table");
              $this->res->total = $db->fetchSingleValue($qr);
              if ($table=='evnamegl_guests' && $parent_id!=null)
              { $qr = $db->query('select * from evnamegl where id=:id',
                array('id'=>$parent_id));                
                $this->res->head = $db->fetchSingle($qr);
              }
              
          } else return $this->error(T('ACCESS_DENIED'), 1041);
          
          echo json_encode($this->res);
       }
              
       function ajxSaveEmailSettings()
       {  if (!$this->authGroup('admin')) return;
          $db = $this->cfg->db;
          $r = (object)$_POST;
          $d = new stdClass();
          $d->json = json_encode($r);
          $this->res->rd = $d;
          if ($db->updateObject('settings', $d, array('name'=>'email')))
          $this->res->info = T('EMAIL_SETTINGS_SAVED');
          echo json_encode($this->res);
       }
       
       function ajxLoadEmailSettings()
       {   if (!$this->authGroup('admin')) return;
           $db = $this->cfg->db;
           $qr = $db->query("select json from settings where name='email'");
           $this->res->row = json_decode($db->fetchSingleValue($qr));
           echo json_encode($this->res);
       }
       
       function ajxSavePassword()
       {  if (!$this->authGroup('admin')) return;
          $db = $this->cfg->db;
          $r = (object)$_POST;
          if ($r->enewpass1!=$r->enewpass2)
          { return $this->error(T('PW_DONT_MATCH'), 1058);
          }
          
          $auth = $this->cfg->user;
          $user = $auth->user;
          $info = null;
          if (!$auth->checkUserPassword($user->name, $r->epassold, $info))
          { return $this->error(T('PW_WRONG_OLD'), 1066);
          }
          
          $pass = $auth->hashPassword($r->enewpass1);
          try
          {
            $db->query('update mc_users set pass=:pass where id=:id',
            array('pass'=>$pass, 'id'=>$user->id));
            $this->res->info = T('PASSWORD_CHANGED');  
            echo json_encode($this->res);
          } catch (Exception $e)
          {  return $this->error($e->getMessage(), $e->getCode());
          }
       }

    }
?>
