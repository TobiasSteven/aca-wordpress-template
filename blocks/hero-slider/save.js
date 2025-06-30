import { useBlockProps } from '@wordpress/block-editor';

export default function save({ attributes }) {
    const { slides, sliderHeight, autoPlay, autoPlaySpeed, showNavigation, showIndicators } = attributes;
    
    const blockProps = useBlockProps.save({
        className: 'wp-block-mon-theme-aca-hero-slider'
    });

    return (
        <div {...blockProps}>
            <section 
                className='hero-slider'
                data-auto-play={autoPlay}
                data-auto-play-speed={autoPlaySpeed}
                data-show-navigation={showNavigation}
                data-show-indicators={showIndicators}
                style={{ 
                    position: 'relative',
                    width: '100%',
                    overflow: 'hidden',
                    height: sliderHeight 
                }}
            >
                {/* Slides */}
                {slides.map((slide, index) => (
                    <div 
                        key={index}
                        className={`hero-slide ${index === 0 ? 'active' : ''}`}
                        style={{
                            backgroundImage: slide.backgroundImage ? `url(${slide.backgroundImage})` : 'none',
                            backgroundColor: slide.backgroundImage ? 'transparent' : '#2D9B8A'
                        }}
                    >
                        <div className='hero-content'>
                            <div>
                                <h1 className='hero-title'>
                                    {slide.title}
                                </h1>
                                <p className='hero-subtitle'>
                                    {slide.subtitle}
                                </p>
                                <div className='hero-buttons'>
                                    {slide.primaryButtonText && (
                                        <a 
                                            href={slide.primaryButtonUrl}
                                            className='hero-btn hero-btn-primary'
                                        >
                                            {slide.primaryButtonText}
                                        </a>
                                    )}
                                    {slide.secondaryButtonText && (
                                        <a 
                                            href={slide.secondaryButtonUrl}
                                            className='hero-btn hero-btn-secondary'
                                        >
                                            {slide.secondaryButtonText}
                                        </a>
                                    )}
                                </div>
                            </div>
                        </div>
                    </div>
                ))}

                {/* Contrôles de navigation */}
                {showNavigation && slides.length > 1 && (
                    <>
                        <button 
                            className='hero-nav hero-nav-prev'
                            aria-label='Slide précédente'
                        >
                            &#10094;
                        </button>
                        <button 
                            className='hero-nav hero-nav-next'
                            aria-label='Slide suivante'
                        >
                            &#10095;
                        </button>
                    </>
                )}

                {/* Indicateurs de slide */}
                {showIndicators && slides.length > 1 && (
                    <div className='hero-indicators'>
                        {slides.map((_, index) => (
                            <button 
                                key={index}
                                className={`hero-indicator ${index === 0 ? 'active' : ''}`}
                                aria-label={`Aller à la slide ${index + 1}`}
                            ></button>
                        ))}
                    </div>
                )}
            </section>
        </div>
    );
}