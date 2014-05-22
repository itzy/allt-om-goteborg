<?php if (is_array($comments) && !empty($comments)) : ?>

<h2><?=$title?></h2>

<div class='comment'>
<?php foreach ($comments as $comment) : ?>
<?php $thisComment = $comment->getProperties(); ?>
<p class='name'><?=$thisComment['name']?></p>
<p class='content'><?=$thisComment['content']?></p>
<br>
<p><i>Email:</i> <?=$thisComment['mail']?></p>
<p><i>Hemsida:</i> <?=$thisComment['web']?></p>
<p><i>IP:</i> <?=$thisComment['ip']?></p>

<p class='comment-toolbar'>
	<form method=post class='comment'>
	<?=$thisComment['thumbs']?> - 
	<input type=hidden name="redirect" value="<?=$this->url->create('')?>">
	<input type=hidden name="id" value="<?=$thisComment['id']?>">
	<input type='submit' name='thumbsUp' value='Thumbs Up' onClick="this.form.action = '<?=$this->url->create('comment/thumbs-up/' . $thisComment['id'] . '/')?>'"/> 
	<input type='submit' name='thumbsDown' value='Thumbs Down' onClick="this.form.action = '<?=$this->url->create('comment/thumbs-down/' . $thisComment['id'] . '/')?>'"/>
	<input type='submit' name='edit' value='Editera' onClick="this.form.action = '<?=$this->url->create('comment/edit/' . $thisComment['id'] . '/')?>'"/>
	<?php 
	if($thisComment['thumbs'] == 0)
	{
		?>
		<input type='submit' name='remove' value='Ta bort' onClick="this.form.action = '<?=$this->url->create('comment/remove/' . $thisComment['id'] . '/')?>'"/>
		<?php
	}
	?>
</form>
</p>
<?php endforeach; ?>
</div>
<?php endif; ?>