<?php
// Inclure le fichier header de WordPress
get_header();

// Charger Timber et vérifier si Timber est bien activé
if ( class_exists( 'Timber' ) ) {
    // Récupérer le contexte global
    $context = Timber::context();

    // Passer des critères de requête à Timber::get_posts()
    // Cela peut être une requête vide pour récupérer les articles par défaut, 
    // ou vous pouvez spécifier des arguments comme 'post_type', 'category_name', etc.
    $args = array(
        'post_type' => 'post',   // Par défaut, récupérer les articles de type 'post'
        'posts_per_page' => 10   // Limiter à 10 articles, par exemple
    );
    $context['posts'] = Timber::get_posts($args);

    // Rendre le template Twig correspondant (ici, index.twig)
    Timber::render('index.twig', $context);
} else {
    // Si Timber n'est pas actif, afficher un message d'erreur
    echo 'Timber est nécessaire pour afficher ce thème correctement. Veuillez installer et activer le plugin Timber.';
}

// Inclure le fichier footer de WordPress
get_footer();
