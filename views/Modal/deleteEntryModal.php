<div class="modal fade" id="deleteEntryModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" action="editEntry?eid=<?php echo $entry['entryID']; ?>">
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
                    <input type="submit" name="delete" value="Eintrag löschen" class="btn btn-danger">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Abbrechen
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>