<?php
  /* Fedotov Vitaliy (c) Ulan-Ude 2016 | kursruk@yandex.ru */
  class wConfig extends wMain
  { public $conf = null;
      // Database settings
      // Open first: http://yoursite.com/index.php/setup
      public $dbtype = 'mysql';
      public $dbhost = 'localhost';
      public $dbname = 'db200';  // Database name
      public $dbuser = 'root';
      public $dbpass = '';       // Password
      public $dbcharset = 'utf8';
      
      // System settings
      public $title = 'Forms';
      public $author = 'Fedotov V.V.';
      public $description = 'Forms';
      public $lang = 'EN';
      protected $template = 'templates/template.php';
      
      // Custom settings
      public $email_templates = array('signup','evnamegl','vipreserv');
  }
?>
