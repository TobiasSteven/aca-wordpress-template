/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-block-editor/#useBlockProps
 */
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';

/**
 * WordPress components
 */
import {
    PanelBody,
    TextControl,
    RangeControl,
    ToggleControl,
    SelectControl,
} from '@wordpress/components';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/developers/block-api/block-edit-save/#edit
 *
 * @return {WPElement} Element to render.
 */
export default function Edit({ attributes, setAttributes }) {
    const {
        sectionTitle,
        postsPerPage,
        showSearchFilter,
        showCategoryFilter,
        showTemporalFilter,
        showGeographicFilter,
        showSortControls,
        showPagination,
        paginationType,
        defaultSortBy,
        defaultOrder,
    } = attributes;

    return (
        <div {...useBlockProps()}>
            <InspectorControls>
                <PanelBody title={__('Paramètres généraux', 'mon-theme-aca')}>
                    <TextControl
                        label={__('Titre de la section', 'mon-theme-aca')}
                        value={sectionTitle}
                        onChange={(value) => setAttributes({ sectionTitle: value })}
                    />
                    <RangeControl
                        label={__('Articles par page', 'mon-theme-aca')}
                        value={postsPerPage}
                        onChange={(value) => setAttributes({ postsPerPage: value })}
                        min={1}
                        max={24}
                    />
                </PanelBody>

                <PanelBody title={__('Filtres', 'mon-theme-aca')}>
                    <ToggleControl
                        label={__('Afficher la recherche', 'mon-theme-aca')}
                        checked={showSearchFilter}
                        onChange={(value) => setAttributes({ showSearchFilter: value })}
                    />
                    <ToggleControl
                        label={__('Afficher les filtres par catégorie', 'mon-theme-aca')}
                        checked={showCategoryFilter}
                        onChange={(value) => setAttributes({ showCategoryFilter: value })}
                    />
                    <ToggleControl
                        label={__('Afficher les filtres temporels', 'mon-theme-aca')}
                        checked={showTemporalFilter}
                        onChange={(value) => setAttributes({ showTemporalFilter: value })}
                    />
                    <ToggleControl
                        label={__('Afficher les filtres géographiques', 'mon-theme-aca')}
                        checked={showGeographicFilter}
                        onChange={(value) => setAttributes({ showGeographicFilter: value })}
                    />
                </PanelBody>

                <PanelBody title={__('Contrôles et tri', 'mon-theme-aca')}>
                    <ToggleControl
                        label={__('Afficher les contrôles de tri', 'mon-theme-aca')}
                        checked={showSortControls}
                        onChange={(value) => setAttributes({ showSortControls: value })}
                    />
                    <SelectControl
                        label={__('Tri par défaut', 'mon-theme-aca')}
                        value={defaultSortBy}
                        options={[
                            { label: __('Date', 'mon-theme-aca'), value: 'date' },
                            { label: __('Titre', 'mon-theme-aca'), value: 'title' },
                            { label: __('Auteur', 'mon-theme-aca'), value: 'author' },
                        ]}
                        onChange={(value) => setAttributes({ defaultSortBy: value })}
                    />
                    <SelectControl
                        label={__('Ordre par défaut', 'mon-theme-aca')}
                        value={defaultOrder}
                        options={[
                            { label: __('Décroissant', 'mon-theme-aca'), value: 'desc' },
                            { label: __('Croissant', 'mon-theme-aca'), value: 'asc' },
                        ]}
                        onChange={(value) => setAttributes({ defaultOrder: value })}
                    />
                </PanelBody>

                <PanelBody title={__('Pagination', 'mon-theme-aca')}>
                    <ToggleControl
                        label={__('Afficher la pagination', 'mon-theme-aca')}
                        checked={showPagination}
                        onChange={(value) => setAttributes({ showPagination: value })}
                    />
                    {showPagination && (
                        <SelectControl
                            label={__('Type de pagination', 'mon-theme-aca')}
                            value={paginationType}
                            options={[
                                { label: __('Numérotée', 'mon-theme-aca'), value: 'numbered' },
                                { label: __('Charger plus', 'mon-theme-aca'), value: 'load-more' },
                            ]}
                            onChange={(value) => setAttributes({ paginationType: value })}
                        />
                    )}
                </PanelBody>
            </InspectorControls>

            <div className="wp-block-mon-theme-aca-filtered-posts-preview">
                <h2>{sectionTitle}</h2>
                <div className="filtered-posts-layout">
                    <div className="filters-sidebar">
                        <h3>{__('Filtres', 'mon-theme-aca')}</h3>
                        {showSearchFilter && (
                            <div className="filter-group">
                                <label>{__('Recherche', 'mon-theme-aca')}</label>
                                <input type="text" placeholder={__('Rechercher...', 'mon-theme-aca')} disabled />
                            </div>
                        )}
                        {showCategoryFilter && (
                            <div className="filter-group">
                                <label>{__('Catégories', 'mon-theme-aca')}</label>
                                <div className="checkbox-group">
                                    <label><input type="checkbox" disabled /> {__('Catégorie 1', 'mon-theme-aca')}</label>
                                    <label><input type="checkbox" disabled /> {__('Catégorie 2', 'mon-theme-aca')}</label>
                                </div>
                            </div>
                        )}
                        {showTemporalFilter && (
                            <div className="filter-group">
                                <label>{__('Filtres Temporels', 'mon-theme-aca')}</label>
                                <select disabled>
                                    <option>{__('Sélectionner...', 'mon-theme-aca')}</option>
                                </select>
                            </div>
                        )}
                        {showGeographicFilter && (
                            <div className="filter-group">
                                <label>{__('Filtres Géographiques', 'mon-theme-aca')}</label>
                                <select disabled>
                                    <option>{__('Sélectionner...', 'mon-theme-aca')}</option>
                                </select>
                            </div>
                        )}
                    </div>
                    <div className="posts-grid">
                        {showSortControls && (
                            <div className="posts-controls">
                                <span>{__('Trier par:', 'mon-theme-aca')} {defaultSortBy} ({defaultOrder})</span>
                                <span>{postsPerPage} {__('articles par page', 'mon-theme-aca')}</span>
                            </div>
                        )}
                        <div className="posts-preview">
                            {[...Array(3)].map((_, index) => (
                                <div key={index} className="post-card-preview">
                                    <div className="card-image-placeholder"></div>
                                    <div className="card-content-preview">
                                        <h4>{__('Titre de l\'article', 'mon-theme-aca')} {index + 1}</h4>
                                        <p>{__('Extrait de l\'article...', 'mon-theme-aca')}</p>
                                    </div>
                                </div>
                            ))}
                        </div>
                        {showPagination && (
                            <div className="pagination-preview">
                                {paginationType === 'numbered' ? (
                                    <span>1 2 3 ...</span>
                                ) : (
                                    <button disabled>{__('Charger plus', 'mon-theme-aca')}</button>
                                )}
                            </div>
                        )}
                    </div>
                </div>
            </div>
        </div>
    );
}