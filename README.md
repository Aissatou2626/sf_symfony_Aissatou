<!-- DATABASE_URL="mysql://root:root@127.0.0.1:3306/symfony_aissatou?serverVersion=8.0.36&charset=utf8mb4" :  -->
cette commande, doit être copier depuis le fichier (.env) tout en oubliant pas de mettre à jour votre user, mot de passe et version.

<!-- composer dump-env dev :  -->
Pour créer le fichier (.env.local.php)

<!-- symfony console doctrine:database:create : -->
Pour créer automatiquement sa base de données

<!-- symfony server:start -->
    Pour ouvrir le server

 <!-- symfony server:stop  -->
 Pour arrêter le server

 {{}} = echo

 <!-- symfony console make:controller -->
 Cette commande permet de générer automatiquement  ma class, puis on précise le nom de la class qu'on veut créer.

 MODEL: permet de connecter avec la BDD(c'est le pont)

 <!-- symfony console make:entity Categorie -->
    pour créer les champs(colonnes) , puis repondre à la question par le nom que vous voulez donner à votre champs

  <!-- symfony console make:migration -->
  pour tout migrer vers votre BDD


Pour génerer un formulaire il faut 3 étapes:
 1- <!-- symfony console make:form  -->

 2-  <!-- CategorieType -->

 3-  <!-- Categorie  -->

  <!-- symfony console make:controller Backend\CategorieController -->
  Pour  creer le fichier CategorieController dans le dossier Backend


  query = get
  request = $_POST

  On est pas obliger de persister les données dans UPDATE tandis qu'il est obligatoire dans le create

  <!-- type(scope): message -->
  <!-- git commit -m 'feat(categories): add crud for categories' -->
  La convention 
  
  