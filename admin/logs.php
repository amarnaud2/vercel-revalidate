<?php

function vercel_revalidate_logs_menu() {
    add_submenu_page(
        'vercel-revalidate',
        'Revalidation Logs',
        'Logs',
        'manage_options',
        'vercel-revalidate-logs',
        'vercel_revalidate_logs_page'
    );
}
add_action('admin_menu', 'vercel_revalidate_logs_menu');

function vercel_revalidate_logs_page() {
    $logs = get_option('vercel_revalidate_logs', []);
    ?>
    <div class="wrap">
        <h1>Vercel Revalidation Logs</h1>

        <form method="post" style="margin-bottom: 20px;">
            <?php submit_button('Export as CSV', 'secondary', 'vercel_revalidate_export_csv'); ?>
        </form>

        <?php if (!empty($logs)) : ?>
            <table class="widefat fixed striped">
                <thead>
                    <tr>
                        <th>Time</th>
                        <th>Slug</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (array_reverse($logs) as $log) : ?>
                        <tr>
                            <td><?php echo esc_html($log['time']); ?></td>
                            <td><?php echo esc_html($log['slug']); ?></td>
                            <td><?php echo esc_html($log['status']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <form method="post" style="margin-top: 20px;">
                <?php submit_button('Clear Logs', 'delete', 'vercel_revalidate_clear_logs'); ?>
            </form>
        <?php else : ?>
            <p>No logs recorded yet.</p>
        <?php endif; ?>

        <?php
        if (isset($_POST['vercel_revalidate_clear_logs'])) {
            delete_option('vercel_revalidate_logs');
            echo '<div class="notice notice-success"><p>Logs cleared.</p></div>';
        }

        if (isset($_POST['vercel_revalidate_export_csv'])) {
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="vercel-revalidate-logs.csv"');
            $output = fopen('php://output', 'w');
            fputcsv($output, ['Time', 'Slug', 'Status']);
            foreach ($logs as $log) {
                fputcsv($output, [$log['time'], $log['slug'], $log['status']]);
            }
            fclose($output);
            exit;
        }
        ?>
    </div>
    <?php
}

// Admin menu badge for errors
function vercel_revalidate_admin_bubble($menu) {
    $logs = get_option('vercel_revalidate_logs', []);
    $errors = array_filter($logs, function($log) {
        return $log['status'] === 'Error';
    });

    if (count($errors) > 0) {
        foreach ($menu as $key => $item) {
            if ($item[2] === 'vercel-revalidate') {
                $menu[$key][0] .= ' <span class="update-plugins count-' . count($errors) . '"><span class="plugin-count">' . count($errors) . '</span></span>';
            }
        }
    }

    return $menu;
}
add_filter('add_menu_classes', 'vercel_revalidate_admin_bubble');

// Send email alert on error
/*
function vercel_revalidate_log_event($slug, $status) {
    $logs = get_option('vercel_revalidate_logs', []);
    $logs[] = [
        'time'   => current_time('mysql'),
        'slug'   => $slug,
        'status' => $status,
    ];
    update_option('vercel_revalidate_logs', $logs);

    if ($status === 'Error') {
        $admin_email = get_option('admin_email');
        $subject = 'Vercel Revalidate Failed';
        $message = "A revalidation request for '/blog/{$slug}' has failed.

Time: " . current_time('mysql');
        wp_mail($admin_email, $subject, $message);
    }
}
*/