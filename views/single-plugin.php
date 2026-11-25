<div class="scene-host post-scene-host">
    <div class="scene post-scene plugin-scene">
        <?php get_template_part('views/plugin-header'); ?>
        <article <?php post_class('post-layout plugin-layout'); ?>>
            <nav class="plugin-breadcrumbs" aria-label="Хлебные крошки">
                <a href="<?php echo esc_url(psv3_url('home')); ?>">Главная</a>
                <a href="<?php echo esc_url(psv3_url('plugins')); ?>">Плагины</a>
                <span aria-current="page"><?php the_title(); ?></span>
            </nav>
            <?php $protected = post_password_required(); ?>
            <header class="plugin-hero<?php if (has_post_thumbnail()) : ?> plugin-hero-with-cover<?php endif; ?>">
                <div class="plugin-intro">
                    <h1><?php the_title(); ?></h1>
                    <?php if (!$protected && has_excerpt()) : ?>
                        <div class="plugin-summary"><?php the_excerpt(); ?></div>
                    <?php endif; ?>
                    <?php if (!$protected) : ?>
                        <div class="plugin-actions">
                            <a class="plugin-action-primary" href="#n-251-157">Оставить заявку ↓</a>
                            <a class="plugin-action-secondary" href="#plugin-details">Возможности ↓</a>
                        </div>
                    <?php endif; ?>
                </div>
                <?php if (has_post_thumbnail()) : ?>
                    <div class="plugin-cover"><?php the_post_thumbnail('large'); ?></div>
                <?php endif; ?>
            </header>
            <section id="plugin-details" class="plugin-details post-body" aria-label="Описание плагина">
                <?php the_content(); ?>
                <?php wp_link_pages(['before' => '<nav class="post-pagination" aria-label="Страницы описания">Страницы: ', 'after' => '</nav>']); ?>
            </section>
            <?php if (!$protected) : ?>
                <section id="n-251-157" class="plugin-request" aria-labelledby="plugin-request-title">
                    <div>
                        <h2 id="plugin-request-title">Запросить плагин</h2>
                        <p>Пришлите ссылку на магазин. Уточним совместимость, стоимость и способ подключения.</p>
                        <a class="plain-action" href="<?php echo esc_url(psv3_telegram()); ?>">Написать в Telegram ↗</a>
                    </div>
                    <?php get_template_part('views/plugin-request-form', null, ['plugin_id' => get_the_ID()]); ?>
                </section>
            <?php endif; ?>
        </article>
        <?php get_template_part('views/plugin-footer'); ?>
    </div>
</div>
