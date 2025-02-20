<?php 
if (\Elementor\Plugin::$instance->editor->is_edit_mode()):
    do_action('go-preview-mode');
else:
 
$settings      = $this->get_settings_for_display();
$post_type     = $settings['post_type'];
$loop_template = $settings['loop_template'];
$taxonomies    = [];
$per_page      = $settings['posts_per_page'];

foreach ($settings as $tax_name => $value) {
    if (!str_contains($tax_name, 'taxonomy_')) continue;    
    if (empty($value)) continue;

    $name         = str_replace('taxonomy_', '', $tax_name);
    $taxonomies[$name] = $value;
    
}
?>

<div class="cpt-2c-photo-article" data-post_type="<?php echo $post_type ?>" data-per_page="<?php echo $per_page ?>" data-loop="<?php echo $loop_template ?>">
    <?php do_action('2c-photo-article-filter-options-template', $taxonomies, $settings['filter_button_class']) ?>
    <div class="filter-results loading"></div>    
    <div class="elementor-widget <?php echo $settings['load_more_button_class'] ?> load-more loading">
        <a class="elementor-button" href="#">
            <span>Load More</span>            
        </a>
    </div>    
</div>
<?php endif; ?>