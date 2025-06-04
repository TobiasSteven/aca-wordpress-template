# Bloc Événements - Documentation Complète

## Vue d'ensemble

Le bloc **Événements** est un bloc WordPress personnalisé qui affiche un calendrier interactif et une liste des événements à venir. Il se base sur un Custom Post Type "event" avec des champs personnalisés pour toutes les informations d'événement.

## Fonctionnalités

### 🎯 Fonctionnalités principales

- **Calendrier interactif** avec navigation mois par mois
- **Liste d'événements** avec affichage des détails
- **Filtrage par type d'événement** (taxonomie personnalisée)
- **Interface d'administration complète** pour gérer les événements
- **Options d'affichage flexibles** (calendrier, heure, lieu, type)
- **Design responsive** adapté à tous les écrans

### 🛠 Fonctionnalités techniques

- **Custom Post Type** "event" avec tous les champs nécessaires
- **Taxonomie personnalisée** "event_type" pour catégoriser les événements
- **Meta boxes avancées** dans l'administration WordPress
- **Requêtes optimisées** avec support du tri et filtrage
- **JavaScript interactif** pour la navigation du calendrier
- **Styles CSS personnalisés** avec la palette de couleurs ACA

## Structure des fichiers

```
blocks/events/
├── block.json          # Configuration du bloc
├── index.js           # Point d'entrée principal
├── edit.js            # Interface d'édition
├── render.php         # Rendu côté serveur
├── view.js            # JavaScript front-end
├── style-index.css    # Styles front-end
├── style.scss         # Styles SCSS (importe style-index.css)
├── editor.scss        # Styles éditeur
└── build/             # Fichiers compilés
    ├── index.js
    ├── index.css
    ├── index.asset.php
    └── style-index.css
```

## Installation et activation

### 1. Activation automatique

Le bloc et le Custom Post Type sont automatiquement activés avec le thème. Lors de l'activation du thème :

