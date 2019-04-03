<?php if(isset($error)):?>
    <div class="container">
        <p class="border border-danger px-md-1">
            <?php echo $error; ?>
        </p>
    </div>
<?php endif; ?>

<div class="container h3">
    Eintrag bearbeiten
</div>

<div class="container">
    <form method="post" action="editEntry?eid=<?php echo $entry['entryID']; ?>">
        <div class="form-group">
            <input type="text" class="form-control" name="blogtitle" value="<?php echo $entry['blogtitle'] ?>"/>
        </div>
        <div class="form-group">
            <textarea class="form-control" name="blogcontent" rows="10"><?php echo $entry['blogcontent']; ?></textarea>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary col-sm-3" name="update" value="Änderung speichern">
            <input type="submit" class="btn btn-secondary col-sm-3" name="discard" value="Änderung verwerfen">
            <button type="button" class="btn btn-danger col-sm-3 float-right" data-toggle="modal" data-target="#deleteModal">
                Eintrag löschen
            </button>
        </div>
    </form>
</div>



<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">
                    Eintrag löschen
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Wollen Sie diesen Eintrag wirklich löschen?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger">
                    Eintrag löschen
                </button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    Abbrechen
                </button>
            </div>
        </div>
    </div>
</div>