<?php

function vercel_revalidate_admin_menu() {
    add_menu_page(
        'Vercel Revalidate',
        'Vercel Revalidate',
        'manage_options',
        'vercel-revalidate',
        'vercel_revalidate_settings_page',
        'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHZpZXdCb3g9IjAgMCA3NiA2NSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KICA8cGF0aCBkPSJNMzcuNTI3NCAwTDc1LjA1NDggNjVIMEwzNy41Mjc0IDBaIiBmaWxsPSIjMDAwMDAwIi8+Cjwvc3ZnPg==',
        81
    );
}
add_action('admin_menu', 'vercel_revalidate_admin_menu');

function vercel_revalidate_settings_page() {
    ?>
    <div class="wrap">
        <h1>Vercel Revalidate Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('vercel_revalidate_settings');
            do_settings_sections('vercel-revalidate');
            submit_button();
            ?>
        </form>

        <hr />

        <h2>Manual Revalidation Test</h2>
        <form method="post">
            <?php wp_nonce_field('vercel_revalidate_test_action', 'vercel_revalidate_nonce'); ?>
            <input type="text" name="vercel_revalidate_test_slug" placeholder="Enter slug (e.g. my-post-slug)" class="regular-text" required />
            <?php submit_button('Revalidate Now', 'primary', 'vercel_revalidate_test_submit'); ?>
        </form>

        <?php
        if (
            isset($_POST['vercel_revalidate_test_submit']) &&
            check_admin_referer('vercel_revalidate_test_action', 'vercel_revalidate_nonce')
        ) {
            $slug = isset($_POST['vercel_revalidate_test_slug'])
                ? sanitize_text_field(wp_unslash($_POST['vercel_revalidate_test_slug']))
                : '';

            $secret = get_option('vercel_revalidate_secret');
            $endpoint = get_option('vercel_revalidate_url');

            if ($slug && $secret && $endpoint) {
                $url = add_query_arg([
                    'secret' => $secret,
                    'slug'   => $slug,
                ], $endpoint);

                $response = wp_remote_get($url, [
                    'method'    => 'GET',
                    'timeout'   => 5,
                    'headers'   => [
                        'Content-Type' => 'application/json',
                    ],
                ]);

                if (!is_wp_error($response)) {
                    echo '<div class="notice notice-success"><p>Revalidation triggered for <code>/blog/' . esc_html($slug) . '</code>.</p></div>';
                } else {
                    echo '<div class="notice notice-error"><p>Error: ' . esc_html($response->get_error_message()) . '</p></div>';
                }
            }
        }
        ?>
    </div>
    <?php
}

function vercel_revalidate_secret_args() {
    return [
        'sanitize_callback' => 'sanitize_text_field',
        'type'              => 'string',
        'show_in_rest'      => false,
    ];
}

function vercel_revalidate_url_args() {
    return [
        'sanitize_callback' => 'esc_url_raw',
        'type'              => 'string',
        'show_in_rest'      => false,
    ];
}

function vercel_revalidate_register_settings() {
    register_setting('vercel_revalidate_settings', 'vercel_revalidate_secret', vercel_revalidate_secret_args());
    register_setting('vercel_revalidate_settings', 'vercel_revalidate_url', vercel_revalidate_url_args());
    
    add_settings_section(
        'vercel_revalidate_section',
        'Revalidation Settings',
        null,
        'vercel-revalidate'
    );

    add_settings_field(
        'vercel_revalidate_secret',
        'Revalidation Secret',
        'vercel_revalidate_secret_render',
        'vercel-revalidate',
        'vercel_revalidate_section'
    );

    add_settings_field(
        'vercel_revalidate_url',
        'Revalidation Endpoint URL',
        'vercel_revalidate_url_render',
        'vercel-revalidate',
        'vercel_revalidate_section'
    );
}
add_action('admin_init', 'vercel_revalidate_register_settings');

function vercel_revalidate_secret_render() {
    $value = get_option('vercel_revalidate_secret');
    echo "<input type='text' name='vercel_revalidate_secret' value='" . esc_attr($value) . "' class='regular-text' />";
}

function vercel_revalidate_url_render() {
    $value = get_option('vercel_revalidate_url');
    echo "<input type='text' name='vercel_revalidate_url' value='" . esc_attr($value) . "' class='regular-text' />";
}
