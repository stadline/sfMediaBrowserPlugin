<?php if ($upload_form): ?>
    <?php $upload_form->getWidgetSchema()->setFormFormatterName('list') ?>
    <fieldset id="sf_media_browser_upload">
        <legend><?php echo __('Upload a file') ?></legend>
        <form action="<?php echo url_for('sf_media_browser_file_create') ?>" method="post" enctype="multipart/form-data">
            <?php echo $upload_form ?>
            <input type="submit" class="submit" value="<?php echo __('Save') ?>" />
        </form>
    </fieldset>
<?php endif;