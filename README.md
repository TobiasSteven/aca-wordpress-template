# Mon Thème ACA

Un thème WordPress modulaire et bien structuré, conçu pour être flexible et adapté aux besoins modernes avec des blocs Gutenberg personnalisés.

## Caractéristiques

- Design responsive
- Support des blocs WordPress avec blocs personnalisés
- Options de personnalisation avancées
- Structure modulaire et bien organisée
- Prêt pour la traduction
- Optimisé pour les performances
- **Blocs Gutenberg personnalisés** :
  - **Stats Cards** : Affichage de statistiques avec icônes
  - **Hero Slider** : Slider en hero section
  - **Recent News** : Actualités récentes avec filtrage par catégories

## Prérequis

- WordPress 6.0 ou supérieur
- PHP 7.4 ou supérieur
- Navigateurs modernes (Chrome, Firefox, Safari, Edge)

## Installation

1. Téléchargez le thème
2. Allez dans votre administration WordPress → Apparence → Thèmes → Ajouter
3. Cliquez sur "Téléverser un thème"
4. Sélectionnez le fichier zip du thème
5. Cliquez sur "Installer"
6. Activez le thème

## Personnalisation

Le thème offre plusieurs options de personnalisation:

1. Allez dans Apparence → Personnaliser
2. Vous pouvez modifier:
   - Couleur principale
   - Texte du pied de page
   - Et d'autres options standard de WordPress

## Structure des fichiers

```
mon-theme-aca/
├── assets/
│   ├── css/
│   ├── js/
│   │   ├── customizer.js
│   │   └── main.js
│   └── images/
├── blocks/
│   ├── stats-cards/
│   │   ├── block.json
│   │   ├── edit.js
│   │   ├── save.js
│   │   └── build/
│   ├── hero-slider/
│   │   ├── block.json
│   │   ├── edit.js
│   │   ├── view.js
│   │   └── build/
│   └── recent-news/
│       ├── block.json
│       ├── edit.js
│       ├── render.php
│       └── build/
├── functions-parts/
│   ├── blocks.php
│   ├── enqueue.php
│   └── theme-setup.php
├── inc/
│   ├── customizer.php
│   ├── template-functions.php
│   └── template-tags.php
├── languages/
├── template-parts/
│   ├── content-none.php
│   ├── content-page.php
│   ├── content-search.php
│   ├── content-single.php
│   └── content.php
├── 404.php
├── archive.php
├── comments.php
├── footer.php
├── functions.php
├── header.php
├── index.php
├── page.php
├── README.md
├── screenshot.png
├── search.php
├── sidebar.php
├── single.php
└── style.css
```

## Ajout de fonctionnalités

Le thème est conçu pour être extensible. Vous pouvez ajouter vos propres fonctionnalités:

1. Pour ajouter des styles personnalisés, éditez style.css ou créez vos propres fichiers CSS dans le dossier assets/css
2. Pour ajouter du JavaScript, modifiez assets/js/main.js ou créez vos propres fichiers
3. Pour modifier les templates, éditez les fichiers dans template-parts/
4. Pour ajouter des fonctions PHP, vous pouvez les ajouter dans functions.php ou créer de nouveaux fichiers dans inc/

## Blocs Gutenberg personnalisés

### 1. Stats Cards

Block pour afficher des statistiques avec icônes FontAwesome.

- Cartes configurables avec titre, valeur et icône
- Design responsive
- Animations au survol

### 2. Hero Slider

Block slider pour la section hero de votre site.

- Support de plusieurs slides
- Navigation par pagination et flèches
- Entièrement responsive

### 3. Recent News (Nouveau!)

Block pour afficher les actualités récentes avec options avancées.

- **Fonctionnalités** :
  - Sélection du nombre d'articles (1-12)
  - Filtrage par catégories multiples
  - Tri par date, titre ou aléatoire
  - Options d'affichage (date, extrait)
  - Design responsive avec cartes élégantes
- **Utilisation** : Consultez le guide détaillé dans `blocks/recent-news/USAGE-GUIDE.md`

## Développement des blocs

Pour développer ou modifier les blocs :

```bash
# Installer les dépendances
npm install

# Compiler tous les blocs
npm run build

# Compiler un bloc spécifique
npm run build:recent-news
npm run build:hero-slider
npm run build:stats-cards

# Mode développement avec watch
npm run start:recent-news
```

## Support

Pour toute question ou assistance, veuillez contacter [votre-email@example.com](mailto:votre-email@example.com)

## Licence

Ce thème est sous licence GNU General Public License v2 ou ultérieure
