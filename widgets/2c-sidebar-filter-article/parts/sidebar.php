<div class="go-sidebar">
    <div class="filters">
        <h3 class="sidebar-title">Filters</h3>
        
        <div class="taxonomies">
        <?php 
        foreach ($taxonomies as $tax_slug => $tax_title): 
            $terms = get_terms( array(
                'taxonomy'   => $tax_slug,
                'hide_empty' => false,
            ) );
            ?>

            <div class="taxonomy-group">
                <div class="taxonomy-title">
                    <span class="icon">
                        <?php \Elementor\Icons_Manager::render_icon( $icons[$tax_slug], [ 'aria-hidden' => 'true' ] ); ?>
                    </span>
                    <h6>By <?php echo $tax_title ?></h6>
                    <span class="arrow">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M6 15L12 9L18 15" stroke="#121619" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                </div>
                <div class="terms">

                    <label for="view-all-<?php echo $tax_slug ?>">
                        <input type="checkbox" class="term" id="view-all-<?php echo $tax_slug ?>" value="view-all" checked>
                        <span class="checkbox">
                            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="8" viewBox="0 0 10 8" fill="none">
                                <path d="M3.58583 5.06059L1.46451 2.93927L0.050293 4.35348L3.58583 7.88901L9.94979 1.52505L8.53557 0.11084L3.58583 5.06059Z" fill="white"/>
                            </svg>
                        </span>
                        <span class="label">View All</span>
                    </label>

                    <?php foreach ($terms as $term): ?>

                        <label for="term-<?php echo $term->term_id ?>">
                            <input type="checkbox" class="term" id="term-<?php echo $term->term_id ?>" value="<?php echo $term->term_id ?>">
                            <span class="checkbox">
                                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="8" viewBox="0 0 10 8" fill="none">
                                    <path d="M3.58583 5.06059L1.46451 2.93927L0.050293 4.35348L3.58583 7.88901L9.94979 1.52505L8.53557 0.11084L3.58583 5.06059Z" fill="white"/>
                                </svg>
                            </span>
                            <span class="label"><?php echo $term->name ?></span>
                        </label>

                    <?php endforeach; ?>
                </div>
            </div>


        <?php endforeach; ?>
        </div>
    </div>
</div>