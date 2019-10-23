<div class="wrap">
    <h2><?php _e('Bulk Edit Settings'); ?></h2>
    <hr />
    <h4><?php _e('By Default "Post" and "Page" Type are enabled for Bulk Edit.'); ?></h4>
    <hr />

    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <div class="alert alert-success" style="display:none;">                
            </div>
            <div class="alert alert-danger" style="display:none;">                
            </div>
        </div>
        <div class="col-md-3"></div>
    </div> 

    <div class="container">
        <form method="post" action="options.php">        
            <table class="form-table">            
                <tr valign="top">
                    <th scope="row"><?php _e("Enable Bulk Edit for :"); ?></th>
                    <td>
                        <select class="regular-select" name="bulk_edit_posts" id="bulk_edit_posts" multiple="multiple">
                            <?php
                            $args = array(
                                'public' => true,
                                '_builtin' => false,
                            );


                            $post_types = get_post_types($args, 'names', 'or');
                            
                            $allowed_post_types = get_option("bulk_edit_posts");

                            if (!empty($allowed_post_types)) {
                                $postTypeList = explode(",", $allowed_post_types);
                            } else {
                                $postTypeList = array('post', 'page');
                            }

                            if (!empty($post_types)) {
                                foreach ($post_types as $post_type) {
                                    $selected = "";

                                    if (in_array($post_type, $postTypeList)) {
                                        $selected = "checked=checked selected";
                                    }

                                    ?>
                                    <option value="<?php echo $post_type; ?>" <?php echo $selected; ?>><?php echo ucfirst($post_type); ?></option>
                                    <?php
                                }
                            }

                            ?>                                                
                        </select><br />
                        <span class="notice" style="font-size: 12px;"><?php _e("Select Post Types for which the bulk edit needs to be enabled."); ?></span>
                    </td>                
                </tr>                        
            </table>        
        </form>
        <div class="form-group">
            <button type="button" class="btn btn-success update-yp-posts"><span class="glyphicon glyphicon-plus"></span> Update Configuration</button>
            <div id="yp_spinner" class="yp_spinner spinner">            
                <p><?php _e('Please wait while we update bulk edit options.'); ?></p>
            </div> 
        </div>
    </div> 

</div>