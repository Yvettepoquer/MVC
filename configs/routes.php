<?php
//- A gauche l'url voulue
//- A droite l'url renseignée dans les vues

////////////////
//REGLES FRONTOFFICE//

// Affichege du detail d'un post
Router::connect(':prefix/:slug-:id', 'posts/view/id:([0-9]+)/slug:([a-z0-9\-]+)/prefix:([a-z0-9\-]+)');

//Liste de tous les articles plus listing
Router::connect('blog', 'posts/index');

// Liste de toutes les pages
Router::connect(':slug-:id', 'pages/view/id:([0-9]+)/slug:([a-z0-9\-]+)');
// Affichage d'une page catégorie

Router::prefix('adm', 'backoffice'); //Définition du préfixe backoffice