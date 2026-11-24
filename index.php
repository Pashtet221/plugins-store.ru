<?php
defined('ABSPATH') || exit;
$view = psv3_view();
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<main id="content">
<?php psv3_notice(); ?>
<?php if ($view === 'account' && !is_user_logged_in()) : ?>
    <div class="editor-content"><h1>Личный кабинет</h1><p>Войдите, чтобы открыть кабинет.</p><button type="button" class="plain-action" data-open="login">Войти</button></div>
<?php elseif ($view) : ?>
    <div class="scene-host"><?php require get_theme_file_path('/views/' . $view . '.php'); ?></div>
    <?php if (is_page() && trim((string) get_post_field('post_content', get_queried_object_id()))) : ?>
        <section class="editor-content"><?php while (have_posts()) { the_post(); the_content(); } ?></section>
    <?php endif; ?>
<?php else : ?>
    <div class="editor-content">
        <nav><a href="<?php echo esc_url(home_url('/')); ?>">Plugins-store</a> · <a href="<?php echo esc_url(psv3_url('plugins')); ?>">Каталог</a> · <a href="<?php echo esc_url(psv3_url('blog')); ?>">Блог</a></nav>
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <article><h1><?php if (is_singular()) { the_title(); } else { ?><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a><?php } ?></h1>
            <?php if (is_singular()) { the_content(); } else { the_excerpt(); } ?></article>
        <?php endwhile; the_posts_pagination(); else : ?>
            <h1>Страница не найдена</h1>
        <?php endif; ?>
    </div>
<?php endif; ?>
</main>
<?php foreach (['mega', 'profile-menu', 'login', 'reset', 'ticket'] as $overlay) : ?>
    <dialog id="overlay-<?php echo esc_attr($overlay); ?>" class="ps-dialog <?php echo esc_attr('ps-dialog-' . $overlay); ?>"><?php require get_theme_file_path('/views/' . $overlay . '.php'); ?></dialog>
<?php endforeach; ?>
<?php wp_footer(); ?>
</body>
</html>
