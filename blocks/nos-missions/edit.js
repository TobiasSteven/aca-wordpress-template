/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import {
    useBlockProps,
    InspectorControls,
    RichText,
} from '@wordpress/block-editor';
import {
    PanelBody,
    Button,
    TextControl,
    TextareaControl,
} from '@wordpress/components';

/**
 * Edit component
 */
export default function Edit({ attributes, setAttributes }) {
    const { title, missions } = attributes;
    const blockProps = useBlockProps({
        className: 'nos-missions-block',
    });

    const updateMission = (index, field, value) => {
        const newMissions = [...missions];
        newMissions[index] = {
            ...newMissions[index],
            [field]: value,
        };
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
                <PanelBody title={__('Paramètres des Missions', 'mon-theme-aca')}>
                    <TextControl
                        label={__('Titre de la section', 'mon-theme-aca')}
                        value={title}
                        onChange={(value) => setAttributes({ title: value })}
                    />
                    <Button
                        isPrimary
                        onClick={addMission}
                        style={{ marginTop: '10px' }}
                    >
                        {__('Ajouter une mission', 'mon-theme-aca')}
                    </Button>
                </PanelBody>

                {missions.map((mission, index) => (
                    <PanelBody
                        key={index}
                        title={`${__('Mission', 'mon-theme-aca')} ${index + 1}: ${mission.title}`}
                        initialOpen={false}
                    >
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
                    </PanelBody>
                ))}
            </InspectorControls>

            <div {...blockProps}>
                <div className="missions-container">
                    <RichText
                        tagName="h2"
                        className="missions-title"
                        value={title}
                        onChange={(value) => setAttributes({ title: value })}
                        placeholder={__('Titre de la section...', 'mon-theme-aca')}
                    />

                    <div className="missions-cards">
                        {missions.map((mission, index) => (
                            <div key={index} className="mission-card">
                                <div className="mission-icon">{mission.icon}</div>
                                <RichText
                                    tagName="h3"
                                    value={mission.title}
                                    onChange={(value) => updateMission(index, 'title', value)}
                                    placeholder={__('Titre de la mission...', 'mon-theme-aca')}
                                />
                                <RichText
                                    tagName="p"
                                    value={mission.description}
                                    onChange={(value) => updateMission(index, 'description', value)}
                                    placeholder={__('Description de la mission...', 'mon-theme-aca')}
                                />
                            </div>
                        ))}
                    </div>
                </div>
            </div>
        </>
    );
}
