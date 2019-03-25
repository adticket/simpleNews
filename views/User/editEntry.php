<div class="container h3">
    Eintrag bearbeiten
</div>

<div class="container">
    <form method="post" action="editEntry?eid=<?php echo $entry['entryID']; ?>">
        <div class="form-group">
            <input type="text" class="form-control" name="blogtitle" value="<?php echo $entry['blogtitle'] ?>"required/>
        </div>
        <div class="form-group">
            <textarea class="form-control" name="blogcontent" rows="10"><?php echo $entry['blogcontent']; ?></textarea>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-success" name="update" value="Änderung speichern">
            <input type="submit" class="btn btn-secondary" name="discard" value="Änderung verwerfen">
            <input type="submit" class="btn btn-danger" name="delete" value="Eintrag löschen">
        </div>
    </form>
</div>