<?php

add_action('save_post', 'vercel_revalidate_on_post_update', 10, 3);

function vercel_revalidate_on_post_update($post_ID, $post, $update) {
    if ($post->post_type !== 'post' || $post->post_status !== 'publish') {
        return;
    }

    $slug = $post->post_name;
    $secret = get_option('vercel_revalidate_secret');
    $endpoint = get_option('vercel_revalidate_url');

    if (!$secret || !$endpoint) {
        return;
    }

    $url = add_query_arg([
        'secret' => $secret,
        'slug'   => $slug,
    ], $endpoint);

    $response = wp_remote_get($url, [
        'method'    => 'GET',
        'timeout'   => 2,
        'blocking'  => false,
        'headers'   => [
            'Content-Type' => 'application/json',
        ],
    ]);

    $status = is_wp_error($response) ? 'Error' : 'Success';
    vercel_revalidate_log_event($slug, $status);
}

function vercel_revalidate_log_event($slug, $status) {
    $logs = get_option('vercel_revalidate_logs', []);
    $logs[] = [
        'time'   => current_time('mysql'),
        'slug'   => $slug,
        'status' => $status,
    ];
    update_option('vercel_revalidate_logs', $logs);
}
