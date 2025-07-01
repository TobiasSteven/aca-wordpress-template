import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, TextControl, ColorPicker } from '@wordpress/components';

export default function Edit({ attributes, setAttributes }) {
    const {
        sectionTitle,
        subtitle,
        buttonText,
        placeholderText,
        backgroundColor,
        textColor,
        buttonColor,
        buttonTextColor
    } = attributes;

    const blockProps = useBlockProps();

    return (
        <>
            <InspectorControls>
                <PanelBody title={__('Contenu de la section', 'mon-theme-aca')}>
                    <TextControl
                        label={__('Titre', 'mon-theme-aca')}
                        value={sectionTitle}
                        onChange={(value) => setAttributes({ sectionTitle: value })}
                    />
                    <TextControl
                        label={__('Sous-titre', 'mon-theme-aca')}
                        value={subtitle}
                        onChange={(value) => setAttributes({ subtitle: value })}
                    />
                    <TextControl
                        label={__('Texte du placeholder', 'mon-theme-aca')}
                        value={placeholderText}
                        onChange={(value) => setAttributes({ placeholderText: value })}
                    />
                    <TextControl
                        label={__('Texte du bouton', 'mon-theme-aca')}
                        value={buttonText}
                        onChange={(value) => setAttributes({ buttonText: value })}
                    />
                </PanelBody>
                <PanelBody title={__('Couleurs', 'mon-theme-aca')} initialOpen={false}>
                    <div>
                        <label>{__('Couleur de fond', 'mon-theme-aca')}</label>
                        <ColorPicker
                            color={backgroundColor}
                            onChangeComplete={(color) => setAttributes({ backgroundColor: color.hex })}
                            disableAlpha
                        />
                    </div>
                    <div style={{ marginTop: '15px' }}>
                        <label>{__('Couleur du texte principal', 'mon-theme-aca')}</label>
                        <ColorPicker
                            color={textColor}
                            onChangeComplete={(color) => setAttributes({ textColor: color.hex })}
                            disableAlpha
                        />
                    </div>
                    <div style={{ marginTop: '15px' }}>
                        <label>{__('Couleur du bouton', 'mon-theme-aca')}</label>
                        <ColorPicker
                            color={buttonColor}
                            onChangeComplete={(color) => setAttributes({ buttonColor: color.hex })}
                            disableAlpha
                        />
                    </div>
                    <div style={{ marginTop: '15px' }}>
                        <label>{__('Couleur du texte du bouton', 'mon-theme-aca')}</label>
                        <ColorPicker
                            color={buttonTextColor}
                            onChangeComplete={(color) => setAttributes({ buttonTextColor: color.hex })}
                            disableAlpha
                        />
                    </div>
                </PanelBody>
            </InspectorControls>

            <div {...blockProps} style={{ backgroundColor: backgroundColor, color: textColor, padding: '2rem' }}>
                <h2 style={{ color: textColor }}>{sectionTitle}</h2>
                <p style={{ color: '#A8E6CF' }}>{subtitle}</p>
                <form style={{ display: 'flex', gap: '1rem', alignItems: 'center' }}>
                    <input type="email" placeholder={placeholderText} disabled style={{ flexGrow: 1, padding: '0.5rem' }} />
                    <button type="button" style={{ backgroundColor: buttonColor, color: buttonTextColor, padding: '0.5rem 1rem', borderRadius: '0.25rem' }}>
                        {buttonText}
                    </button>
                </form>
            </div>
        </>
    );
}