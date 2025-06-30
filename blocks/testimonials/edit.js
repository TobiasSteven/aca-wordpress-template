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
    BaseControl,
    Icon
} from '@wordpress/components';
import { Fragment, useState } from '@wordpress/element';

import './editor.scss';

// Icônes SVG pour la prévisualisation dans l'éditeur
const QuoteIcon = () => <svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h4v10h-10z"></path></svg>;
const ChevronLeft = () => <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M15 19l-7-7 7-7"></path></svg>;
const ChevronRight = () => <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M9 5l7 7-7 7"></path></svg>;


export default function Edit({ attributes, setAttributes }) {
    const { sectionTitle, sectionDescription, testimonials } = attributes;
    const [currentTestimonial, setCurrentTestimonial] = useState(0);

    const addTestimonial = () => {
        const newTestimonial = {
            image: '',
            quote: __('Nouveau témoignage...', 'mon-theme-aca'),
            name: __('Nom du témoin', 'mon-theme-aca'),
            title: __('Fonction, Lieu', 'mon-theme-aca'),
            country: __('Pays', 'mon-theme-aca'),
        };
        setAttributes({ testimonials: [...testimonials, newTestimonial] });
        setCurrentTestimonial(testimonials.length); // Affiche le nouveau témoignage
    };

    const removeTestimonial = (index) => {
        const newTestimonials = testimonials.filter((_, i) => i !== index);
        if (currentTestimonial >= newTestimonials.length) {
            setCurrentTestimonial(Math.max(0, newTestimonials.length - 1));
        }
        setAttributes({ testimonials: newTestimonials });
    };

    const updateTestimonial = (index, field, value) => {
        const newTestimonials = [...testimonials];
        newTestimonials[index][field] = value;
        setAttributes({ testimonials: newTestimonials });
    };

    const blockProps = useBlockProps({
        className: 'wp-block-mon-theme-aca-testimonials-editor'
    });

    const testimonial = testimonials[currentTestimonial] || {};

    return (
        <Fragment>
            <InspectorControls>
                <PanelBody title={__('Paramètres généraux', 'mon-theme-aca')}>
                    <TextControl
                        label={__('Titre de la section', 'mon-theme-aca')}
                        value={sectionTitle}
                        onChange={(value) => setAttributes({ sectionTitle: value })}
                    />
                     <TextControl
                        label={__('Description de la section', 'mon-theme-aca')}
                        value={sectionDescription}
                        onChange={(value) => setAttributes({ sectionDescription: value })}
                    />
                </PanelBody>

                <PanelBody title={__('Gestion des témoignages', 'mon-theme-aca')}>
                    <p>{__('Vous modifiez le témoignage', 'mon-theme-aca')} {currentTestimonial + 1} / {testimonials.length}</p>
                    <BaseControl label={__('Image du témoin', 'mon-theme-aca')} id={`testimonial-image-${currentTestimonial}`}>
                        <MediaUploadCheck>
                            <MediaUpload
                                onSelect={(media) => updateTestimonial(currentTestimonial, 'image', media.url)}
                                allowedTypes={['image']}
                                value={testimonial.image}
                                render={({ open }) => (
                                    <Button onClick={open} variant={testimonial.image ? 'secondary' : 'primary'}>
                                        {testimonial.image ? __('Changer l\'image', 'mon-theme-aca') : __('Sélectionner une image', 'mon-theme-aca')}
                                    </Button>
                                )}
                            />
                        </MediaUploadCheck>
                        {testimonial.image && (
                            <div style={{ marginTop: '10px' }}>
                                <img src={testimonial.image} alt="" style={{ maxWidth: '100px', height: 'auto' }}/>
                                <Button isDestructive variant="link" onClick={() => updateTestimonial(currentTestimonial, 'image', '')}>
                                    {__('Supprimer l\'image', 'mon-theme-aca')}
                                </Button>
                            </div>
                        )}
                    </BaseControl>
                    <TextControl label={__('Citation', 'mon-theme-aca')} value={testimonial.quote} onChange={(value) => updateTestimonial(currentTestimonial, 'quote', value)} />
                    <TextControl label={__('Nom', 'mon-theme-aca')} value={testimonial.name} onChange={(value) => updateTestimonial(currentTestimonial, 'name', value)} />
                    <TextControl label={__('Poste', 'mon-theme-aca')} value={testimonial.title} onChange={(value) => updateTestimonial(currentTestimonial, 'title', value)} />
                    <TextControl label={__('Pays', 'mon-theme-aca')} value={testimonial.country} onChange={(value) => updateTestimonial(currentTestimonial, 'country', value)} />
                    <hr/>
                    <Button isDestructive variant="primary" onClick={() => removeTestimonial(currentTestimonial)} style={{ marginTop: '16px' }}>
                        {__('Supprimer ce témoignage', 'mon-theme-aca')}
                    </Button>
                </PanelBody>
                 <PanelBody title={__("Ajouter un nouveau témoignage", "mon-theme-aca")}>
                    <Button variant="primary" onClick={addTestimonial}>
                        {__('Ajouter un témoignage', 'mon-theme-aca')}
                    </Button>
                </PanelBody>
            </InspectorControls>

            <div {...blockProps}>
                 <div className="text-center mb-12">
                    <RichText
                        tagName="h2"
                        className="text-3xl md:text-4xl font-bold text-[#1F6B5C] mb-4"
                        value={sectionTitle}
                        onChange={(value) => setAttributes({ sectionTitle: value })}
                        placeholder={__('Titre de la section...', 'mon-theme-aca')}
                    />
                    <RichText
                        tagName="p"
                        className="text-lg text-[#6C757D] max-w-2xl mx-auto"
                        value={sectionDescription}
                        onChange={(value) => setAttributes({ sectionDescription: value })}
                        placeholder={__('Description...', 'mon-theme-aca')}
                    />
                </div>

                <div className="relative max-w-4xl mx-auto">
                     {testimonials.length > 0 && (
                        <div className="testimonial-card-editor bg-white rounded-2xl p-8 md:p-12 shadow-xl relative">
                            <div className="absolute top-6 left-6 text-[#A8E6CF]"><QuoteIcon /></div>
                            <div className="text-center pt-8">
                                <RichText
                                    tagName="blockquote"
                                    className="text-xl md:text-2xl text-[#343A40] mb-8 leading-relaxed italic"
                                    value={testimonial.quote}
                                    onChange={(value) => updateTestimonial(currentTestimonial, 'quote', value)}
                                    placeholder={__('Citation...', 'mon-theme-aca')}
                                />
                                <div className="flex items-center justify-center space-x-4">
                                    {testimonial.image && <img src={testimonial.image} alt={testimonial.name} className="w-16 h-16 rounded-full object-cover border-4 border-[#2D9B8A]" />}
                                    <div className="text-left">
                                        <RichText
                                            tagName="div"
                                            className="font-bold text-[#1F6B5C] text-lg"
                                            value={testimonial.name}
                                            onChange={(value) => updateTestimonial(currentTestimonial, 'name', value)}
                                            placeholder={__('Nom...', 'mon-theme-aca')}
                                        />
                                        <RichText
                                            tagName="div"
                                            className="text-[#6C757D]"
                                            value={testimonial.title}
                                            onChange={(value) => updateTestimonial(currentTestimonial, 'title', value)}
                                            placeholder={__('Poste...', 'mon-theme-aca')}
                                        />
                                        <RichText
                                            tagName="div"
                                            className="text-[#2D9B8A] font-medium"
                                            value={testimonial.country}
                                            onChange={(value) => updateTestimonial(currentTestimonial, 'country', value)}
                                            placeholder={__('Pays...', 'mon-theme-aca')}
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                    )}

                    {/* Navigation dans l'éditeur */}
                    {testimonials.length > 1 && (
                        <>
                            <button
                                onClick={() => setCurrentTestimonial((prev) => (prev - 1 + testimonials.length) % testimonials.length)}
                                className="nav-button-editor prev"
                            >
                                <ChevronLeft />
                            </button>
                            <button
                                onClick={() => setCurrentTestimonial((prev) => (prev + 1) % testimonials.length)}
                                className="nav-button-editor next"
                            >
                                <ChevronRight />
                            </button>
                             <div className="dots-container-editor">
                                {testimonials.map((_, index) => (
                                    <button
                                        key={index}
                                        onClick={() => setCurrentTestimonial(index)}
                                        className={index === currentTestimonial ? 'active' : ''}
                                    />
                                ))}
                            </div>
                        </>
                    )}
                </div>
            </div>
        </Fragment>
    );
}