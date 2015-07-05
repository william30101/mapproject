<?php get_header(); ?>
<div class="content">
	<div class="article">
		<?php if ( have_posts() ) : ?>
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
		<?php else : ?>
			<article class="article-content">
				<h1>搜尋結果</h1>
				<p>很抱歉，找不到你所搜尋的文章，你可以試著用其他關鍵字再次搜尋。</p>
				<?php get_search_form(); ?>
			</article>
		<?php endif; ?>
		<?php wp_pagenavi(); ?>
	</div>
	<div class="sidebar">
	<?php get_sidebar(); ?>
	</div>
</div>
<?php get_footer(); ?>