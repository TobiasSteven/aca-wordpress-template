import { useBlockProps, RichText } from '@wordpress/block-editor';

export default function save({ attributes }) {
    const { cards, backgroundColor } = attributes;

    const blockProps = useBlockProps.save({
        className: 'wp-block-mon-theme-aca-stats-cards',
        style: {
            backgroundColor: backgroundColor
        }
    });

    return (
        <div {...blockProps}>
            <div className="stats-container">
                {cards.map((card, index) => (
                    <div key={index} className="stat-card">
                        <div className="icon">
                            <i
                                key={`${index}-${card.icon}`}
                                className={card.icon || 'fas fa-chart-bar'}
                                style={{
                                    fontFamily: '"Font Awesome 6 Free", "Font Awesome 6 Pro", "Font Awesome 6 Brands", "FontAwesome", sans-serif',
                                    fontWeight: '900'
                                }}
                            ></i>
                        </div>
                        <div className="stat-label">
                            {card.label}
                        </div>
                        <div className="stat-value">
                            {card.value}
                        </div>
                    </div>
                ))}
            </div>
        </div>
    );
}
