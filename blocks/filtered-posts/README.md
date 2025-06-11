# Bloc "Liste d'articles filtrable"

## Description

Le bloc "Liste d'articles filtrable" (`filtered-posts`) permet d'afficher une grille d'articles avec une barre latérale de filtres dynamiques. La grille se met à jour en temps réel sans rechargement de page grâce à l'AJAX.

## Fonctionnalités

### Barre latérale de filtres

- **Recherche textuelle** : Champ de recherche pour filtrer par titre/contenu
- **Filtres par catégories** : Cases à cocher pour sélectionner plusieurs catégories
- **Filtres temporels** : Liste déroulante pour la taxonomie personnalisée `filtres_temporels`
- **Filtres géographiques** : Liste déroulante pour la taxonomie personnalisée `filtres_geographiques`
- **Bouton de réinitialisation** : Permet de remettre tous les filtres à zéro

### Grille d'articles

- **Affichage en cartes** : Réutilise le design du bloc `recent-news`
- **Informations affichées** : Image à la une, titre, extrait, date, lien "Lire plus"
- **Responsive** : S'adapte automatiquement aux différentes tailles d'écran

### Contrôles de tri et pagination

- **Tri** : Par date, titre ou auteur (ordre croissant/décroissant)
- **Articles par page** : 6, 9, 12 ou 18 articles
- **Pagination** : Numérotée ou "Charger plus"

### Interactivité AJAX

- **Mise à jour instantanée** : Tous les filtres fonctionnent sans rechargement
- **Indicateur de chargement** : Overlay avec spinner pendant les requêtes
- **Gestion d'erreurs** : Messages d'erreur en cas de problème de connexion
- **Debounce** : La recherche textuelle utilise un délai pour éviter trop de requêtes

## Attributs du bloc

### Paramètres généraux

- `sectionTitle` (string) : Titre de la section (défaut: "Articles")
- `postsPerPage` (number) : Nombre d'articles par page (défaut: 6)

### Filtres

- `showSearchFilter` (boolean) : Afficher la recherche (défaut: true)
- `showCategoryFilter` (boolean) : Afficher les filtres par catégorie (défaut: true)
- `showTemporalFilter` (boolean) : Afficher les filtres temporels (défaut: true)
- `showGeographicFilter` (boolean) : Afficher les filtres géographiques (défaut: true)

### Contrôles

- `showSortControls` (boolean) : Afficher les contrôles de tri (défaut: true)
- `showPagination` (boolean) : Afficher la pagination (défaut: true)
- `paginationType` (string) : Type de pagination - "numbered" ou "load-more" (défaut: "numbered")

### Tri par défaut

- `defaultSortBy` (string) : Critère de tri - "date", "title" ou "author" (défaut: "date")
- `defaultOrder` (string) : Ordre de tri - "asc" ou "desc" (défaut: "desc")

## Taxonomies personnalisées

Le bloc supporte deux taxonomies personnalisées optionnelles :

1. **`filtres_temporels`** : Pour les filtres temporels (années, mois, périodes, etc.)
2. **`filtres_geographiques`** : Pour les filtres géographiques (régions, pays, villes, etc.)

Si ces taxonomies n'existent pas, les filtres correspondants ne s'affichent pas et aucune erreur n'est générée.

## Utilisation

### Dans l'éditeur Gutenberg

1. Ajouter le bloc "Liste d'articles filtrable" depuis la catégorie "Mon Thème ACA"
2. Configurer les options dans la barre latérale (Inspector Controls)
3. Prévisualiser le résultat dans l'éditeur

### Sur le front-end

- Le bloc s'initialise automatiquement au chargement de la page
- Tous les filtres sont fonctionnels immédiatement
- Les utilisateurs peuvent interagir avec les filtres sans rechargement de page

## Structure des fichiers

```
blocks/filtered-posts/
├── block.json          # Configuration du bloc
├── index.js           # Point d'entrée (enregistrement)
├── edit.js            # Interface d'édition
├── render.php         # Rendu côté serveur
├── view.js            # JavaScript front-end (AJAX)
├── style.scss         # Styles front-end
├── editor.scss        # Styles éditeur
└── README.md          # Documentation
```

## Endpoint AJAX

Le bloc utilise l'endpoint `wp_ajax_filtered_posts_ajax` qui accepte les paramètres suivants :

- `page` : Numéro de page
- `posts_per_page` : Articles par page
- `orderby` : Critère de tri
- `order` : Ordre de tri
- `search` : Terme de recherche
- `categories` : Array des IDs de catégories
- `temporal_filter` : ID du terme de filtre temporel
- `geographic_filter` : ID du terme de filtre géographique
- `load_more` : Boolean pour le mode "charger plus"
- `nonce` : Token de sécurité

## Sécurité

- Utilisation de nonces WordPress pour sécuriser les requêtes AJAX
- Sanitisation de tous les paramètres reçus
- Vérification des capacités utilisateur
- Échappement des sorties HTML

## Responsive Design

Le bloc est entièrement responsive :

- **Desktop** : Layout en 2 colonnes (filtres à gauche, contenu à droite)
- **Tablet/Mobile** : Layout vertical (filtres en haut, contenu en bas)
- **Grille adaptive** : Le nombre de colonnes s'ajuste automatiquement

## Compatibilité

- **WordPress** : 6.0+
- **PHP** : 7.4+
- **Gutenberg** : API Version 3
- **Navigateurs** : Modernes (ES6+)

## Personnalisation

### CSS

Les styles peuvent être surchargés en ciblant les classes :

- `.wp-block-mon-theme-aca-filtered-posts`
- `.filters-sidebar`
- `.posts-content`
- `.news-card`

### JavaScript

Les événements peuvent être écoutés :

- `filtered-posts:loading`
- `filtered-posts:loaded`
- `filtered-posts:error`

### PHP

Les hooks disponibles :

- `filtered_posts_query_args` : Modifier les arguments de requête
- `filtered_posts_render_card` : Personnaliser le rendu des cartes
