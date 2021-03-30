# Resto-Conso


Il s'agit d'une plateforme Web/API pour la facturation des consommations étudiantes dans les restaurants universitaires. Ce projet a été développé avec CodeIgniter version 4.

### Pré-requis

- avoir `composer` installé
- avoir `php >= 7.2` installé


### Comment lancer le projet

Pour lancer l'application il faut : 

1- installer les dépendances :

```bash
composer install 
```

2- Mettre en place la base de données :

Modifier le fichier `.env` pour correspondre à votre base de données 

```dotenv
#--------------------------------------------------------------------
# DATABASE
#--------------------------------------------------------------------

database.default.hostname = localhost
database.default.database = nom_de_votre_base_de_donnees
database.default.username = utilisateur
database.default.password = mot_de_passe
database.default.DBDriver = PDO
```

3- Lancer le serveur :

```bash
php -S localhost:8000 -t public
```

5- Ouvrir le navigateur à l'adresse http://localhost:8000
