<?php

/**
 * Plugin Name: Intersect Connect
 * Plugin URI: https://akismet.com/
 * Description: Plugin to connect Intersect Server to WordPress
 * Version: 1.0
 * Requires PHP: 8.1
 * Author: XFallSeane
 * Author URI: https://thomasfds.fr
 * License: GPLv2 or later
 * Text Domain: Intersect Connect
 */

require_once("api.php");

// Crée la table "intersect_connect" dans la base de données WordPress avec les colonnes "id", "key" et "value".
function intersect_connect_create_table()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'intersect_connect';
    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE $table_name (
        id int(11) NOT NULL AUTO_INCREMENT,
        `key` varchar(255) NOT NULL,
        `value` LONGTEXT NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    $wpdb->query($sql);
}

// Insère des données dans la table "intersect_connect" de la base de données WordPress : "api_username", "api_password", "api_token" et "api_url".

// Insère des données dans la table "intersect_connect" de la base de données WordPress : "api_username", "api_password", "api_token" et "api_url".
function intersect_connect_insert_data()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'intersect_connect';

    // Vérifier si les données existent déjà
    $existing_data_query = $wpdb->prepare("SELECT COUNT(*) FROM $table_name");
    $existing_data_count = $wpdb->get_var($existing_data_query);

    // Ajouter les données uniquement si elles n'existent pas déjà
    if ($existing_data_count === '0') {
        $data = array(
            array('key' => 'api_username', 'value' => ''),
            array('key' => 'api_password', 'value' => ''),
            array('key' => 'api_token', 'value' => ''),
            array('key' => 'api_url', 'value' => '')
        );

        foreach ($data as $item) {
            $wpdb->insert($table_name, $item);
        }
    }
}


// Ajoute la colonne "intersect_id" à la table "wp_users".
function intersect_connect_add_column()
{
    global $wpdb;

    $table_name = $wpdb->prefix . 'users';
    $column_name = 'intersect_id';

    $sql = "ALTER TABLE $table_name ADD $column_name VARCHAR(255) NULL";

    $wpdb->query($sql);
}

function intersect_connect_setup()
{
    intersect_connect_create_table();
    intersect_connect_insert_data();
    intersect_connect_add_column();
    intersect_connect_insert_page();
}

function intersect_connect_admin_page()
{
    add_menu_page(
        'Intersect Connect', // Titre de la page
        'Intersect Connect', // Titre du menu
        'manage_options', // Capacité requise pour accéder à la page
        'intersect-connect', // Slug de la page principale
        'intersect_connect_render_admin_page_settings' // Fonction de rappel pour le contenu de la page
    );

    add_submenu_page(
        'intersect-connect', // Slug de la page parente
        'Serveur', // Titre de la page de sous-menu
        'Serveur', // Titre du sous-menu
        'manage_options', // Capacité requise pour accéder à la page de sous-menu
        'server', // Slug de la page de sous-menu
        'intersect_connect_render_admin_page_server' // Fonction de rappel pour le contenu de la page de sous-menu
    );

    add_submenu_page(
        'intersect-connect', // Slug de la page parente
        'Paramètres', // Titre de la page de sous-menu
        'Paramètres', // Titre du sous-menu
        'manage_options', // Capacité requise pour accéder à la page de sous-menu
        'settings', // Slug de la page de sous-menu
        'intersect_connect_render_admin_page_settings' // Fonction de rappel pour le contenu de la page de sous-menu
    );

    add_submenu_page(
        'intersect-connect', // Slug de la page parente
        'A propos', // Titre de la page de sous-menu
        'A propos', // Titre du sous-menu
        'manage_options', // Capacité requise pour accéder à la page de sous-menu
        'about', // Slug de la page de sous-menu
        'intersect_connect_render_admin_page_about' // Fonction de rappel pour le contenu de la page de sous-menu
    );
}


function intersect_connect_render_admin_page_settings()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'intersect_connect';

    // Vérifier si le formulaire a été soumis et que le nonce est valide
    if (isset($_POST['intersect_connect_nonce']) && wp_verify_nonce($_POST['intersect_connect_nonce'], 'intersect_connect_settings')) {
        // Récupérer les valeurs des champs du formulaire
        $apiUsername = sanitize_text_field($_POST['api_username']);
        $apiPassword = sanitize_text_field($_POST['api_password']);
        $apiUrl = sanitize_text_field($_POST['api_url']);

        // Mettre à jour les données dans la table intersect_connect
        $wpdb->update($table_name, array('value' => $apiUsername), array('key' => 'api_username'));
        $wpdb->update($table_name, array('value' => $apiPassword), array('key' => 'api_password'));
        $wpdb->update($table_name, array('value' => $apiUrl), array('key' => 'api_url'));
    }

    // Récupérer les données de la table intersect_connect après la mise à jour
    $data = $wpdb->get_results("SELECT * FROM $table_name", ARRAY_A);

    // Afficher le formulaire pour éditer les données
?>
    <div class="wrap">
        <h1>Intersect Connect Settings</h1>
        <form method="post" action="">
            <?php wp_nonce_field('intersect_connect_settings', 'intersect_connect_nonce'); ?>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="api_username">API Username</label></th>
                    <td><input type="text" name="api_username" value="<?php echo esc_attr($data[0]['value']); ?>"></td>
                </tr>
                <tr>
                    <th scope="row"><label for="api_password">API Password</label></th>
                    <td><input type="password" name="api_password" value="<?php echo esc_attr($data[1]['value']); ?>"></td>
                </tr>
                <tr>
                    <th scope="row"><label for="api_url">API URL</label></th>
                    <td><input type="text" name="api_url" value="<?php echo esc_attr($data[3]['value']); ?>"></td>
                </tr>
            </table>
            <?php submit_button('Save Settings'); ?>
        </form>
    </div>
