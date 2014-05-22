<?php $thisUser = $user->getProperties(); ?>

<h1><?=$thisUser['name']?></h1>
<p>
	<?php $gravatar = get_gravatar($thisUser['email'], 150); ?>
	<img class="gravatar" align="right" src="<?=$gravatar?>" alt="<?=$thisUser['name']?>'s Gravatar">
	<i>Acronym:</i> <?=$thisUser['acronym']?><br>
	<i>Användarnamn: </i> <?=$thisUser['username']?><br>
	<i>Email:</i> <?=$thisUser['email']?><br>
	<i>Namn:</i> <?=$thisUser['name']?><br>
	<i>Födelsedatum:</i> <?=$thisUser['birthdate']?><br>
	<i>Antal poster:</i> <?=$thisUser['posts']?><br>
	<i>Skapad:</i> <?=$thisUser['created']?><br>
	<i>Aktiv senast:</i> <?=$thisUser['active']?><br>
	<?php 
	if($thisUser['updated'])
	{
		echo "<i>Uppdaterad: </i>" . $thisUser['updated'] . "<br>";
	}
	
	if($thisUser['deleted'])
	{
		echo "<i>Borttagen: </i>" . $thisUser['deleted'] . "<br>";
	}
	?>	
</p>