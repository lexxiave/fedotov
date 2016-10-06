<?php
  include('lib/mime.php');
  output_headers('evnamegl.csv');
  if ($this->inGroup('admin'))
  {   $db = $this->db;
      $h = array('id','created','firstname','lastname','email','guest firstname','guest lastname');
      $qr=$db->query('select 
    e.id,
    e.created,
    e.firstname,
    e.lastname,
    e.email,
    g.firstname,
    g.lastname
from evnamegl e
join evnamegl_guests g on g.engl_id=e.id
order by id desc');
      $fp = fopen('php://output', 'w');
      fputcsv($fp, $h);
      while ($r=$qr->fetch(PDO::FETCH_NUM))
      { fputcsv($fp, $r);
      }
      fclose($fp);
   } else echo 'Access denied. Please login.';
?>
