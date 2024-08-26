<?php
// Theme paths
define('THEME_URI', get_template_directory_uri());
define('THEME_DIR', get_template_directory());

// Assets Version, if some trouble with the cache, update the version
$assets_version = wp_get_theme()['Version'];
define('ASSETS_VERSION', $assets_version);

// Enregistrer les scripts et les styles
function theme_enqueue_scripts() {
    // Enregistrer les scripts de base
    wp_enqueue_script('base-script', THEME_URI . '/assets/js/base-script.js', array(), ASSETS_VERSION, true);  
    wp_enqueue_script('ajax-script', THEME_URI . '/assets/js/ajax-script.js', array(), ASSETS_VERSION, true); 

    // Localiser les scripts avec des données dynamiques
    wp_localize_script('base-script', 'script_params', [
        'ajaxurl'   => admin_url('admin-ajax.php'),
        'websiteurl'=> get_site_url(),
    ]); 

    // Enregistrer les styles de base
    wp_enqueue_style('style', THEME_URI . "/style.css", array(), ASSETS_VERSION);
    wp_enqueue_style('base-style', THEME_URI . '/assets/css/base-style.min.css', array(), ASSETS_VERSION);
    wp_enqueue_style('front-page-css', THEME_URI . '/assets/css/front-page.min.css', array(), ASSETS_VERSION);
    
}
add_action('wp_enqueue_scripts', 'theme_enqueue_scripts');



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
        add_action('after_setup_theme', array($this, 'theme_supports'));

        // Ajouter le contexte global à Timber
        add_filter('timber/context', array($this, 'add_to_context'));

        parent::__construct();
    }

    public function theme_supports() {
        // Activer les images à la une
        add_theme_support('post-thumbnails');
        // Activer les menus
        add_theme_support('menus');
    }

    public function add_to_context($context) {
        // Ajouter des éléments au contexte global
        $context['site'] = $this;
        $context['logo'] = esc_url(get_template_directory_uri() . '/assets/images/gftc title3.webp');
        $context['backgroundL'] = esc_url(get_template_directory_uri() . '/assets/images/backgroundL.webp');
        $context['backgroundL2'] = esc_url(get_template_directory_uri() . '/assets/images/backgroundL2.webp');
        $context['backgroundR'] = esc_url(get_template_directory_uri() . '/assets/images/backgroundR.webp');
        $context['backgroundR2'] = esc_url(get_template_directory_uri() . '/assets/images/backgroundR2.webp');
        $context['head'] = esc_url(get_template_directory_uri() . '/assets/images/gftc head2.webp');
        $context['cab'] = esc_url(get_template_directory_uri() . '/assets/images/gftc cab2.webp');
        $context['menu'] = esc_url(get_template_directory_uri() . '/assets/images/gftc menu.webp');

        // Ajouter des informations sur l'utilisateur connecté si nécessaire
        if (is_user_logged_in()) {
            $context['current_user'] = wp_get_current_user();
        }

        // Retourner le contexte modifié
        return $context;
    }
}

// Initialiser notre classe de thème
new MySite();


/***********************************************************************************************************************/

