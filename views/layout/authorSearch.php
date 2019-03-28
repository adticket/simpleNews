<div class="container">
    <form method="get" action="index">
        <div class="form-inline justify-content-center">
            <select name="author" class="form-control mr-sm-2">
                <option value="" selected>Alle</option>
                <?php foreach($authors AS $author):?>
                    <option value="<?php echo $author; ?>" <?php if(isset($_GET['author'])){ if(($_GET['author']==$author)) echo "selected"; }?>><?php echo $author; ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="btn btn-outline-secondary my-sm-0">Suchen</button>
        </div>
    </form>
</div>