<?php
/**
 * Nos Missions Block Template
 *
 * @param array $attributes Block attributes.
 * @param string $content Block default content.
 * @param WP_Block $block Block instance.
 */

// Extract attributes
$title = isset($attributes['title']) ? $attributes['title'] : 'Nos Missions';
$subtitle = isset($attributes['subtitle']) ? $attributes['subtitle'] : '';
$missions = isset($attributes['missions']) ? $attributes['missions'] : [];
$showCallToAction = isset($attributes['showCallToAction']) ? $attributes['showCallToAction'] : true;
$ctaTitle = isset($attributes['ctaTitle']) ? $attributes['ctaTitle'] : 'Rejoignez Notre Mission';
$ctaSubtitle = isset($attributes['ctaSubtitle']) ? $attributes['ctaSubtitle'] : 'Participez au développement de l\'excellence cotonnière africaine';
$ctaButtonText = isset($attributes['ctaButtonText']) ? $attributes['ctaButtonText'] : 'Devenir Partenaire';
$ctaButtonUrl = isset($attributes['ctaButtonUrl']) ? $attributes['ctaButtonUrl'] : '#';

// Generate unique ID for this block instance
$block_id = 'nos-missions-' . wp_unique_id();

// Block wrapper attributes
$wrapper_attributes = get_block_wrapper_attributes([
    'class' => 'nos-missions-block',
    'id' => $block_id,
]);
?>

<div <?php echo $wrapper_attributes; ?>>
    <section class="missions-section">
        <div class="missions-container">
            <!-- Section Header -->
            <?php if (!empty($title) || !empty($subtitle)) : ?>
                <div class="missions-header">
                    <?php if (!empty($title)) : ?>
                        <h2 class="missions-title"><?php echo esc_html($title); ?></h2>
                    <?php endif; ?>
                    <?php if (!empty($subtitle)) : ?>
                        <p class="missions-subtitle"><?php echo esc_html($subtitle); ?></p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <!-- Missions Grid -->
            <?php if (!empty($missions)) : ?>
                <div class="missions-grid">
                    <?php foreach ($missions as $index => $mission) : ?>
                        <div class="mission-card">
                            <div class="mission-content">
                                <?php if (!empty($mission['icon'])) : ?>
                                    <div class="mission-icon-wrapper">
                                        <div class="mission-icon-circle">
                                            <span class="mission-icon"><?php echo esc_html($mission['icon']); ?></span>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if (!empty($mission['title'])) : ?>
                                    <h3 class="mission-title"><?php echo esc_html($mission['title']); ?></h3>
                                <?php endif; ?>
                                
                                <?php if (!empty($mission['description'])) : ?>
                                    <p class="mission-description"><?php echo esc_html($mission['description']); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- Call to Action -->
            <?php if ($showCallToAction && (!empty($ctaTitle) || !empty($ctaSubtitle) || !empty($ctaButtonText))) : ?>
                <div class="missions-cta">
                    <div class="cta-content">
                        <?php if (!empty($ctaTitle)) : ?>
                            <h3 class="cta-title"><?php echo esc_html($ctaTitle); ?></h3>
                        <?php endif; ?>
                        
                        <?php if (!empty($ctaSubtitle)) : ?>
                            <p class="cta-subtitle"><?php echo esc_html($ctaSubtitle); ?></p>
                        <?php endif; ?>
                        
                        <?php if (!empty($ctaButtonText)) : ?>
                            <div class="cta-button-wrapper">
                                <a href="<?php echo esc_url($ctaButtonUrl); ?>" class="cta-button">
                                    <?php echo esc_html($ctaButtonText); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>
</div>