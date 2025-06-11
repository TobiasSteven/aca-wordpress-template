import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import {
    PanelBody,
    SelectControl,
    RadioControl
} from '@wordpress/components';
import { useEntityRecords } from '@wordpress/core-data';
import './editor.scss';

export default function Edit({ attributes, setAttributes }) {
    const {
        filterType,
        selectedCategory,
        selectedTag
    } = attributes;

    // Récupérer les catégories disponibles
    const { records: categories, isResolving: isLoadingCategories } = useEntityRecords('taxonomy', 'category', {
        per_page: -1,
        hide_empty: true,
    });

    // Récupérer les tags disponibles
    const { records: tags, isResolving: isLoadingTags } = useEntityRecords('taxonomy', 'post_tag', {
        per_page: -1,
        hide_empty: true,
    });

    // Récupérer l'article en vedette selon les paramètres
    const queryArgs = {
        per_page: 1,
        _embed: true,
        order: 'desc',
        orderby: 'date',
    };

    if (filterType === 'category' && selectedCategory > 0) {
        queryArgs.categories = [selectedCategory];
    } else if (filterType === 'tag' && selectedTag > 0) {
        queryArgs.tags = [selectedTag];
    }

    const { records: posts, isResolving: isLoadingPosts } = useEntityRecords('postType', 'post', queryArgs);

    const blockProps = useBlockProps();

    // Options pour les catégories
    const categoryOptions = [
        { label: __('Sélectionner une catégorie', 'mon-theme-aca'), value: 0 }
    ];
    if (categories) {
        categories.forEach(category => {
            categoryOptions.push({
                label: category.name,
                value: category.id
            });
        });
    }

    // Options pour les tags
    const tagOptions = [
        { label: __('Sélectionner un tag', 'mon-theme-aca'), value: 0 }
    ];
    if (tags) {
        tags.forEach(tag => {
            tagOptions.push({
                label: tag.name,
                value: tag.id
            });
        });
    }

    // Fonction pour obtenir l'image de l'article
    const getPostImage = (post) => {
        if (post._embedded && post._embedded['wp:featuredmedia'] && post._embedded['wp:featuredmedia'][0]) {
            return post._embedded['wp:featuredmedia'][0].source_url;
        }
        return null;
    };

    // Fonction pour obtenir l'auteur de l'article
    const getPostAuthor = (post) => {
        if (post._embedded && post._embedded.author && post._embedded.author[0]) {
            return post._embedded.author[0].name;
        }
        return __('Auteur inconnu', 'mon-theme-aca');
    };

    // Fonction pour formater la date
    const formatDate = (dateString) => {
        const date = new Date(dateString);
        return date.toLocaleDateString('fr-FR', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
    };

    return (
        <>
            <InspectorControls>
                <PanelBody title={__('Paramètres de filtrage', 'mon-theme-aca')} initialOpen={true}>
                    <RadioControl
                        label={__('Filtrer par', 'mon-theme-aca')}
                        selected={filterType}
                        options={[
                            { label: __('Catégorie', 'mon-theme-aca'), value: 'category' },
                            { label: __('Tag', 'mon-theme-aca'), value: 'tag' }
                        ]}
                        onChange={(value) => setAttributes({ filterType: value })}
                    />

                    {filterType === 'category' && (
                        <SelectControl
                            label={__('Catégorie', 'mon-theme-aca')}
                            value={selectedCategory}
                            options={categoryOptions}
                            onChange={(value) => setAttributes({ selectedCategory: parseInt(value) })}
                            disabled={isLoadingCategories}
                        />
                    )}

                    {filterType === 'tag' && (
                        <SelectControl
                            label={__('Tag', 'mon-theme-aca')}
                            value={selectedTag}
                            options={tagOptions}
                            onChange={(value) => setAttributes({ selectedTag: parseInt(value) })}
                            disabled={isLoadingTags}
                        />
                    )}
                </PanelBody>
            </InspectorControls>

            <div {...blockProps}>
                <div className="featured-post-preview">
                    {isLoadingPosts && (
                        <div className="loading">
                            {__('Chargement...', 'mon-theme-aca')}
                        </div>
                    )}

                    {!isLoadingPosts && posts && posts.length > 0 ? (
                        <section className="hero-section">
                            <div className="container">
                                <div className="content-wrapper">
                                    <div className="text-content">
                                        <span className="featured-badge">FEATURED</span>
                                        <h1 className="main-title">{posts[0].title.rendered}</h1>
                                        <div className="subtitle" dangerouslySetInnerHTML={{ __html: posts[0].excerpt.rendered }} />
                                        <p className="author-info">Par {getPostAuthor(posts[0])} | {formatDate(posts[0].date)}</p>
                                        <a href="#" className="cta-button">Lire l'article</a>
                                    </div>
                                    <div className="image-section">
                                        <img src={getPostImage(posts[0])} alt={posts[0].title.rendered} className="hero-image" />
                                    </div>
                                </div>
                            </div>
                        </section>
                    ) : (
                        !isLoadingPosts && (
                            <div className="no-posts">
                                {__('Aucun article trouvé avec les critères sélectionnés.', 'mon-theme-aca')}
                            </div>
                        )
                    )}
                </div>
            </div>
        </>
    );
}