<?php

function vercel_revalidate_about_menu() {
    add_submenu_page(
        'vercel-revalidate',
        __('About', 'vercel-revalidate'),
        __('About', 'vercel-revalidate'),
        'manage_options',
        'vercel-revalidate-about',
        'vercel_revalidate_about_page'
    );
}
add_action('admin_menu', 'vercel_revalidate_about_menu');

function vercel_revalidate_about_page() {
    ?>
    <div class="wrap">
        <h1><?php esc_html_e('About Vercel Revalidate', 'vercel-revalidate'); ?></h1>
        <p>
            <?php esc_html_e('This plugin allows your WordPress site to trigger Incremental Static Regeneration (ISR) on a Next.js frontend hosted on Vercel, each time a post is updated.', 'vercel-revalidate'); ?>
        </p>
        <p>
            <?php esc_html_e('It supports admin configuration, manual testing, logging, email alerts on failure, and CSV export.', 'vercel-revalidate'); ?>
        </p>
        <h2><?php esc_html_e('Developed by', 'vercel-revalidate'); ?></h2>
        <p>
            Arnaud Martin — <a href="https://www.digital-advantage.com" target="_blank">digital-advantage.com</a>
        </p>
        <h2><?php esc_html_e('Version', 'vercel-revalidate'); ?></h2>
        <p>1.3</p>
    </div>
    <?php
}
