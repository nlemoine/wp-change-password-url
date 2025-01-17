<?php

declare(strict_types=1);

namespace n5s\WpChangePassordUrl;

/*
 * Plugin Name:       WP Change Password URL
 * Plugin URI:        https://github.com/nlemoine/wp-change-password-url
 * Description:       A tiny (mu) plugin that adds support for the well-known URL for changing passwords
 * Version:           1.0
 * Requires at least: 6.0
 * Requires PHP:      8.1
 * Author:            Nicolas Lemoine
 * Author URI:        https:/github.com/nlemoine
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 */

/**
 * Redirect user to profile page when visiting the well-known change password URL.
 *
 * @see https://www.w3.org/TR/change-password-url/
 * @see https://web.dev/articles/change-password-url?hl=en
 * @see https://core.trac.wordpress.org/ticket/51173
 *
 * @return void
 */
function redirect_well_knwow_change_password(): void
{
    global $wp_rewrite;

    if (!(is_404() && $wp_rewrite->using_permalinks())) {
        return;
    }

    $wellKnownPasswordUrl = home_url('.well-known/change-password', 'relative');
    if ($wellKnownPasswordUrl === untrailingslashit($_SERVER['REQUEST_URI'])) {
        wp_redirect(admin_url('profile.php'));
        exit;
    }
}

add_action('template_redirect', __NAMESPACE__ . '\\redirect_well_knwow_change_password', 1000);
