<div class="container">
    <form method="post" action="index">
        <div class="form-inline justify-content-center">
            <select name="author" class="form-control mr-sm-2">
                <option selected value="">Alle</option>
                <?php foreach($authors AS $author):?>
                    <option value="<?php echo $author; ?>"<?php if(isset($_POST['author'])){ if(($_POST['author']==$author)) echo "selected"; }?>><?php echo $author; ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="btn btn-outline-secondary my-sm-0">Suchen</button>
        </div>
    </form>
</div>