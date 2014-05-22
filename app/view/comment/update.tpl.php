<?php if(is_object($comment)): ?>
<form method="post">
<input type="hidden" name="redirect" value="<?=$this->url->create('')?>">
<input type="hidden" name="id" value="<?=$comment->id?>">
<p>Namn:<br> <input type="text" name="name" value="<?=$comment->name?>"></p>
<p>Email:<br> <input type="text" name="mail" value="<?=$comment->mail?>"></p>
<p>Hemsida: <br> <input type="text" name="web" value="<?=$comment->web?>"></p>
<p>Kommentar: <br> <textarea name="content"><?=$comment->content?></textarea></p>
<p><input type="submit" name="doSubmit" value="Spara" onClick="this.form.action = '<?=$this->url->create('comment/save')?>'"></p>

<?php else : ?>
<p>No comment with that id was found.</p>
<?php endif; ?>