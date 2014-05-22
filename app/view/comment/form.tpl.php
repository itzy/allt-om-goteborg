<script>
    $(document).ready(function(){
        <?php if(!isset($edit)) : ?>
            $(".comment-form").hide();
            $("#hide").hide();
        <?php else : ?>
            $("#show").hide();
        <?php endif; ?>
        $("#show").click(function() {
            $(".comment-form").show();
            $("#show").hide();
            $("#hide").show();
        });
        $("#hide").click(function(){
            $(".comment-form").hide();
            $("#hide").hide();
            $("#show").show();
        });
    });
</script>

<button id="show">Lägg till kommentar</button>
<button id="hide">Stäng kommentar fält</button>
<br><br>
<div class='comment-form'>
    <form method=post>
        <input type=hidden name="redirect" value="<?=$this->url->create('')?>">
        <fieldset>
        <legend>Lämna en kommentar</legend>
        <p><label>Kommentar:<br/><textarea name='content'><?=$content?></textarea></label></p>
        <p><label>Namn:<br/><input type='text' name='name' value='<?=$name?>'/></label></p>
        <p><label>Hemsida:<br/><input type='text' name='web' value='<?=$web?>'/></label></p>
        <p><label>Email:<br/><input type='text' name='mail' value='<?=$mail?>'/></label></p>
        <p class=buttons>
            <input type='submit' name='addComment' value='Comment' onClick="this.form.action = '<?=$this->url->create('comment/add')?>'"/>
            <input type='reset' value='Reset'/>
            <input type='submit' name='doRemoveAll' value='Remove all' onClick="this.form.action = '<?=$this->url->create('comment/remove-all')?>'"/>
        </p>
        <output><?=$output?></output>
        </fieldset>
    </form>
</div>
