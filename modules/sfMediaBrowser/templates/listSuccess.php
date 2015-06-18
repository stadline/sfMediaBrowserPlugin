<?php sfMediaBrowserUtils::loadAssets('list') ?>
<?php use_helper('I18N') ?>

<div id="sf_media_browser_forms"><!--
    --><?php include_partial('sfMediaBrowser/uploadForm', array('upload_form' => $upload_form)) ?><!--
    --><?php include_partial('sfMediaBrowser/directoryForm', array('dir_form' => $dir_form)) ?><!--
--></div>


<h1 id="sf_media_browser_title"><?php echo sprintf(__('Current directory : %s'), '<small>' . $display_dir . '</small>') ?></h1>


<ul id="sf_media_browser_list">
    <li class="placeholder">
        <?php echo __('The directory is empty.') ?>
    </li>

    <?php if ($parent_dir): ?>
        <li class="up">
            <div class="icon">
                <?php echo link_to(image_tag('/sfMediaBrowserPlugin/images/icons/up.png'), $current_route, array_merge($sf_data->getRaw('current_params'), array('dir' => $parent_dir))) ?>
            </div>
            <label class="name" title="..">..</label>
        </li>
    <?php endif ?>

    <?php foreach ($dirs as $dir): ?>
        <li class="folder">
            <div class="icon">
                <?php echo link_to(image_tag('/sfMediaBrowserPlugin/images/icons/folder.png'), $current_route, array_merge($sf_data->getRaw('current_params'), array('dir' => $relative_dir . '/' . $dir)), array('title' => $dir)) ?>
            </div>
            <label class="name" title="<?php echo $dir ?>"><?php echo $dir ?></label>
            <div class="action"><?php echo link_to('delete', 'sf_media_browser_dir_delete', array('sf_method' => 'delete', 'directory' => urlencode($relative_dir . '/' . $dir)), array('class' => 'delete', 'title' => sprintf(__('Delete folder "%s"'), $dir))) ?></div>
        </li>
    <?php endforeach ?>

    <?php foreach ($files as $file): ?>
        <li class="file">
            <?php include_component('sfMediaBrowser', 'icon', array('file_url' => $relative_url . '/' . $file, 'relative_dir' => $relative_dir)) ?>
        </li>
    <?php endforeach ?>
</ul>

<script type="text/javascript">
    var delete_msg = "<?php echo __('Are you sure you want to delete this item ?') ?>";
    var move_file_url = "<?php echo url_for('sf_media_browser_move') ?>";
    var rename_file_url = "<?php echo url_for('sf_media_browser_rename') ?>";
</script>