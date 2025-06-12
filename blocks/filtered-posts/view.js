/**
 * Frontend JavaScript for Filtered Posts block
 */

// Éviter les redéclarations si le script est chargé plusieurs fois
if (typeof window.FilteredPostsHandler === 'undefined') {

    document.addEventListener('DOMContentLoaded', function () {
        // Initialiser tous les blocs de posts filtrés sur la page
        const filteredPostsBlocks = document.querySelectorAll('.wp-block-mon-theme-aca-filtered-posts');

        filteredPostsBlocks.forEach(function (block) {
            new FilteredPostsHandler(block);
        });
    });

    class FilteredPostsHandler {
        constructor(blockElement) {
            this.block = blockElement;
            this.blockId = blockElement.dataset.blockId;
            this.postsPerPage = parseInt(blockElement.dataset.postsPerPage) || 6;
            this.paginationType = blockElement.dataset.paginationType || 'numbered';
            this.defaultSort = blockElement.dataset.defaultSort || 'date';
            this.defaultOrder = blockElement.dataset.defaultOrder || 'desc';

            this.currentPage = 1;
            this.isLoading = false;

            this.initializeElements();
            this.attachEventListeners();
            this.initializeView();
        }

        initializeElements() {
            // Éléments de filtre
            this.searchInput = this.block.querySelector('.search-input');
            this.categoryCheckboxes = this.block.querySelectorAll('.category-checkbox');
            this.temporalSelect = this.block.querySelector('.temporal-select');
            this.geographicSelect = this.block.querySelector('.geographic-select');
            this.resetButton = this.block.querySelector('.reset-filters-btn');

            // Contrôles de tri et de vue
            this.sortSelect = this.block.querySelector('.sort-select');
            this.orderSelect = this.block.querySelector('.order-select');
            this.perPageSelect = this.block.querySelector('.per-page-select');
            this.viewButtons = this.block.querySelectorAll('.view-btn');

            // Zones d'affichage (critiques)
            this.postsGrid = this.block.querySelector('.posts-grid');
            this.pagination = this.block.querySelector('.posts-pagination');
            this.loadingOverlay = this.block.querySelector('.loading-overlay');
            this.noPostsFound = this.block.querySelector('.no-posts-found');
            this.loadMoreBtn = this.block.querySelector('.load-more-btn');

            // Débogage : vérifier que les éléments critiques existent
            if (!this.postsGrid) {
                console.error('FilteredPostsHandler: .posts-grid element not found in block', this.block);
            }
            if (!this.pagination) {
                console.warn('FilteredPostsHandler: .posts-pagination element not found in block', this.block);
            }
            if (!this.loadingOverlay) {
                console.warn('FilteredPostsHandler: .loading-overlay element not found in block', this.block);
            }
            if (!this.noPostsFound) {
                console.warn('FilteredPostsHandler: .no-posts-found element not found in block', this.block);
            }
        }

        attachEventListeners() {
            // Filtres de recherche avec debounce
            if (this.searchInput) {
                this.searchInput.addEventListener('input', this.debounce(() => {
                    this.resetPagination();
                    this.loadPosts();
                }, 500));
            }

            // Filtres par catégorie
            this.categoryCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', () => {
                    this.resetPagination();
                    this.loadPosts();
                });
            });

            // Filtres temporels et géographiques
            if (this.temporalSelect) {
                this.temporalSelect.addEventListener('change', () => {
                    this.resetPagination();
                    this.loadPosts();
                });
            }

            if (this.geographicSelect) {
                this.geographicSelect.addEventListener('change', () => {
                    this.resetPagination();
                    this.loadPosts();
                });
            }

            // Bouton de réinitialisation
            if (this.resetButton) {
                this.resetButton.addEventListener('click', () => {
                    this.resetFilters();
                });
            }

            // Contrôles de tri
            if (this.sortSelect) {
                this.sortSelect.addEventListener('change', () => {
                    this.resetPagination();
                    this.loadPosts();
                });
            }

            if (this.orderSelect) {
                this.orderSelect.addEventListener('change', () => {
                    this.resetPagination();
                    this.loadPosts();
                });
            }

            if (this.perPageSelect) {
                this.perPageSelect.addEventListener('change', () => {
                    this.postsPerPage = parseInt(this.perPageSelect.value);
                    this.resetPagination();
                    this.loadPosts();
                });
            }

            // Contrôles de vue
            this.viewButtons.forEach(button => {
                button.addEventListener('click', () => {
                    // Retirer la classe active de tous les boutons
                    this.viewButtons.forEach(btn => btn.classList.remove('active'));
                    // Ajouter la classe active au bouton cliqué
                    button.classList.add('active');

                    // Appliquer la vue correspondante
                    const viewType = button.dataset.view;
                    this.changeView(viewType);
                });
            });

            // Bouton "Charger plus"
            if (this.loadMoreBtn) {
                this.loadMoreBtn.addEventListener('click', () => {
                    this.loadMorePosts();
                });
            }

            // Pagination numérotée (délégation d'événements)
            if (this.pagination) {
                this.pagination.addEventListener('click', (e) => {
                    if (e.target.classList.contains('page-numbers') && !e.target.classList.contains('current')) {
                        e.preventDefault();
                        const href = e.target.getAttribute('href');
                        const pageMatch = href.match(/paged=(\d+)/);
                        if (pageMatch) {
                            this.currentPage = parseInt(pageMatch[1]);
                            this.loadPosts();
                        }
                    }
                });
            }
        }

        getFilterData() {
            const data = {
                action: 'filtered_posts_ajax',
                nonce: filteredPostsAjax.nonce,
                page: this.currentPage,
                posts_per_page: this.postsPerPage,
                orderby: this.sortSelect ? this.sortSelect.value : this.defaultSort,
                order: this.orderSelect ? this.orderSelect.value : this.defaultOrder,
            };

            // Recherche
            if (this.searchInput && this.searchInput.value.trim()) {
                data.search = this.searchInput.value.trim();
            }

            // Catégories sélectionnées
            const selectedCategories = [];
            this.categoryCheckboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    selectedCategories.push(checkbox.value);
                }
            });
            if (selectedCategories.length > 0) {
                data.categories = selectedCategories;
            }

            // Filtres temporels
            if (this.temporalSelect && this.temporalSelect.value) {
                data.temporal_filter = this.temporalSelect.value;
            }

            // Filtres géographiques
            if (this.geographicSelect && this.geographicSelect.value) {
                data.geographic_filter = this.geographicSelect.value;
            }

            return data;
        }

        loadPosts() {
            if (this.isLoading) return;

            this.showLoading();
            this.isLoading = true;

            const data = this.getFilterData();

            fetch(filteredPostsAjax.ajaxurl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams(data)
            })
                .then(response => response.json())
                .then(result => {
                    this.hideLoading();
                    this.isLoading = false;

                    if (result.success) {
                        this.postsGrid.innerHTML = result.data.posts_html;

                        // Réappliquer la vue sélectionnée après le chargement AJAX avec un petit délai
                        setTimeout(() => {
                            const activeViewBtn = this.block.querySelector('.view-btn.active');
                            if (activeViewBtn) {
                                const currentView = activeViewBtn.dataset.view;
                                this.changeView(currentView);
                            }
                        }, 50);

                        if (result.data.pagination_html) {
                            if (this.pagination) {
                                this.pagination.innerHTML = result.data.pagination_html;
                                this.pagination.style.display = 'block';
                            }
                        } else {
                            if (this.pagination) {
                                this.pagination.style.display = 'none';
                            }
                        }

                        // Mise à jour du bouton "Charger plus"
                        if (this.loadMoreBtn) {
                            if (result.data.has_more_posts) {
                                this.loadMoreBtn.style.display = 'block';
                                this.loadMoreBtn.dataset.page = this.currentPage.toString();
                                this.loadMoreBtn.dataset.maxPages = result.data.max_pages.toString();
                            } else {
                                this.loadMoreBtn.style.display = 'none';
                            }
                        }

                        // Afficher/masquer le message "aucun résultat"
                        if (result.data.posts_html.trim() === '' || result.data.total_posts === 0) {
                            if (this.noPostsFound) {
                                this.noPostsFound.style.display = 'block';
                            }
                        } else {
                            if (this.noPostsFound) {
                                this.noPostsFound.style.display = 'none';
                            }
                        }

                        // Scroll vers le haut de la grille si ce n'est pas la première page
                        if (this.currentPage > 1 && this.paginationType === 'numbered') {
                            this.postsGrid.scrollIntoView({ behavior: 'smooth', block: 'start' });
                        }
                    } else {
                        console.error('Erreur lors du chargement des posts:', result.data);
                        this.showError('Une erreur est survenue lors du chargement des articles.');
                    }
                })
                .catch(error => {
                    this.hideLoading();
                    this.isLoading = false;
                    console.error('Erreur AJAX:', error);
                    this.showError('Une erreur de connexion est survenue.');
                });
        }

        loadMorePosts() {
            if (this.isLoading) return;

            const maxPages = parseInt(this.loadMoreBtn.dataset.maxPages);
            if (this.currentPage >= maxPages) return;

            this.currentPage++;
            this.loadMoreBtn.textContent = 'Chargement...';
            this.loadMoreBtn.disabled = true;

            const data = this.getFilterData();
            data.load_more = true;

            fetch(filteredPostsAjax.ajaxurl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams(data)
            })
                .then(response => response.json())
                .then(result => {
                    this.loadMoreBtn.textContent = 'Charger plus d\'articles';
                    this.loadMoreBtn.disabled = false;

                    if (result.success) {
                        // Ajouter les nouveaux posts à la grille existante
                        const tempDiv = document.createElement('div');
                        tempDiv.innerHTML = result.data.posts_html;
                        const newPosts = tempDiv.querySelectorAll('.news-card');

                        const existingContainer = this.postsGrid.querySelector('.news-cards-container');
                        if (existingContainer) {
                            newPosts.forEach(post => {
                                existingContainer.appendChild(post);
                            });

                            // Réappliquer la vue sélectionnée après l'ajout de nouveaux posts avec un petit délai
                            setTimeout(() => {
                                const activeViewBtn = this.block.querySelector('.view-btn.active');
                                if (activeViewBtn) {
                                    const currentView = activeViewBtn.dataset.view;
                                    this.changeView(currentView);
                                }
                            }, 50);
                        }

                        // Masquer le bouton s'il n'y a plus de posts
                        if (!result.data.has_more_posts || this.currentPage >= result.data.max_pages) {
                            if (this.loadMoreBtn) {
                                this.loadMoreBtn.style.display = 'none';
                            }
                        }
                    } else {
                        console.error('Erreur lors du chargement des posts:', result.data);
                        this.showError('Une erreur est survenue lors du chargement des articles.');
                    }
                })
                .catch(error => {
                    this.loadMoreBtn.textContent = 'Charger plus d\'articles';
                    this.loadMoreBtn.disabled = false;
                    console.error('Erreur AJAX:', error);
                    this.showError('Une erreur de connexion est survenue.');
                });
        }

        resetFilters() {
            // Réinitialiser la recherche
            if (this.searchInput) {
                this.searchInput.value = '';
            }

            // Décocher toutes les catégories
            this.categoryCheckboxes.forEach(checkbox => {
                checkbox.checked = false;
            });

            // Réinitialiser les sélects
            if (this.temporalSelect) {
                this.temporalSelect.value = '';
            }

            if (this.geographicSelect) {
                this.geographicSelect.value = '';
            }

            // Réinitialiser les contrôles de tri
            if (this.sortSelect) {
                this.sortSelect.value = this.defaultSort;
            }

            if (this.orderSelect) {
                this.orderSelect.value = this.defaultOrder;
            }

            this.resetPagination();
            this.loadPosts();
        }

        resetPagination() {
            this.currentPage = 1;
        }

        showLoading() {
            if (this.loadingOverlay) {
                this.loadingOverlay.style.display = 'flex';
            }
        }

        hideLoading() {
            if (this.loadingOverlay) {
                this.loadingOverlay.style.display = 'none';
            }
        }

        showError(message) {
            // Créer ou mettre à jour un message d'erreur
            let errorDiv = this.block.querySelector('.error-message');
            if (!errorDiv) {
                errorDiv = document.createElement('div');
                errorDiv.className = 'error-message';
                errorDiv.style.cssText = 'color: #d63638; background: #fcf0f1; border: 1px solid #f1aeb5; padding: 10px; margin: 10px 0; border-radius: 4px;';
                this.postsGrid.parentNode.insertBefore(errorDiv, this.postsGrid);
            }
            errorDiv.textContent = message;

            // Masquer le message après 5 secondes
            setTimeout(() => {
                if (errorDiv.parentNode) {
                    errorDiv.parentNode.removeChild(errorDiv);
                }
            }, 5000);
        }

        debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }

        changeView(viewType) {
            const container = this.postsGrid.querySelector('.news-cards-container');
            if (!container) {
                console.warn('FilteredPostsHandler: .news-cards-container not found in', this.postsGrid);
                return;
            }

            // Supprimer les classes de vue existantes
            container.classList.remove('view-grid', 'view-cards', 'view-list');

            // Ajouter la nouvelle classe de vue
            container.classList.add(`view-${viewType}`);

            // Sauvegarder la préférence dans localStorage
            localStorage.setItem('filtered-posts-view', viewType);

            // Log silencieux pour le débogage seulement en mode développement
            if (window.location.hostname === 'localhost' || window.location.hostname.includes('dev')) {
                console.log('FilteredPostsHandler: Applied view', viewType, 'to container', container);
            }
        }

        initializeView() {
            // Restaurer la vue sauvegardée ou utiliser la vue par défaut (cards)
            const savedView = localStorage.getItem('filtered-posts-view') || 'cards';

            // Mettre à jour le bouton actif
            this.viewButtons.forEach(btn => {
                btn.classList.toggle('active', btn.dataset.view === savedView);
            });

            // Appliquer la vue
            this.changeView(savedView);
        }
    }

    // Sauvegarder la classe dans l'objet window pour éviter les redéclarations
    window.FilteredPostsHandler = FilteredPostsHandler;

} // Fin de la condition if (typeof window.FilteredPostsHandler === 'undefined')