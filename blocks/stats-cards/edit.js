import { __ } from '@wordpress/i18n';
import {
    useBlockProps,
    InspectorControls,
    RichText
} from '@wordpress/block-editor';
import {
    PanelBody,
    Button,
    TextControl,
    ColorPicker,
    SelectControl
} from '@wordpress/components';
import { Fragment } from '@wordpress/element';

import './editor.scss';

// Liste d'icônes communes pour faciliter la sélection
const iconOptions = [
    { label: __('Utilisateurs', 'mon-theme-aca'), value: 'fas fa-users' },
    { label: __('Globe/Monde', 'mon-theme-aca'), value: 'fas fa-globe-americas' },
    { label: __('Feuille/Nature', 'mon-theme-aca'), value: 'fas fa-leaf' },
    { label: __('Presse-papier/Liste', 'mon-theme-aca'), value: 'fas fa-clipboard-list' },
    { label: __('Graphique à barres', 'mon-theme-aca'), value: 'fas fa-chart-bar' },
    { label: __('Graphique linéaire', 'mon-theme-aca'), value: 'fas fa-chart-line' },
    { label: __('Graphique circulaire', 'mon-theme-aca'), value: 'fas fa-chart-pie' },
    { label: __('Tendance montante', 'mon-theme-aca'), value: 'fas fa-chart-line-up' },
    { label: __('Cible', 'mon-theme-aca'), value: 'fas fa-bullseye' },
    { label: __('Trophée', 'mon-theme-aca'), value: 'fas fa-trophy' },
    { label: __('Médaille', 'mon-theme-aca'), value: 'fas fa-medal' },
    { label: __('Étoile', 'mon-theme-aca'), value: 'fas fa-star' },
    { label: __('Cœur', 'mon-theme-aca'), value: 'fas fa-heart' },
    { label: __('Pouce en l\'air', 'mon-theme-aca'), value: 'fas fa-thumbs-up' },
    { label: __('Ampoule', 'mon-theme-aca'), value: 'fas fa-lightbulb' },
    { label: __('Rouage', 'mon-theme-aca'), value: 'fas fa-cog' },
    { label: __('Bouclier', 'mon-theme-aca'), value: 'fas fa-shield-alt' },
    { label: __('Carte', 'mon-theme-aca'), value: 'fas fa-map' },
    { label: __('Horloge', 'mon-theme-aca'), value: 'fas fa-clock' },
    { label: __('Calendrier', 'mon-theme-aca'), value: 'fas fa-calendar' },
    { label: __('Argent', 'mon-theme-aca'), value: 'fas fa-dollar-sign' },
    { label: __('Maison', 'mon-theme-aca'), value: 'fas fa-home' },
    { label: __('Bâtiment', 'mon-theme-aca'), value: 'fas fa-building' },
    { label: __('Industrie', 'mon-theme-aca'), value: 'fas fa-industry' },
    { label: __('Camion', 'mon-theme-aca'), value: 'fas fa-truck' },
    { label: __('Personnalisé', 'mon-theme-aca'), value: 'custom' }
];

