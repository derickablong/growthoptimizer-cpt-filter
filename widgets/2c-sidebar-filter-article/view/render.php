<?php 
if (\Elementor\Plugin::$instance->editor->is_edit_mode()):
    do_action('go-preview-mode');
else:
 
$settings       = $this->get_settings_for_display();
$post_type      = $settings['post_type'];
$loop_template  = $settings['loop_template'];
$per_page       = $settings['posts_per_page'];
$columns        = $settings['grid_columns'];
$taxonomies     = [];
$taxonomy_icons = [];

# Taxonomies
foreach ($settings as $tax_name => $value) {
    if (!str_contains($tax_name, 'taxonomy_')) continue;    
    if (empty($value)) continue;

    $name         = str_replace('taxonomy_', '', $tax_name);
    $taxonomies[$name] = $value;
    
}

# Taxonomy icons
foreach ($settings as $tax_name => $value) {
    if (!str_contains($tax_name, 'tax_icon_')) continue;    
    if (empty($value)) continue;

    $icon                  = str_replace('tax_icon_', '', $tax_name);
    $taxonomy_icons[$icon] = $settings[$tax_name];
    
}
?>

<div class="cpt-2c-sidebar-filter-article" data-post_type="<?php echo $post_type ?>" data-per_page="<?php echo $per_page ?>" data-loop="<?php echo $loop_template ?>">
    <?php do_action('2c-sidebar-filter-article-parts-sidebar', $post_type, $taxonomies, $taxonomy_icons); ?>
    <?php do_action('2c-sidebar-filter-article-parts-content', $post_type); ?>
</div>
<?php endif; ?>