<?php

/**
 * Rendu du bloc Partenaires
 */

// Récupération des attributs
$title = isset($attributes['title']) ? $attributes['title'] : 'Nos Partenaires';
$partners = isset($attributes['partners']) ? $attributes['partners'] : [];
$background_color = isset($attributes['backgroundColor']) ? $attributes['backgroundColor'] : '#ffffff';
$show_borders = isset($attributes['showBorders']) ? $attributes['showBorders'] : true;

// Classes CSS
$wrapper_attributes = get_block_wrapper_attributes([
    'class' => 'partners-block'
]);

// Styles inline
$section_styles = [
    'background-color: ' . esc_attr($background_color),
    'padding: 40px 20px',
    'text-align: center'
];

if ($show_borders) {
    $section_styles[] = 'border-top: 5px solid #e0e0e0';
    $section_styles[] = 'border-bottom: 5px solid #e0e0e0';
}

$section_style = implode('; ', $section_styles);
?>

<div <?php echo $wrapper_attributes; ?>>
    <div class="partners-section" style="<?php echo esc_attr($section_style); ?>">
        <?php if (!empty($title)) : ?>
            <h2 class="partners-title">
                <?php echo esc_html($title); ?>
            </h2>
        <?php endif; ?>

        <?php if (!empty($partners)) : ?>
            <div class="partners-logos">
                <?php foreach ($partners as $partner) : ?>
                    <?php
                    $image_url = !empty($partner['url']) ? $partner['url'] : '';
                    $image_alt = !empty($partner['alt']) ? $partner['alt'] : '';
                    $partner_link = !empty($partner['link']) ? $partner['link'] : '';
                    ?>

                    <div class="partner-logo">
                        <?php if (!empty($partner_link)) : ?>
                            <a href="<?php echo esc_url($partner_link); ?>" target="_blank" rel="noopener noreferrer">
                            <?php endif; ?>

                            <?php if (!empty($image_url)) : ?>
                                <img
                                    src="<?php echo esc_url($image_url); ?>"
                                    alt="<?php echo esc_attr($image_alt); ?>"
                                    loading="lazy" />
                            <?php else : ?>
                                <div class="partner-placeholder">
                                    <!-- Placeholder vide si pas d'image -->
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($partner_link)) : ?>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else : ?>
            <div class="partners-empty">
                <p><?php esc_html_e('Aucun partenaire configuré.', 'mon-theme-aca'); ?></p>
            </div>
        <?php endif; ?>
    </div>
</div>