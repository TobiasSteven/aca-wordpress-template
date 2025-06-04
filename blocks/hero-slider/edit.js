import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls, MediaUpload, MediaUploadCheck } from '@wordpress/block-editor';
import {
    PanelBody,
    TextControl,
    Button,
    ToggleControl,
    RangeControl,
    SelectControl,
    __experimentalHeading as Heading
} from '@wordpress/components';
import { useState } from '@wordpress/element';

export default function Edit({ attributes, setAttributes }) {
    const { slides, sliderHeight, autoPlay, autoPlaySpeed, showNavigation, showIndicators } = attributes;
    const [currentSlide, setCurrentSlide] = useState(0);

    const updateSlide = (index, field, value) => {
        const newSlides = [...slides];
        newSlides[index] = { ...newSlides[index], [field]: value };
        setAttributes({ slides: newSlides });
    };

    const addSlide = () => {
        const newSlides = [...slides, {
            backgroundImage: "",
            title: __("Nouveau slide", "mon-theme-aca"),
            subtitle: __("Votre sous-titre ici", "mon-theme-aca"),
            primaryButtonText: __("Bouton principal", "mon-theme-aca"),
            primaryButtonUrl: "#",
            secondaryButtonText: __("Bouton secondaire", "mon-theme-aca"),
            secondaryButtonUrl: "#"
        }];
        setAttributes({ slides: newSlides });
    };

    const removeSlide = (index) => {
        if (slides.length > 1) {
            const newSlides = slides.filter((_, i) => i !== index);
            setAttributes({ slides: newSlides });
            if (currentSlide >= newSlides.length) {
                setCurrentSlide(newSlides.length - 1);
            }
        }
    };

    const blockProps = useBlockProps({
        className: 'wp-block-mon-theme-aca-hero-slider'
    });

    const heightOptions = [
        { label: '50vh', value: '50vh' },
        { label: '60vh', value: '60vh' },
        { label: '70vh', value: '70vh' },
        { label: '80vh', value: '80vh' },
        { label: '90vh', value: '90vh' },
        { label: '100vh', value: '100vh' },
    ];

    return (
        <>
            <InspectorControls>
                <PanelBody title={__('Paramètres du slider', 'mon-theme-aca')} initialOpen={true}>
                    <SelectControl
                        label={__('Hauteur du slider', 'mon-theme-aca')}
                        value={sliderHeight}
                        options={heightOptions}
                        onChange={(value) => setAttributes({ sliderHeight: value })}
                    />

                    <ToggleControl
                        label={__('Lecture automatique', 'mon-theme-aca')}
                        checked={autoPlay}
                        onChange={(value) => setAttributes({ autoPlay: value })}
                    />

                    {autoPlay && (
                        <RangeControl
                            label={__('Vitesse de lecture (ms)', 'mon-theme-aca')}
                            value={autoPlaySpeed}
                            onChange={(value) => setAttributes({ autoPlaySpeed: value })}
                            min={2000}
                            max={10000}
                            step={500}
                        />
                    )}

                    <ToggleControl
                        label={__('Afficher la navigation', 'mon-theme-aca')}
                        checked={showNavigation}
                        onChange={(value) => setAttributes({ showNavigation: value })}
                    />

                    <ToggleControl
                        label={__('Afficher les indicateurs', 'mon-theme-aca')}
                        checked={showIndicators}
                        onChange={(value) => setAttributes({ showIndicators: value })}
                    />
                </PanelBody>

                <PanelBody title={__('Gestion des slides', 'mon-theme-aca')} initialOpen={false}>
                    <div style={{ marginBottom: '20px' }}>
                        <Button
                            variant="primary"
                            onClick={addSlide}
                            style={{ marginBottom: '10px' }}
                        >
                            {__('Ajouter un slide', 'mon-theme-aca')}
                        </Button>
                    </div>

                    {slides.map((slide, index) => (
                        <div key={index} style={{ marginBottom: '20px', padding: '15px', border: '1px solid #ddd', borderRadius: '4px' }}>
                            <Heading level={4}>
                                {__('Slide', 'mon-theme-aca')} {index + 1}
                                {slides.length > 1 && (
                                    <Button
                                        variant="secondary"
                                        isDestructive
                                        onClick={() => removeSlide(index)}
                                        style={{ marginLeft: '10px', fontSize: '12px' }}
                                    >
                                        {__('Supprimer', 'mon-theme-aca')}
                                    </Button>
                                )}
                            </Heading>

                            <MediaUploadCheck>
                                <MediaUpload
                                    onSelect={(media) => updateSlide(index, 'backgroundImage', media.url)}
                                    allowedTypes={['image']}
                                    value={slide.backgroundImage}
                                    render={({ open }) => (
                                        <div style={{ marginBottom: '10px' }}>
                                            <Button
                                                variant={slide.backgroundImage ? 'secondary' : 'primary'}
                                                onClick={open}
                                            >
                                                {slide.backgroundImage ? __('Changer l\'image', 'mon-theme-aca') : __('Sélectionner une image', 'mon-theme-aca')}
                                            </Button>
                                            {slide.backgroundImage && (
                                                <div style={{ marginTop: '10px' }}>
                                                    <img
                                                        src={slide.backgroundImage}
                                                        alt={__('Image de fond', 'mon-theme-aca')}
                                                        style={{ maxWidth: '200px', height: 'auto' }}
                                                    />
                                                    <br />
                                                    <Button
                                                        variant="link"
                                                        isDestructive
                                                        onClick={() => updateSlide(index, 'backgroundImage', '')}
                                                    >
                                                        {__('Supprimer l\'image', 'mon-theme-aca')}
                                                    </Button>
                                                </div>
                                            )}
                                        </div>
                                    )}
                                />
                            </MediaUploadCheck>

                            <TextControl
                                label={__('Titre', 'mon-theme-aca')}
                                value={slide.title}
                                onChange={(value) => updateSlide(index, 'title', value)}
                            />

                            <TextControl
                                label={__('Sous-titre', 'mon-theme-aca')}
                                value={slide.subtitle}
                                onChange={(value) => updateSlide(index, 'subtitle', value)}
                            />

                            <TextControl
                                label={__('Texte bouton principal', 'mon-theme-aca')}
                                value={slide.primaryButtonText}
                                onChange={(value) => updateSlide(index, 'primaryButtonText', value)}
                            />

                            <TextControl
                                label={__('URL bouton principal', 'mon-theme-aca')}
                                value={slide.primaryButtonUrl}
                                onChange={(value) => updateSlide(index, 'primaryButtonUrl', value)}
                            />

                            <TextControl
                                label={__('Texte bouton secondaire', 'mon-theme-aca')}
                                value={slide.secondaryButtonText}
                                onChange={(value) => updateSlide(index, 'secondaryButtonText', value)}
                            />

                            <TextControl
                                label={__('URL bouton secondaire', 'mon-theme-aca')}
                                value={slide.secondaryButtonUrl}
                                onChange={(value) => updateSlide(index, 'secondaryButtonUrl', value)}
                            />
                        </div>
                    ))}
                </PanelBody>
            </InspectorControls>

            <div {...blockProps}>
                <div className="hero-slider-editor" style={{
                    position: 'relative',
                    height: sliderHeight,
                    backgroundColor: '#f0f0f0',
                    borderRadius: '8px',
                    overflow: 'hidden'
                }}>
                    {/* Navigation des slides dans l'éditeur */}
                    {slides.length > 1 && (
                        <div style={{
                            position: 'absolute',
                            top: '10px',
                            left: '10px',
                            zIndex: 10,
                            backgroundColor: 'rgba(0,0,0,0.7)',
                            borderRadius: '4px',
                            padding: '5px'
                        }}>
                            {slides.map((_, index) => (
                                <Button
                                    key={index}
                                    variant={currentSlide === index ? 'primary' : 'secondary'}
                                    onClick={() => setCurrentSlide(index)}
                                    style={{
                                        margin: '2px',
                                        minWidth: '30px',
                                        fontSize: '12px'
                                    }}
                                >
                                    {index + 1}
                                </Button>
                            ))}
                        </div>
                    )}

                    {/* Slide actuel dans l'éditeur */}
                    {slides[currentSlide] && (
                        <div
                            className="hero-slide-preview"
                            style={{
                                height: '100%',
                                backgroundImage: slides[currentSlide].backgroundImage ? `url(${slides[currentSlide].backgroundImage})` : 'none',
                                backgroundSize: 'cover',
                                backgroundPosition: 'center',
                                display: 'flex',
                                alignItems: 'center',
                                justifyContent: 'center',
                                textAlign: 'center',
                                color: 'white',
                                padding: '2rem',
                                backgroundColor: slides[currentSlide].backgroundImage ? 'transparent' : '#2D9B8A'
                            }}
                        >
                            <div className="hero-content-preview">
                                <h1 style={{
                                    fontSize: 'clamp(2rem, 5vw, 4rem)',
                                    fontWeight: 'bold',
                                    marginBottom: '1rem',
                                    textShadow: '2px 2px 4px rgba(0,0,0,0.5)'
                                }}>
                                    {slides[currentSlide].title}
                                </h1>
                                <p style={{
                                    fontSize: 'clamp(1rem, 2vw, 1.25rem)',
                                    marginBottom: '2rem',
                                    textShadow: '1px 1px 2px rgba(0,0,0,0.5)'
                                }}>
                                    {slides[currentSlide].subtitle}
                                </p>
                                <div style={{ display: 'flex', gap: '1rem', justifyContent: 'center', flexWrap: 'wrap' }}>
                                    {slides[currentSlide].primaryButtonText && (
                                        <span style={{
                                            display: 'inline-block',
                                            backgroundColor: '#28A745',
                                            color: 'white',
                                            fontWeight: '600',
                                            padding: '12px 32px',
                                            borderRadius: '8px',
                                            textDecoration: 'none'
                                        }}>
                                            {slides[currentSlide].primaryButtonText}
                                        </span>
                                    )}
                                    {slides[currentSlide].secondaryButtonText && (
                                        <span style={{
                                            display: 'inline-block',
                                            backgroundColor: '#FFFFFF',
                                            color: '#343A40',
                                            fontWeight: '600',
                                            padding: '12px 32px',
                                            borderRadius: '8px',
                                            textDecoration: 'none'
                                        }}>
                                            {slides[currentSlide].secondaryButtonText}
                                        </span>
                                    )}
                                </div>
                            </div>
                        </div>
                    )}
                </div>
            </div>
        </>
    );
}
