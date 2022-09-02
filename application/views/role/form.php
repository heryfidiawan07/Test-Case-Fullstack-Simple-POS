<div id="modal-form" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form method="POST" id="form" action="">
                    <div class="form-group">
                        <label for="name">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" autocomplete="off" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description <span class="text-danger">*</span></label>
                        <textarea name="description" id="description" class="form-control" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>Permissions <span class="text-danger">*</span></label>
                        <?php foreach($permissions as $row): ?>
                            <?php if($row->parent_menu || !$row->parent_menu && !$row->parent_id): ?>
                                <div class="form-check">
                                    <input name="permissions[]" class="form-check-input permissions" 
                                        type="checkbox" value="<?=$row->id?>" id="<?=$row->name?>">
                                    <label class="form-check-label font-weight-bold text-primary" for="<?=$row->name?>">
                                        <?=$row->alias?>
                                    </label>
                                </div>
                                <?php foreach($permissions as $child): ?>
                                    <?php if($row->id == $child->parent_id): ?>
                                        <div class="form-check form-check-inline">
                                            <input name="permissions[]" class="form-check-input permissions" 
                                                type="checkbox" value="<?=$child->id?>" id="<?=$child->name?>">
                                            <label class="form-check-label font-weight-bold text-primary" for="<?=$child->name?>">
                                                <?=$child->name?>
                                            </label>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                                <hr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary px-4 mr-1">Save</button>
                        <button type="button" class="btn btn-secondary px-4" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>