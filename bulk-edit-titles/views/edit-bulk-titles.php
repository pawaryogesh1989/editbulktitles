<?php
wp_head();

$raw_post_array = sanitize_text_field(esc_attr($_REQUEST['id']));
$post_array = explode(",", $raw_post_array);

foreach ($post_array as $key => $value) {
    if (!is_numeric($value)) {
        unset($post_array[$key]);
    }
}

?>
<form name="bulk-form" id="bulk-form" action="" method="post">
    <br />
    <?php
    foreach ($post_array as $key => $value) {

        ?>
        <div class="bulk-title-edit">
            <input type="text" class="bulk-title-text" name="text-<?php echo intval($value); ?>" id="<?php echo intval($value); ?>" value="<?php echo get_the_title(intval($value)); ?>" />
        </div>
        <?php
    }

    ?>
    <input class="bulk-button" type="button" name="bulk-update" id="bulkupdate" value="Update" />
</form>

<?php
wp_footer();

?>