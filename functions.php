<?php
defined('ABSPATH') || exit;

function psv3_pages(): array {
    return [
        'home' => 'Главная', 'plugins' => 'Каталог плагинов', 'plugins-payment' => 'Плагины для оплаты',
        'ozon-delivery' => 'Доставка Ozon для WooCommerce', 'services' => 'Услуги',
        'purchase-terms' => 'Гарантии, поддержка и возврат', 'privacy' => 'Политика конфиденциальности',
        'offer' => 'Публичная оферта', 'account' => 'Личный кабинет', 'register' => 'Регистрация',
        'blog' => 'Блог', 'checkout-guide' => 'Как упростить оформление заказа в WooCommerce',
        'contacts' => 'О проекте и контакты',
    ];
}

add_action('after_setup_theme', static function () {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('automatic-feed-links');
});
add_action('wp_enqueue_scripts', static function () {
    wp_enqueue_style('psv3-layout', get_theme_file_uri('/assets/theme.css'), [], '1.0.12');
    wp_enqueue_style('psv3-geometry', get_theme_file_uri('/assets/geometry.css'), ['psv3-layout'], '1.0.12');
    wp_enqueue_script('psv3-ui', get_theme_file_uri('/assets/theme.js'), [], '1.0.12', true);
});
add_action('customize_register', static function ($customizer) {
    $customizer->add_section('psv3_contacts', ['title' => 'Plugins-store']);
    $settings = [
        'psv3_telegram' => ['Ссылка на Telegram', 'esc_url_raw'],
        'psv3_email' => ['Почта для заявок', 'sanitize_email'],
        'psv3_hours' => ['Время работы поддержки', 'sanitize_text_field'],
        'psv3_person' => ['ФИО', 'sanitize_text_field'],
        'psv3_tax_id' => ['ИНН', 'sanitize_text_field'],
    ];
    foreach ($settings as $id => [$label, $sanitize]) {
        $customizer->add_setting($id, ['sanitize_callback' => $sanitize]);
        $customizer->add_control($id, ['section' => 'psv3_contacts', 'label' => $label]);
    }
});

function psv3_telegram(): string {
    return get_theme_mod('psv3_telegram') ?: psv3_url('contacts');
}

function psv3_url(string $slug): string {
    if ($slug === 'home') {
        return home_url('/');
    }
    $page = get_page_by_path($slug);
    return $page && $page->post_status === 'publish' ? get_permalink($page) : add_query_arg('psv3', $slug, home_url('/'));
}

function psv3_view(): string {
    $query = isset($_GET['psv3']) && is_string($_GET['psv3']) ? sanitize_key(wp_unslash($_GET['psv3'])) : '';
    if ($query && isset(psv3_pages()[$query])) {
        return $query;
    }
    if (is_front_page()) {
        return 'home';
    }
    if (is_home()) {
        return 'blog';
    }
    if (is_page()) {
        $slug = get_post_field('post_name', get_queried_object_id());
        return isset(psv3_pages()[$slug]) ? $slug : '';
    }
    return '';
}

add_filter('pre_get_document_title', static function ($title) {
    $view = psv3_view();
    return $view && $view !== 'home' ? psv3_pages()[$view] . ' — ' . get_bloginfo('name') : $title;
});

function psv3_form_fields(string $action): void {
    echo '<input type="hidden" name="action" value="psv3_' . esc_attr($action) . '">';
    wp_nonce_field('psv3_' . $action);
}

function psv3_post(string $key): string {
    return isset($_POST[$key]) && is_string($_POST[$key]) ? wp_unslash($_POST[$key]) : '';
}

function psv3_finish(string $destination, string $status): never {
    wp_safe_redirect(add_query_arg('psv3_status', $status, psv3_url($destination)));
    exit;
}

