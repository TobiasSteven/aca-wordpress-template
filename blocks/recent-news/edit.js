import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import {
    PanelBody,
    RangeControl,
    SelectControl,
    ToggleControl,
    CheckboxControl,
    TextControl
} from '@wordpress/components';
import { useSelect } from '@wordpress/data';
import { useEntityRecords } from '@wordpress/core-data';
import './editor.scss';

export default function Edit({ attributes, setAttributes }) {
    const {
        sectionTitle,
        numberOfPosts,
        selectedCategories,
        showDate,
        showExcerpt,
        orderBy,
        order
    } = attributes;

    // Récupérer les catégories disponibles
    const { records: categories, isResolving: isLoadingCategories } = useEntityRecords('taxonomy', 'category', {
        per_page: -1,
        hide_empty: true,
    });

    // Récupérer les articles selon les paramètres
    const queryArgs = {
        per_page: numberOfPosts,
        _embed: true,
        order: order,
        orderby: orderBy,
    };

    if (selectedCategories.length > 0) {
        queryArgs.categories = selectedCategories;
    }

    const { records: posts, isResolving: isLoadingPosts } = useEntityRecords('postType', 'post', queryArgs);

    const blockProps = useBlockProps();

    const onCategoryChange = (categoryId, checked) => {
        let newCategories = [...selectedCategories];
        if (checked) {
            newCategories.push(categoryId);
        } else {
            newCategories = newCategories.filter(id => id !== categoryId);
        }
        setAttributes({ selectedCategories: newCategories });
    };

    return (
        <>
            <InspectorControls>
                <PanelBody title={__('Paramètres des actualités', 'mon-theme-aca')}>
                    <TextControl
                        label={__('Titre de la section', 'mon-theme-aca')}
                        value={sectionTitle}
                        onChange={(value) => setAttributes({ sectionTitle: value })}
                        placeholder={__('Actualités Récentes', 'mon-theme-aca')}
                    />

                    <RangeControl
                        label={__('Nombre d\'articles', 'mon-theme-aca')}
                        value={numberOfPosts}
                        onChange={(value) => setAttributes({ numberOfPosts: value })}
                        min={1}
                        max={12}
                    />

                    <SelectControl
                        label={__('Trier par', 'mon-theme-aca')}
                        value={orderBy}
                        options={[
                            { label: 'Date', value: 'date' },
                            { label: 'Titre', value: 'title' },
                            { label: 'Aléatoire', value: 'rand' },
                        ]}
                        onChange={(value) => setAttributes({ orderBy: value })}
                    />

                    <SelectControl
                        label={__('Ordre', 'mon-theme-aca')}
                        value={order}
                        options={[
                            { label: 'Décroissant', value: 'desc' },
                            { label: 'Croissant', value: 'asc' },
                        ]}
                        onChange={(value) => setAttributes({ order: value })}
                    />

                    <ToggleControl
                        label={__('Afficher la date', 'mon-theme-aca')}
                        checked={showDate}
                        onChange={(value) => setAttributes({ showDate: value })}
                    />

                    <ToggleControl
                        label={__('Afficher l\'extrait', 'mon-theme-aca')}
                        checked={showExcerpt}
                        onChange={(value) => setAttributes({ showExcerpt: value })}
                    />
                </PanelBody>

                <PanelBody title={__('Catégories', 'mon-theme-aca')} initialOpen={false}>
                    {isLoadingCategories && <p>{__('Chargement des catégories...', 'mon-theme-aca')}</p>}
                    {categories && categories.map((category) => (
                        <CheckboxControl
                            key={category.id}
                            label={category.name}
                            checked={selectedCategories.includes(category.id)}
                            onChange={(checked) => onCategoryChange(category.id, checked)}
                        />
                    ))}
                </PanelBody>
            </InspectorControls>

            <div {...blockProps}>
                <div className="recent-news-editor">
                    <h2>{sectionTitle || __('Actualités Récentes', 'mon-theme-aca')}</h2>

                    {isLoadingPosts && (
                        <p>{__('Chargement des articles...', 'mon-theme-aca')}</p>
                    )}

                    {posts && posts.length === 0 && (
                        <p>{__('Aucun article trouvé avec ces paramètres.', 'mon-theme-aca')}</p>
                    )}

                    {posts && posts.length > 0 && (
                        <div className="news-cards-container">
                            {posts.map((post, index) => {
                                const featuredImage = post._embedded?.['wp:featuredmedia']?.[0];
                                const dateColors = ['date-green', 'date-blue', 'date-green'];
                                const dateColorClass = dateColors[index % dateColors.length];

                                return (
                                    <article key={post.id} className="news-card">
                                        <div className="card-image-container">
                                            {featuredImage ? (
                                                <img
                                                    src={featuredImage.source_url}
                                                    alt={featuredImage.alt_text || post.title.rendered}
                                                />
                                            ) : (
                                                <div className="placeholder-image">
                                                    {__('Pas d\'image', 'mon-theme-aca')}
                                                </div>
                                            )}
                                            {showDate && (
                                                <span className={`card-date ${dateColorClass}`}>
                                                    {new Date(post.date).toLocaleDateString('fr-FR', {
                                                        day: '2-digit',
                                                        month: 'short',
                                                        year: 'numeric'
                                                    }).toUpperCase()}
                                                </span>
                                            )}
                                        </div>
                                        <div className="card-content">
                                            <h3 dangerouslySetInnerHTML={{ __html: post.title.rendered }} />
                                            {showExcerpt && (
                                                <p dangerouslySetInnerHTML={{ __html: post.excerpt.rendered.replace(/<[^>]*>/g, '') }} />
                                            )}
                                            <a href="#" className="read-more">
                                                {__('Lire plus', 'mon-theme-aca')} →
                                            </a>
                                        </div>
                                    </article>
                                );
                            })}
                        </div>
                    )}
                </div>
            </div>
        </>
    );
}
