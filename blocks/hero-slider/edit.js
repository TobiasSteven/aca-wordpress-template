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
import { select } from '@wordpress/data';

export default function Edit({ attributes, setAttributes }) {
    const { slides, sliderHeight, autoPlay, autoPlaySpeed, showNavigation, showIndicators } = attributes;
    const [currentSlide, setCurrentSlide] = useState(0);

    const updateSlide = (index, field, value) => {
        const newSlides = [...slides];
        newSlides[index] = { ...newSlides[index], [field]: value };
        setAttributes({ slides: newSlides });
    };

    const addSlide = () => {
        const newSlide = {
            backgroundImage: "",
            title: __("Nouveau slide", "mon-theme-aca"),
            subtitle: __("Votre sous-titre ici", "mon-theme-aca"),
            primaryButtonText: __("Bouton principal", "mon-theme-aca"),
            primaryButtonUrl: "#",
            secondaryButtonText: __("Bouton secondaire", "mon-theme-aca"),
            secondaryButtonUrl: "#"
        };
        const newSlides = [...slides, newSlide];
        setAttributes({ slides: newSlides });
        // Mettre à jour le slide actuel vers le nouveau slide
        setCurrentSlide(newSlides.length - 1);
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
                    <div style={{ marginBottom: '20px', padding: '10px', backgroundColor: '#f0f0f0', borderRadius: '4px' }}>
                        <p style={{ margin: '0 0 10px 0', fontWeight: 'bold' }}>
                            {__('Nombre de slides :', 'mon-theme-aca')} {slides.length}
                        </p>
                        <Button
                            variant="primary"
                            onClick={addSlide}
                            style={{ marginBottom: '5px' }}
                        >
                            {__('➕ Ajouter un slide', 'mon-theme-aca')}
                        </Button>
                        <p style={{ margin: '5px 0 0 0', fontSize: '12px', color: '#666' }}>
                            {__('Vous pouvez ajouter autant de slides que vous voulez', 'mon-theme-aca')}
                        </p>
                    </div>

                    {slides.map((slide, index) => (
                        <div key={`slide-${index}`} style={{
                            marginBottom: '20px',
                            padding: '15px',
                            border: index === currentSlide ? '2px solid #0073aa' : '1px solid #ddd',
                            borderRadius: '4px',
                            backgroundColor: index === currentSlide ? '#f0f8ff' : '#fff'
                        }}>
                            <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: '10px' }}>
                                <Heading level={4} style={{ margin: 0 }}>
                                    {__('Slide', 'mon-theme-aca')} {index + 1}
                                    {index === currentSlide && (
                                        <span style={{ fontSize: '12px', color: '#0073aa', marginLeft: '10px' }}>
                                            {__('(En cours de prévisualisation)', 'mon-theme-aca')}
                                        </span>
                                    )}
                                </Heading>
                                <div>
                                    <Button
                                        variant="secondary"
                                        onClick={() => setCurrentSlide(index)}
                                        style={{ marginRight: '5px', fontSize: '12px' }}
                                    >
                                        {__('Prévisualiser', 'mon-theme-aca')}
                                    </Button>
                                    {slides.length > 1 && (
                                        <Button
                                            variant="secondary"
                                            isDestructive
                                            onClick={() => removeSlide(index)}
                                            style={{ fontSize: '12px' }}
                                        >
                                            {__('🗑️ Supprimer', 'mon-theme-aca')}
                                        </Button>
                                    )}
                                </div>
                            </div>

                            <div style={{ marginBottom: '15px' }}>
                                <label style={{ display: 'block', marginBottom: '5px', fontWeight: '600' }}>
                                    {__('Image de fond', 'mon-theme-aca')}
                                </label>
                                <MediaUploadCheck
                                    fallback={
                                        <p>{__('Pour sélectionner une image, vous devez avoir les permissions de téléchargement.', 'mon-theme-aca')}</p>
                                    }
                                >
                                    <MediaUpload
                                        onSelect={(media) => {
                                            console.log('Media selected:', media);
                                            if (media && media.url) {
                                                updateSlide(index, 'backgroundImage', media.url);
                                            }
                                        }}
                                        allowedTypes={['image']}
                                        value={slide.backgroundImage}
                                        multiple={false}
                                        render={({ open }) => (
                                            <div>
                                                <Button
                                                    variant={slide.backgroundImage ? 'secondary' : 'primary'}
                                                    onClick={open}
                                                    style={{ display: 'block', marginBottom: '10px', width: '100%' }}
                                                >
                                                    {slide.backgroundImage ? __('📷 Changer l\'image', 'mon-theme-aca') : __('📷 Sélectionner une image', 'mon-theme-aca')}
                                                </Button>
                                                {slide.backgroundImage && (
                                                    <div style={{ marginTop: '10px' }}>
                                                        <img
                                                            src={slide.backgroundImage}
                                                            alt={__('Image de fond', 'mon-theme-aca')}
                                                            style={{
                                                                width: '100%',
                                                                height: 'auto',
                                                                maxHeight: '150px',
                                                                objectFit: 'cover',
                                                                border: '1px solid #ddd',
                                                                borderRadius: '4px'
                                                            }}
                                                        />
                                                        <Button
                                                            variant="link"
                                                            isDestructive
                                                            onClick={() => updateSlide(index, 'backgroundImage', '')}
                                                            style={{ marginTop: '5px', fontSize: '12px' }}
                                                        >
                                                            {__('❌ Supprimer l\'image', 'mon-theme-aca')}
                                                        </Button>
                                                    </div>
                                                )}
                                            </div>
                                        )}
                                    />
                                </MediaUploadCheck>
                                <p style={{ fontSize: '11px', color: '#666', margin: '5px 0 0 0' }}>
                                    {__('Formats supportés : JPG, PNG, GIF, WebP', 'mon-theme-aca')}
                                </p>
                            </div>

                            <div style={{ display: 'grid', gap: '10px' }}>
                                <TextControl
                                    label={__('📝 Titre', 'mon-theme-aca')}
                                    value={slide.title}
                                    onChange={(value) => updateSlide(index, 'title', value)}
                                    placeholder={__('Entrez le titre du slide', 'mon-theme-aca')}
                                />

                                <TextControl
                                    label={__('📄 Sous-titre', 'mon-theme-aca')}
                                    value={slide.subtitle}
                                    onChange={(value) => updateSlide(index, 'subtitle', value)}
                                    placeholder={__('Entrez le sous-titre du slide', 'mon-theme-aca')}
                                />

                                <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '10px' }}>
                                    <TextControl
                                        label={__('🔗 Texte bouton principal', 'mon-theme-aca')}
                                        value={slide.primaryButtonText}
                                        onChange={(value) => updateSlide(index, 'primaryButtonText', value)}
                                        placeholder={__('Ex: Découvrir', 'mon-theme-aca')}
                                    />

                                    <TextControl
                                        label={__('🌐 URL bouton principal', 'mon-theme-aca')}
                                        value={slide.primaryButtonUrl}
                                        onChange={(value) => updateSlide(index, 'primaryButtonUrl', value)}
                                        placeholder={__('Ex: #section', 'mon-theme-aca')}
                                    />
                                </div>

                                <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '10px' }}>
                                    <TextControl
                                        label={__('🔗 Texte bouton secondaire', 'mon-theme-aca')}
                                        value={slide.secondaryButtonText}
                                        onChange={(value) => updateSlide(index, 'secondaryButtonText', value)}
                                        placeholder={__('Ex: En savoir plus', 'mon-theme-aca')}
                                    />

                                    <TextControl
                                        label={__('🌐 URL bouton secondaire', 'mon-theme-aca')}
                                        value={slide.secondaryButtonUrl}
                                        onChange={(value) => updateSlide(index, 'secondaryButtonUrl', value)}
                                        placeholder={__('Ex: /contact', 'mon-theme-aca')}
                                    />
                                </div>
                            </div>
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
