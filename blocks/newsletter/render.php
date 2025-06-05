<?php

/**
 * Render du bloc Newsletter
 *
 * @package Mon-Theme-ACA
 */

// Extraction des attributs
$section_title = $attributes['sectionTitle'] ?? 'Abonnez-vous à notre newsletter';
$subtitle = $attributes['subtitle'] ?? 'Restez informé des dernières actualités, événements et initiatives de l\'ACA.';
$button_text = $attributes['buttonText'] ?? 'S\'inscrire';
$placeholder_text = $attributes['placeholderText'] ?? 'Votre adresse email';
$background_color = $attributes['backgroundColor'] ?? '#28A745';
$text_color = $attributes['textColor'] ?? '#FFFFFF';
$button_color = $attributes['buttonColor'] ?? '#2D9B8A'; // Updated to theme's teal green
$button_text_color = $attributes['buttonTextColor'] ?? '#FFFFFF'; // Updated to white

// Génération d'un ID unique pour le formulaire
$form_id = 'newsletter-form-' . uniqid();

// Styles spécifiques pour ce bloc
$styles = "
    .newsletter-section-{$form_id} {
        background-color: {$background_color};
        color: {$text_color};
        padding: 60px 20px;
        text-align: center;
    }
    
    .newsletter-section-{$form_id} h2 {
        font-size: 2.2em;
        margin-top: 0;
        margin-bottom: 15px;
        font-weight: 600;
    }
    
    .newsletter-section-{$form_id} .subtitle {
        font-size: 1.1em;
        margin-bottom: 35px;
        line-height: 1.6;
        max-width: 550px;
        margin-left: auto;
        margin-right: auto;
    }
    
    .newsletter-section-{$form_id} .newsletter-form {
        display: flex;
        justify-content: center;
        align-items: stretch;
        max-width: 500px;
        margin: 0 auto;
    }
    
    .newsletter-section-{$form_id} .newsletter-form input[type='email'] {
        flex-grow: 1;
        padding: 15px 20px;
        font-size: 1em;
        border: none;
        border-radius: 5px;
        background-color: #FFFFFF;
        color: #343A40;
        margin-right: -1px;
        z-index: 1;
    }
    
    .newsletter-section-{$form_id} .newsletter-form input[type='email']::placeholder {
        color: #6C757D;
        opacity: 1;
    }
    
    .newsletter-section-{$form_id} .newsletter-form input[type='email']:focus {
        outline: 2px solid #1F6B5C;
        outline-offset: -1px;
    }
    
    .newsletter-section-{$form_id} .newsletter-form button {
        padding: 15px 25px;
        font-size: 1em;
        border: none;
        border-radius: 5px;
        background-color: {$button_color};
        color: {$button_text_color};
        cursor: pointer;
        font-weight: bold;
        white-space: nowrap;
        margin-left: 10px;
        transition: background-color 0.3s ease;
    }
    
    .newsletter-section-{$form_id} .newsletter-form button:hover {
        background-color: #1F6B5C; /* Dark Teal on hover */
    }
    
    @media (max-width: 600px) {
        .newsletter-section-{$form_id} h2 {
            font-size: 1.8em;
        }
        
        .newsletter-section-{$form_id} .subtitle {
            font-size: 1em;
        }
        
        .newsletter-section-{$form_id} .newsletter-form {
            flex-direction: column;
        }
        
        .newsletter-section-{$form_id} .newsletter-form input[type='email'] {
            margin-right: 0;
            margin-bottom: 10px;
            width: 100%;
            box-sizing: border-box;
        }
        
        .newsletter-section-{$form_id} .newsletter-form button {
            width: 100%;
            box-sizing: border-box;
            margin-left: 0;
        }
    }
";

// Classes du bloc
$wrapper_attributes = get_block_wrapper_attributes([
    'class' => 'newsletter-section newsletter-section-' . $form_id . ' alignfull'
]);

// Si l'attribut align existe et n'est pas "full", on supprime la classe alignfull
if (isset($attributes['align']) && $attributes['align'] !== 'full') {
    $wrapper_attributes = get_block_wrapper_attributes([
        'class' => 'newsletter-section newsletter-section-' . $form_id
    ]);
} else {
    // Par défaut, on met en pleine largeur
    $wrapper_attributes = get_block_wrapper_attributes([
        'class' => 'newsletter-section newsletter-section-' . $form_id . ' alignfull'
    ]);
}

?>

<style>
    <?php echo $styles; ?>
</style>

<section <?php echo $wrapper_attributes; ?>>
    <h2><?php echo esc_html($section_title); ?></h2>
    <p class="subtitle"><?php echo esc_html($subtitle); ?></p>

    <form class="newsletter-form" id="<?php echo esc_attr($form_id); ?>" action="#" method="post">
        <?php wp_nonce_field('newsletter_subscription', 'newsletter_nonce'); ?>
        <input type="email" name="newsletter_email" placeholder="<?php echo esc_attr($placeholder_text); ?>" required>
        <button type="submit"><?php echo esc_html($button_text); ?></button>
    </form>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('<?php echo esc_js($form_id); ?>');

        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const email = this.querySelector('input[name="newsletter_email"]').value;
                const nonce = this.querySelector('input[name="newsletter_nonce"]').value;

                // Ici vous pouvez ajouter le code pour envoyer les données à votre API d'inscription newsletter
                // Par exemple avec fetch :

                /*
                fetch(ajaxurl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({
                        action: 'newsletter_subscription',
                        email: email,
                        nonce: nonce
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Merci pour votre inscription !');
                        this.reset();
                    } else {
                        alert(data.data.message || 'Une erreur est survenue.');
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    alert('Une erreur est survenue lors de l\'inscription.');
                });
                */

                // Pour l'instant, affichons simplement un message
                alert('Merci de vous être inscrit avec l\'email: ' + email);
                this.reset();
            });
        }
    });
</script>