<?php $currentQuestion = $question->getProperties(); ?>

<h1 class="gradient"><?=$currentQuestion['title']?></h1>

<?php foreach($answers as $answer) : ?>
<div id="question">
	<span class="postedby">
		<a href="<?=$this->url->create('users/username/')?>/<?=$answer->username?>"><b><?=$answer->username?></b></a>
		<?php $gravatar = get_gravatar($answer->email); ?>
		<img src="<?=$gravatar?>" alt="<?=$answer->username?>'s Gravatar">
		<br>
		<?php
		if($answer->thumbs > 0) : echo "<font color='#52D017'>"; endif;
		if($answer->thumbs < 0) : echo "<font color='red'>"; endif;

		echo "<b>" . $answer->thumbs . "</b>";
		?>
		</font>
		<?php
		$user = $this->session->get('logged_in');

		if((!empty($user)) && ($user['username'] != $answer->username))
		{
		?>
		<a href="<?=$this->url->create('question/thumbsUp/' . $answer->id . '/' . $currentQuestion['id']);?>"><i class="fa fa-angle-up"></i></a>
		<a href="<?=$this->url->create('question/thumbsDown/' . $answer->id . '/' . $currentQuestion['id']);?>"><i class="fa fa-angle-down"></i></a>
		<?php
		}
		?>
	</span>

	<?php
	$content = $this->textFilter->doFilter($answer->content, 'shortcode, markdown');
	?>

	<p><span class="content"><?=$content?></span></p>
	<p><span class="created"><?=$answer->created?></span></p>
</div>
<?php 
endforeach;

if(!empty($user))
{
	?>
	<form method="post" class="profileForm">
	<input type="hidden" name="question_id" value="<?=$currentQuestion['id']?>">
	<p><label>Meddelande: </label><textarea name="content"></textarea></p>
	<p><input type="submit" value="Lägg till svar" name="doSave" onClick="this.form.action = '<?=$this->url->create('question/addAnswer/')?>'"></p>
	</form>
	<?php
}