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


### Installation de la base de données (peut être fait en ligne après mise en production ou en local)
1. Dans le fichier .env, modifiez les informations d'accès à la base de données
```bash
DATABASE_URL=mysql://nomUtilisateur:motDePasseUtilisateur@urlHebergement/nomDeLaBase
```

2. Utilisez la ligne de commande suivante pour créer la base de données
```bash
php bin/console doctrine:database:create
```

3. Utilisez la ligne de commande suivante pour ajouter les tables à la base de données
```bash
php bin/console doctrine:migrations:migrate
```

4.1. Ouvrez le fichier src/DataFixtures/UtilisateurFixture.php et modifiez le mot de passe de l'administrateur à la ligne 33 par le mot de passe de votre choix.

4.2. Utilisez la ligne de commande suivante pour ajouter l'utilisateur admin
```bash
php bin/console doctrine:fixtures:load
```



### Mise en production

1. Dans le fichier .env, passez la variable APP_ENV en prod
```bash
APP_ENV=prod
```

2. Videz le cache de l'application
```bash
php bin/console cache:clear
APP_ENV=prod APP_DEBUG=0 php bin/console cache:clear
```

3. Déployez les fichiers sur le serveur

4. Configurez les routes de redirection (créé un fichier .htaccess dans le dossier public - peut être fait en local)
```bash
composer require symfony/apache-pack
```

5. Insérez le site de Nevers dans la table Site


## Contributeur

[Noled](https://github.com/Noled)
[Blaster91](https://github.com/Blaster91)
[SolangeHarmoniePICARD](https://github.com/SolangeHarmoniePICARD)
[jlc92130](https://github.com/jlc92130)


## License
[GNU General Public License](https://github.com/Access-Code-School-Nevers/SGDF_Nevers/blob/master/LICENSE)
