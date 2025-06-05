import { __ } from '@wordpress/i18n';
import {
    useBlockProps,
    InspectorControls,
    RichText,
    MediaUpload,
    MediaUploadCheck
} from '@wordpress/block-editor';
import {
    PanelBody,
    Button,
    TextControl,
    BaseControl
} from '@wordpress/components';
import { Fragment } from '@wordpress/element';

import './editor.scss';

export default function Edit({ attributes, setAttributes }) {
    const { sectionTitle, testimonials } = attributes;

    const addTestimonial = () => {
        const newTestimonial = {
            image: '',
            quote: __('Nouveau témoignage...', 'mon-theme-aca'),
            name: __('Nom du témoin', 'mon-theme-aca'),
            title: __('Fonction, Lieu', 'mon-theme-aca')
        };
        setAttributes({
            testimonials: [...testimonials, newTestimonial]
        });
    };

    const removeTestimonial = (index) => {
        const newTestimonials = testimonials.filter((_, i) => i !== index);
        setAttributes({ testimonials: newTestimonials });
    };

    const updateTestimonial = (index, field, value) => {
        const newTestimonials = [...testimonials];
        newTestimonials[index][field] = value;
        setAttributes({ testimonials: newTestimonials });
    };

    const blockProps = useBlockProps({
        className: 'testimonials-section-editor'
    });

    return (
        <Fragment>
            <InspectorControls>
                <PanelBody title={__('Paramètres généraux', 'mon-theme-aca')}>
                    <TextControl
                        label={__('Titre de la section', 'mon-theme-aca')}
                        value={sectionTitle}
                        onChange={(value) => setAttributes({ sectionTitle: value })}
                    />

                    <Button
                        variant="primary"
                        onClick={addTestimonial}
                        style={{ marginTop: '16px' }}
                    >
                        {__('Ajouter un témoignage', 'mon-theme-aca')}
                    </Button>
                </PanelBody>

                {testimonials.map((testimonial, index) => (
                    <PanelBody
                        key={index}
                        title={__('Témoignage', 'mon-theme-aca') + ` ${index + 1}`}
                        initialOpen={false}
                    >
                        <BaseControl label={__('Image du témoin', 'mon-theme-aca')}>
                            <MediaUploadCheck>
                                <MediaUpload
                                    onSelect={(media) =>
                                        updateTestimonial(index, 'image', media.url)
                                    }
                                    allowedTypes={['image']}
                                    value={testimonial.image}
                                    render={({ open }) => (
                                        <Button
                                            onClick={open}
                                            variant={testimonial.image ? 'secondary' : 'primary'}
                                        >
                                            {testimonial.image
                                                ? __('Changer l\'image', 'mon-theme-aca')
                                                : __('Sélectionner une image', 'mon-theme-aca')
                                            }
                                        </Button>
                                    )}
                                />
                            </MediaUploadCheck>
                            {testimonial.image && (
                                <div style={{ marginTop: '10px' }}>
                                    <img
                                        src={testimonial.image}
                                        alt=""
                                        style={{ maxWidth: '100px', height: 'auto' }}
                                    />
                                    <br />
                                    <Button
                                        isDestructive
                                        variant="link"
                                        onClick={() => updateTestimonial(index, 'image', '')}
                                    >
                                        {__('Supprimer l\'image', 'mon-theme-aca')}
                                    </Button>
                                </div>
                            )}
                        </BaseControl>

                        <TextControl
                            label={__('URL d\'image (alternative)', 'mon-theme-aca')}
                            value={testimonial.image}
                            onChange={(value) => updateTestimonial(index, 'image', value)}
                            help={__('Vous pouvez aussi saisir directement une URL d\'image', 'mon-theme-aca')}
                        />

                        <BaseControl label={__('Citation', 'mon-theme-aca')}>
                            <textarea
                                value={testimonial.quote}
                                onChange={(e) => updateTestimonial(index, 'quote', e.target.value)}
                                rows="4"
                                style={{ width: '100%' }}
                            />
                        </BaseControl>

                        <TextControl
                            label={__('Nom du témoin', 'mon-theme-aca')}
                            value={testimonial.name}
                            onChange={(value) => updateTestimonial(index, 'name', value)}
                        />

                        <TextControl
                            label={__('Fonction et lieu', 'mon-theme-aca')}
                            value={testimonial.title}
                            onChange={(value) => updateTestimonial(index, 'title', value)}
                        />

                        <Button
                            isDestructive
                            variant="link"
                            onClick={() => removeTestimonial(index)}
                            style={{ marginTop: '16px' }}
                        >
                            {__('Supprimer ce témoignage', 'mon-theme-aca')}
                        </Button>
                    </PanelBody>
                ))}
            </InspectorControls>

            <div {...blockProps}>
                <div className="testimonials-section">
                    <RichText
                        tagName="h2"
                        value={sectionTitle}
                        onChange={(value) => setAttributes({ sectionTitle: value })}
                        placeholder={__('Titre de la section...', 'mon-theme-aca')}
                        allowedFormats={[]}
                    />

                    <div className="testimonials-grid">
                        {testimonials.map((testimonial, index) => (
                            <div key={index} className="testimonial-card">
                                {testimonial.image && (
                                    <img
                                        src={testimonial.image}
                                        alt={`Photo de ${testimonial.name}`}
                                    />
                                )}

                                <RichText
                                    tagName="p"
                                    className="quote"
                                    value={testimonial.quote}
                                    onChange={(value) => updateTestimonial(index, 'quote', value)}
                                    placeholder={__('Citation du témoignage...', 'mon-theme-aca')}
                                    allowedFormats={['core/italic', 'core/bold']}
                                />

                                <RichText
                                    tagName="p"
                                    className="name"
                                    value={testimonial.name}
                                    onChange={(value) => updateTestimonial(index, 'name', value)}
                                    placeholder={__('Nom du témoin...', 'mon-theme-aca')}
                                    allowedFormats={[]}
                                />

                                <RichText
                                    tagName="p"
                                    className="title"
                                    value={testimonial.title}
                                    onChange={(value) => updateTestimonial(index, 'title', value)}
                                    placeholder={__('Fonction, lieu...', 'mon-theme-aca')}
                                    allowedFormats={[]}
                                />
                            </div>
                        ))}
                    </div>
                </div>
            </div>
        </Fragment>
    );
}
