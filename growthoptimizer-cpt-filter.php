<?php
/**
 * Plugin Name:     Growth Optimizer CPT Filter
 * Plugin URI:      https://growthoptimizer.com
 * Description:     Custom filter for CPT
 * Author:          Growth Optimizer
 * Author URI:      https://growthoptimizer.com/
 * Text Domain:     go-kit
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         growthoptimizer-cpt-filter
 */
namespace GO_CPT_Filter;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define('GROWTH_OPTIMIZER_FILTER_DIR', plugin_dir_path( __FILE__ ));
define('GROWTH_OPTIMIZER_FILTER_URL', plugin_dir_url( __FILE__ ));
define('BUTTON_CLASSES', [
    'primary'         => 'Primary',
    'secondary'       => 'Secondary',
    'secondary white' => 'Secondary White',
    'tertiary'        => 'Tertiary'
]);



# 2c Photo Article
require_once(GROWTH_OPTIMIZER_FILTER_DIR.'class/class_2c-photo-article.php');
# 2c Sidebar Filter Article
require_once(GROWTH_OPTIMIZER_FILTER_DIR.'class/class_2c-sidebar-filter-article.php');
# CPT Filter
require_once(GROWTH_OPTIMIZER_FILTER_DIR.'class/class_cpt-filter.php');

# Starter the CPT filter widget
$go_cpt_filter = new GO_CPT_Filter(
    GROWTH_OPTIMIZER_FILTER_DIR,
    GROWTH_OPTIMIZER_FILTER_URL
);