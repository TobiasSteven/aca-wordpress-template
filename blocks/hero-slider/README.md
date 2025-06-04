# Hero Slider Block

Un bloc de slider hero moderne et entièrement personnalisable pour WordPress, basé sur le code HTML fourni et optimisé pour le thème ACA.

## Fonctionnalités

- **Slider automatique** avec contrôle de la vitesse
- **Navigation manuelle** avec boutons précédent/suivant
- **Indicateurs de slides** cliquables
- **Gestion d'images de fond** via la médiathèque WordPress
- **Contenu personnalisable** (titre, sous-titre, boutons d'action)
- **Responsive design** avec animations fluides
- **Support du swipe** sur mobile
- **Navigation au clavier** (flèches gauche/droite)
- **Pause au survol** de la souris

## Paramètres disponibles

### Paramètres généraux

- **Hauteur du slider** : 50vh, 60vh, 70vh, 80vh, 90vh, 100vh
- **Lecture automatique** : Activée/Désactivée
- **Vitesse de lecture** : 2000ms à 10000ms (par défaut 5000ms)
- **Affichage de la navigation** : Boutons précédent/suivant
- **Affichage des indicateurs** : Points de navigation en bas

### Paramètres par slide

- **Image de fond** : Sélection depuis la médiathèque
- **Titre** : Texte principal du slide
- **Sous-titre** : Description ou accroche
- **Bouton principal** : Texte et URL
- **Bouton secondaire** : Texte et URL

## Couleurs utilisées

Le bloc utilise la palette de couleurs définie pour le thème ACA :

- **Bouton principal** : Success Green (#28A745) avec hover vers Teal Green (#2D9B8A)
- **Bouton secondaire** : White (#FFFFFF) avec hover vers Light Gray (#F8F9FA)
- **Texte** : Dark Gray (#343A40)
- **Couleur de fond par défaut** : Teal Green (#2D9B8A)

## Structure des fichiers

```
hero-slider/
├── block.json          # Configuration du bloc
├── index.js           # Point d'entrée principal
├── edit.js            # Interface d'édition (Gutenberg)
├── save.js            # Sortie frontend
├── style-index.css    # Styles frontend
├── view.js            # JavaScript frontend
├── editor.scss        # Styles éditeur (optionnel)
├── README.md          # Cette documentation
└── build/             # Fichiers compilés
    ├── index.js
    └── index.asset.php
```

## Installation et utilisation

1. Le bloc est automatiquement enregistré via `functions-parts/blocks.php`
2. Compilez le bloc avec `npm run build:hero-slider`
3. Le bloc apparaît dans l'éditeur Gutenberg sous la catégorie "Mon Theme ACA"
4. Ajoutez le bloc à votre page/article
5. Configurez les slides dans le panneau des paramètres

## Développement

Pour développer le bloc en mode watch :

```bash
npm run start:hero-slider
```

Pour compiler la version de production :

```bash
npm run build:hero-slider
```

## Compatibilité

- **WordPress** : 6.8+
- **PHP** : 8.0+
- **Navigateurs** : Tous les navigateurs modernes
- **Responsive** : Mobile, tablette, desktop
- **Accessibilité** : Support ARIA et navigation clavier

## Notes techniques

- Utilise l'API WordPress Block Editor v3
- Animation CSS avec `fadeInText`
- Gestion des événements tactiles pour le swipe
- Optimisé pour les performances avec `offsetHeight` pour forcer le reflow
- Support de plusieurs sliders sur la même page

## Personnalisation

Les styles peuvent être personnalisés en modifiant `style-index.css`. Les animations et transitions sont configurables via CSS.

Pour ajouter de nouvelles fonctionnalités, modifiez :

- `block.json` pour les nouveaux attributs
- `edit.js` pour l'interface d'édition
- `save.js` pour la sortie frontend
- `view.js` pour les interactions JavaScript

Un bloc personnalisé pour créer des sliders hero avec images de fond, titres, sous-titres et boutons d'action.

## Fonctionnalités

- **Slides multiples** : Ajoutez autant de slides que nécessaire
- **Images de fond personnalisables** : Téléchargez vos propres images depuis la médiathèque WordPress
- **Contenu personnalisable** : Titre, sous-titre et deux boutons d'action par slide
- **Lecture automatique** : Option pour faire défiler automatiquement les slides
- **Navigation** : Boutons précédent/suivant et indicateurs en bas
- **Responsive** : Optimisé pour tous les appareils
- **Support tactile** : Navigation par swipe sur mobile
- **Navigation au clavier** : Support des flèches du clavier
- **Hauteur personnalisable** : Choisissez la hauteur du slider (50vh à 100vh)

## Utilisation

1. Dans l'éditeur Gutenberg, cherchez le bloc "Hero Slider" dans la catégorie "Mon Thème ACA"
2. Ajoutez le bloc à votre page
3. Configurez les paramètres dans le panneau de droite :
   - Hauteur du slider
   - Lecture automatique et vitesse
   - Affichage de la navigation et des indicateurs
4. Gérez vos slides :
   - Ajoutez/supprimez des slides
   - Téléchargez des images de fond
   - Personnalisez les textes et liens des boutons

## Structure des fichiers

- `block.json` : Configuration du bloc
- `index.js` : Point d'entrée
- `edit.js` : Interface d'édition dans Gutenberg
- `save.js` : Génération du HTML pour le frontend
- `style-index.css` : Styles CSS pour le frontend
- `editor.scss` : Styles pour l'éditeur
- `view.js` : JavaScript pour l'interactivité du slider

## Compatibilité

- WordPress 6.0+
- Tous les navigateurs modernes
- Appareils mobiles et tablettes

## Couleurs utilisées

Le bloc utilise la palette de couleurs du thème :

- Bouton principal : #28A745 (Success Green)
- Bouton secondaire : White (#FFFFFF)
- Couleur de fond par défaut : #2D9B8A (Teal Green)
- Texte : White avec ombre pour la lisibilité
