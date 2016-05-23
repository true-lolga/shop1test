<?php
/**
 * 
 * The template for displaying 404 pages (not found).
 *
 * @package azera-shop
 */

	get_header(); 
?>

	</div>
	<!-- /END COLOR OVER IMAGE -->
</header>
<!-- /END HOME / HEADER  -->

<div class="content-wrap">
	<div class="container">

		<div id="primary" class="content-area col-md-8">
			<main id="main" class="site-main" role="main">

				<section class="error-404 not-found">
					<header class="page-header">
						<h1 class="page-title">УПС! СТРАНИЦА НЕ НАЙДЕНА.</h1>
					</header><!-- .page-header -->

					<div class="page-content">
						<p>Похоже, что ничего не найдено по данному пути. Попробуйте воспользоваться поиском!</p>
						<img class="404" src="http://www.catgifpage.com/gifs/239.gif">

						<?php get_product_search_form(); ?>

					</div><!-- .page-content -->
				</section><!-- .error-404 -->

			</main><!-- #main -->
		</div><!-- #primary -->

	</div>
</div><!-- .content-wrap -->

<?php get_footer(); ?>
