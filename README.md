# yggtorrent-get-ratio
yggtorrent-get-ratio vous permet de récupérer votre ratio en PHP


![Preview](ygg-ratio.png)




# Installation et configuration

Mettre le fichier [yggtorrent_ratio.php](yggtorrent_ratio.php) sur un serveur PHP

Configurer l'URL de yggtorrent (actuellement yggtorrent.wtf) et votre compte au début du script :


    $YGGTORRENT_URL="yggtorrent.wtf";
    
    $USER = "the_username";
    $PASSWORD = "the_password";


Exécuter le script pour afficher votre ratio.

Le code est assez simple pour etre récupéré dans un programme plus complexe (ex : suivi de ratio).


### Fonctionnement :

Le script effectue 2 requêtes CURL :

- La 1ere pour s'authentifier ( https://$YGGTORRENT_URL/user/login )
- La 2e récupère l'entete du site ( https://$YGGTORRENT_URL/user/ajax_usermenu ) et fait le tri dans les informations pour afficher les infos.

