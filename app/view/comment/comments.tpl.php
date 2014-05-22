<?php if (is_array($comments) && !empty($comments)) : ?>

<h2>Kommentarer</h2>

<div class='comment'>
<?php foreach ($comments as $id => $comment) : ?>
<p class='name'><?=$comment['name']?></p>
<p class='content'><?=$comment['content']?></p>
<br>
<p><i>Email:</i> <?=$comment['mail']?></p>
<p><i>Hemsida:</i> <?=$comment['web']?></p>
<p><i>IP:</i> <?=$comment['ip']?></p>

<p class='comment-toolbar'>
	<form method=post class='comment'>
	<?=$comment['thumbs']?> - 
	<input type=hidden name="redirect" value="<?=$this->url->create('')?>">
	<input type=hidden name="id" value="<?=$id?>">
	<input type='submit' name='thumbsUp' value='Thumbs Up' onClick="this.form.action = '<?=$this->url->create('comment/thumbs-up')?>'"/> 
	<input type='submit' name='thumbsDown' value='Thumbs Down' onClick="this.form.action = '<?=$this->url->create('comment/thumbs-down')?>'"/>
	<input type='submit' name='edit' value='Editera'/>
	<?php 
	if($comment['thumbs'] == 0)
	{
		?>
		<input type='submit' name='remove' value='Ta bort' onClick="this.form.action = '<?=$this->url->create('comment/remove')?>'"/>
		<?php
	}
	?>
</form>
</p>
<?php endforeach; ?>
</div>
<?php endif; ?>