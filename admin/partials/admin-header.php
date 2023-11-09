<?php
/**
* Almedis Dashboard - Header Content
*
*
* @package    almedis-forms
* @subpackage admin-header
*
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
?>
<div class="almedis-forms-header">
    <h1><?php echo get_admin_page_title(); ?></h1>
    <img src="<?php echo WP_PLUGIN_URL . '/almedis-forms/admin/img/logo.png'; ?>" alt="Almedis" class="img-fluid logo" />
</div>