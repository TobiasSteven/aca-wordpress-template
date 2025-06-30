import { useBlockProps, RichText } from '@wordpress/block-editor';

export default function save({ attributes }) {
    const { sectionTitle, testimonials, sectionDescription } = attributes;
    
    const blockProps = useBlockProps.save();

    return (
        <div {...blockProps}>
            <section className="py-16 bg-[#F8F9FA]">
              <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                {/* Testimonials Section */}
                <div className="mb-16">
                  <div className="text-center mb-12">
                    <RichText.Content
                        tagName="h2"
                        className="text-3xl md:text-4xl font-bold text-[#1F6B5C] mb-4"
                        value={sectionTitle}
                    />
                    <RichText.Content
                        tagName="p"
                        className="text-lg text-[#6C757D] max-w-2xl mx-auto"
                        value={sectionDescription}
                    />
                  </div>

                  <div className="relative max-w-4xl mx-auto">
                    {/* Testimonial Cards */}
                    {testimonials.map((testimonial, index) => (
                        <div key={index} className="testimonial-card bg-white rounded-2xl p-8 md:p-12 shadow-xl relative" style={{ display: index === 0 ? 'block' : 'none' }}>
                          {/* Quote Icon */}
                          <div className="absolute top-6 left-6">
                            <svg className="w-12 h-12 text-[#A8E6CF]" fill="currentColor" viewBox="0 0 24 24">
                              <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h4v10h-10z"></path>
                            </svg>
                          </div>

                          {/* Content */}
                          <div className="text-center pt-8">
                            <blockquote className="text-xl md:text-2xl text-[#343A40] mb-8 leading-relaxed italic">
                              "<RichText.Content value={testimonial.quote} />"
                            </blockquote>

                            <div className="flex items-center justify-center space-x-4">
                              <img
                                src={testimonial.image}
                                alt={testimonial.name}
                                className="w-16 h-16 rounded-full object-cover border-4 border-[#2D9B8A]"
                              />
                              <div className="text-left">
                                <div className="font-bold text-[#1F6B5C] text-lg">
                                  <RichText.Content value={testimonial.name} />
                                </div>
                                <div className="text-[#6C757D]">
                                  <RichText.Content value={testimonial.title} />
                                </div>
                                <div className="text-[#2D9B8A] font-medium">
                                    {/* Pour le pays, vous pouvez l'ajouter comme attribut dans block.json si nécessaire */}
                                    Afrique
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                    ))}

                    {/* Navigation */}
                    <button
                      className="nav-button prev absolute left-4 top-1/2 transform -translate-y-1/2 bg-white shadow-lg rounded-full p-3 hover:bg-[#A8E6CF] transition-colors"
                    >
                      <svg className="w-6 h-6 text-[#2D9B8A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M15 19l-7-7 7-7"></path>
                      </svg>
                    </button>
                    <button
                      className="nav-button next absolute right-4 top-1/2 transform -translate-y-1/2 bg-white shadow-lg rounded-full p-3 hover:bg-[#A8E6CF] transition-colors"
                    >
                      <svg className="w-6 h-6 text-[#2D9B8A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M9 5l7 7-7 7"></path>
                      </svg>
                    </button>

                    {/* Dots */}
                    <div className="dots-container flex justify-center mt-8 space-x-2">
                      {testimonials.map((_, index) => (
                        <button
                          key={index}
                          className={`dot w-3 h-3 rounded-full transition-all duration-300 ${
                            index === 0 ? 'bg-[#2D9B8A] scale-125' : 'bg-[#A8E6CF] hover:bg-[#2D9B8A]'
                          }`}
                        />
                      ))}
                    </div>
                  </div>
                </div>
              </div>
            </section>
        </div>
    );
}