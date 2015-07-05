<?php get_header(); ?>
<div class="content">
	<div class="article">
  <?php the_field('mydata'); ?>
    
		<?php while ( have_posts() ) : the_post(); ?>
			<article class="article-content">
				<h1 class="article-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
				<div class="article-meta">
					<span><?php the_time('n / j, Y'); ?></span><span> / </span>
					<span><?php the_category(' , '); ?></span><span> / </span>
					<span><?php the_tags('', ' , ', ''); ?></span>
				</div>
				<?php the_content(); ?>
				<div class="clearfix"></div>
			</article>
		<?php endwhile; ?>
		<?php wp_pagenavi(); ?>
	</div>
    
	<div class="sidebar">
	<?php get_sidebar(); ?>
	</div>
</div>


<?php get_footer(); ?>