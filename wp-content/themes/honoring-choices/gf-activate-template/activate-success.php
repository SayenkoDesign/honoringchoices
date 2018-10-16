<?php

global $gw_activate_template;

extract( $gw_activate_template->result );

$url = is_multisite() ? get_blogaddress_by_id( (int) $blog_id ) : home_url('', 'http');
$user = new WP_User( (int) $user_id );

?>

<h2><?php _e('Account is now active!'); ?></h2>

<div id="signup-welcome">
    <p><span class="h3"><?php _e('Username:'); ?></span> <?php echo $user->user_login ?></p>
</div>