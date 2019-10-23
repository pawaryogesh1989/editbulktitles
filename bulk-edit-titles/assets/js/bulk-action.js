/**
 * 
 * A jQuery document on ready block
 * @param {type} param
 */
jQuery(document).ready(function () {

    /**
     * To bind the select element with Multi JS library
     */
    if (jQuery("select#bulk_edit_posts").length) {
        jQuery('select#bulk_edit_posts').multiSelect();
    }



    /**
     * Function to update user roles in the database
     */
    if (jQuery(".update-yp-posts").length) {

        jQuery(".update-yp-posts").click(function () {

            if (confirm("Are you sure want to modify bulk edit actions for selectec Post Types?")) {
                jQuery(".yp_spinner").show();

                var data = {
                    'action': 'bulkAddRemovePostTypes',
                    'bulk_edit_posts': jQuery("#bulk_edit_posts").val(),
                };
                jQuery.post(bulkactionscript.bulk_ajax_url, data, function (response) {

                    jQuery(".yp_spinner").hide();
                    var message = (JSON.parse(response));

                    if (message.status == "success") {
                        jQuery('.alert-success').html(message.message);
                        jQuery('.alert-success').show();
                        setTimeout(function () {
                            jQuery('.alert-success').fadeOut('slow');
                            // document.location.reload();
                        }, 2000);
                    }
                    else {
                        jQuery('.alert-danger').html(message.message);
                        jQuery('.alert-danger').show();
                        setTimeout(function () {
                            jQuery('.alert-danger').fadeOut('slow');
                        }, 2000);
                    }
                });

            } else {
                return false;
            }
        });
    }

    /**
     * Function to handle bulk edit
     */
    jQuery(".bulkactions #doaction").click(function () {
        
        var bulk_value = jQuery("[name=action]").val();

        if (bulk_value == "bulk-edit-title") {

            var allVals = [];
            var bulk_counter = 0;

            jQuery('tbody#the-list input[type=checkbox]:checked').each(function () {
                allVals.push(jQuery(this).val());
                bulk_counter++;
            });

           // bulk_counter = bulk_counter - 5;

            if (bulk_counter > 0) {
                var url = bulkactionscript.site_url + "/wp-admin/admin-ajax.php?action=edit_bulk_titles&id=" + allVals + "&KeepThis=true&TB_iframe=true&width=800&height=400";
                tb_show("Bulk Post Rename", url);
                return false;
            } else {
                alert("Please Select records to edit.");
                return false;
            }
        }
    });


    /**
     * Function to update the titles of selected Posts
     */
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
                    var url = parent.location.href;

                    if (url.indexOf('?') > -1) {
                        url += '&method=success'
                    } else {
                        url += '?method=success'
                    }

                    window.parent.location = url;
                } else {
                    alert("Oops! Something went wrong. Please try later.");
                    return false;
                }
            });
        }
    });
});