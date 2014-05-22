<script>
    $(document).ready(function(){
        $("#user-panel").click(function() {
            $("#user-panel-links").toggle();
        });
    });
</script>

<span class='topheaderBox'>
	<span class='topheaderright'>
		<?php
		$user = $this->session->get('logged_in');
		$userID = $user;

		if(!empty($userID))
		{
		?>
			<button class="user-panel" id="user-panel">User-Panel <i class="fa fa-angle-down"></i></button>
			<div id="user-panel-links">
				<ul>
					<li><a href="<?=$this->url->create('users/id')?>">Profil</a></li>
					<li><a href="<?=$this->url->create('users/update')?>">Editera Profil</a></li>
					<li><a href="<?=$this->url->create('users/logout')?>">Logga ut</a></li>
				</ul>
			</div>
		<?php
		} else {
			?>
			<button class="user-panel" id="user-panel">Logga in <i class="fa fa-angle-down"></i></button>
			<div id="user-panel-links">
				<ul>
					<form method="post">
					<input type=hidden name="redirect" value="<?=$this->url->create('')?>">
					<li><input type="text" name="username" placeholder="Användarnamn"></li>
					<li><input type="password" name="password" placeholder="Lösenord"></li>
					<li><input type="submit" id="loginSubmit" name="login" value="Logga in" onClick="this.form.action = '<?=$this->url->create('users/login')?>'"></li>
				</form>
				</ul>
			</div>
			<?php
		}
		?>
		<form method="post" class="searchForm">
			<select name="searchIn">
				<option>Kategori att söka i...</option>
				<option>Användare</option>
				<option>Frågor</option>
				<option>Taggar</option>
			</select>
			<input type="search" name="keyword" placeholder="Sökord">
			<input type="submit" name="doSearch" value="Sök" onClick="this.form.action = '<?=$this->url->create('search/for/')?>'">
		</form>
	</span>
</span>