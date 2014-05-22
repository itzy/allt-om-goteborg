<?php if(is_object($user)): ?>
<form method="post" class="profileForm">
<fieldset>
<legend><font size="5px">Uppdatera <?=$user->name?>'s profil</font></legend>
<input type="hidden" name="redirect" value="<?=$this->url->create('')?>">
<input type="hidden" name="id" value="<?=$user->id?>">
<p><label>Acronym:</label> <input type="text" name="acronym" value="<?=$user->acronym?>"></p>
<p><label>Användarnamn: </label><input type="text" name="username" value="<?=$user->username?>"></p>
<p><label>Namn: </label><input type="text" name="name" value="<?=$user->name?>"></p>
<p><label>Födelsedatum</label> <input type="text" name="birthdate" value="<?=$user->birthdate?>"></p>
<p><label>Email:</label> <input type="text" name="email" value="<?=$user->email?>"></p>
<p><label></label><input type="submit" name="doSubmit" value="Spara" onClick="this.form.action = '<?=$this->url->create('users/save')?>'"></p>
</fieldset>
<?php else : ?>
<p>No user with that id was found</p>
<?php endif; ?>