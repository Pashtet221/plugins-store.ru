<header class="site-header">
    <a class="site-brand" href="<?php echo esc_url(psv3_url('home')); ?>">
        <?php get_template_part('views/site-logo'); ?>
    </a>
    <nav class="site-header-nav" aria-label="Основная навигация">
        <button class="site-header-plugins" type="button" data-open="mega" aria-haspopup="dialog" aria-controls="overlay-mega">
            Плагины
            <svg viewBox="0 0 16 16" width="16" height="16" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                <path d="m4 6 4 4 4-4"/>
            </svg>
        </button>
        <a href="<?php echo esc_url(psv3_url('services')); ?>">Услуги</a>
        <a href="<?php echo esc_url(psv3_url('home') . '#n-240-134'); ?>">Мини-кейсы</a>
        <a href="<?php echo esc_url(psv3_url('purchase-terms')); ?>">Документация</a>
        <a href="<?php echo esc_url(psv3_url('blog')); ?>">Блог</a>
        <a href="<?php echo esc_url(psv3_url('contacts')); ?>">Контакты</a>
    </nav>
    <button class="site-header-account" type="button" data-open="profile-menu" aria-haspopup="dialog" aria-controls="overlay-profile-menu">
        <?php echo is_user_logged_in() ? 'Мой профиль' : 'Вход в ЛК'; ?>
    </button>
    <?php get_template_part('views/mobile-nav-toggle'); ?>
</header>
