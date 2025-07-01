<?php
/**
 * Render du bloc Newsletter (Version dynamique)
 *
 * @package Mon-Theme-ACA
 */

// Extraction des attributs avec valeurs par défaut
$attributes = $attributes ?? [];
$section_title = $attributes['sectionTitle'] ?? 'Restez Informé';
$subtitle = $attributes['subtitle'] ?? 'Recevez les dernières actualités, analyses de marché et opportunités...';
$button_text = $attributes['buttonText'] ?? "S'abonner";
$placeholder_text = $attributes['placeholderText'] ?? 'Votre adresse email';
$background_color = $attributes['backgroundColor'] ?? '#2D9B8A';
$text_color = $attributes['textColor'] ?? '#FFFFFF';
$button_color = $attributes['buttonColor'] ?? '#28A745';
$button_text_color = $attributes['buttonTextColor'] ?? '#FFFFFF';
$accent_color = '#A8E6CF'; // Couleur d'accent pour les sous-textes

// Génération d'un ID unique pour le formulaire et la section
$unique_id = 'newsletter-' . uniqid();

// Classes du bloc
$wrapper_attributes = get_block_wrapper_attributes([
    'id' => esc_attr($unique_id) . '-section',
    'class' => 'newsletter-container-block',
    'style' => 'background-color:' . esc_attr($background_color) . '; color:' . esc_attr($text_color) . ';'
]);
?>

<section <?php echo $wrapper_attributes; ?>>
    <div class="newsletter-background-pattern">
        <div class="shape1"></div>
        <div class="shape2"></div>
        <div class="shape3"></div>
        <div class="shape4"></div>
    </div>

    <div class="newsletter-content-wrapper">
        <div class="newsletter-header">
            <svg class="newsletter-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
            <h2 class="newsletter-title" style="color: <?php echo esc_attr($text_color); ?>;"><?php echo esc_html($section_title); ?></h2>
            <p class="newsletter-subtitle" style="color: <?php echo esc_attr($accent_color); ?>;"><?php echo esc_html($subtitle); ?></p>
        </div>

        <form id="<?php echo esc_attr($unique_id); ?>-form" class="newsletter-form">
            <div class="newsletter-input-group">
                <input type="email" name="email" placeholder="<?php echo esc_attr($placeholder_text); ?>" class="newsletter-input" required>
            </div>
            <button type="submit" class="newsletter-button" style="background-color: <?php echo esc_attr($button_color); ?>; color: <?php echo esc_attr($button_text_color); ?>;">
                <span class="newsletter-button-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                </span>
                <span class="newsletter-button-text"><?php echo esc_html($button_text); ?></span>
                <span class="newsletter-button-loader"></span>
            </button>
        </form>

        <p class="newsletter-privacy-text" style="color: <?php echo esc_attr($accent_color); ?>;">Nous respectons votre vie privée. Désabonnement possible à tout moment.</p>

        <div class="newsletter-features">
            <div class="newsletter-feature-item">
                <div class="feature-icon-wrapper"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg></div>
                <h3 class="feature-title">Newsletter Hebdomadaire</h3>
                <p class="feature-description" style="color: <?php echo esc_attr($accent_color); ?>;">Actualités et analyses chaque semaine</p>
            </div>
            <div class="newsletter-feature-item">
                <div class="feature-icon-wrapper"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg></div>
                <h3 class="feature-title">Contenu Exclusif</h3>
                <p class="feature-description" style="color: <?php echo esc_attr($accent_color); ?>;">Rapports et études réservés aux abonnés</p>
            </div>
            <div class="newsletter-feature-item">
                <div class="feature-icon-wrapper"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg></div>
                <h3 class="feature-title">Invitations Prioritaires</h3>
                <p class="feature-description" style="color: <?php echo esc_attr($accent_color); ?>;">Accès privilégié aux événements ACA</p>
            </div>
        </div>
    </div>

    <div class="newsletter-success-message" style="display: none;">
        <div class="success-content">
             <svg class="success-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
            <h2 class="success-title">Merci pour votre inscription !</h2>
            <p class="success-text" style="color: <?php echo esc_attr($accent_color); ?>;">Vous recevrez bientôt nos dernières actualités et informations exclusives sur la filière cotonnière africaine.</p>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const section = document.getElementById('<?php echo esc_js($unique_id); ?>-section');
    if (!section) return;

    const form = document.getElementById('<?php echo esc_js($unique_id); ?>-form');
    const contentWrapper = section.querySelector('.newsletter-content-wrapper');
    const successMessage = section.querySelector('.newsletter-success-message');
    const button = form.querySelector('.newsletter-button');
    const buttonText = button.querySelector('.newsletter-button-text');
    const buttonLoader = button.querySelector('.newsletter-button-loader');

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const email = form.querySelector('input[type="email"]').value;
        if (!email) return;

        button.disabled = true;
        buttonText.style.display = 'none';
        buttonLoader.style.display = 'inline-block';

        setTimeout(() => {
            button.disabled = false;
            buttonText.style.display = 'inline';
            buttonLoader.style.display = 'none';
            contentWrapper.style.display = 'none';
            successMessage.style.display = 'flex';
        }, 1500);
    });
});
</script>