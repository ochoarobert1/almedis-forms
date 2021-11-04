<?php

/**
* Almedis Forms - Dectvation Hooks
*
*
* @package    almedis-forms
* @subpackage deactivation_hook
*
*/

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Method pluginprefix_deactivate
 *
 * @return void
 */
function almedis_deactivate()
{
    unregister_post_type('pedidos');
    flush_rewrite_rules();
}
register_deactivation_hook(__FILE__, 'almedis_deactivate');
