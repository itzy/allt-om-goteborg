<h1><?=$title?></h1>
<hr>
<?php foreach ($questions as $question) : ?>
<p>
	<a href="<?=$this->url->create('question/id/')?>/<?=$question->id?>"><font size="4px"><b><?=$question->title?></b></font></a>
	<span class="topheaderright"><i><?=$question->updated?></i></span>
	<br>
	<?php
	$tags = explode(',', $question->tags);

	echo "Tags: <i>";
	foreach($tags as $tag)
	{
		?>
		<a href="<?=$this->url->create('tag/name/')?>/<?=$tag?>"><?=$tag?></a>, 
		<?php
	}
	echo "</i>";
	?>
	<span class="topheaderright"><i>Svar: <?=$question->nrofposts?></i></span>
</p>
<?php endforeach; ?>

<br><br><br>
<?php
$user = $this->session->get('logged_in');
$userID = $user;

if(!empty($userID))
{
?>
<a href="<?=$this->url->create('newQuestion')?>"><b><i>Ny Fråga</i></b></a>
<?php
}