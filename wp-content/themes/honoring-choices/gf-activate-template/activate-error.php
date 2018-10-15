<?php

global $gw_activate_template;

$result = $gw_activate_template->result;

// if the blog is already active or if the blog is taken, display respective messages
if ( $gw_activate_template->is_blog_already_active( $result ) || $gw_activate_template->is_blog_taken( $result ) ):
    $signup = $result->get_error_data();
    ?>

    <h2><?php _e('Account has already been activated!'); ?></h2>
<?php else: ?>

    <h2><?php _e('An error occurred during the activation'); ?></h2>
    <p><?php echo $result->get_error_message(); ?></p>

<?php endif; ?>