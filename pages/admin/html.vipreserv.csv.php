<?php
  include('lib/mime.php');
  output_headers('vipreserv.csv');
  if ($this->inGroup('admin'))
  {   $db = $this->db;
      $h = array('id','created','firstname','lastname','email','booking date','contact number','package','guest firstname','guest lastname');
      $qr=$db->query('select 
    v.id,
    v.created,
    v.firstname,
    v.lastname,
    v.email,
    v.bookdate,
    v.phone,
    v.vippackage_id as package,
    g.firstname,
    g.lastname
from vipreserv v
join vipreserv_guests g on g.vipreserv_id=v.id
order by id desc');
      $fp = fopen('php://output', 'w');
      fputcsv($fp, $h);
      while ($r=$qr->fetch(PDO::FETCH_NUM))
      { fputcsv($fp, $r);
      }
      fclose($fp);
   } else echo 'Access denied. Please login.';
?>
