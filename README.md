# stage_juin
Realisation d un portfolio sous symfony dans le cadre du stage de la RAN numerique suivi en juin2021


### istructions de mise en route->

### Installer les dépendances/vendor    
composer install  
  
### Fichier environnement  
Copier et coller le fichier __.env__ à la racine du projet  
Renommer la copie en __.env.local__  
  
### Configurer le fichier .env.local avec vos identifiants SQL  
DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=5.7  
  
### Créer la database   
php bin/console doctrine:database:create   
  
### Ajouter les entités a la database    
php bin/console make:migration  
php bin/console doctrine:migrations:migrate  
  
### Installer la configuration des tables   
php bin/console doctrine:fixtures:load   
  
### Créer votre compte développeur    
php bin/console make:dev  

### certificat pour https let's encrypt
symfony server:ca:install
  
### lancer le starter-kit  
symfony server:start
