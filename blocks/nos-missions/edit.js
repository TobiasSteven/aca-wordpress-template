/** 
 * WordPress dependencies 
 */
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
  TextareaControl,
  ToggleControl,
  __experimentalDivider as Divider
} from '@wordpress/components';

/** 
 * Edit component 
 */
export default function Edit({ attributes, setAttributes }) {
    const { 
        title, 
        subtitle, 
        missions, 
        showCallToAction, 
        ctaTitle, 
        ctaSubtitle, 
        ctaButtonText, 
        ctaButtonUrl 
    } = attributes;
    
    const blockProps = useBlockProps({
        className: 'nos-missions-block',
    });

    const updateMission = (index, field, value) => {
        const newMissions = [...missions];
        newMissions[index] = { ...newMissions[index], [field]: value };
        setAttributes({ missions: newMissions });
    };

    const addMission = () => {
        const newMissions = [
        ...missions,
        {
            icon: '✨',
            title: __('Nouvelle Mission', 'mon-theme-aca'),
            description: __('Description de la mission...', 'mon-theme-aca'),
        },
        ];
        setAttributes({ missions: newMissions });
    };

    const removeMission = (index) => {
        const newMissions = missions.filter((_, i) => i !== index);
        setAttributes({ missions: newMissions });
    };

    return (
        <>
        <InspectorControls>
            <PanelBody title={__('Paramètres Généraux', 'mon-theme-aca')}>
            <TextControl
                label={__('Titre de la section', 'mon-theme-aca')}
                value={title}
                onChange={(value) => setAttributes({ title: value })}
            />
            <TextareaControl
                label={__('Sous-titre', 'mon-theme-aca')}
                value={subtitle}
                onChange={(value) => setAttributes({ subtitle: value })}
                rows={3}
            />
            </PanelBody>

            <PanelBody title={__('Missions', 'mon-theme-aca')}>
            <Button 
                isPrimary 
                onClick={addMission}
                style={{ marginBottom: '15px' }}
            >
                {__('Ajouter une mission', 'mon-theme-aca')}
            </Button>
            
            {missions.map((mission, index) => (
                <div key={index} style={{ marginBottom: '20px', padding: '15px', border: '1px solid #ddd', borderRadius: '4px' }}>
                <h4>{__('Mission', 'mon-theme-aca')} {index + 1}</h4>
                <TextControl
                    label={__('Icône (Emoji)', 'mon-theme-aca')}
                    value={mission.icon}
                    onChange={(value) => updateMission(index, 'icon', value)}
                />
                <TextControl
                    label={__('Titre', 'mon-theme-aca')}
                    value={mission.title}
                    onChange={(value) => updateMission(index, 'title', value)}
                />
                <TextareaControl
                    label={__('Description', 'mon-theme-aca')}
                    value={mission.description}
                    onChange={(value) => updateMission(index, 'description', value)}
                    rows={4}
                />
                <Button 
                    isDestructive 
                    onClick={() => removeMission(index)}
                    style={{ marginTop: '10px' }}
                >
                    {__('Supprimer cette mission', 'mon-theme-aca')}
                </Button>
                </div>
            ))}
            </PanelBody>

            <PanelBody title={__('Call to Action', 'mon-theme-aca')}>
            <ToggleControl
                label={__('Afficher le Call to Action', 'mon-theme-aca')}
                checked={showCallToAction}
                onChange={(value) => setAttributes({ showCallToAction: value })}
            />
            
            {showCallToAction && (
                <>
                <TextControl
                    label={__('Titre CTA', 'mon-theme-aca')}
                    value={ctaTitle}
                    onChange={(value) => setAttributes({ ctaTitle: value })}
                />
                <TextareaControl
                    label={__('Sous-titre CTA', 'mon-theme-aca')}
                    value={ctaSubtitle}
                    onChange={(value) => setAttributes({ ctaSubtitle: value })}
                    rows={2}
                />
                <TextControl
                    label={__('Texte du bouton', 'mon-theme-aca')}
                    value={ctaButtonText}
                    onChange={(value) => setAttributes({ ctaButtonText: value })}
                />
                <TextControl
                    label={__('URL du bouton', 'mon-theme-aca')}
                    value={ctaButtonUrl}
                    onChange={(value) => setAttributes({ ctaButtonUrl: value })}
                />
                </>
            )}
            </PanelBody>
        </InspectorControls>

        <div {...blockProps}>
            {/* <section className="missions-section"> */}
            <section>
            <div className="missions-container">
                {/* Section Header */}
                <div className="missions-header">
                <RichText
                    tagName="h2"
                    className="missions-title"
                    value={title}
                    onChange={(value) => setAttributes({ title: value })}
                    placeholder={__('Titre de la section...', 'mon-theme-aca')}
                />
                <RichText
                    tagName="p"
                    className="missions-subtitle"
                    value={subtitle}
                    onChange={(value) => setAttributes({ subtitle: value })}
                    placeholder={__('Sous-titre...', 'mon-theme-aca')}
                />
                </div>

                {/* Missions Grid */}
                <div className="missions-grid">
                {missions.map((mission, index) => (
                    <div key={index} className="mission-card">
                    <div className="mission-content">
                        <div className="mission-icon-wrapper">
                        <div className="mission-icon-circle">
                            <span className="mission-icon">{mission.icon}</span>
                        </div>
                        </div>
                        <RichText
                        tagName="h3"
                        className="mission-title"
                        value={mission.title}
                        onChange={(value) => updateMission(index, 'title', value)}
                        placeholder={__('Titre de la mission...', 'mon-theme-aca')}
                        />
                        <RichText
                        tagName="p"
                        className="mission-description"
                        value={mission.description}
                        onChange={(value) => updateMission(index, 'description', value)}
                        placeholder={__('Description de la mission...', 'mon-theme-aca')}
                        />
                    </div>
                    </div>
                ))}
                </div>

                {/* Call to Action */}
                {showCallToAction && (
                <div className="missions-cta">
                    <div className="cta-content">
                    <RichText
                        tagName="h3"
                        className="cta-title"
                        value={ctaTitle}
                        onChange={(value) => setAttributes({ ctaTitle: value })}
                        placeholder={__('Titre CTA...', 'mon-theme-aca')}
                    />
                    <RichText
                        tagName="p"
                        className="cta-subtitle"
                        value={ctaSubtitle}
                        onChange={(value) => setAttributes({ ctaSubtitle: value })}
                        placeholder={__('Sous-titre CTA...', 'mon-theme-aca')}
                    />
                    <div className="cta-button-wrapper">
                        <RichText
                        tagName="span"
                        className="cta-button"
                        value={ctaButtonText}
                        onChange={(value) => setAttributes({ ctaButtonText: value })}
                        placeholder={__('Texte du bouton...', 'mon-theme-aca')}
                        />
                    </div>
                    </div>
                </div>
                )}
            </div>
            </section>
        </div>
        </>
    );
    }