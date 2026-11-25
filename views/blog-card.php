<?php
defined('ABSPATH') || exit;

$featured = !empty($args['featured']);
$heading = $featured ? 'h2' : 'h3';
$title = get_the_title();
$title = trim($title) !== '' ? $title : 'Без заголовка';
$url = get_permalink();
$summary = trim(wp_strip_all_tags(get_the_excerpt(), true));
$categories = get_the_category();
$category = $categories[0] ?? null;
?>
<article class="blog-card<?php if ($featured) : ?> blog-card-featured<?php endif; ?>">
    <?php if (has_post_thumbnail()) : ?>
        <a class="blog-card-cover" href="<?php echo esc_url($url); ?>" aria-label="<?php echo esc_attr($title); ?>">
            <?php the_post_thumbnail($featured ? 'large' : 'medium_large'); ?>
        </a>
    <?php endif; ?>
    <div class="blog-card-copy">
        <?php if ($category && (int) $category->term_id !== (int) get_option('default_category')) : ?>
            <p class="blog-card-category"><?php echo esc_html($category->name); ?></p>
        <?php endif; ?>
        <<?php echo $heading; ?> class="blog-card-title"><a href="<?php echo esc_url($url); ?>"><?php echo esc_html($title); ?></a></<?php echo $heading; ?>>
        <?php if ($summary !== '') : ?>
            <p class="blog-card-summary"><?php echo esc_html($summary); ?></p>
        <?php endif; ?>
        <a class="blog-card-link" href="<?php echo esc_url($url); ?>" aria-label="<?php echo esc_attr('Читать: ' . $title); ?>">Читать статью ↗</a>
    </div>
</article>
