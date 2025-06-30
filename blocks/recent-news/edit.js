import { __ } from '@wordpress/i18n';
import {
    useBlockProps,
    InspectorControls,
    MediaUpload,
    MediaUploadCheck,
    RichText
} from '@wordpress/block-editor';
import {
    PanelBody,
    TextControl,
    TextareaControl,
    Button,
    BaseControl,
    ToggleControl
} from '@wordpress/components';
import { useState } from '@wordpress/element';

import './editor.scss';

export default function Edit({ attributes, setAttributes }) {
    const {
        sectionTitle,
        sectionSubtitle,
        newsItems,
        showCategory,
        showDate,
        showReadTime,
        showReadMore
    } = attributes;
    const blockProps = useBlockProps();

    const [currentItemIndex, setCurrentItemIndex] = useState(0);

    const updateItem = (index, field, value) => {
        const newItems = [...newsItems];
        newItems[index][field] = value;
        setAttributes({ newsItems: newItems });
    };

    const addItem = () => {
        const newItem = {
            id: new Date().getTime(),
            image: '',
            category: __('Catégorie', 'mon-theme-aca'),
            date: new Date().toLocaleDateString('fr-FR', { day: 'numeric', month: 'short', year: 'numeric' }),
            title: __('Nouveau Titre', 'mon-theme-aca'),
            excerpt: __('Court extrait de l\'actualité...', 'mon-theme-aca'),
            readTime: '4 min',
            link: '#'
        };
        const newItems = [...newsItems, newItem];
        setAttributes({ newsItems: newItems });
        setCurrentItemIndex(newItems.length - 1);
    };

    const removeItem = (index) => {
        const newItems = newsItems.filter((_, i) => i !== index);
        if (index <= currentItemIndex) {
            setCurrentItemIndex(Math.max(0, currentItemIndex - 1));
        }
        setAttributes({ newsItems: newItems });
    };

    const goToNextItem = () => setCurrentItemIndex((prev) => (prev + 1) % newsItems.length);
    const goToPrevItem = () => setCurrentItemIndex((prev) => (prev - 1 + newsItems.length) % newsItems.length);

    const currentItem = newsItems[currentItemIndex] || null;

    return (
        <>
            <InspectorControls>
                <PanelBody title={__('Paramètres de la Section', 'mon-theme-aca')}>
                    <TextControl label={__('Titre', 'mon-theme-aca')} value={sectionTitle} onChange={(val) => setAttributes({ sectionTitle: val })} />
                    <TextareaControl label={__('Sous-titre', 'mon-theme-aca')} value={sectionSubtitle} onChange={(val) => setAttributes({ sectionSubtitle: val })} />
                </PanelBody>

                <PanelBody title={__('Affichage des éléments', 'mon-theme-aca')} initialOpen={true}>
                    <ToggleControl label={__('Afficher la catégorie', 'mon-theme-aca')} checked={showCategory} onChange={(val) => setAttributes({ showCategory: val })} />
                    <ToggleControl label={__('Afficher la date', 'mon-theme-aca')} checked={showDate} onChange={(val) => setAttributes({ showDate: val })} />
                    <ToggleControl label={__('Afficher le temps de lecture', 'mon-theme-aca')} checked={showReadTime} onChange={(val) => setAttributes({ showReadTime: val })} />
                    <ToggleControl label={__('Afficher le bouton "Lire plus"', 'mon-theme-aca')} checked={showReadMore} onChange={(val) => setAttributes({ showReadMore: val })} />
                </PanelBody>

                <PanelBody title={__('Gestion des Actualités', 'mon-theme-aca')}>
                    <Button variant="primary" onClick={addItem} style={{ marginBottom: '1rem' }}>{__('Ajouter une actualité', 'mon-theme-aca')}</Button>
                    {newsItems.length > 0 && (
                        <>
                            <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between', marginBottom: '1rem' }}>
                                <Button onClick={goToPrevItem} disabled={newsItems.length <= 1}>{'<'}</Button>
                                <span>{`${currentItemIndex + 1} / ${newsItems.length}`}</span>
                                <Button onClick={goToNextItem} disabled={newsItems.length <= 1}>{'>'}</Button>
                            </div>
                            {currentItem && (
                                <>
                                    <BaseControl label={__('Image', 'mon-theme-aca')} id={`media-upload-${currentItem.id}`}>
                                        <MediaUploadCheck>
                                            {currentItem.image && <img src={currentItem.image} alt="" style={{ width: '100%', marginBottom: '8px' }} />}
                                            <MediaUpload onSelect={(media) => updateItem(currentItemIndex, 'image', media.url)} allowedTypes={['image']} value={currentItem.image}
                                                render={({ open }) => (<Button onClick={open} variant={currentItem.image ? "secondary" : "primary"}>{!currentItem.image ? __('Sélectionner', 'mon-theme-aca') : __('Changer', 'mon-theme-aca')}</Button>)}
                                            />
                                        </MediaUploadCheck>
                                    </BaseControl>
                                    <TextControl label={__('Catégorie', 'mon-theme-aca')} value={currentItem.category} onChange={(val) => updateItem(currentItemIndex, 'category', val)} />
                                    <TextControl label={__('Date', 'mon-theme-aca')} value={currentItem.date} onChange={(val) => updateItem(currentItemIndex, 'date', val)} />
                                    <TextControl label={__('Titre', 'mon-theme-aca')} value={currentItem.title} onChange={(val) => updateItem(currentItemIndex, 'title', val)} />
                                    <TextareaControl label={__('Extrait', 'mon-theme-aca')} value={currentItem.excerpt} onChange={(val) => updateItem(currentItemIndex, 'excerpt', val)} />
                                    <TextControl label={__('Temps de lecture', 'mon-theme-aca')} value={currentItem.readTime} onChange={(val) => updateItem(currentItemIndex, 'readTime', val)} />
                                    <TextControl label={__('Lien', 'mon-theme-aca')} value={currentItem.link} onChange={(val) => updateItem(currentItemIndex, 'link', val)} />
                                    <Button isDestructive style={{ marginTop: '1rem' }} onClick={() => removeItem(currentItemIndex)}>{__('Supprimer', 'mon-theme-aca')}</Button>
                                </>
                            )}
                        </>
                    )}
                </PanelBody>
            </InspectorControls>

            <div {...blockProps} className="recent-news-editor-preview">
                 <div className="section-header">
                    <RichText tagName="h2" className="section-title" value={sectionTitle} onChange={(val) => setAttributes({ sectionTitle: val })} placeholder={__('Titre...', 'mon-theme-aca')} />
                    <RichText tagName="p" className="section-subtitle" value={sectionSubtitle} onChange={(val) => setAttributes({ sectionSubtitle: val })} placeholder={__('Sous-titre...', 'mon-theme-aca')} />
                </div>
                <div className="news-grid">
                    {newsItems.map((article) => (
                        <article key={article.id} className="news-article group">
                            <div className="image-container">
                                {article.image ? <img src={article.image} alt={article.title} className="news-image" /> : <div className="placeholder-image">Image</div>}
                                {showCategory && <div className="category-badge-wrapper"><span className="category-badge">{article.category}</span></div>}
                                {showDate && <div className="date-badge-wrapper"><span className="date-badge">{article.date}</span></div>}
                            </div>
                            <div className="content-container">
                                <h3 className="news-title">{article.title}</h3>
                                <p className="news-excerpt">{article.excerpt}</p>
                                <div className="meta-container">
                                    {showReadTime && <span className="read-time">{article.readTime} de lecture</span>}
                                    {showReadMore && <span className="read-more-button">Lire plus</span>}
                                </div>
                            </div>
                        </article>
                    ))}
                </div>
            </div>
        </>
    );
}