export default function Edit({ attributes, setAttributes }) {
    const { cards, backgroundColor } = attributes;

    const addCard = () => {
        const newCard = {
            icon: 'fas fa-chart-bar',
            label: __('Nouvelle statistique', 'mon-theme-aca'),
            value: '0'
        };
        setAttributes({
            cards: [...cards, newCard]
        });
    };

    const removeCard = (index) => {
        const newCards = cards.filter((_, i) => i !== index);
        setAttributes({ cards: newCards });
    };

    const updateCard = (index, field, value) => {
        const newCards = [...cards];
        newCards[index][field] = value;
        setAttributes({ cards: newCards });
    };

    const blockProps = useBlockProps({
        style: {
            backgroundColor: backgroundColor
        }
    });

    return (
        <Fragment>
            <InspectorControls>
                <PanelBody title={__('Paramètres des cartes', 'mon-theme-aca')}>
                    <div style={{ marginBottom: '16px' }}>
                        <label>{__('Couleur de fond', 'mon-theme-aca')}</label>
                        <ColorPicker
                            color={backgroundColor}
                            onChange={(color) => setAttributes({ backgroundColor: color })}
                        />
                    </div>

                    <Button
                        variant="primary"
                        onClick={addCard}
                        style={{ marginBottom: '16px' }}
                    >
                        {__('Ajouter une carte', 'mon-theme-aca')}
                    </Button>
                </PanelBody>

                {cards.map((card, index) => (
                    <PanelBody
                        key={index}
                        title={__(`Carte ${index + 1}`, 'mon-theme-aca')}
                        initialOpen={false}
                    >
                        <SelectControl
                            label={__('Choisir une icône', 'mon-theme-aca')}
                            value={iconOptions.find(option => option.value === card.icon) ? card.icon : 'custom'}
                            options={iconOptions}
                            onChange={(value) => {
                                if (value === 'custom') {
                                    // Basculer vers un mode d'édition personnalisé
                                    updateCard(index, 'icon', 'fas fa-star');
                                } else {
                                    updateCard(index, 'icon', value);
                                }
                            }}
                        />

                        {/* Boutons visuels pour les icônes les plus courantes */}
                        <div style={{ marginBottom: '16px' }}>
                            <label style={{ fontSize: '12px', color: '#666', display: 'block', marginBottom: '8px' }}>
                                {__('Icônes populaires:', 'mon-theme-aca')}
                            </label>
                            <div style={{
                                display: 'flex',
                                flexWrap: 'wrap',
                                gap: '8px',
                                padding: '8px',
                                backgroundColor: '#f8f9fa',
                                borderRadius: '4px'
                            }}>
                                {[
                                    'fas fa-users',
                                    'fas fa-globe-americas',
                                    'fas fa-leaf',
                                    'fas fa-chart-bar',
                                    'fas fa-trophy',
                                    'fas fa-heart'
                                ].map((iconClass) => (
                                    <button
                                        key={iconClass}
                                        type="button"
                                        onClick={() => updateCard(index, 'icon', iconClass)}
                                        style={{
                                            background: card.icon === iconClass ? '#2D9B8A' : '#fff',
                                            color: card.icon === iconClass ? '#fff' : '#2D9B8A',
                                            border: '1px solid #2D9B8A',
                                            borderRadius: '4px',
                                            padding: '8px',
                                            cursor: 'pointer',
                                            fontSize: '16px',
                                            transition: 'all 0.2s ease'
                                        }}
                                        title={iconClass}
                                    >
                                        <i className={iconClass} style={{
                                            fontFamily: '"Font Awesome 6 Free", "Font Awesome 6 Pro", "Font Awesome 6 Brands", "FontAwesome", sans-serif !important',
                                            fontWeight: '900 !important'
                                        }}></i>
                                    </button>
                                ))}
                            </div>
                        </div>

                        {(!iconOptions.find(option => option.value === card.icon)) && (
                            <div>
                                <TextControl
                                    label={__('Icône personnalisée (classe FontAwesome)', 'mon-theme-aca')}
                                    value={card.icon}
                                    onChange={(value) => updateCard(index, 'icon', value)}
                                    help={__('Ex: fas fa-users, fas fa-chart-bar, fas fa-leaf, fas fa-globe-americas, fas fa-clipboard-list', 'mon-theme-aca')}
                                    placeholder="fas fa-chart-bar"
                                />
                                <Button
                                    variant="secondary"
                                    size="small"
                                    onClick={() => updateCard(index, 'icon', 'fas fa-users')}
                                    style={{ marginTop: '8px' }}
                                >
                                    {__('Revenir aux icônes prédéfinies', 'mon-theme-aca')}
                                </Button>
                            </div>
                        )}

                        {card.icon && (
                            <div style={{ marginBottom: '16px', textAlign: 'center' }}>
                                <label style={{ fontSize: '12px', color: '#666', display: 'block', marginBottom: '8px' }}>
                                    {__('Aperçu de l\'icône:', 'mon-theme-aca')}
                                </label>
                                <div style={{
                                    padding: '10px',
                                    backgroundColor: '#f8f9fa',
                                    borderRadius: '4px',
                                    border: '1px solid #e9ecef'
                                }}
                                    className="stat-icon-preview"
                                >
                                    <i
                                        className={card.icon}
                                        style={{
                                            fontSize: '24px',
                                            color: '#2D9B8A',
                                            fontFamily: '"Font Awesome 6 Free", "Font Awesome 6 Pro", "Font Awesome 6 Brands", "FontAwesome", sans-serif !important',
                                            fontWeight: '900 !important',
                                            fontStyle: 'normal !important',
                                            display: 'inline-block !important',
                                            lineHeight: '1 !important'
                                        }}
                                    ></i>
                                    <div style={{
                                        fontSize: '10px',
                                        color: '#6c757d',
                                        marginTop: '4px',
                                        fontStyle: 'italic'
                                    }}>
                                        {card.icon}
                                    </div>
                                </div>
                            </div>
                        )}

                        <TextControl
                            label={__('Étiquette', 'mon-theme-aca')}
                            value={card.label}
                            onChange={(value) => updateCard(index, 'label', value)}
                        />

                        <TextControl
                            label={__('Valeur', 'mon-theme-aca')}
                            value={card.value}
                            onChange={(value) => updateCard(index, 'value', value)}
                        />

                        <Button
                            variant="secondary"
                            isDestructive
                            onClick={() => removeCard(index)}
                        >
                            {__('Supprimer cette carte', 'mon-theme-aca')}
                        </Button>
                    </PanelBody>
                ))}
            </InspectorControls>

            <div {...blockProps}>
                <div className="stats-container-editor">
                    {cards.map((card, index) => (
                        <div key={index} className="stat-card-editor">
                            <div className="stat-icon-editor">
                                <i
                                    key={`${index}-${card.icon}`}
                                    className={card.icon || 'fas fa-chart-bar'}
                                    style={{
                                        fontFamily: '"Font Awesome 6 Free", "Font Awesome 6 Pro", "Font Awesome 6 Brands", "FontAwesome", sans-serif',
                                        fontWeight: '900'
                                    }}
                                ></i>
                            </div>
                            <RichText
                                tagName="div"
                                className="stat-label-editor"
                                value={card.label}
                                onChange={(value) => updateCard(index, 'label', value)}
                                placeholder={__('Étiquette de la statistique', 'mon-theme-aca')}
                            />
                            <RichText
                                tagName="div"
                                className="stat-value-editor"
                                value={card.value}
                                onChange={(value) => updateCard(index, 'value', value)}
                                placeholder={__('Valeur', 'mon-theme-aca')}
                            />
                        </div>
                    ))}
                </div>
            </div>
        </Fragment>
    );
}
