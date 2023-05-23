<?php

/**
 * Plugin Name: Intersect Connect
 * Plugin URI: https://akismet.com/
 * Description: Plugin to connect Intersect Server to WordPress
 * Version: 1.1
 * Requires PHP: 8.1
 * Author: XFallSeane
 * Author URI: https://thomasfds.fr
 * License: GPLv2 or later
 * Text Domain: Intersect Connect
 */

// Crée la table "intersect_connect" dans la base de données WordPress avec les colonnes "id", "key" et "value".
function intersect_connect_create_table()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'intersect_connect';
    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE $table_name (
        id int(11) NOT NULL AUTO_INCREMENT,
        `key` varchar(255) NOT NULL,
        `value` varchar(255) NOT NULL,
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
        'intersect_connect_settings', // Slug de la page
        'intersect_connect_render_admin_page' // Fonction de rappel pour le contenu de la page
    );
}

function intersect_connect_render_admin_page()
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

function intersect_connect_insert_page() {
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

function intersect_connect_token_shortcode() {
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
            "password" => $api_password
        ];

        // Création du call API qui appel l'API de Intersect sur la route /api/oauth/token
        $curl = curl_init($api_url . '/api/oauth/token');
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $authData);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        $response = curl_exec($curl);
        curl_close($curl);

        $response = json_decode($response, true);
        $new_token = $response['access_token'];
        // Mettre à jour le token dans la table intersect_connect
        $wpdb->update(
            $table_name,
            array('value' => $new_token),
            array('key' => 'api_token')
        );

        // Retourner la réponse JSON avec le nouveau token
        $response = array(
            'success' => true,
            'message' => 'Token updated successfully.',
            'token' => $new_token
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



add_action('admin_menu', 'intersect_connect_admin_page');
register_activation_hook(__FILE__, 'intersect_connect_setup');
add_shortcode('intersect-connect-token', 'intersect_connect_token_shortcode');
