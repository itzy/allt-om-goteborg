<h1><?=$title?></h1>
 
<?php foreach ($users as $user) : ?>
<p>
	<?php 
	$thisUser = $user->getProperties(); 
    $gravatar = 'http://www.gravatar.com/avatar/' . md5(strtolower(trim($thisUser['email']))) . '.jpg?s=60';
	?>
	<img class="gravatar" align="left" src="<?=$gravatar?>" alt="<?=$thisUser['name']?>'s Gravatar">
	<i>Acronym:</i> <a href="<?=$this->url->create('users/id/')?>/<?=$thisUser['id']?>"><?=$thisUser['acronym']?></a><br>
	<i>Användarnamn: </i> <?=$thisUser['username']?><br>
	<i>Email:</i> <?=$thisUser['email']?><br>
	<i>Namn</i> <?=$thisUser['name']?><br>
	<i>Födelsedatum: </i><?=$thisUser['birthdate']?><br>
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
	<hr>
</p>

<?php endforeach; ?>
 