<?php

function getApiUrl()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'intersect_connect';
    $data = $wpdb->get_results("SELECT * FROM $table_name", ARRAY_A);
    return $data[3]['value'];
}

function getToken()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'intersect_connect';
    $data = $wpdb->get_results("SELECT * FROM $table_name", ARRAY_A);
    return $data[2]['value'];
}

function get()
{
}

function post()
{
}

function getAuth($endpoint)
{
    $headers = array(
        'Content-Type' => 'application/json',
        'Authorization' => 'Bearer ' . getToken(),
    );

    $args = array(
        'headers' => $headers,
        'sslverify' => false,
    );

    $response = wp_remote_get(getApiUrl() . $endpoint, $args);

    if (is_wp_error($response)) {
        die('Error: ' . $response->get_error_message());
        // return ''; // Gérer l'erreur selon vos besoins
    }

    $response_body = wp_remote_retrieve_body($response);
    return json_decode($response_body, true);
}

function postAuth(array $postData, string $endpoint)
{
    $headers = array(
        'Content-Type' => 'application/json',
        'Authorization' => 'Bearer ' . getToken(),
    );

    $args = array(
        'body' => json_encode($postData),
        'headers' => $headers,
        'sslverify' => false,
    );

    $response = wp_remote_post(getApiUrl() . $endpoint, $args);
    $response_body = wp_remote_retrieve_body($response);
    return json_decode($response_body, true);
}

function auth(array $authData, string $api_url): string
{
    $headers = array(
        'Content-Type' => 'application/json',
    );

    $args = array(
        'body' => json_encode($authData),
        'headers' => $headers,
        'sslverify' => false,
    );

    $response = wp_remote_post($api_url . '/api/oauth/token', $args);

    if (is_wp_error($response)) {
        die('Error: ' . $response->get_error_message());
        // return ''; // Gérer l'erreur selon vos besoins
    }

    $response_body = wp_remote_retrieve_body($response);
    $response_data = json_decode($response_body, true);

    return $response_data["access_token"];
}


function getUser(string $username): array
{
    $user = getAuth("/api/v1/users/" . $username);

    return $user;
}

function register(array $postData): bool
{
    $register = postAuth($postData, "/api/v1/users/register");
    die(var_dump($register));
    if (!isset($register["username"])) {
        return false;
    }

    return true;
}
