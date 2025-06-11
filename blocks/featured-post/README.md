# Bloc "Article en Vedette" (Featured Post)

## Description

Le bloc "Article en Vedette" affiche dynamiquement le dernier article ayant une catégorie ou un tag spécifique. Il est conçu pour mettre en avant un contenu important sur votre site WordPress.

## Fonctionnalités

- **Filtrage dynamique** : Sélectionnez une catégorie ou un tag pour filtrer les articles
- **Affichage automatique** : Affiche automatiquement le dernier article correspondant aux critères
- **Design responsive** : S'adapte à tous les types d'écrans
- **Pastille "FEATURED"** : Badge visuel pour identifier l'article en vedette
- **Métadonnées complètes** : Affiche l'auteur, la date de publication
- **Bouton d'action** : Lien "Lire l'article" vers l'article complet

## Utilisation

1. Dans l'éditeur Gutenberg, ajoutez le bloc "Article en Vedette"
2. Dans le panneau de droite, configurez les paramètres :
   - **Filtrer par** : Choisissez entre "Catégorie" ou "Tag"
   - **Catégorie/Tag** : Sélectionnez la catégorie ou le tag souhaité
3. Le bloc affichera automatiquement le dernier article correspondant

## Paramètres disponibles

### Type de filtre

- **Catégorie** : Filtre les articles par catégorie
- **Tag** : Filtre les articles par étiquette/tag

### Sélection

- Liste déroulante des catégories ou tags disponibles
- Seuls les termes ayant des articles publiés sont affichés

## Apparence

Le bloc génère un affichage comprenant :

- **Badge "FEATURED"** : Pastille verte en haut à gauche
- **Image à la une** : Image principale de l'article (si disponible)
- **Titre de l'article** : Lien vers l'article complet
- **Extrait** : Résumé automatique de l'article
- **Métadonnées** : Nom de l'auteur et date de publication
- **Bouton CTA** : "Lire l'article" avec icône

## Styles personnalisables

Le bloc utilise les couleurs du thème :

- **Couleur principale** : `#2D9B8A` (Badge et titre)
- **Couleur d'action** : `#28A745` (Bouton CTA)
- **Couleurs de texte** : Grilles de gris pour une lisibilité optimale

## Fichiers du bloc

```
blocks/featured-post/
├── block.json          # Configuration du bloc
├── edit.js             # Interface d'édition
├── index.js            # Enregistrement du bloc
├── render.php          # Rendu frontend
├── editor.scss         # Styles pour l'éditeur
├── style.scss          # Styles frontend
├── build/              # Fichiers compilés
│   ├── index.js
│   ├── index.css
│   ├── style-index.css
│   └── index.asset.php
└── README.md          # Documentation
```

## Développement

Pour modifier le bloc :

1. Modifiez les fichiers source (`edit.js`, `render.php`, `style.scss`)
2. Recompilez avec : `npm run build:featured-post`
3. Les modifications apparaîtront automatiquement

## Compatibilité

- **WordPress** : 6.0+
- **Gutenberg** : Dernière version
- **PHP** : 7.4+
- **Responsive** : Tous appareils
