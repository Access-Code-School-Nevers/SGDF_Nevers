# Création d'une application de gestion de matériel pour "Scouts Guides de France" avec "Symfony"

Voici le projet d'une application pour Scouts Guides de France.


## Installation locale

Pour installer le projet il vous faut le logiciel "Composer" et une version PHP en 7.3.5. ouvrez une console. Et placez-vous dans le dossier de votre choix.

1. Commencez par cloner le projet dans le dossier :
```bash
git clone https://github.com/Access-Code-School-Nevers/SGDF_Nevers.git
```
2. Mettre à jour les dépendances du projet :
```bash
composer install
```

3. Et lancez le serveur :
```bash
symfony server:start
```

### Mise en production


1. Dans le fichier .env, passer la variable APP_ENV en prod
```bash
APP_ENV=prod
```

2. Dans le fichier .env, modifier les informations d'accès à la base de données
```bash
DATABASE_URL=mysql://nomUtilisateur:motDePasseUtilisateur@urlHebergement/nomDeLaBase
```

3. Vider le cache de l'application
```bash
php bin/console cache:clear
APP_ENV=prod APP_DEBUG=0 php bin/console cache:clear
```

4. Déployer les fichiers sur le serveur

5. Configurer les routes de redirection (créer un fichier .htaccess dans le dossier public - peut être fait en local)
```bash
composer require symfony/apache-pack
```

6. Créer un utilisateur admin dans la table utilisateur (la commande permet de créer un mot de passe crypté pour être inséré dans la base de données)
```bash
php bin/console security:encode-password
```

7. Insérer le site de Nevers dans la table Site

## Contributeur

[Noled](https://github.com/Noled)
[Blaster91](https://github.com/Blaster91)
[SolangeHarmoniePICARD](https://github.com/SolangeHarmoniePICARD)
[jlc92130](https://github.com/jlc92130)

## License
[GNU General Public License](https://github.com/Access-Code-School-Nevers/SGDF_Nevers/blob/master/LICENSE)
