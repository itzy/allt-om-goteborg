<h2>Delaktig i dessa frågor:</h2>

<?php foreach ($questions as $question) : ?>
	<a href="<?=$this->url->create('question/id/')?>/<?=$question->id?>"><font size="4px"><b><?=$question->title?></b></font></a><br>
<?php endforeach; ?>