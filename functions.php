<?php
// Theme paths
define('THEME_URI', get_template_directory_uri());
define('THEME_DIR', get_template_directory());

// Assets Version, if some trouble with the cache, update the version
$assets_version = wp_get_theme()['Version'];
define('ASSETS_VERSION', $assets_version);

// Enregistrer les scripts et les styles
function theme_enqueue_scripts() {
    // Enregistrer les scripts
    wp_enqueue_script( 'script', THEME_URI . '/assets/js/script.js', array(), ASSETS_VERSION, true );  
    wp_enqueue_script( 'ajax-script', THEME_URI . '/assets/js/ajax-script.js', array(), ASSETS_VERSION, true ); 

    wp_localize_script('script', 'script_params', [
		'ajaxurl' 					=> admin_url( 'admin-ajax.php' ),
	]); 

    wp_localize_script('ajax-script', 'script_params', [
		'websiteurl' 					=> get_site_url(),
	]); 
    // Enregistrer les styles
    wp_enqueue_style( 'style', THEME_URI."/style.css" , array(), ASSETS_VERSION );
    wp_enqueue_style( 'custom-style', THEME_URI . '/assets/css/custom-style.css', array(), ASSETS_VERSION );
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_scripts' );

// Désactiver Gutenberg pour un type de publication personnalisé
function disabled_gutenberg_cpt( $use_block_editor, $post_type ) {
    if ( 'photo' === $post_type ) {
        return false;
    }
    return $use_block_editor;
}
add_filter( 'use_block_editor_for_post_type', 'disabled_gutenberg_cpt', 10, 2 );

/******************************************************************************************************************/

// Load Composer dependencies.
require_once __DIR__ . '/vendor/autoload.php';

// Initialize Timber.
Timber\Timber::init();

// Ajoute une fonction personnalisée à Timber pour appeler do_shortcode.
add_filter( 'timber/twig', function( \Twig\Environment $twig ) {
    $twig->addFunction( new \Twig\TwigFunction( 'do_shortcode', 'do_shortcode' ) );
    return $twig;
} );

// Configurer Timber pour utiliser le dossier 'views'
Timber::$dirname = array('views');

// Définir une classe pour organiser les fonctions du thème
class MySite extends Timber\Site {
    
    public function __construct() {
        // Déclarer les supports de thème
        add_action( 'after_setup_theme', array( $this, 'theme_supports' ) );
        parent::__construct();
    }

    public function theme_supports() {
        // Activer les images à la une
        add_theme_support( 'post-thumbnails' );
        // Activer les menus
        add_theme_support( 'menus' );
    }
}

// Initialiser notre classe de thème
new MySite();

/***********************************************************************************************************************/

