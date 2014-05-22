<?php

echo "<h1>" . $title . "</h1>";

foreach($tags as $tag)
{
	?>
	<a href="<?=$this->url->create('tag/name/')?>/<?=$tag->title?>"><?=$tag->title?></a><br>
	<?php
}

?>