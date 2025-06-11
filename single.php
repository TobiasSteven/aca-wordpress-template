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
                        <?php the_content(); ?>
                    </div>
                    <div class="mt-10 pt-6 border-t border-gray-200">
                        <h4 class="text-lg font-semibold text-[#1F6B5C] mb-3">
                            Partager cet article :
                        </h4>
                        <div class="flex space-x-3">
                            <a
                                class="social-share-button p-2 rounded-full flex items-center justify-center"
                                href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>"
                                target="_blank">
                                <i class="fab fa-facebook-f text-xl"></i>
                            </a>
                            <a
                                class="social-share-button p-2 rounded-full flex items-center justify-center"
                                href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>"
                                target="_blank">
                                <i class="fab fa-twitter text-xl"></i>
                            </a>
                            <a
                                class="social-share-button p-2 rounded-full flex items-center justify-center"
                                href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo urlencode(get_permalink()); ?>"
                                target="_blank">
                                <i class="fab fa-linkedin-in text-xl"></i>
                            </a>
                            <a
                                class="social-share-button p-2 rounded-full flex items-center justify-center"
                                href="mailto:?subject=<?php echo urlencode(get_the_title()); ?>&body=<?php echo urlencode(get_permalink()); ?>"
                                target="_blank">
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