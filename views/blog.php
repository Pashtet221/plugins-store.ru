<?php
defined('ABSPATH') || exit;

$blog_page = isset($_GET['blog_page']) && is_string($_GET['blog_page'])
    ? max(1, absint(wp_unslash($_GET['blog_page'])))
    : 1;
$articles = new WP_Query([
    'post_type' => 'post',
    'post_status' => 'publish',
    'posts_per_page' => 7,
    'paged' => $blog_page,
    'ignore_sticky_posts' => true,
]);
?>
<div class="scene post-scene blog-scene">
<header id="n-275-88" class="layer n-275-88 section site-header" ><a id="n-275-89" class="layer n-275-89 text site-brand" href="<?php echo esc_url(psv3_url('home')); ?>"><?php get_template_part('views/site-logo'); ?></a>
<button id="n-275-90" class="layer n-275-90 text" data-open="mega" type="button">Плагины</button>
<a id="n-275-91" class="layer n-275-91 text" href="<?php echo esc_url(psv3_url('services')); ?>">Услуги</a>
<a id="n-275-92" class="layer n-275-92 text" href="<?php echo esc_url(psv3_url('home')); ?>#n-240-134">Мини-кейсы</a>
<a id="n-275-93" class="layer n-275-93 text" href="<?php echo esc_url(psv3_url('purchase-terms')); ?>">Документация</a>
<button id="n-275-94" class="layer n-275-94" data-open="profile-menu" type="button"><span id="n-275-95" class="layer n-275-95 text" >Вход в ЛК</span>
</button>
<div id="n-275-96" class="layer n-275-96" ><div id="n-275-97" class="layer n-275-97 image-layer" ><img src="<?php echo esc_url(get_theme_file_uri('/assets/media/275_97.png')); ?>" alt="" style="object-fit:fill"></div>
</div>
<a id="n-275-270" class="layer n-275-270 text" href="<?php echo esc_url(psv3_url('blog')); ?>">Блог</a>
<a id="n-277-178" class="layer n-277-178 text" href="<?php echo esc_url(psv3_url('contacts')); ?>">Контакты</a>
<?php get_template_part('views/mobile-nav-toggle'); ?>
</header>
<div class="post-layout blog-layout">
    <section class="blog-hero" aria-labelledby="blog-title">
        <h1 id="blog-title">Блог Plugins-store</h1>
        <p>Практические статьи о WooCommerce, плагинах и интеграциях.</p>
        <?php if ($blog_page === 1 && $articles->have_posts()) : ?>
            <?php
            $articles->the_post();
            get_template_part('views/blog-card', null, ['featured' => true]);
            ?>
        <?php endif; ?>
    </section>
    <section class="blog-list" aria-labelledby="blog-list-title">
        <h2 id="blog-list-title">Все статьи</h2>
        <?php if ($articles->have_posts()) : ?>
            <div class="blog-grid">
                <?php while ($articles->have_posts()) : $articles->the_post(); ?>
                    <?php get_template_part('views/blog-card'); ?>
                <?php endwhile; ?>
            </div>
        <?php elseif (!$articles->post_count) : ?>
            <p><?php echo $blog_page > 1 ? 'На этой странице нет записей.' : 'Пока нет опубликованных статей.'; ?></p>
        <?php endif; ?>
        <?php
        wp_reset_postdata();
        $page_marker = 999999999;
        $pagination = paginate_links([
            'base' => str_replace((string) $page_marker, '%#%', add_query_arg('blog_page', $page_marker, psv3_url('blog'))),
            'format' => '',
            'total' => $articles->max_num_pages,
            'current' => $blog_page,
            'prev_text' => '← Назад',
            'next_text' => 'Далее →',
            'type' => 'list',
        ]);
        if ($pagination) :
            ?>
            <nav class="blog-pagination" aria-label="Страницы блога"><?php echo wp_kses_post($pagination); ?></nav>
        <?php endif; ?>
    </section>
    <section class="blog-catalog">
        <h2>Готовые решения для магазина</h2>
        <a href="<?php echo esc_url(psv3_url('plugins')); ?>">Перейти в каталог ↗</a>
    </section>
</div>
<footer id="n-275-146" class="layer n-275-146 section site-footer" ><div id="n-275-147" class="layer n-275-147" ><div id="n-275-148" class="layer n-275-148" ><a id="n-275-149" class="layer n-275-149 text" href="<?php echo esc_url(psv3_url('home')); ?>">plugins.store</a>
<span id="n-275-150" class="layer n-275-150 text" >Плагины и разработка
для интернет-магазинов</span>
</div>
<div id="n-275-151" class="layer n-275-151" ><a id="n-275-152" class="layer n-275-152 text" href="<?php echo esc_url(psv3_url('plugins')); ?>">Плагины</a>
<a id="n-275-153" class="layer n-275-153 text" href="<?php echo esc_url(psv3_url('plugins')); ?>">WooCommerce</a>
<a id="n-275-154" class="layer n-275-154 text" href="<?php echo esc_url(psv3_url('plugins')); ?>">WordPress</a>
<a id="n-275-155" class="layer n-275-155 text" href="<?php echo esc_url(psv3_url('plugins')); ?>">1С-Битрикс</a>
</div>
<div id="n-275-156" class="layer n-275-156" ><a id="n-275-157" class="layer n-275-157 text" href="<?php echo esc_url(psv3_url('services')); ?>">Услуги</a>
<span id="n-275-158" class="layer n-275-158 text" >Разработка плагинов</span>
<span id="n-275-159" class="layer n-275-159 text" >Доработка магазинов</span>
<span id="n-275-160" class="layer n-275-160 text" >Техническая поддержка</span>
</div>
<div id="n-275-161" class="layer n-275-161" ><span id="n-275-162" class="layer n-275-162 text" >Помощь</span>
<a id="n-275-163" class="layer n-275-163 text" href="<?php echo esc_url(psv3_url('purchase-terms')); ?>">Документация</a>
<a id="n-275-164" class="layer n-275-164 text" href="<?php echo esc_url(psv3_url('account')); ?>">Личный кабинет</a>
<a id="n-275-165" class="layer n-275-165 text" href="<?php echo esc_url(psv3_telegram()); ?>">Telegram</a>
</div>
</div>
<div id="n-275-166" class="layer n-275-166 ornament" ></div>
<div id="n-275-167" class="layer n-275-167" ><span id="n-275-168" class="layer n-275-168 text" >© Plugins-store</span>
<div id="n-275-169" class="layer n-275-169" ><a id="n-275-170" class="layer n-275-170 text" href="<?php echo esc_url(psv3_url('privacy')); ?>">Политика конфиденциальности</a>
<a id="n-275-171" class="layer n-275-171 text" href="<?php echo esc_url(psv3_url('offer')); ?>">Публичная оферта</a>
<a id="n-275-172" class="layer n-275-172 text" href="<?php echo esc_url(psv3_url('purchase-terms')); ?>">Гарантии и возврат</a>
</div>
</div>
</footer>
</div>
