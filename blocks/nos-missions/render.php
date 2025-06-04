<?php

/**
 * Nos Missions Block Template
 *
 * @param array    $attributes Block attributes.
 * @param string   $content    Block default content.
 * @param WP_Block $block      Block instance.
 */

// Extract attributes
$title = isset($attributes['title']) ? $attributes['title'] : 'Nos Missions';
$missions = isset($attributes['missions']) ? $attributes['missions'] : [];
$backgroundColor = isset($attributes['backgroundColor']) ? $attributes['backgroundColor'] : '#ffffff';

// Generate unique ID for this block instance
$block_id = 'nos-missions-' . wp_unique_id();

// Block wrapper attributes
$wrapper_attributes = get_block_wrapper_attributes([
    'class' => 'nos-missions-block',
    'id' => $block_id,
]);
?>

<div <?php echo $wrapper_attributes; ?>>
    <div class="missions-full-width-background" style="background-color: <?php echo esc_attr($backgroundColor); ?>;">
        <div class="missions-container">
            <section class="missions">
                <?php if (!empty($title)) : ?>
                    <h2 class="missions-title"><?php echo esc_html($title); ?></h2>
                <?php endif; ?>

                <?php if (!empty($missions)) : ?>
                    <div class="missions-cards">
                        <?php foreach ($missions as $index => $mission) : ?>
                            <div class="mission-card">
                                <?php if (!empty($mission['icon'])) : ?>
                                    <div class="mission-icon"><?php echo esc_html($mission['icon']); ?></div>
                                <?php endif; ?>

                                <?php if (!empty($mission['title'])) : ?>
                                    <h3><?php echo esc_html($mission['title']); ?></h3>
                                <?php endif; ?>

                                <?php if (!empty($mission['description'])) : ?>
                                    <p><?php echo esc_html($mission['description']); ?></p>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </section>
        </div>
    </div>
</div>