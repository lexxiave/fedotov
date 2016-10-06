<div>
    <div class="row">
        <div class="col-lg-4">
             <h1><?=T($this->cfg->title)?></h1>
             <div class="list-group" id="admin-menu">
                    <a href="javascript:" data-view="emailtmpl" class="list-group-item"><?=T('EMAIL_TEMPLATES')?></a>
                    <a href="javascript:" data-view="emailsettings" class="list-group-item"><?=T('EMAIL_SETTINGS')?></a>
                    <a href="javascript:" data-view="signuplist" class="list-group-item"><?=T('SIGNUP_LIST')?></a>
                    <a href="javascript:" data-view="evnamegl" class="list-group-item"><?=T('ENGL')?></a>
                    <a href="javascript:" data-view="vipreserv" class="list-group-item"><?=T('VIP_RESERVATION')?></a>
                    <a href="javascript:" data-view="changepass" class="list-group-item"><?=T('CHANGE_PASSWORD')?></a>
             </div>
        </div>
        <div class="col-lg-8" id="views">
        </div>
    </div>
</div>
