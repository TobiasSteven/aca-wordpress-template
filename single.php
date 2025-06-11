<?php get_header(); ?>

<main class="flex-1 bg-white">
    <nav class="bg-[#f9fbf9] py-4 px-6 md:px-10">
        <ol class="list-none p-0 inline-flex items-center text-sm text-gray-600">
            <li class="flex items-center">
                <a class="hover:text-[#2D9B8A]" href="<?php echo esc_url(home_url('/')); ?>">Accueil</a>
                <i class="fas fa-chevron-right text-sm mx-2 text-gray-500"></i>
            </li>
            <li class="flex items-center">
                <a class="hover:text-[#2D9B8A]" href="<?php echo esc_url(get_post_type_archive_link('post')); ?>">Actualités</a>
                <i class="fas fa-chevron-right text-sm mx-2 text-gray-500"></i>
            </li>
            <li class="text-[#1F6B5C] font-medium">
                <?php echo esc_html(get_the_title()); ?>
            </li>
        </ol>
    </nav>

    <?php while (have_posts()) : the_post(); ?>

        <section class="relative h-[400px] md:h-[500px] w-full">
            <?php if (has_post_thumbnail()) : ?>
                <div
                    class="absolute inset-0 bg-cover bg-center"
                    style="background-image: url('<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'full')); ?>');">
                </div>
            <?php else : ?>
                <div class="absolute inset-0 bg-gradient-to-r from-[#2D9B8A] to-[#1F6B5C]"></div>
            <?php endif; ?>
            <div class="absolute inset-0 hero-overlay"></div>
            <div class="relative h-full flex flex-col items-center justify-center text-center text-white p-6 md:p-10">
                <h1 class="text-4xl md:text-[36px] font-bold leading-tight tracking-tight mb-4">
                    <?php the_title(); ?>
                </h1>
                <div class="flex flex-wrap justify-center items-center gap-x-4 gap-y-2 text-[#A8E6CF] text-sm">
                    <span><?php echo esc_html(get_the_date('j F Y')); ?></span>
                    <span class="hidden md:inline">|</span>
                    <span>Par <?php echo esc_html(get_the_author()); ?></span>
                    <?php
                    $categories = get_the_category();
                    if (!empty($categories)) : ?>
                        <span class="hidden md:inline">|</span>
                        <a href="<?php echo esc_url(get_category_link($categories[0]->term_id)); ?>" class="hover:text-white transition-colors">
                            <?php echo esc_html($categories[0]->name); ?>
                        </a>
                    <?php endif; ?>
                    <?php
                    $content = get_post_field('post_content', get_the_ID());
                    $word_count = str_word_count(strip_tags($content));
                    $reading_time = ceil($word_count / 200); // Estimation: 200 mots par minute
                    ?>
                    <span class="hidden md:inline">|</span>
                    <span>Lecture: <?php echo esc_html($reading_time); ?> min</span>
                </div>
            </div>
        </section>

        <div class="max-w-7xl mx-auto py-12 px-6 md:px-10">
            <div class="flex flex-col lg:flex-row gap-12">
                <article class="w-full lg:w-2/3">
                    <div class="prose max-w-none text-[#343A40] leading-relaxed">
                        <p class="mb-6">
                            L'Afrique, continent aux vastes étendues de terres arables,
                            est depuis longtemps un acteur majeur dans la production
                            mondiale de coton. Cependant, les défis liés aux méthodes
                            agricoles traditionnelles, aux changements climatiques et à
                            l'accès limité aux ressources ont souvent entravé le plein
                            potentiel de cette industrie vitale. Ces dernières années,
                            l'intégration de la technologie dans les pratiques de
                            culture du coton a commencé à transformer le paysage
                            agricole africain, ouvrant la voie à une productivité
                            accrue, à une meilleure durabilité et à des conditions de
                            vie améliorées pour des millions d'agriculteurs.
                        </p>
                        <h2 class="text-2xl font-bold text-[#1F6B5C] mt-8 mb-4">
                            L'avènement de l'agriculture de précision
                        </h2>
                        <p class="mb-6">
                            L'agriculture de précision, grâce à des outils tels que le
                            GPS, les drones et les capteurs IoT, permet aux agriculteurs
                            de gérer leurs champs avec une précision sans précédent. Ces
                            technologies fournissent des données en temps réel sur
                            l'humidité du sol, les niveaux de nutriments et la santé des
                            cultures, permettant des interventions ciblées. Par exemple,
                            l'irrigation de précision minimise le gaspillage d'eau, une
                            ressource précieuse dans de nombreuses régions d'Afrique,
                            tandis que l'application ciblée d'engrais et de pesticides
                            réduit les coûts et l'impact environnemental. Des pays comme
                            le Bénin et le Mali ont vu des projets pilotes montrer des
                            augmentations significatives de rendement grâce à ces
                            techniques.
                        </p>
                        <img
                            alt="Champ de coton avec drone"
                            class="rounded-lg my-8 w-full h-auto object-cover"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuCsv2_agzdigiq4RYR18pVzqNkyABhUV7umMh8MwXI1ZIy5Bq2X2rfKdiI1qnRwzPiJRK4J5MIWNBcQK8HjNpnNsln2keHSnK3-XC4VEhXdeK8YCjdFYzrPyp8KzKglk9BLP4LLXi7TpTC9EWEN0RiQ1swRJrgtZE-jEwp01O2hCyTJbV7Q_AdrP-qwrptW1xl28-RQZZQAzvCdJsZDsDz71kL8FrcraqHsTRaNsO8VvLZBiO9bkhFlEvTfKAHQu38Ynk7Cs1mamgg" />
                        <h3 class="text-xl font-semibold text-[#1F6B5C] mt-8 mb-4">
                            Biotechnologie et amélioration des semences
                        </h3>
                        <p class="mb-6">
                            La biotechnologie joue un rôle crucial dans le développement
                            de variétés de coton résistantes aux parasites et aux
                            maladies, ainsi qu'adaptées aux conditions climatiques
                            locales. Le coton Bt (Bacillus thuringiensis), par exemple,
                            a permis de réduire considérablement l'utilisation de
                            pesticides chimiques, améliorant la sécurité des
                            agriculteurs et la biodiversité. L'accès à des semences
                            améliorées, bien que parfois controversé et nécessitant un
                            cadre réglementaire solide, offre un potentiel immense pour
                            augmenter les rendements et la qualité du coton africain.
                            Des institutions de recherche locales, en collaboration avec
                            des partenaires internationaux, travaillent activement à
                            développer des variétés adaptées aux contextes africains.
                        </p>
                        <blockquote class="blockquote-style">
                            <p>
                                "L'adoption de nouvelles technologies est essentielle pour
                                que l'Afrique puisse non seulement maintenir sa position
                                sur le marché mondial du coton, mais aussi pour améliorer
                                la résilience et la rentabilité de ses petits exploitants
                                agricoles." - Dr. Amani Kouassi, Expert en agriculture
                                tropicale.
                            </p>
                        </blockquote>
                        <h2 class="text-2xl font-bold text-[#1F6B5C] mt-8 mb-4">
                            Solutions mobiles et accès à l'information
                        </h2>
                        <p class="mb-6">
                            La prolifération des téléphones mobiles en Afrique a ouvert
                            de nouvelles voies pour la diffusion d'informations
                            agricoles. Des applications mobiles fournissent aux
                            agriculteurs des prévisions météorologiques, des conseils
                            sur les meilleures pratiques, des informations sur les prix
                            du marché et un accès aux services financiers. Ces
                            plateformes facilitent également la mise en relation des
                            agriculteurs avec les acheteurs et les fournisseurs
                            d'intrants, renforçant ainsi les chaînes de valeur. Au
                            Kenya, par exemple, des services basés sur SMS ont aidé les
                            agriculteurs à mieux planifier leurs semis et à négocier de
                            meilleurs prix pour leur récolte.
                        </p>
                        <div class="my-8 aspect-w-16 aspect-h-9">
                            <iframe
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen=""
                                class="w-full h-full rounded-lg"
                                frameborder="0"
                                src="https://www.youtube.com/embed/dQw4w9WgXcQ"
                                title="YouTube video player"></iframe>
                        </div>
                        <h3 class="text-xl font-semibold text-[#1F6B5C] mt-8 mb-4">
                            Défis et perspectives
                        </h3>
                        <p class="mb-6">
                            Malgré les promesses de la technologie, plusieurs défis
                            subsistent. L'accès limité au capital, le manque
                            d'infrastructures (comme l'électricité et l'internet fiable
                            en zones rurales), et un niveau d'alphabétisation parfois
                            bas peuvent freiner l'adoption des nouvelles technologies.
                            De plus, il est crucial de s'assurer que ces innovations
                            soient inclusives et bénéficient aux petits exploitants, qui
                            constituent la majorité des producteurs de coton en Afrique.
                            Des politiques gouvernementales favorables, des
                            investissements dans la formation et les infrastructures,
                            ainsi que des partenariats public-privé sont essentiels pour
                            surmonter ces obstacles. L'Association Africaine du Coton
                            (ACA) s'engage à promouvoir l'intégration de technologies
                            appropriées et durables pour renforcer la filière cotonnière
                            sur le continent. Pour en savoir plus sur nos initiatives,
                            <a class="link-style" href="#">cliquez ici</a>.
                        </p>
                    </div>
                    <div class="mt-10 pt-6 border-t border-gray-200">
                        <h4 class="text-lg font-semibold text-[#1F6B5C] mb-3">
                            Partager cet article :
                        </h4>
                        <div class="flex space-x-3">
                            <a
                                class="social-share-button p-2 rounded-full flex items-center justify-center"
                                href="#">
                                <i class="fab fa-facebook-f text-xl"></i>
                            </a>
                            <a
                                class="social-share-button p-2 rounded-full flex items-center justify-center"
                                href="#">
                                <i class="fab fa-twitter text-xl"></i>
                            </a>
                            <a
                                class="social-share-button p-2 rounded-full flex items-center justify-center"
                                href="#">
                                <i class="fab fa-linkedin-in text-xl"></i>
                            </a>
                            <a
                                class="social-share-button p-2 rounded-full flex items-center justify-center"
                                href="#">
                                <i class="fas fa-envelope text-xl"></i>
                            </a>
                        </div>
                    </div>
                    <div class="mt-12">
                        <?php
                        // Affichage dynamique des commentaires WordPress
                        if (comments_open() || get_comments_number()) :
                            comments_template();
                        endif;
                        ?>
                    </div>
                </article>
                <aside class="w-full lg:w-1/3 space-y-8">
                    <!-- Articles similaires -->
                    <div class="bg-[#f9fbf9] p-6 rounded-lg shadow-sm">
                        <h3 class="text-xl font-semibold text-[#1F6B5C] mb-4">
                            Articles Similaires
                        </h3>
                        <?php
                        // Articles similaires
                        $current_post_id = get_the_ID();
                        $categories = get_the_category($current_post_id);
                        $related_posts = array();

                        if (!empty($categories)) {
                            $category_ids = array();
                            foreach ($categories as $category) {
                                $category_ids[] = $category->term_id;
                            }

                            $related_posts = get_posts(array(
                                'category__in' => $category_ids,
                                'post__not_in' => array($current_post_id),
                                'posts_per_page' => 3,
                                'orderby' => 'rand'
                            ));
                        }

                        if (!empty($related_posts)) : ?>
                            <ul class="space-y-3">
                                <?php foreach ($related_posts as $related_post) : ?>
                                    <li>
                                        <a class="group" href="<?php echo esc_url(get_permalink($related_post->ID)); ?>">
                                            <p class="font-medium text-[#343A40] group-hover:text-[#2D9B8A]">
                                                <?php echo esc_html($related_post->post_title); ?>
                                            </p>
                                            <p class="text-xs text-gray-500">
                                                <?php echo esc_html(get_the_date('j F Y', $related_post->ID)); ?>
                                            </p>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else : ?>
                            <p class="text-[#6C757D] text-sm italic">
                                Aucun article similaire trouvé pour le moment.
                            </p>
                        <?php endif; ?>
                    </div>

                    <?php
                    // Catégories dynamiques
                    $categories = get_categories(array(
                        'orderby' => 'count',
                        'order' => 'DESC',
                        'number' => 5,
                        'hide_empty' => true
                    ));

                    if (!empty($categories)) : ?>
                        <div class="bg-[#f9fbf9] p-6 rounded-lg shadow-sm">
                            <h3 class="text-xl font-semibold text-[#1F6B5C] mb-4">
                                Catégories
                            </h3>
                            <ul class="space-y-2">
                                <?php foreach ($categories as $category) : ?>
                                    <li>
                                        <a class="text-[#343A40] hover:text-[#2D9B8A]"
                                            href="<?php echo esc_url(get_category_link($category->term_id)); ?>">
                                            <?php echo esc_html($category->name); ?> (<?php echo $category->count; ?>)
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    <div class="newsletter-gradient text-white p-8 rounded-xl shadow-lg relative overflow-hidden">
                        <!-- Decorative elements -->
                        <div class="absolute top-0 right-0 w-20 h-20 bg-[#A8E6CF] opacity-10 rounded-full -mr-10 -mt-10"></div>
                        <div class="absolute bottom-0 left-0 w-16 h-16 bg-[#A8E6CF] opacity-10 rounded-full -ml-8 -mb-8"></div>

                        <div class="relative z-10">
                            <div class="flex items-center mb-4">
                                <i class="fas fa-envelope-open-text text-2xl text-[#A8E6CF] mr-3"></i>
                                <h3 class="text-2xl font-bold">Newsletter</h3>
                            </div>
                            <p class="text-[#A8E6CF] mb-6 leading-relaxed">
                                Restez informé des dernières actualités de l'ACA et recevez nos insights exclusifs directement dans votre boîte mail.
                            </p>
                            <form class="space-y-4" id="newsletter-form">
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-envelope text-[#6C757D]"></i>
                                    </div>
                                    <input
                                        class="form-input w-full pl-10 pr-4 py-3 rounded-lg border-none bg-white text-[#343A40] placeholder-[#6C757D] focus:ring-2 focus:ring-[#A8E6CF] focus:outline-none transition-all duration-200 shadow-sm"
                                        placeholder="Votre adresse email"
                                        type="email"
                                        name="email"
                                        id="newsletter-email"
                                        required />
                                </div>
                                <button
                                    class="w-full px-6 py-3 bg-[#28A745] text-white font-semibold rounded-lg hover:bg-[#28A745]/90 focus:bg-[#28A745]/90 focus:ring-2 focus:ring-[#A8E6CF] focus:outline-none transition-all duration-200 shadow-sm hover:shadow-md transform hover:-translate-y-0.5 flex items-center justify-center group"
                                    type="submit">
                                    <span>S'inscrire maintenant</span>
                                    <i class="fas fa-arrow-right ml-2 transition-transform group-hover:translate-x-1"></i>
                                </button>
                            </form>
                            <p class="text-xs text-[#A8E6CF]/80 mt-3 text-center">
                                <i class="fas fa-shield-alt mr-1"></i>
                                Vos données sont protégées. Désabonnement possible à tout moment.
                            </p>
                        </div>
                    </div>
                </aside>
            </div>
        </div>

    <?php endwhile; ?>

</main>

<?php get_footer(); ?>