<?php

echo "<h1>Sökresultat för: " . $title . "</h1>";

foreach($searchResults as $result)
{
	if($for == "Användare")
	{
		?>
		<a href="<?=$this->url->create('users/id/')?>/<?=$result->id?>"><?=$result->name?></a><br>
		<?php
	} 
	else if($for == "Frågor") 
	{
		?>
		<a href="<?=$this->url->create('question/id/')?>/<?=$result->id?>"><?=$result->title?></a><br>
		<?php	
	}
	else if($for == "Taggar")
	{
		?>
		<a href="<?=$this->url->create('tags/id/')?>/<?=$result->id?>"><?=$result->title?></a><br>
		<?php
	}
}