add_action('admin_post_nopriv_psv3_login', static function () {
    check_admin_referer('psv3_login');
    $email = sanitize_email(psv3_post('email'));
    $account = get_user_by('email', $email);
    $result = $account ? wp_signon(['user_login' => $account->user_login, 'user_password' => psv3_post('password'), 'remember' => false], is_ssl()) : null;
    psv3_finish($result && !is_wp_error($result) ? 'account' : 'home', $result && !is_wp_error($result) ? 'logged-in' : 'login-error');
});
add_action('admin_post_nopriv_psv3_register', static function () {
    check_admin_referer('psv3_register');
    if (!get_option('users_can_register')) {
        psv3_finish('register', 'registration-disabled');
    }
    $email = sanitize_email(psv3_post('email'));
    $pass = psv3_post('password');
    if (!$email || strlen($pass) < 8 || $pass !== psv3_post('confirm') || !psv3_post('consent')) {
        psv3_finish('register', 'invalid');
    }
    $id = wp_insert_user(['user_login' => 'client-' . wp_generate_password(16, false), 'user_email' => $email, 'user_pass' => $pass, 'role' => 'subscriber', 'display_name' => sanitize_text_field(psv3_post('name')) ?: $email]);
    if (is_wp_error($id)) {
        psv3_finish('register', 'invalid');
    }
    update_user_meta($id, 'psv3_consent_at', current_time('mysql', true));
    update_user_meta($id, 'psv3_marketing', psv3_post('marketing') ? 1 : 0);
    wp_new_user_notification($id, null, 'admin');
    wp_set_auth_cookie($id, false, is_ssl());
    psv3_finish('account', 'logged-in');
});
add_action('admin_post_nopriv_psv3_reset', static function () {
    check_admin_referer('psv3_reset');
    retrieve_password(sanitize_email(psv3_post('email')));
    psv3_finish('home', 'reset-sent');
});
function psv3_request(): never {
    check_admin_referer('psv3_request');
    $contact = sanitize_text_field(psv3_post('contact'));
    $body = sanitize_textarea_field(psv3_post('message'));
    $plugin_id = absint(psv3_post('plugin_id'));
    $plugin = $plugin_id ? get_post($plugin_id) : null;
    $plugin_context = '';
    if ($plugin && $plugin->post_type === 'wp-plugins' && $plugin->post_status === 'publish' && !$plugin->post_password) {
        $plugin_context = "Плагин: " . sanitize_text_field(get_the_title($plugin)) . "\n" . get_permalink($plugin) . "\n\n";
    }
    $name = sanitize_text_field(psv3_post('name'));
    $website = esc_url_raw(psv3_post('website'));
    if (!$contact || !$body) {
        // The product form allows an empty comment.
        if (!$contact) {
            psv3_finish('services', 'invalid');
        }
    }
    $attachments = [];
    $tmp_dir = '';
    if (isset($_FILES['attachment']['error']) && $_FILES['attachment']['error'] !== UPLOAD_ERR_NO_FILE) {
        $file = $_FILES['attachment'];
        $mimes = ['doc' => 'application/msword', 'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'pdf' => 'application/pdf', 'txt' => 'text/plain'];
        if ($file['error'] !== UPLOAD_ERR_OK || $file['size'] > 5 * MB_IN_BYTES || !is_uploaded_file($file['tmp_name'])) {
            psv3_finish('services', 'attachment-error');
        }
        $type = wp_check_filetype_and_ext($file['tmp_name'], $file['name'], $mimes);
        if (empty($type['ext']) || empty($type['type'])) {
            psv3_finish('services', 'attachment-error');
        }
        $tmp_dir = trailingslashit(get_temp_dir()) . 'psv3-' . wp_generate_uuid4();
        if (!mkdir($tmp_dir, 0700)) {
            psv3_finish('services', 'attachment-error');
        }
        $path = $tmp_dir . '/' . sanitize_file_name($file['name']);
        if (!move_uploaded_file($file['tmp_name'], $path)) {
            rmdir($tmp_dir);
            psv3_finish('services', 'attachment-error');
        }
        $attachments[] = $path;
    }
    try {
        $sent = wp_mail(get_theme_mod('psv3_email') ?: get_option('admin_email'), 'Заявка Plugins-store', "{$plugin_context}Имя: $name\nКонтакт: $contact\nСайт: $website\n\n$body", [], $attachments);
    } finally {
        foreach ($attachments as $path) {
            unlink($path);
        }
        if ($tmp_dir) {
            rmdir($tmp_dir);
        }
    }
    psv3_finish('services', $sent ? 'sent' : 'mail-error');
}
add_action('admin_post_psv3_request', 'psv3_request');
add_action('admin_post_nopriv_psv3_request', 'psv3_request');
add_action('admin_post_psv3_ticket', static function () {
    check_admin_referer('psv3_ticket');
    $subject = sanitize_text_field(psv3_post('subject'));
    $message = sanitize_textarea_field(psv3_post('message'));
    $u = wp_get_current_user();
    if (!$subject || !$message) {
        psv3_finish('account', 'invalid');
    }
    $ticket = wp_insert_post(['post_type' => 'psv3_ticket', 'post_status' => 'private', 'post_author' => $u->ID, 'post_title' => $subject, 'post_content' => $message], true);
    if (is_wp_error($ticket)) {
        psv3_finish('account', 'mail-error');
    }
    wp_mail(get_theme_mod('psv3_email') ?: get_option('admin_email'), 'Поддержка Plugins-store: ' . $subject, $u->user_email . "\n\n" . $message);
    psv3_finish('account', 'sent');
});

function psv3_notice(): void {
    $labels = [
        'login-error' => 'Не удалось войти. Проверьте email и пароль.',
        'invalid' => 'Проверьте данные формы и попробуйте ещё раз.',
        'sent' => 'Сообщение отправлено.',
        'mail-error' => 'Сообщение не отправлено. Попробуйте снова или свяжитесь с поддержкой.',
        'reset-sent' => 'Если аккаунт существует, на email отправлена ссылка для восстановления.',
        'attachment-error' => 'Прикрепите DOC, DOCX, PDF или TXT размером до 5 МБ.',
        'registration-disabled' => 'Регистрация пока закрыта.',
    ];
    $status = isset($_GET['psv3_status']) && is_string($_GET['psv3_status']) ? sanitize_key(wp_unslash($_GET['psv3_status'])) : '';
    if (isset($labels[$status])) {
        echo '<p class="ps-notice" role="status">' . esc_html($labels[$status]) . '</p>';
    }
}

add_action('init', static function () {
    register_post_type('wp-plugins', [
        'labels' => [
            'name' => 'Плагины',
            'singular_name' => 'Плагин',
            'menu_name' => 'Плагины магазина',
            'all_items' => 'Все плагины',
            'add_new_item' => 'Добавить плагин',
            'edit_item' => 'Редактировать плагин',
            'view_item' => 'Посмотреть плагин',
            'search_items' => 'Найти плагин',
            'not_found' => 'Плагины не найдены',
        ],
        'public' => true,
        'show_in_rest' => true,
        'menu_icon' => 'dashicons-admin-plugins',
        'has_archive' => false,
        'rewrite' => false,
        'supports' => ['title', 'editor', 'excerpt', 'thumbnail', 'revisions'],
    ]);

    register_post_type('psv3_ticket', [
        'label' => 'Обращения Plugins-store', 'public' => false, 'show_ui' => true,
        'supports' => ['title', 'editor', 'author', 'custom-fields'],
    ]);
});
function psv3_account_data(string $field): string {
    static $data = null;
    if ($data === null) {
        $id = get_current_user_id();
        $title = (string) get_user_meta($id, 'psv3_license_title', true);
        $key = (string) get_user_meta($id, 'psv3_license_key', true);
        $domain = (string) get_user_meta($id, 'psv3_license_domain', true);
        $download = (string) get_user_meta($id, 'psv3_license_download', true);
        $tickets = get_posts(['post_type' => 'psv3_ticket', 'post_status' => 'private', 'author' => $id, 'numberposts' => 1, 'suppress_filters' => true]);
        $ticket = $tickets[0] ?? null;
        $data = [
            'license_count' => $key ? '1 активная лицензия' : 'Пока нет лицензий',
            'download_count' => $download ? '1 доступный архив' : 'Архивов пока нет',
            'ticket_count' => $ticket ? 'Последнее обращение' : 'Нет обращений',
            'license_title' => $title ?: 'Лицензия пока не назначена',
            'license_status' => $key ? 'Активна' : 'Нет ключа',
            'domain' => $domain ? 'Домен · ' . $domain : 'Домен не привязан',
            'masked' => $key ? '••••  ••••  ••••  ' . substr($key, -4) : '—',
            'key' => $key,
            'download' => $download,
            'archive_title' => $download && $title ? $title : 'Архив пока недоступен',
            'archive_version' => $download ? 'ZIP-архив плагина' : 'Архив появится после выдачи доступа.',
            'ticket_title' => $ticket ? $ticket->post_title : 'У вас пока нет обращений',
            'ticket_number' => $ticket ? '№ ' . $ticket->ID : '',
            'ticket_status' => $ticket ? 'Принято' : '—',
            'ticket_message' => $ticket ? wp_trim_words($ticket->post_content, 32) : 'Создайте обращение, чтобы написать в поддержку.',
            'ticket_reply' => $ticket ? (get_post_meta($ticket->ID, 'psv3_reply', true) ?: 'Ответа пока нет.') : '—',
        ];
    }
    return $data[$field] ?? '';
}
function psv3_license_fields(): array {
    return ['title' => 'Название плагина', 'domain' => 'Домен', 'key' => 'Ключ активации', 'download' => 'URL архива'];
}
function psv3_license_form(WP_User $user): void {
    if (!current_user_can('manage_options')) {
        return;
    }
    echo '<h2>Лицензия Plugins-store</h2><table class="form-table">';
    foreach (psv3_license_fields() as $field => $label) {
        $name = 'psv3_license_' . $field;
        echo '<tr><th><label for="' . esc_attr($name) . '">' . esc_html($label) . '</label></th><td><input class="regular-text" id="' . esc_attr($name) . '" name="' . esc_attr($name) . '" value="' . esc_attr(get_user_meta($user->ID, $name, true)) . '"></td></tr>';
    }
    echo '</table>';
}
add_action('show_user_profile', 'psv3_license_form');
add_action('edit_user_profile', 'psv3_license_form');
function psv3_save_license(int $user_id): void {
    if (!current_user_can('manage_options') || !current_user_can('edit_user', $user_id)) {
        return;
    }
    foreach (psv3_license_fields() as $field => $label) {
        $name = 'psv3_license_' . $field;
        if (isset($_POST[$name])) {
            update_user_meta($user_id, $name, $field === 'download' ? esc_url_raw(psv3_post($name)) : sanitize_text_field(psv3_post($name)));
        }
    }
}
add_action('personal_options_update', 'psv3_save_license');
add_action('edit_user_profile_update', 'psv3_save_license');

add_action('admin_menu', static function () {
    add_theme_page('Страницы Plugins-store', 'Страницы Plugins-store', 'edit_theme_options', 'psv3-pages', static function () {
        echo '<div class="wrap"><h1>Страницы Plugins-store</h1><p>Создайте страницы с постоянными адресами. Существующие страницы с такими адресами будут сохранены.</p><form method="post" action="' . esc_url(admin_url('admin-post.php')) . '">';
        psv3_form_fields('create_pages');
        submit_button('Создать недостающие страницы');
        echo '</form></div>';
    });
});
add_action('admin_post_psv3_create_pages', static function () {
    if (!current_user_can('edit_theme_options')) {
        wp_die('Недостаточно прав.');
    }
    check_admin_referer('psv3_create_pages');
    foreach (psv3_pages() as $slug => $title) {
        if (!get_page_by_path($slug)) {
            wp_insert_post(['post_title' => $title, 'post_name' => $slug, 'post_type' => 'page', 'post_status' => 'publish']);
        }
    }
    wp_safe_redirect(admin_url('themes.php?page=psv3-pages'));
    exit;
});
