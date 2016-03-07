jQuery(document).ready(function () {

    jQuery(".bulkactions #doaction").click(function () {
        var bulk_value = jQuery("[name=action]").val();

        if (bulk_value == "bulk-edit-title") {

            var allVals = [];
            var bulk_counter = 0;

            jQuery('input[type=checkbox]:checked').each(function () {
                allVals.push(jQuery(this).val());
                bulk_counter++;
            });

            bulk_counter = bulk_counter - 5;

            if (bulk_counter > 0) {
                var url = bulkactionscript.pluginsUrl + "/views/edit-bulk-titles.php?id=" + allVals + "&KeepThis=true&TB_iframe=true&width=800&height=600";
                tb_show("Bulk Post Rename", url);
                return false;
            } else {
                alert("Please Select records to edit.");
                return false;
            }
        }
    });


    jQuery(document).on('click', '#bulkupdate', function () {
        if (confirm("Are you sure want to change the selected titles?")) {

            var alltitles = [];
            var allid = [];

            jQuery("form#bulk-form :input[type=text]").each(function () {
                alltitles.push(jQuery(this).val());
                allid.push(jQuery(this).attr('id'));
            });

            var data = {
                'action': 'bulk_update_post_titles',
                'post_title': alltitles,
                'post_id': allid,
            };

            jQuery.post(bulkactionscript.site_url + '/wp-admin/admin-ajax.php', data, function (response) {
                if (response == 'done') {
                    tb_remove();
                    window.parent.location = bulkactionscript.site_url + '/wp-admin/edit.php?method=success';
                }
                else {
                    alert("Oops! Something went wrong. Please try later.");
                    return false;
                }
            });
        }
    });
});