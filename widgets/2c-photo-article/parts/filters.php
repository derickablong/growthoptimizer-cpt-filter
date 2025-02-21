<div class="elementor-widget <?php echo $button_class ?> filter-options">
    <div class="filter-item" id="sort">
        <a href="#" class="elementor-button filter-btn">
            <span>Sort by Date</span>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path d="M12.0716 13.3139L17.0216 8.36388C17.1139 8.26837 17.2242 8.19219 17.3462 8.13978C17.4682 8.08737 17.5995 8.05979 17.7322 8.05863C17.865 8.05748 17.9967 8.08278 18.1196 8.13306C18.2425 8.18334 18.3541 8.25759 18.448 8.35149C18.5419 8.44538 18.6162 8.55703 18.6665 8.67993C18.7167 8.80282 18.742 8.9345 18.7409 9.06728C18.7397 9.20006 18.7121 9.33128 18.6597 9.45329C18.6073 9.57529 18.5311 9.68564 18.4356 9.77788L12.7786 15.4349C12.5911 15.6224 12.3368 15.7277 12.0716 15.7277C11.8065 15.7277 11.5522 15.6224 11.3646 15.4349L5.70763 9.77788C5.61212 9.68564 5.53594 9.57529 5.48353 9.45329C5.43112 9.33128 5.40354 9.20006 5.40238 9.06728C5.40123 8.9345 5.42653 8.80282 5.47681 8.67993C5.52709 8.55703 5.60134 8.44538 5.69524 8.35149C5.78913 8.25759 5.90078 8.18334 6.02368 8.13306C6.14657 8.08278 6.27825 8.05748 6.41103 8.05863C6.54381 8.05979 6.67503 8.08737 6.79704 8.13978C6.91904 8.19219 7.02939 8.26837 7.12163 8.36388L12.0716 13.3139Z" fill="white"></path>
            </svg>
        </a>
        <div class="dropdown list sort">
            <a href="#" data-order="DESC" class="order selected ">
                <span class="checkbox">
                    <svg style="enable-background:new 0 0 24 24;" width="13" version="1.1" viewBox="0 0 24 24" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g id="info"></g><g id="icons"><path d="M10,18c-0.5,0-1-0.2-1.4-0.6l-4-4c-0.8-0.8-0.8-2,0-2.8c0.8-0.8,2.1-0.8,2.8,0l2.6,2.6l6.6-6.6   c0.8-0.8,2-0.8,2.8,0c0.8,0.8,0.8,2,0,2.8l-8,8C11,17.8,10.5,18,10,18z" id="check"></path></g></svg>
                </span>
                <span>Newest to oldest</span>
            </a>
                <a href="#" data-order="ASC" class="order">
                <span class="checkbox">
                    <svg style="enable-background:new 0 0 24 24;" width="13" version="1.1" viewBox="0 0 24 24" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g id="info"></g><g id="icons"><path d="M10,18c-0.5,0-1-0.2-1.4-0.6l-4-4c-0.8-0.8-0.8-2,0-2.8c0.8-0.8,2.1-0.8,2.8,0l2.6,2.6l6.6-6.6   c0.8-0.8,2-0.8,2.8,0c0.8,0.8,0.8,2,0,2.8l-8,8C11,17.8,10.5,18,10,18z" id="check"></path></g></svg>
                </span>
                <span>Oldest to newest</span>
            </a>
        </div>
    </div>

    <?php 
    foreach ($taxonomies as $tax_slug => $tax_title): 
        if (!taxonomy_exists($tax_slug) || $tax_title=='no') continue;
        $terms = get_terms( array(
            'taxonomy'   => $tax_slug,
            'hide_empty' => false,
        ) );
        ?>

    <div class="filter-item">
        <a href="#" class="elementor-button filter-btn filter-category">
            <span><?php echo $tax_title ?></span>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path d="M12.0716 13.3139L17.0216 8.36388C17.1139 8.26837 17.2242 8.19219 17.3462 8.13978C17.4682 8.08737 17.5995 8.05979 17.7322 8.05863C17.865 8.05748 17.9967 8.08278 18.1196 8.13306C18.2425 8.18334 18.3541 8.25759 18.448 8.35149C18.5419 8.44538 18.6162 8.55703 18.6665 8.67993C18.7167 8.80282 18.742 8.9345 18.7409 9.06728C18.7397 9.20006 18.7121 9.33128 18.6597 9.45329C18.6073 9.57529 18.5311 9.68564 18.4356 9.77788L12.7786 15.4349C12.5911 15.6224 12.3368 15.7277 12.0716 15.7277C11.8065 15.7277 11.5522 15.6224 11.3646 15.4349L5.70763 9.77788C5.61212 9.68564 5.53594 9.57529 5.48353 9.45329C5.43112 9.33128 5.40354 9.20006 5.40238 9.06728C5.40123 8.9345 5.42653 8.80282 5.47681 8.67993C5.52709 8.55703 5.60134 8.44538 5.69524 8.35149C5.78913 8.25759 5.90078 8.18334 6.02368 8.13306C6.14657 8.08278 6.27825 8.05748 6.41103 8.05863C6.54381 8.05979 6.67503 8.08737 6.79704 8.13978C6.91904 8.19219 7.02939 8.26837 7.12163 8.36388L12.0716 13.3139Z" fill="white"></path>
            </svg>
        </a>
        <div class="dropdown list categories">
            <?php 
            foreach ($terms as $term): 
                if (!term_exists($term->term_id)) continue;
                ?>
            <a href="#" data-term="<?php echo $term->term_id ?>" data-taxonomy="<?php echo $tax_slug ?>">
                <span class="checkbox">
                    <svg style="enable-background:new 0 0 24 24;" width="13" version="1.1" viewBox="0 0 24 24" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g id="info"></g><g id="icons"><path d="M10,18c-0.5,0-1-0.2-1.4-0.6l-4-4c-0.8-0.8-0.8-2,0-2.8c0.8-0.8,2.1-0.8,2.8,0l2.6,2.6l6.6-6.6   c0.8-0.8,2-0.8,2.8,0c0.8,0.8,0.8,2,0,2.8l-8,8C11,17.8,10.5,18,10,18z" id="check"></path></g></svg>
                </span>
                <span><?php echo $term->name ?></span>
            </a>
            <?php endforeach; ?>
        </div>
    </div>

    <?php endforeach; ?>
</div>
<div class="applied-filters loading"></div>