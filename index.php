<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * 
 * Template Name: Главная страница
 * 
 * 
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package test
 */



get_header();
?>

    <main class="main">
		<div class="content">
    <h1>Статьи</h1>
    <?php
    $paged = get_query_var('paged') ? get_query_var('paged') : (get_query_var('page') ? get_query_var('page') : 1);
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => 10,
        'paged' => $paged,
    );
    
    $query = new WP_Query($args);
        if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();
          $post_id = get_the_ID();
        ?>
        <div class="content__item" data-post-id="<?php echo $post_id; ?>">
          <a href="<?php the_permalink(); ?>"><img src="<?php echo get_the_post_thumbnail_url(get_the_ID(),'full'); ?>" alt="<?php the_title(); ?>"></a>
          <div class="content__data">
            <a href="<?php the_permalink(); ?>"><h2><?php the_title(); ?></h2></a>
            <p><?php the_excerpt(); ?></p>
            <div class="extra">
              <p>Автор: <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><?php the_author(); ?></a></p>
              <div class="likes">
                <button aria-label="поставить лайк" class="plus"></button>
                <b class="total good"><?php echo get_likes_count($post_id); ?></b>
                <button aria-label="поставить дизлайк" class="minus"></button>
              </div>
            </div>
          </div>
        </div>
        <?php endwhile; wp_reset_postdata(); endif; 


    $pagination_args = array(
        'base' => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
        'format' => 'page/%#%/', 
        'current' => $paged,
        'total' => $query->max_num_pages,
        'mid_size' => 1,
        'end_size' => 1,
        'prev_next' => true,
        'prev_text' => __('Назад'),
        'next_text' => __('Вперед'),
        'type' => 'array', 
    );
    
    $pages_links = paginate_links($pagination_args);
    
    if (is_array($pages_links)) {
        echo '<div class="content__pagination">';
        foreach ($pages_links as $page_link) {
            $href = '';
            if (preg_match('/href="([^"]*)"/', $page_link, $matches)) {
                $href = $matches[1];
            }
    
						if (strpos($page_link, 'prev') !== false) {
							echo "<a href='{$href}' class='first'><span>{$pagination_args['prev_text']}</span>
							<svg width='16.000000' height='16.000000' viewBox='0 0 16 16' fill='none' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'>
									<defs>
											<clipPath id='clip4_1115'>
													<rect id='arrow11 2' width='16.000000' height='16.000000' transform='matrix(4.37114e-08 -1 -1 -4.37114e-08 16 16)' fill='white' fill-opacity='0'/>
											</clipPath>
									</defs>
									<rect id='arrow11 2' width='16.000000' height='16.000000' transform='matrix(4.37114e-08 -1 -1 -4.37114e-08 16 16)' fill='#FFFFFF' fill-opacity='0'/>
									<g clip-path='url(#clip4_1115)'>
											<path id='Vector' d='M12.6809 1.66602L6.59839 8.01929L12.6422 14.4119L11.0537 16L3.30591 8.05811L11.0156 0L12.6809 1.66602Z' fill='#000000' fill-opacity='1.000000' fill-rule='evenodd'/>
									</g>
							</svg>
							</a>";
					} elseif (strpos($page_link, 'next') !== false) {
							echo "<a href='{$href}' class='last'><span>{$pagination_args['next_text']}</span>
							<svg width='16.000000' height='16.000000' viewBox='0 0 16 16' fill='none' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'>
									<defs>
											<clipPath id='clip4_1113'>
													<rect id='arrow11 1' width='16.000000' height='16.000000' transform='translate(0.000000 16.000000) rotate(-90.000000)' fill='white' fill-opacity='0'/>
											</clipPath>
									</defs>
									<rect id='arrow11 1' width='16.000000' height='16.000000' transform='translate(0.000000 16.000000) rotate(-90.000000)' fill='#FFFFFF' fill-opacity='0'/>
									<g clip-path='url(#clip4_1113)'>
											<path id='Vector' d='M3.31909 1.66602L9.40161 8.01929L3.35779 14.4119L4.94629 16L12.6941 8.05811L4.98438 0L3.31909 1.66602Z' fill='#000000' fill-opacity='1.000000' fill-rule='evenodd'/>
									</g>
							</svg>
							</a>";
					}
					else {
                $class = strpos($page_link, 'current') !== false ? 'regular active' : 'regular';
                echo "<a href='{$href}' class='{$class}'>" . strip_tags($page_link) . "</a>";
            }
        }
        echo '</div>';
    }
    ?>
</div>

      <div class="sidebar">Sidebar</div>
    </main>

<?php
get_footer();
