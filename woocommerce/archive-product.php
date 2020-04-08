<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );
if(get_theme_mod('eightstore_shop_slider')=="1"){
	do_action('eightstore_lite_homepage_slider');
}
/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action( 'woocommerce_before_main_content' );
if ( ! is_active_sidebar( 'shop' ) ) {
	$is_sidebar = "shop-sidebar";
}else{
	$is_sidebar = "";
}
?>
<main id="main" class="site-main clearfix sidebar-left" role="main">
	
<div id="primary" class="content-area">
	<?php
	if ( woocommerce_product_loop() ) {

if ($_SERVER['REQUEST_URI'] == '/') : 
			$parentid = get_queried_object_id();
         
			$args = array(
				'parent' => $parentid
			);
			 
			$terms = get_terms( 'product_cat', $args );
			 
			if ( $terms ) {
					 
				echo '<ul class="products columns-3">';
				 
					foreach ( $terms as $term ) {
									 
						echo '<li class="product-category product">';                 
								echo '<div class="collection_combine item-img">';
									echo '<a href="' .  esc_url( get_term_link( $term ) ) . '" class="' . $term->slug . '">'; 
									woocommerce_subcategory_thumbnail( $term );
								echo '</div>';
								echo '<div class="collection_desc clearfix">';
									echo '<div class="title-cart">';
										echo '<a href="' .  esc_url( get_term_link( $term ) ) . '" class="' . $term->slug . '">';
											echo $term->name;
										echo '</a>';
										echo '<div class="cart">';
											echo '<a href="' .  esc_url( get_term_link( $term ) ) . '" class="' . $term->slug . '">';
											echo '(' . $term->count . ')';
										echo '</a>';
										echo '</div>';
									echo '</div>';
									echo '<div class="price-desc">';
										echo '<span class="price">';
											echo esc_html( $term->description );
										echo '</span>';
									echo '</div>';
							echo '</div>';
						echo '</li>';
																				 
			 
				}
				 
				echo '</ul>';
			 
			}
			endif;

	/**
	 * Hook: woocommerce_before_shop_loop.
	 *
	 * @hooked wc_print_notices - 10
	 * @hooked woocommerce_result_count - 20
	 * @hooked woocommerce_catalog_ordering - 30
	 */
	do_action( 'woocommerce_before_shop_loop' );

	woocommerce_product_loop_start();

	if ( wc_get_loop_prop( 'total' ) ) {
		while ( have_posts() ) {
			the_post();

			/**
			 * Hook: woocommerce_shop_loop.
			 *
			 * @hooked WC_Structured_Data::generate_product_data() - 10
			 */
			do_action( 'woocommerce_shop_loop' );

			wc_get_template_part( 'content', 'product' );
		}
	}

	woocommerce_product_loop_end();

	/**
	 * Hook: woocommerce_after_shop_loop.
	 *
	 * @hooked woocommerce_pagination - 10
	 */
	do_action( 'woocommerce_after_shop_loop' );
} else {
	/**
	 * Hook: woocommerce_no_products_found.
	 *
	 * @hooked wc_no_products_found - 10
	 */
	do_action( 'woocommerce_no_products_found' );
}
?>
</div>
<?php

/**
 * Hook: woocommerce_sidebar.
 *
 * @hooked woocommerce_get_sidebar - 10
 */
do_action( 'woocommerce_sidebar' );
?>
</main>
<?php
/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action( 'woocommerce_after_main_content' );

//promotional section 2 if enabled for inner pages
if(get_theme_mod('eightstore_shop_cta')=="1"){
		//promotional section 2
	if(is_active_sidebar('widget-promo-2')){
		?>
		<section id="section-promo2" class='clear'>
			<div class="large-cta-block">
				<?php dynamic_sidebar('widget-promo-2'); ?>
			</div>
		</section>
		<?php
	}
}

get_footer( 'shop' );
