Application de Génération objectif d'un DM :

Fonctionnalités :

Création d'un DM _ Création d'un objectif de ce DM par Mois
Technologie Utilisé :

HTML 5 & CSS3
Javascript (ES6) & Jquery (Vers 3.6.0 ) & AJAX
Plugins Jquery
DataTables (Pour afficher les éléments en tableau)+[packages de langues VF (Change la langue du dataTables en VF)]+[momentjs(Plugins gestion des Dates)]
sweetAlert (Pour afficher les notifications des succès et des erreurs)
Bootstrap 5
PHP v7... (Pas de configuration spécial)
Structuration du dossier de l'application :

Pages : => Dans ce dossier se trouve toutes les pages "Front-end" pour récueillir et manipuler les données saisies par l'utilisateurs. ce page contient les dossiers suivant : + accueil : c'est la page d'accueil de l'application ; page de génération des objectifs , Pages pour les détails de chaque DM (Détails des objectifs) + DM : c'est la page de manipulation des DM ( Créations du DM , Modification des Labos [ajout du labo ou suppression du labo]) + login : c'est la page de connexion pour l'application lors de l'ouverture de l'application et la déconnexion de l'application + logout : c'est la gestion du SESSION de l'application + Utilisateurs : c'est la page de création d'un utilisateurs (pas utiliser pour l'instant)

Config: => Sur ce dossier se trouve la configuration de la connexion avec la base de données.

Controller: =>Sur ce dossier se trouve toutes les pages "back-end" , c'est à dire la page pour toutes les requêtes. ce dossier contient les pages suivantes : accueil.php : Gestion de la page d'accueil dmcreate.php : Création d'un DM dmsupp.php : Suppression d'un DM dmtab.php : (Non utiliser) dmupdate.php : (Non utiliser) edit_labo.php : Modification du labo existant d'un DM editController.php : Affiche les détails d'un DM dans la page d'accueil qui utilise la procédure stocké : " getobjectif " genere.php : Génére l'objectif d'un DM par la procédure stocké : "generer_obj_dm2" genereSend.php : Gestion des insertions des articles séléctionner dans la générations de l'objectif homeEdit.php : Gestion des modifications dans la page détails(pour les Etats) homeUpdate.php : Gestion des modifications dans la page détails (pour les commentaires) login.php : Gestion des identifiants et mot de passe lors de la connexion de l'utilisateurs selected.php : Gestion d'affichage des labos dans l'attribut " select"

Plugins: => Ce dossier contient les Framework "Front-end" comme : + bootstrap + jquery + datatables + sweetalerts

assets : => Ce dossier contient les ressources utilisers pour l'application (css,fonts,images,js)
