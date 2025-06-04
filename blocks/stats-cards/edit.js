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
    ColorPicker
} from '@wordpress/components';
import { Fragment } from '@wordpress/element';

import './editor.scss';

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
                        <TextControl
                            label={__('Icône (classe FontAwesome)', 'mon-theme-aca')}
                            value={card.icon}
                            onChange={(value) => updateCard(index, 'icon', value)}
                            help={__('Ex: fas fa-users, fas fa-chart-bar, fas fa-leaf', 'mon-theme-aca')}
                        />

                        {card.icon && (
                            <div style={{ marginBottom: '16px', textAlign: 'center' }}>
                                <label style={{ fontSize: '12px', color: '#666', display: 'block', marginBottom: '8px' }}>
                                    {__('Aperçu de l\'icône:', 'mon-theme-aca')}
                                </label>
                                <i
                                    className={card.icon}
                                    style={{ fontSize: '24px', color: '#A8E6CF' }}
                                ></i>
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
                                <i key={`${index}-${card.icon}`} className={card.icon}></i>
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
