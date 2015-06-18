<?php if ($dir_form): ?>
    <?php $dir_form->getWidgetSchema()->setFormFormatterName('list') ?>
    <fieldset id="sf_media_browser_mkdir">
        <legend><?php echo __('Create a new directory') ?></legend>
        <form action="<?php echo url_for('sf_media_browser_dir_create') ?>" method="post">
            <?php echo $dir_form ?>
            <input type="submit" class="submit" value="<?php echo __('Create') ?>" />
        </form>
    </fieldset>
<?php endif;