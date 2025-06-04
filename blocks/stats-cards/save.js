import { useBlockProps, RichText } from '@wordpress/block-editor';

export default function save({ attributes }) {
    const { cards, backgroundColor, cardsPerRow } = attributes;

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
                        <div className="stat-icon">
                            <i className={card.icon}></i>
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
