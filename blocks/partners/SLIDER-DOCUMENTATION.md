# Bloc Partenaires - Mode Slider

## 🎠 Fonctionnalité Slider Automatique

Le bloc "Nos Partenaires" dispose maintenant d'un mode slider automatique qui s'active lorsque plus de 4 partenaires sont configurés.

## ✨ Fonctionnalités

### Activation Automatique

- **≤ 4 partenaires** : Affichage en grille statique
- **> 4 partenaires** : Mode slider avec carrousel automatique

### Navigation

- **Boutons fléchés** : Navigation manuelle gauche/droite
- **Points de navigation** : Indicateurs de position avec navigation directe
- **Auto-play** : Défilement automatique toutes les 4 secondes
- **Pause au survol** : L'auto-play se met en pause quand on survole le slider

### Contrôles

- **Clavier** : Flèches gauche/droite pour naviguer
- **Touch/Swipe** : Navigation tactile sur mobile et tablette
- **Responsive** : Adaptation automatique selon la taille d'écran

### Affichage Responsive

- **Desktop** : 4 partenaires par vue
- **Tablette** : 2 partenaires par vue
- **Mobile** : 1 partenaire par vue

## 🎨 Design

### Couleurs

- **Boutons de navigation** : Teal Green (#2D9B8A)
- **Hover** : Dark Teal (#1F6B5C)
- **Points de navigation** : Assortis aux couleurs de la marque

### Animations

- **Transitions fluides** : 0.3s ease pour tous les mouvements
- **Effets hover** : Agrandissement des boutons (scale 1.1)
- **Ombres** : Effet de profondeur sur les contrôles

## 📱 Compatibilité

### Navigateurs

- Chrome, Firefox, Safari, Edge (versions récentes)
- Support complet des fonctionnalités touch

### Accessibilité

- **Labels ARIA** : Navigation accessible aux lecteurs d'écran
- **Navigation clavier** : Support complet des flèches
- **Focus visible** : Indicateurs de focus pour la navigation

## 🛠 Utilisation

### Dans l'Éditeur

1. Ajoutez plus de 4 partenaires dans le bloc
2. L'éditeur affiche un indicateur "Mode Slider Activé"
3. Aperçu des 4 premiers partenaires + compteur du reste

### Sur le Frontend

1. Le slider s'affiche automatiquement
2. Navigation disponible immédiatement
3. Auto-play démarre après chargement de la page

## 📋 Exemple d'Usage

```php
// Dans un template WordPress
<?php
$partners = [
    ['url' => 'logo1.jpg', 'alt' => 'Partenaire 1', 'link' => 'https://partner1.com'],
    ['url' => 'logo2.jpg', 'alt' => 'Partenaire 2', 'link' => 'https://partner2.com'],
    ['url' => 'logo3.jpg', 'alt' => 'Partenaire 3', 'link' => 'https://partner3.com'],
    ['url' => 'logo4.jpg', 'alt' => 'Partenaire 4', 'link' => 'https://partner4.com'],
    ['url' => 'logo5.jpg', 'alt' => 'Partenaire 5', 'link' => 'https://partner5.com'],
    // Plus de 4 = mode slider activé
];
?>
```

## 🎯 Personnalisation

### Vitesse de l'Auto-play

Modifiez la valeur dans `view.js` ligne ~98 :

```javascript
}, 4000); // 4 secondes - changez cette valeur
```

### Nombre d'items par vue

Modifiez la fonction `getItemsPerView()` dans `view.js` :

```javascript
function getItemsPerView() {
  if (window.innerWidth <= 480) return 1; // Mobile
  if (window.innerWidth <= 768) return 2; // Tablette
  return 4; // Desktop - changez cette valeur
}
```

### Seuil d'activation

Modifiez dans `render.php` ligne 44 :

```php
$use_slider = $partners_count > 4; // Changez le nombre ici
```

## 🔧 Maintenance

### Fichiers Concernés

- `render.php` : Logique d'affichage et structure HTML
- `view.js` : Fonctionnalités JavaScript du slider
- `style.scss` : Styles CSS pour le slider
- `edit.js` : Aperçu dans l'éditeur Gutenberg

### Debug

Ajoutez `console.log()` dans `view.js` pour débugger :

```javascript
console.log("Slider initialisé:", sliderElement);
console.log("Nombre de partenaires:", totalSlides);
```
