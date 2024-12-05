<?php
/**
 * SINGLE
 */
get_header();
$pst_related = get_news_related(get_the_ID(), 'category', 5); 
?>

<div class="gv_post_single clearfix">
	<div class="container">
		<div class="head_single clearfix">
			<h1 class="title"><?php the_title(); ?></h1>
		</div>
		<div class="meta">
			<span>Publish: <?php echo get_the_date('j F, Y'); ?></span>
		</div>
		<?php while(have_posts()) : the_post(); ?>
		<div class="entry-content">
			<?php the_content(); ?>
		</div>
		<?php endwhile; ?>
		<hr>
		<?php if($pst_related->have_posts()) : ?>
		<div class="head_blog clearfix">
			<h3 class="title">Bài viết liên quan</h3>
		</div>

		<div class="related">
			<?php while($pst_related->have_posts()) : $pst_related->the_post();
			$pst_thumb = get_the_post_thumbnail_url(get_the_ID(), 'medium'); ?>
			<div class="related-item">
				<div class="thumb">
					<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
						<img src="<?php echo $pst_thumb; ?>" alt="<?php the_title(); ?>"/>
					</a>
				</div>
				<div class="info">
					<h4>
						<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
							<?php the_title(); ?>
						</a>
					</h4>
					<div class="date">
						Publish: <?php echo get_the_date('F j, Y'); ?>
					</div>
				</div>
			</div>
			<?php endwhile; ?>
		</div>
		<?php endif; wp_reset_query(); ?>
	</div>
</div>

<?php get_footer(); ?>