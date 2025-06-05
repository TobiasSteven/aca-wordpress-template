import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls, MediaUploadCheck, MediaUpload } from '@wordpress/block-editor';
import {
    PanelBody,
    TextControl,
    ToggleControl,
    Button,
    ColorPicker
} from '@wordpress/components';
import { useState } from '@wordpress/element';

export default function Edit({ attributes, setAttributes }) {
    const { title, partners, backgroundColor, showBorders } = attributes;
    const [selectedPartnerIndex, setSelectedPartnerIndex] = useState(null);

    const blockProps = useBlockProps({
        className: 'partners-block-editor',
        style: {
            backgroundColor: backgroundColor,
            width: '100%'
        }
    });

    const addPartner = () => {
        const newPartners = [...partners, {
            id: Date.now(),
            url: '',
            alt: '',
            link: ''
        }];
        setAttributes({ partners: newPartners });
    };

    const updatePartner = (index, field, value) => {
        const newPartners = [...partners];
        newPartners[index][field] = value;
        setAttributes({ partners: newPartners });
    };

    const removePartner = (index) => {
        const newPartners = partners.filter((_, i) => i !== index);
        setAttributes({ partners: newPartners });
    };

    const onSelectMedia = (media, index) => {
        updatePartner(index, 'id', media.id);
        updatePartner(index, 'url', media.url);
        updatePartner(index, 'alt', media.alt || '');
    };

    return (
        <div {...blockProps}>
            <InspectorControls>
                <PanelBody title={__('Paramètres généraux', 'mon-theme-aca')}>
                    <TextControl
                        label={__('Titre', 'mon-theme-aca')}
                        value={title}
                        onChange={(value) => setAttributes({ title: value })}
                    />
                    <ToggleControl
                        label={__('Afficher les bordures', 'mon-theme-aca')}
                        checked={showBorders}
                        onChange={(value) => setAttributes({ showBorders: value })}
                    />
                    <div style={{ marginBottom: '16px' }}>
                        <label>{__('Couleur de fond', 'mon-theme-aca')}</label>
                        <ColorPicker
                            color={backgroundColor}
                            onChange={(color) => setAttributes({ backgroundColor: color })}
                        />
                    </div>
                </PanelBody>
                <PanelBody title={__('Gestion des partenaires', 'mon-theme-aca')}>
                    <Button
                        isPrimary
                        onClick={addPartner}
                        style={{ marginBottom: '16px' }}
                    >
                        {__('Ajouter un partenaire', 'mon-theme-aca')}
                    </Button>
                    {partners.map((partner, index) => (
                        <div key={partner.id} style={{
                            marginBottom: '20px',
                            padding: '16px',
                            border: '1px solid #ddd',
                            borderRadius: '4px'
                        }}>
                            <h4>{__('Partenaire', 'mon-theme-aca')} {index + 1}</h4>
                            <TextControl
                                label={__('Texte alternatif', 'mon-theme-aca')}
                                value={partner.alt}
                                onChange={(value) => updatePartner(index, 'alt', value)}
                            />
                            <TextControl
                                label={__('Lien (optionnel)', 'mon-theme-aca')}
                                value={partner.link}
                                onChange={(value) => updatePartner(index, 'link', value)}
                                placeholder="https://"
                            />
                            <Button
                                isDestructive
                                onClick={() => removePartner(index)}
                                style={{ marginTop: '8px' }}
                            >
                                {__('Supprimer', 'mon-theme-aca')}
                            </Button>
                        </div>
                    ))}
                </PanelBody>
            </InspectorControls>            <div className="partners-section-editor" style={{
                padding: '40px 20px',
                textAlign: 'center',
                border: showBorders ? '5px solid #e0e0e0' : 'none',
                borderTop: showBorders ? '5px solid #e0e0e0' : 'none',
                borderBottom: showBorders ? '5px solid #e0e0e0' : 'none',
                width: '100%'
            }}>
                <div className="partners-content-editor" style={{
                    width: '100%',
                    maxWidth: '1200px',
                    margin: '0 auto'
                }}>
                    <h2 style={{
                        fontSize: '2.5em',
                        fontWeight: 'bold',
                        color: '#343A40',
                        marginBottom: '40px'
                    }}>
                        {title}
                    </h2>

                    {partners.length > 4 ? (
                        <div style={{ textAlign: 'center' }}>
                            <div style={{
                                backgroundColor: '#f8f9fa',
                                padding: '20px',
                                borderRadius: '8px',
                                marginBottom: '20px',
                                border: '2px dashed #2D9B8A'
                            }}>
                                <p style={{ color: '#2D9B8A', fontWeight: 'bold', margin: 0 }}>
                                    🎠 Mode Slider Activé ({partners.length} partenaires)
                                </p>
                                <p style={{ color: '#6C757D', fontSize: '14px', margin: '5px 0 0 0' }}>
                                    Les partenaires défileront automatiquement sur le frontend
                                </p>
                            </div>
                            <div className="partners-logos-editor" style={{
                                display: 'flex',
                                flexWrap: 'wrap',
                                justifyContent: 'center',
                                gap: '20px',
                                maxHeight: '200px',
                                overflow: 'hidden'
                            }}>
                                {partners.slice(0, 4).map((partner, index) => (
                                    <div key={partner.id} className="partner-logo-editor" style={{
                                        width: '120px',
                                        height: '120px',
                                        backgroundColor: '#6c757d',
                                        display: 'flex',
                                        justifyContent: 'center',
                                        alignItems: 'center',
                                        overflow: 'hidden',
                                        border: '2px solid #ddd',
                                        borderRadius: '4px',
                                        position: 'relative'
                                    }}>
                                        {partner.url ? (
                                            <img
                                                src={partner.url}
                                                alt={partner.alt}
                                                style={{
                                                    width: '100%',
                                                    height: '100%',
                                                    objectFit: 'contain'
                                                }}
                                            />
                                        ) : (
                                            <div style={{
                                                color: 'white',
                                                fontSize: '12px',
                                                textAlign: 'center'
                                            }}>
                                                Logo {index + 1}
                                            </div>
                                        )}
                                    </div>
                                ))}
                                {partners.length > 4 && (
                                    <div style={{
                                        width: '120px',
                                        height: '120px',
                                        backgroundColor: '#2D9B8A',
                                        display: 'flex',
                                        justifyContent: 'center',
                                        alignItems: 'center',
                                        borderRadius: '4px',
                                        color: 'white',
                                        fontSize: '14px',
                                        fontWeight: 'bold'
                                    }}>
                                        +{partners.length - 4}
                                    </div>
                                )}
                            </div>
                        </div>
                    ) : (
                        <div className="partners-logos-editor" style={{
                            display: 'flex',
                            flexWrap: 'wrap',
                            justifyContent: 'center',
                            gap: '20px'
                        }}>
                            {partners.map((partner, index) => (
                                <div key={partner.id} className="partner-logo-editor" style={{
                                    width: '150px',
                                    height: '150px',
                                    backgroundColor: '#6c757d',
                                    display: 'flex',
                                    justifyContent: 'center',
                                    alignItems: 'center',
                                    overflow: 'hidden',
                                    border: '2px solid #ddd',
                                    borderRadius: '4px',
                                    position: 'relative'
                                }}>
                                    {partner.url ? (
                                        <img
                                            src={partner.url}
                                            alt={partner.alt}
                                            style={{
                                                width: '100%',
                                                height: '100%',
                                                objectFit: 'contain'
                                            }}
                                        />
                                    ) : (
                                        <div style={{
                                            color: '#fff',
                                            textAlign: 'center',
                                            fontSize: '14px'
                                        }}>
                                            {__('Aucune image', 'mon-theme-aca')}
                                        </div>
                                    )}

                                    <div style={{
                                        position: 'absolute',
                                        top: '50%',
                                        left: '50%',
                                        transform: 'translate(-50%, -50%)',
                                        background: 'rgba(0,0,0,0.8)',
                                        padding: '8px',
                                        borderRadius: '4px',
                                        opacity: 0,
                                        transition: 'opacity 0.3s'
                                    }}
                                        onMouseEnter={(e) => e.target.style.opacity = 1}
                                        onMouseLeave={(e) => e.target.style.opacity = 0}>
                                        <MediaUploadCheck>
                                            <MediaUpload
                                                onSelect={(media) => onSelectMedia(media, index)}
                                                allowedTypes={['image']}
                                                value={partner.id}
                                                render={({ open }) => (
                                                    <Button
                                                        onClick={open}
                                                        isSecondary
                                                        isSmall
                                                    >
                                                        {partner.url ? __('Changer', 'mon-theme-aca') : __('Choisir', 'mon-theme-aca')}
                                                    </Button>
                                                )}
                                            />
                                        </MediaUploadCheck>
                                    </div>
                                </div>
                            ))}

                            {partners.length === 0 && (
                                <div style={{
                                    padding: '40px',
                                    textAlign: 'center',
                                    color: '#666',
                                    border: '2px dashed #ddd',
                                    borderRadius: '4px',
                                    width: '100%'
                                }}>
                                    <p>{__('Aucun partenaire ajouté. Utilisez le panneau de droite pour ajouter des partenaires.', 'mon-theme-aca')}</p>
                                </div>
                            )}
                        </div>
                    )}
                </div>
            </div>
        </div>
    );
}
