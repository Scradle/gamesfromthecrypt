<?php

// Charger Timber et vérifier si Timber est bien activé
if ( class_exists( 'Timber' ) ) {
    // Récupérer le contexte global
    $context = Timber::context();

    // Obtenir la page d'accueil
    $context['post'] = Timber::get_post();

    // Rendre le template Twig correspondant (ici, front-page.twig)
    Timber::render('front-page.twig', $context);
} else {
    // Si Timber n'est pas actif, afficher un message d'erreur
    echo 'Timber est nécessaire pour afficher ce thème correctement. Veuillez installer et activer le plugin Timber.';
}
