<?php
 /* Fedotov Vitaliy (c) Ulan-Ude 2016 | kursruk@yandex.ru */
 include('lib/params.php');
 include('lib/phpmailer.php');
  
 class ajxsignup extends wAjax
 {  function ajxSaveSign()
    {   $d = (object)$_POST; 
        $db = $this->cfg->db;
        $email = filter_var($d->email, FILTER_SANITIZE_EMAIL);
        try
          { 

            $q = $db->query("select usersubj,userbody,adminsubj,adminbody
            from templates where name='signup'");
            $t = $db->fetchSingle($q);

            $params = getParams($db,'email');
            
            // send email to the user
            $mail = getDBPHPMailer($params);
            $mail->setFrom($params->smtpsender, $params->smtpsendername);
            $mail->addAddress($email);               // Name is optional
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
            $maila->isHTML(true);                       // Set email format to HTML
            
            
            $maila->Subject = $t->adminsubj;
            $maila->Body    = str_replace('$email',$email, $t->adminbody);

            if(!$maila->send()) {               
               $this->error($maila->ErrorInfo, 4043);
               return false;
            } else {
                $this->res->info='Message has been sent';                                
                $db->query("insert into signup (created, email) values (current_timestamp, :email)",
                    array('email'=>$email));
            }

          } catch (Exception $e)
          {   if ($e->getCode()!=23000) $this->error($e->getMessage(), $e->getCode());
          }
          echo json_encode($this->res);
    }
 }

?>
