<?php
   class authMenu extends wMod
   { function display()
     {   $user = $this->cfg->user->user;
         if (isset($user->id)) 
         {
?>
<ul class="nav navbar-nav navbar-right">
<li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?=$user->name?>&nbsp;<span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="javascript:logoutForm.submit()"><?=T('Logout')?></a></li>
                </ul>
</li>
</ul>
<form id="logoutForm" name="logoutForm" method="POST" action="/index.php" style="display:none"><input type="hidden" name="logout" value="1"></form>
<?php
         }
         else 
         {
?>
<ul class="nav navbar-nav navbar-right">
  <li class="active"><a href="/index.php/login"><?=T('Login')?></a>
</ul>
<?php
         }
     }
   }
?>