<?php
}

function intersect_connect_render_admin_page_about()
{
    ob_start(); // Démarrer la mise en tampon de sortie
    include 'templates/about.php'; // Inclure le fichier PHP
    $content = ob_get_clean(); // Récupérer le contenu de la mise en tampon et vider la mise en tampon
    echo $content; // Afficher le contenu du fichier PHP
}

function intersect_connect_render_admin_page_server()
{
    ob_start(); // Démarrer la mise en tampon de sortie
    include 'templates/server.php'; // Inclure le fichier PHP
    $content = ob_get_clean(); // Récupérer le contenu de la mise en tampon et vider la mise en tampon
    echo $content; // Afficher le contenu du fichier PHP
}

function intersect_connect_insert_page()
{
    global $wpdb;

    $page_title = 'Mise à jour Token';
    $page_content = '[intersect-connect-token]';
    $page_slug = 'mise-a-jour-token';
    $page_template = 'default';

    // Vérifier si la page existe déjà dans la base de données
    $page_exists = $wpdb->get_var($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE post_name = %s", $page_slug));

    if (!$page_exists) {
        // Préparer les données de la nouvelle page
        $page_data = array(
            'post_title' => $page_title,
            'post_content' => $page_content,
            'post_name' => $page_slug,
            'post_status' => 'publish',
            'post_type' => 'page',
            'post_template' => $page_template
        );

        // Insérer la nouvelle page dans la base de données
        $page_id = wp_insert_post($page_data);

        if ($page_id) {
            // Ajouter le shortcode à la nouvelle page
            add_post_meta($page_id, '_wpb_shortcodes_custom_css', '[intersect-connect-token]');

            echo 'La page a été insérée avec succès.';
        } else {
            echo 'Une erreur s\'est produite lors de l\'insertion de la page.';
        }
    } else {
        echo 'La page existe déjà dans la base de données.';
    }
}

function intersect_connect_token_shortcode()
{
    // Récupérer les données nécessaires de la table intersect_connect (api_username, api_password, api_url)
    global $wpdb;
    $table_name = $wpdb->prefix . 'intersect_connect';
    $data = $wpdb->get_results("SELECT * FROM $table_name", ARRAY_A);

    // Vérifier si les données existent
    if ($data) {
        $api_username = $data[0]['value'];
        $api_password = $data[1]['value'];
        $api_url = $data[3]['value'];

        $authData = [
            "grant_type" => "password",
            "username" => $api_username,
            "password" => hash('sha256', $api_password)
        ];

        // Création du call API qui appel l'API de Intersect sur la route /api/oauth/token
        $auth = auth($authData, $api_url);
        $new_token = $auth;

        // Mettre à jour le token dans la table intersect_connect
        $wpdb->update(
            $table_name,
            array('value' => $auth),
            array('key' => 'api_token')
        );

        // Retourner la réponse JSON avec le nouveau token
        $response = array(
            'success' => true,
            'message' => 'Token updated successfully.',
        );

        wp_send_json($response);
    } else {
        // Retourner une réponse JSON en cas de données manquantes
        $response = array(
            'success' => false,
            'message' => 'Missing data in intersect_connect table.'
        );

        wp_send_json($response);
    }
}

function activation_page_shortcode()
{
    restrict_page_to_logged_in_users();

    ob_start();

    $page_title = 'Activation du compte de jeu';
    $page_content = '
                     <form action="" method="post">
                        <label for="username">Nom d\'utilisateur:</label>
                        <input type="text" name="username" id="username" required><br>
                        <label for="password">Mot de passe:</label>
                        <input type="password" name="password" id="password" required><br>
                        <input type="submit" value="Activer le compte">
                     </form>';

    echo $page_content;

    // Vérifier si le formulaire a été soumis
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = sanitize_text_field($_POST['username']);
        $password = sanitize_text_field($_POST['password']);

        // Récupérer l'utilisateur connecté
        $current_user = wp_get_current_user();

        // Vérifier si le mot de passe correspond au mot de passe haché de l'utilisateur connecté
        if (wp_check_password($password, $current_user->user_pass, $current_user->ID)) {
            // On vérifie si l'user existe déjà dans la base de donnée Intersect
            $user = getUser($current_user->display_name);

            if (isset($user["Message"]) && $user["Message"] == "No user with name '$current_user->display_name'.") {
                // On inscrit l'user en db
                if (!register(['username' => $username, 'password' => hash('sha256', $password), 'email' => $current_user->user_email])) {
                    echo '<p>Erreur lors de l\'activation !</p>';
                }

                echo '<p>Activation réussie !</p>';
            } else {
                echo '<p>Votre compte est déjà activer !</p>';
            }
        } else {
            // Afficher le message d'erreur
            echo '<p>Mot de passe incorrect.</p>';
        }
    }

    return ob_get_clean();
}


function restrict_page_to_logged_in_users() {
    // Vérifie si l'utilisateur n'est pas connecté
    if (!is_user_logged_in()) {
        // Redirige l'utilisateur vers la page de connexion
        wp_redirect(wp_login_url());
        exit;
    }
}

add_action('admin_menu', 'intersect_connect_admin_page');
register_activation_hook(__FILE__, 'intersect_connect_setup');
add_shortcode('intersect-connect-token', 'intersect_connect_token_shortcode');
add_shortcode('intersect-connect-activation-account', 'activation_page_shortcode');
