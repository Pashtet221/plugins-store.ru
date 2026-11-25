<div class="scene-host post-scene-host">
    <div class="scene post-scene">
        <?php get_template_part('views/article-header'); ?>
        <article <?php post_class('post-layout'); ?>>
            <header class="post-hero<?php if (has_post_thumbnail()) : ?> post-hero-with-image<?php endif; ?>">
                <div class="post-intro">
                    <a class="post-back-link" href="<?php echo esc_url(psv3_url('blog')); ?>">← Все статьи</a>
                    <h1><?php the_title(); ?></h1>
                    <?php if (!post_password_required() && has_excerpt()) : ?>
                        <div class="post-summary"><?php the_excerpt(); ?></div>
                    <?php endif; ?>
                </div>
                <?php if (has_post_thumbnail()) : ?>
                    <div class="post-cover"><?php the_post_thumbnail('large'); ?></div>
                <?php endif; ?>
            </header>
            <div class="post-reading">
                <nav class="post-toc" aria-label="В этой статье" hidden>
                    <h2>В этой статье</h2>
                    <ul></ul>
                </nav>
                <div class="post-body">
                    <?php
                    the_content();
                    wp_link_pages([
                        'before' => '<nav class="post-pagination" aria-label="Страницы статьи">Страницы: ',
                        'after' => '</nav>',
                    ]);
                    ?>
                </div>
            </div>
        </article>
        <?php get_template_part('views/article-footer'); ?>
    </div>
</div>