- Le Custom Post Type "event" est enregistré
- La taxonomie "event_type" est créée
- Les types d'événements par défaut sont ajoutés
- Des événements de démonstration sont créés (si aucun événement n'existe)

### 2. Compilation du bloc

```bash
# Depuis le dossier du thème
npm run build:events

# Ou pour construire tous les blocs
npm run build
```

## Utilisation

### 1. Ajouter le bloc dans l'éditeur

1. Dans l'éditeur Gutenberg, cliquez sur "+"
2. Recherchez "Événements" ou naviguez vers la catégorie "Mon Theme ACA"
3. Ajoutez le bloc à votre page

### 2. Configuration du bloc

#### Options générales

- **Titre de la section** : Personnaliser le titre affiché (défaut: "Événements À Venir")
- **Nombre d'événements** : 1-20 événements à afficher (défaut: 6)
- **Trier par** : Date de l'événement, Date de création, ou Titre
- **Ordre** : Croissant ou Décroissant

#### Options d'affichage

- **Afficher le calendrier** : Activer/désactiver le calendrier
- **Afficher le type d'événement** : Montrer les tags de type
- **Afficher l'heure** : Afficher les horaires
- **Afficher le lieu** : Montrer les informations de localisation

#### Filtrage par types

- Sélectionner les types d'événements à inclure
- Laissez vide pour afficher tous les types

### 3. Créer des événements

#### Depuis l'administration WordPress

1. Allez dans **Événements > Ajouter nouveau**
2. Remplissez les informations :

##### 📅 Date et Heure

- **Date de début\*** (obligatoire)
- **Heure de début**
- **Date de fin**
- **Heure de fin**

##### 📍 Lieu

- **Nom du lieu** (ex: Centre de Conférence ACA)
- **Adresse complète**

##### 👤 Organisation

- **Organisateur**
- **Email de contact**
- **Téléphone de contact**
- **Site web**

##### 💰 Détails pratiques

- **Prix / Tarif** (ex: Gratuit, 50€, 25000 FCFA)
- **Capacité maximale**

3. Assignez un **Type d'événement**
4. Ajoutez une **image mise en avant** (optionnel)
5. **Publiez** l'événement

#### Types d'événements par défaut

- **Conférence** : Événements de type conférence ou symposium
- **Atelier** : Sessions de formation et ateliers pratiques
- **Webinaire** : Événements en ligne et visioconférences
- **Réunion** : Réunions et assemblées
- **Formation** : Sessions de formation et éducation

## Personnalisation

### 1. Couleurs

Le bloc utilise la palette de couleurs ACA définie dans les variables CSS :

```scss
:root {
  --aca-teal-green: #2d9b8a; // Couleur principale
  --aca-light-green: #a8e6cf; // Couleur d'accent
  --aca-dark-teal: #1f6b5c; // Variante sombre
  --aca-white: #ffffff;
  --aca-light-gray: #f8f9fa;
  --aca-medium-gray: #6c757d;
  --aca-dark-gray: #343a40;
  --aca-success-green: #28a745;
  --aca-warning-orange: #fd7e14;
}
```

### 2. Modification des styles

#### Style front-end

Modifiez `/blocks/events/style-index.css` pour personnaliser l'apparence en front-end.

#### Style éditeur

Modifiez `/blocks/events/editor.scss` pour personnaliser l'apparence dans l'éditeur.

### 3. Personnalisation du rendu

Modifiez `/blocks/events/render.php` pour :

- Changer la structure HTML
- Ajouter des champs personnalisés
- Modifier la logique de filtrage

### 4. Ajouter des champs personnalisés

1. Modifiez `functions-parts/events.php`
2. Ajoutez les champs dans `mon_theme_aca_event_details_callback()`
3. Mettez à jour `mon_theme_aca_save_event_meta()` pour sauvegarder
4. Modifiez `render.php` pour afficher les nouveaux champs

## Développement

### 1. Mode développement

```bash
# Compilation en mode watch
npm run start:events
```

### 2. Structure du code

#### edit.js

- Interface d'édition avec InspectorControls
- Récupération des événements via useEntityRecords
- Génération du calendrier en JavaScript
- Prévisualisation en temps réel

#### render.php

- Rendu côté serveur avec WP_Query
- Génération du calendrier en PHP
- Gestion des meta queries pour le filtrage
- Support de la pagination

#### view.js

- Interactivité front-end
- Navigation du calendrier
- Support du clavier pour l'accessibilité
- Filtrage par date (à implémenter)

### 3. Hooks et filtres disponibles

Le bloc respecte les hooks WordPress standards :

- `save_post` pour la sauvegarde des meta
- `pre_get_posts` pour les colonnes admin
- `after_switch_theme` pour l'initialisation

## Accessibilité

Le bloc est conçu pour être accessible :

- **Navigation clavier** complète du calendrier
- **Attributs ARIA** appropriés
- **Contrastes de couleurs** respectés
- **Textes alternatifs** pour les icônes
- **Focus visible** sur tous les éléments interactifs

## Performance

### Optimisations incluses

- **Lazy loading** des événements
- **Requêtes optimisées** avec meta_query
- **Cache friendly** avec WP_Query standard
- **CSS minifié** en production
- **JavaScript optimisé** avec wp-scripts

### Recommandations

- Limiter le nombre d'événements affichés (6-12 recommandé)
- Utiliser la pagination pour de grandes listes
- Optimiser les images d'événements

## Dépannage

### Problèmes courants

#### Le bloc ne s'affiche pas

1. Vérifiez que le thème est activé
2. Compilez les assets : `npm run build:events`
3. Vérifiez les erreurs JavaScript dans la console

#### Les événements ne s'affichent pas

1. Assurez-vous qu'il y a des événements publiés
2. Vérifiez les filtres de type d'événement
3. Contrôlez les dates des événements

#### Styles manquants

1. Vérifiez que les fichiers CSS sont compilés
2. Contrôlez l'enqueue des styles dans `functions.php`
3. Videz le cache si utilisé

### Debug

Pour debug, ajoutez dans `wp-config.php` :

```php
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('SCRIPT_DEBUG', true);
```

## Roadmap

### Fonctionnalités futures

- **Système de réservation** intégré
- **Export iCal** des événements
- **Notifications par email** pour les nouveaux événements
- **Intégration Google Maps** pour la géolocalisation
- **Multi-langues** avec WPML/Polylang
- **Filtrage par date** interactif
- **Vue liste/grille** alternée

### Améliorations techniques

- **REST API endpoints** personnalisés
- **Cache Redis** pour les gros volumes
- **Progressive Web App** support
- **Tests automatisés** avec Jest
- **TypeScript** migration

## Support

Pour toute question ou problème :

1. Consultez cette documentation
2. Vérifiez les logs d'erreur WordPress
3. Testez avec un thème par défaut
4. Contactez l'équipe de développement

---

_Dernière mise à jour : juin 2025_
_Version du bloc : 1.0.0_
_Compatible WordPress : 6.8+_
