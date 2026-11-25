<div class="mobile-drawer-header">
    <a href="<?php echo esc_url(psv3_url('home')); ?>">
        <?php get_template_part('views/site-logo'); ?>
    </a>
    <button class="mobile-drawer-close" type="button" data-close aria-label="Закрыть меню" autofocus>
        <span aria-hidden="true">×</span>
    </button>
</div>
<nav class="mobile-nav-links" aria-label="Основная навигация">
    <?php
    $links = [
        'plugins' => 'Плагины',
        'services' => 'Услуги',
        'cases' => 'Мини-кейсы',
        'purchase-terms' => 'Документация',
        'blog' => 'Блог',
        'contacts' => 'Контакты',
    ];
    foreach ($links as $slug => $label) :
        $is_cases = $slug === 'cases';
        $url = $is_cases ? psv3_url('home') . '#n-240-134' : psv3_url($slug);
        ?>
        <a href="<?php echo esc_url($url); ?>"<?php if ($is_cases) : ?> data-nav-anchor<?php elseif (psv3_view() === $slug) : ?> aria-current="page"<?php endif; ?>>
            <?php echo esc_html($label); ?>
        </a>
    <?php endforeach; ?>
</nav>
<a class="mobile-nav-account" href="<?php echo esc_url(psv3_url('account')); ?>">Личный кабинет <span aria-hidden="true">↗</span></a>
