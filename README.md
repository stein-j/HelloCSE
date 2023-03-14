# Test technique pour HelloCSE.

> Mars 2023 - JORI STEIN

À l’aide du framework PHP Laravel 9, créer :
- Un backoffice permettant de créer/modifier/supprimer les fiches « star » (nom, prénom, image, description)
- Une page publique permettant d’afficher de manière responsive sur mobile et desktop le contenu des fiches.
  Indications :
- L’utilisation de VueJS 3 et de TailwindCSS est un plus
- N’hésitez pas à commenter votre code et créer des commits sur git au fur et à mesure de votre progression


---

# Fonctionnalités implémentées

La page contient deux affichages :
- Les écrans avec une largeur inférieure à 760 pixels (considéré comme "Mobile") : La liste des stars prennent la largeur entière et l'affichage détail s'affiche dans la liste
- Les écrans avec une largeur supérieure à 760 pixels (considéré comme "tablette" ou "pc") : La liste des stars sont limité sur la largeur et l'affichage détail est placé sur la droite de la liste

### Front:
- Une barre de recherche côté front, car la liste entière est retournée par l'api
- Un bouton pour ajouter une nouvelle star
- Un affichage de la star par url
- Sélectionner / Désélectionner une star en cliquant sur le nom dans la liste
- Quand une star est sélectionnée il est possible de modifier ses données ou de la supprimer
- Dans le formulaire de création ou de modification, les erreurs sont affichées à côté des champs appropriés (mettre des valeurs vides ou un url erroné pour tester)

### Back:

- Les routes CRUD `/api/stars` dans _routes/api.php_
- Un controller pour gérer les stars dans _app/Http/Controllers/StarController.php_
- Une resource pour formater les réponses api _app/Http/Resources/StarResource.php_
- Une request pour valider les données de l'api _app/Https/Requests/StarRequest.php_
- Un modèle Star _app/Models/Star.php_
- Un seeder et factory pour le model avec _database/seeders/DatabaseSeeder.php_ et _database/factories/StarFactory.php_
# Prérequis

Ce projet a été codé sous les versions suivantes :
- `node` : v18.9.1
- `npm` : 8.19.1
- `php` : 8.1
- `mysql` : 8

# Installer

```bash
cp .env.example .env
```

Modifier les informations de connection à la BDD en modifiant les variables suivantes dans le fichiers _./.env_ :
- `DB_HOST`
- `DB_PORT`
- `DB_DATABASE`
- `DB_USERNAME`
- `DB_PASSWORD`

Ensuite, il faut migrer les tables nécessaires dans la base de données : 
```bash
php artisan migrate
```

Si nécessaire, il est possible d'ajouter (_seeder_) 20 stars dans la base de données : 

```bash
php artisan db:seed
```

---

Installer le module `front` :

```bash
npm install
```

```bash
npm build
```

Lancer le serveur web :

```bash
php artisan serve
```

Accéder à la page web `http://127.0.0.1:8000/`.

La liste des fonctionnalités sont présentes ici : https://github.com/stein-j/HelloCSE#fonctionnalit%C3%A9s-impl%C3%A9ment%C3%A9es

# Tester

[Pest](https://pestphp.com/) est utilisé pour l'execution des tests, les fichiers sont localisés dans _./test/Feature/*_.

Les tests peuvent être executés via la commande Laravel :

```bash
php atisan test
```
