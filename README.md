# WP Sitemap

**Contributors:** kevinbenabdelhak  
**Tags:** sitemap, plan de site, shortcode  
**Requires at least:** 5.0  
**Tested up to:** 6.8.3  
**Requires PHP:** 7.0  
**Stable tag:** 1.0  
**License:** GPLv2 or later  
**License URI:** [GPLv2 License](https://www.gnu.org/licenses/gpl-2.0.html)

Ajoutez un plan de site à votre site WordPress avec un simple shortcode.

[![Voir le tutoriel](https://img.youtube.com/vi/DDaSQ18raDw/maxresdefault.jpg)](https://www.youtube.com/watch?v=DDaSQ18raDw&ab_channel=KevinBenabdelhak)

## Description

WP Sitemap est un plugin qui permet d'ajouter facilement un plan de site sur vos pages, articles, et widgets via un shortcode `[sitemap]`. Ce plugin offre des options pour filtrer par type de contenu et limiter le nombre d'éléments affichés.

### Fonctionnalités principales

- **Ajout d'un plan de site** : Intégrez un plan de site à vos publications simplement à l'aide d'un shortcode.
- **Filtrage de contenu** : Affichez uniquement les types de contenu souhaités (pages, articles, produits, etc.).
- **Limitation du nombre d'éléments** : Spécifiez combien d'éléments doivent apparaître dans votre plan de site.
- **Options de tri** : Trie les résultats par ordre alphabétique ou selon d'autres critères.

## Installation

1. **Téléchargez le fichier ZIP du plugin :**
   Téléchargez le fichier ZIP du plugin depuis cette URL: [WP Sitemap](https://kevin-benabdelhak.fr/plugins/wp-sitemap/)

2. **Uploader le fichier ZIP du plugin :**
   - Allez dans le panneau d'administration de WordPress et cliquez sur "Extensions" > "Ajouter".
   - Cliquez sur "Téléverser une extension".
   - Choisissez le fichier ZIP que vous avez téléchargé et cliquez sur "Installer maintenant".

3. **Activer le plugin :**
   Une fois le plugin installé, cliquez sur "Activer".

4. **Utiliser le shortcode :**
   Utilisez le shortcode `[sitemap]` dans n'importe quelle page ou article pour afficher votre plan de site.

## Shortcode

- **Afficher tout le contenu** :

  [sitemap]

Filtrer par type de contenu :

Pour n'afficher que les articles :
[sitemap type="post"]
*  Pour n'afficher que les pages et les produits :
[sitemap type="page,product"]
*  Limiter le nombre de résultats :
*  Pour afficher les 30 derniers articles :

[sitemap type="post" limit="30"]
*  Trier les résultats :
*  Trier par ordre alphabétique (A-Z) :

[sitemap orderby="title" order="ASC"]
*  Exclure du contenu :
*  Exclure plusieurs éléments :

[sitemap excluded="123, nom-de-la-page, 456"]
## MAJ
### 1.0
*  Création du shortcode
*  Type de contenu
*  Choix d'une limite
*  Ordre des liens
*  Exclusion manuelle

<a href="https://kevin-benabdelhak.fr/soutenir/">
  <img src="https://media0.giphy.com/media/v1.Y2lkPTc5MGI3NjExOXY0cmdrdnNjcXlxb3hrcG15YmpzYWRqZ3BpeHNyY3I4YjZ1eXc0dSZlcD12MV9pbnRlcm5hbF9naWZfYnlfaWQmY3Q9Zw/R9mgVlsCuv6XCDK8Lb/giphy.gif" alt="Soutenir Kevin Benabdelhak pour développer des extensions Chrome" style="width:100%;" />
</a>****
