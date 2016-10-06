<h1><?=T('DATABASE_SETUP')?></h1>
<?php  
   
   function getRaw($cfg)
   {   $dbconn = "$cfg->dbtype:host=$cfg->dbhost";       
       $db = new PDO($dbconn, $cfg->dbuser, $cfg->dbpass );
       $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
       $db->exec("set names $cfg->dbcharset;");       
       return $db;
   }
   
   function alert($msg, $type='info')
   { echo "<div class=\"alert alert-$type\">$msg</div>";
   }

 
   $cfg = $this->cfg;   
   if ($cfg->db==null)
   {    try
        {
            $db = getRaw($this->cfg);
            if ($db!=null)
            {
                alert( T('DB_CONNECTION_ESTABLISHED') );
                try
                {
                    $scfile = 'pages/setup/install.sql';
                    $script = explode(';', file_get_contents($scfile));
                    try
                    {
                        $db->query("create database $cfg->dbname;");
                        $db->query("use $cfg->dbname;");
                    } catch (Exception $e)
                    { alert(T('CANT_CREATE_DB')." $cfg->dbname<br>".$e->getMessage(), 'danger');
                    }
                    foreach($script as $q)
                    { if (trim($q)!='')
                      {   $q.=';';
                          try 
                          { $db->query($q);
                          } catch (Exception $e)
                          { alert($q.'<br />'.$e->getMessage(), 'danger');
                          }
                      }         
                    }
                } catch (Exception $e)
                {   alert("Can't load script $scfile.<br>".$e->getMessage(), 'danger');
                }

                alert(T('DATABASE').' <b>'.$cfg->dbname.'</b> '.T('CREATED'), 'info');
            }
        } catch (Exception $e)
        {  alert(T('CHECK_CONFIG_USER_SETTINGS'), 'danger');
        }
   } else alert( T('DATABASE_EXISTS') , 'warning');
   // global $_TRANSLATIONS;
   // print_r($_TRANSLATIONS);   
?>
