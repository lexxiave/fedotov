<?php
 /* Fedotov Vitaliy (c) Ulan-Ude 2016 | kursruk@yandex.ru */
 include('lib/params.php');
 include('lib/phpmailer.php');
  
 class ajxvipreserv extends wAjax
 {  function ajxSave()
    {   $d = (object)$_POST; 
        $db = $this->cfg->db;

        $r = new stdClass();
        $r->firstname = filter_var($d->firstname, FILTER_SANITIZE_STRING);
        $r->lastname = filter_var($d->lastname, FILTER_SANITIZE_STRING);
        $r->email = filter_var($d->email, FILTER_SANITIZE_EMAIL);
        $r->bookdate = filter_var($d->bookdate, FILTER_SANITIZE_STRING);
        $r->phone = filter_var($d->phone, FILTER_SANITIZE_NUMBER_INT);
        $r->vippackage_id = filter_var($d->vippackage_id, FILTER_SANITIZE_NUMBER_INT);

        try
          { 

            $q = $db->query("select usersubj,userbody,adminsubj,adminbody
            from templates where name='vipreserv'");
            $t = $db->fetchSingle($q);

            $params = getParams($db,'email');
            
            // send email to the user
            $mail = getDBPHPMailer($params);
            $mail->setFrom($params->smtpsender, $params->smtpsendername);
            $mail->addAddress($r->email);               // Name is optional
            $mail->isHTML(true);                     // Set email format to HTML
            
            
            $mail->Subject = $t->usersubj;
            $mail->Body    = $t->userbody;
         
            // $mail->AltBody = '';

            if(!$mail->send()) {               
               $this->error($mail->ErrorInfo, 4043);
               return false;
            } 
            
            // send email to the admin
            $maila = getDBPHPMailer($params);
            $maila->setFrom($params->smtpsender, $params->smtpsendername);
            $maila->addAddress($params->adminemail);    // Name is optional
            $maila->isHTML(false);                      // Set email format to HTML
            
            
            $maila->Subject = $t->adminsubj;
            
            $body = str_replace('$email',$r->email, $t->adminbody);
            $body = str_replace('$firstname',$r->firstname, $body);
            $body = str_replace('$lastname',$r->lastname, $body);
            $body = str_replace('$bookdate',$r->bookdate, $body);
            $body = str_replace('$phone',$r->phone, $body);
            $body = str_replace('$vippackage',$r->vippackage_id, $body);
            
            
            $guests = '';
            foreach($d->rows as $row)
            { $sr = (object)$row;              
              $firstname = filter_var($sr->firstname, FILTER_SANITIZE_STRING);  
              $lastname = filter_var($sr->lastname, FILTER_SANITIZE_STRING);
              $guests.="First Name: $firstname\nLast Name: $lastname\n\n";
            }
            $body = str_replace('$guests',$guests, $body); 
            $maila->Body = $body;

            if(!$maila->send()) {               
               $this->error($maila->ErrorInfo, 4043);
               return false;
            } else {
                $this->res->info='Message has been sent';                                
                
                // saving data
                
                $db->insertObject('vipreserv',$r);        
                $id=$db->db->lastInsertId();
                
                $this->res->id = $id;
                foreach($d->rows as $row)
                { $sr = (object)$row;
                  $r = new stdClass();
                  $r->firstname = filter_var($sr->firstname, FILTER_SANITIZE_STRING);  
                  $r->lastname = filter_var($sr->lastname, FILTER_SANITIZE_STRING);
                  $r->vipreserv_id = $id;
                  $db->insertObject('vipreserv_guests',$r);
                }
                
            }

          } catch (Exception $e)
          {   if ($e->getCode()!=23000) $this->error($e->getMessage(), $e->getCode());
          }
          echo json_encode($this->res);
    }
 }

?>
