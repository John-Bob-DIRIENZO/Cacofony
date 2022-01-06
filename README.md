# MT-4 : Skeleton
Un petit squelette d'app pour les MT-4, j'ai amélioré le routeur pour qu'il prenne à peu près n'importe quelle REGEX en entrée et qu'il match correctement en passant les bons paramètres.

J'ai aussi amélioré la manipulation des arrays pour que vous soyez pas tentés d'utiliser des méthodes immondes

N'oubliez pas de rebuild le dossier vendor, donc pour lancer le projet :

```
cd app
composer install
cd ..
docker-compose up -d
```