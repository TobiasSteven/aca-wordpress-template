/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import {
    useBlockProps,
    InspectorControls,
} from '@wordpress/block-editor';
import {
    Panel,
    PanelBody,
    TextControl,
    ColorPicker,
} from '@wordpress/components';

/**
 * Editor component for the Newsletter block
 */
export default function Edit({ attributes, setAttributes }) {
    const {
        sectionTitle,
        subtitle,
        buttonText,
        placeholderText,
        backgroundColor,
        textColor,
        buttonColor,
        buttonTextColor,
    } = attributes;

    // Update functions for each attribute
    const onChangeSectionTitle = (newTitle) => {
        setAttributes({ sectionTitle: newTitle });
    };

    const onChangeSubtitle = (newSubtitle) => {
        setAttributes({ subtitle: newSubtitle });
    };

    const onChangeButtonText = (newButtonText) => {
        setAttributes({ buttonText: newButtonText });
    };

    const onChangePlaceholderText = (newPlaceholderText) => {
        setAttributes({ placeholderText: newPlaceholderText });
    };

    const onChangeBackgroundColor = (newColor) => {
        setAttributes({ backgroundColor: newColor.hex });
    };

    const onChangeTextColor = (newColor) => {
        setAttributes({ textColor: newColor.hex });
    };

    const onChangeButtonColor = (newColor) => {
        setAttributes({ buttonColor: newColor.hex });
    };

    const onChangeButtonTextColor = (newColor) => {
        setAttributes({ buttonTextColor: newColor.hex });
    };

    // Inline styles for the editor preview
    const sectionStyle = {
        backgroundColor: backgroundColor,
        color: textColor,
        padding: '60px 20px',
        textAlign: 'center',
        fontFamily: '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol"',
    };

    const titleStyle = {
        fontSize: '2.2em',
        marginTop: '0',
        marginBottom: '15px',
        fontWeight: '600',
    };

    const subtitleStyle = {
        fontSize: '1.1em',
        marginBottom: '35px',
        lineHeight: '1.6',
        maxWidth: '550px',
        marginLeft: 'auto',
        marginRight: 'auto',
    };

    const formStyle = {
        display: 'flex',
        justifyContent: 'center',
        alignItems: 'stretch',
        maxWidth: '500px',
        margin: '0 auto',
    };

    const inputStyle = {
        flexGrow: '1',
        padding: '15px 20px',
        fontSize: '1em',
        border: 'none',
        borderRadius: '5px',
        backgroundColor: '#FFFFFF',
        color: '#343A40',
        marginRight: '-1px',
        boxSizing: 'border-box',
    };

    const buttonStyle = {
        padding: '15px 25px',
        fontSize: '1em',
        border: 'none',
        borderRadius: '5px',
        backgroundColor: buttonColor,
        color: buttonTextColor,
        cursor: 'pointer',
        fontWeight: 'bold',
        whiteSpace: 'nowrap',
        marginLeft: '10px',
        boxSizing: 'border-box',
    };

    // Render the block in the editor
    return (
        <>
            <InspectorControls>
                <Panel>
                    <PanelBody title={__('Paramètres de la newsletter', 'mon-theme-aca')} initialOpen={true}>
                        <TextControl
                            label={__('Titre de la section', 'mon-theme-aca')}
                            value={sectionTitle}
                            onChange={onChangeSectionTitle}
                        />
                        <TextControl
                            label={__('Sous-titre', 'mon-theme-aca')}
                            value={subtitle}
                            onChange={onChangeSubtitle}
                        />
                        <TextControl
                            label={__('Texte du bouton', 'mon-theme-aca')}
                            value={buttonText}
                            onChange={onChangeButtonText}
                        />
                        <TextControl
                            label={__('Texte du placeholder', 'mon-theme-aca')}
                            value={placeholderText}
                            onChange={onChangePlaceholderText}
                        />
                    </PanelBody>

                    <PanelBody title={__('Couleurs', 'mon-theme-aca')} initialOpen={false}>
                        <div className="color-picker-wrapper">
                            <label>{__('Couleur de fond', 'mon-theme-aca')}</label>
                            <ColorPicker
                                color={backgroundColor}
                                onChangeComplete={onChangeBackgroundColor}
                                disableAlpha
                            />
                        </div>
                        <div className="color-picker-wrapper" style={{ marginTop: '15px' }}>
                            <label>{__('Couleur du texte', 'mon-theme-aca')}</label>
                            <ColorPicker
                                color={textColor}
                                onChangeComplete={onChangeTextColor}
                                disableAlpha
                            />
                        </div>
                        <div className="color-picker-wrapper" style={{ marginTop: '15px' }}>
                            <label>{__('Couleur du bouton', 'mon-theme-aca')}</label>
                            <ColorPicker
                                color={buttonColor}
                                onChangeComplete={onChangeButtonColor}
                                disableAlpha
                            />
                        </div>
                        <div className="color-picker-wrapper" style={{ marginTop: '15px' }}>
                            <label>{__('Couleur du texte du bouton', 'mon-theme-aca')}</label>
                            <ColorPicker
                                color={buttonTextColor}
                                onChangeComplete={onChangeButtonTextColor}
                                disableAlpha
                            />
                        </div>
                    </PanelBody>
                </Panel>
            </InspectorControls>

            <div {...useBlockProps()}>
                <div style={sectionStyle}>
                    <h2 style={titleStyle}>{sectionTitle}</h2>
                    <p style={subtitleStyle}>{subtitle}</p>
                    <div style={formStyle}>
                        <input
                            type="email"
                            placeholder={placeholderText}
                            style={inputStyle}
                            disabled
                        />
                        <button style={buttonStyle}>{buttonText}</button>
                    </div>
                </div>
            </div>
        </>
    );
}
