<?php if ( get_theme_mod('ecommerce_mega_store_our_collection_section_enable') ) : ?>
	<div id="our-collection" class="py-5">
		<div class="container text-center">
			<h4><?php echo esc_html(get_theme_mod('ecommerce_mega_store_our_collection_sub_heading'));?></h4>
          	<h2 class=""><?php echo esc_html(get_theme_mod('ecommerce_mega_store_our_collection_heading'));?></h2>
          	<hr class="hr1">
          	<div class=" tab menu-cat">
				<div class="tab-section">
					<ul class="px-5 ">
				        <?php 
				          $collection_post = get_theme_mod('ecommerce_mega_store_our_collection_tab_number', '');
				          for ( $i = 1; $i <= $collection_post; $i++ ){ ?>
						 	<li class="product-tab align-self-center">
					            <button class="tablinks" onclick="ecommerce_mega_store_openCity(event, '<?php $main_id = get_theme_mod('ecommerce_mega_store_our_collection_tabs_text'.$i); $tab_id = str_replace(' ', '-', $main_id); echo $tab_id; ?> ')">
					              <?php echo esc_html(get_theme_mod('ecommerce_mega_store_our_collection_tabs_text'.$i)); ?>
					            </button>
					        </li>
				        <?php }?>
				    </ul>
		        </div>
			    <hr class="hr2">
			</div>

 		    <?php for ( $i = 1; $i <= $collection_post; $i++ ){ ?>
		        <div id="<?php $main_id = get_theme_mod('ecommerce_mega_store_our_collection_tabs_text'.$i); $tab_id = str_replace(' ', '-', $main_id); echo $tab_id; ?>"  class="tabcontent text-center mt-3">
			        <div class="owl-carousel">
			            <?php
			            $ecommerce_mega_store_catData = get_theme_mod('ecommerce_mega_store_our_collection_category'.$i);
			            if ( class_exists( 'WooCommerce' ) ) {
			              $args = array( 
			                'post_type' => 'product',
			                'posts_per_page' => 8,
			                'product_cat' => $ecommerce_mega_store_catData,
			                'order' => 'ASC'
			              );
			              $loop = new WP_Query( $args );
			              while ( $loop->have_posts() ) : $loop->the_post(); global $product; ?>
			                <div class="tab-product">
			                    <div class="product-image my-lg-4 my-md-2 my-3 mx-1 box">
			                    	<figure>
			                        	<?php if (has_post_thumbnail( $loop->post->ID )) echo get_the_post_thumbnail($loop->post->ID, 'shop_catalog'); else echo '<img src="'.esc_url(woocommerce_placeholder_img_src()).'" />'; ?>
			                        	<?php if (   has_post_thumbnail() ) { ?>      
				                            <?php woocommerce_show_product_sale_flash( $post, $product ); ?>
				                        <?php }?>
			                        </figure>
			                        <div class="box-content intro-button ">
					                    <?php if( $product->is_type( 'simple' ) ) { woocommerce_template_loop_add_to_cart(  $loop->post, $product );} ?>
					                </div>
			                    </div>
			                    <div class="product-details text-center ">
				                  	<h5 class="product-text my-2 "><a href="<?php echo esc_url(get_permalink( $loop->post->ID )); ?>"><?php the_title(); ?></a></h5>
				                  	<p class=" ">
	                                    <?php $content = get_the_content();
	                                    $trimmed_content = wp_trim_words( $content, 3, NULL );
	                                    echo $trimmed_content; ?>
                                    </p>
                                    <h6 class="<?php echo esc_attr( apply_filters( 'woocommerce_product_price_class', 'price' ) ); ?>"><?php echo $product->get_price_html(); ?></h6>
				                  	<?php if( $product->is_type( 'simple' ) ){ woocommerce_template_loop_rating( $loop->post, $product ); } ?>
				                </div>
			                </div>
			              <?php endwhile; wp_reset_query(); ?>
			            <?php } ?>
			        </div>
		        </div>
			<?php }?>
		</div>
	</div>
<?php endif; ?>