<?php
   /* Fedotov Vitaliy (c) Ulan-Ude 2016 | kursruk@yandex.ru */
  $user = $this->cfg->user->user;
  if (!empty($user))
  {  echo '<h1>'.T("WELCOME").' '.$user->firstname.'!</h1>';
     echo '<form method="POST"><input type="hidden" name="logout" value="1" /><button type="submit" class="btn  btn-info btn-lg ">'.T('Logout').'</button></form>';  
  } else
  {
?>
<h1><?=T('Login') ?></h1>
<form method="POST">
  <div class="form-group">
    <label for="uname"><?=T('Login_name') ?></label>
    <input type="text" class="form-control" id="uname" name="uname" placeholder="<?=T('Login_name') ?>" >
  </div>
  <div class="form-group">
    <label for="upass"><?=T('Password') ?></label>
    <input type="password" class="form-control" id="upass" name="upass" placeholder="<?=T('Password') ?>">
  </div>
  <button type="submit" class="btn btn-default btn-info btn-lg "><?=T('Login') ?></button>
</form>
<?php
  }
?>
