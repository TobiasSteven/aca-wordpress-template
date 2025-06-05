import { useBlockProps, RichText } from '@wordpress/block-editor';

export default function save({ attributes }) {
    const { sectionTitle, testimonials } = attributes;

    const blockProps = useBlockProps.save({
        className: 'wp-block-mon-theme-aca-testimonials'
    });

    return (
        <div {...blockProps}>
            <section className="testimonials-section">
                <RichText.Content
                    tagName="h2"
                    value={sectionTitle}
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

                            <RichText.Content
                                tagName="p"
                                className="quote"
                                value={testimonial.quote}
                            />

                            <RichText.Content
                                tagName="p"
                                className="name"
                                value={testimonial.name}
                            />

                            <RichText.Content
                                tagName="p"
                                className="title"
                                value={testimonial.title}
                            />
                        </div>
                    ))}
                </div>
            </section>
        </div>
    );
}
