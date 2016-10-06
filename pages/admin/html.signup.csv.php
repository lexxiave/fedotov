<?php
  include('lib/mime.php');
  output_headers('signup.csv');
  if ($this->inGroup('admin'))
  {   $db = $this->db;
      $h = array('id','created','email');
      $qr=$db->query('select '.implode(',',$h).' from signup order by id desc');
      $fp = fopen('php://output', 'w');
      fputcsv($fp, $h);
      while ($r=$qr->fetch(PDO::FETCH_NUM))
      { fputcsv($fp, $r);
      }
      fclose($fp);
   } else echo 'Access denied. Please login.';
?>
