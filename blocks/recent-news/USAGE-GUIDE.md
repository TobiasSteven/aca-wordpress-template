# Guide d'utilisation du Block "Actualités Récentes"

## Installation et Activation

Le block "Actualités Récentes" est automatiquement disponible dès que le thème `mon-theme-aca` est activé.

## Comment utiliser le block

### 1. Ajouter le block à votre page

1. Ouvrez l'éditeur Gutenberg (Éditeur de blocs)
2. Cliquez sur le bouton "+" pour ajouter un nouveau block
3. Recherchez "Actualités Récentes" ou naviguez dans la catégorie "Mon Thème ACA"
4. Cliquez sur le block pour l'ajouter

### 2. Configuration du block

Une fois le block ajouté, vous pouvez le configurer via le panneau de droite :

#### Panneau "Paramètres des actualités"

- **Titre de la section** : Champ texte pour personnaliser le titre (défaut : "Actualités Récentes")
- **Nombre d'articles** : Slider de 1 à 12 articles (défaut : 3)
- **Trier par** :
  - Date (défaut)
  - Titre
  - Aléatoire
- **Ordre** :
  - Décroissant (défaut) - plus récent en premier
  - Croissant - plus ancien en premier
- **Afficher la date** : Toggle pour afficher/masquer les dates sur les cartes
- **Afficher l'extrait** : Toggle pour afficher/masquer les extraits d'articles

#### Panneau "Catégories"

- Cases à cocher pour sélectionner une ou plusieurs catégories
- Si aucune catégorie n'est sélectionnée, tous les articles publiés sont affichés
- Compatible avec toutes les catégories WordPress

### 3. Personnalisation du design

Le block utilise automatiquement les couleurs du thème :

- **Teal Green (#2D9B8A)** : Titres et liens principaux
- **Dark Teal (#1F6B5C)** : Couleur de survol et titres secondaires
- **Light Gray (#F8F9FA)** : Arrière-plans
- **Medium Gray (#6C757D)** : Texte secondaire

### 4. Responsive Design

Le block s'adapte automatiquement :

- **Desktop** : 3 cartes par ligne (ou selon le nombre configuré)
- **Tablet** : 2 cartes par ligne
- **Mobile** : 1 carte par ligne, centrée

## Exemples d'utilisation

### Exemple 1 : Afficher les 6 derniers articles de la catégorie "Actualités"

```
- Titre de la section : "Nos Dernières Actualités"
- Nombre d'articles : 6
- Catégories : ☑ Actualités
- Trier par : Date
- Ordre : Décroissant
- Afficher la date : ☑
- Afficher l'extrait : ☑
```

### Exemple 2 : Afficher 4 articles aléatoires sans extraits

```
- Titre de la section : "À Découvrir"
- Nombre d'articles : 4
- Catégories : (toutes)
- Trier par : Aléatoire
- Afficher la date : ☑
- Afficher l'extrait : ☐
```

### Exemple 3 : Sidebar avec 3 articles récents sans dates

```
- Titre de la section : "Articles Récents"
- Nombre d'articles : 3
- Trier par : Date
- Ordre : Décroissant
- Afficher la date : ☐
- Afficher l'extrait : ☑
```

## Bonnes pratiques

1. **Images à la une** : Assurez-vous que vos articles ont des images à la une pour un meilleur rendu visuel
2. **Extraits** : Rédigez des extraits courts et accrocheurs (max 20 mots affichés)
3. **Catégories** : Utilisez des catégories cohérentes pour faciliter le filtrage
4. **Performance** : Limitez le nombre d'articles affichés pour optimiser les performances (max 6-8 recommandé)

## Dépannage

### Le block n'apparaît pas

- Vérifiez que le thème `mon-theme-aca` est bien activé
- Assurez-vous que les fichiers JavaScript ont été compilés (`npm run build`)

### Aucun article ne s'affiche

- Vérifiez que vous avez des articles publiés
- Si vous avez sélectionné des catégories, assurez-vous qu'elles contiennent des articles
- Vérifiez les paramètres de tri et d'ordre

### Les images ne s'affichent pas

- Vérifiez que vos articles ont des images à la une définies
- Assurez-vous que les images sont bien uploadées dans WordPress

### Problèmes de style

- Vérifiez que les fichiers CSS ont été compilés
- Assurez-vous qu'aucun autre plugin ou thème ne surcharge les styles
