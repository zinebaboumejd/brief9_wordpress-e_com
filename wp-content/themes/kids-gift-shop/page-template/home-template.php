<?php
/**
 * Template Name: Home Template
 */

get_header(); ?>

<main id="skip-content">
  <section id="top-slider">
    <?php $kids_online_store_slide_pages = array();
      for ( $count = 1; $count <= 3; $count++ ) {
        $mod = intval( get_theme_mod( 'kids_online_store_top_slider_page' . $count ));
        if ( 'page-none-selected' != $mod ) {
          $kids_online_store_slide_pages[] = $mod;
        }
      }
      if( !empty($kids_online_store_slide_pages) ) :
        $args = array(
          'post_type' => 'page',
          'post__in' => $kids_online_store_slide_pages,
          'orderby' => 'post__in'
        );
        $query = new WP_Query( $args );
        if ( $query->have_posts() ) :
          $i = 1;
    ?>
    <div class="owl-carousel" role="listbox">
      <?php  while ( $query->have_posts() ) : $query->the_post(); ?>
        <div class="slider-box">
          <img src="<?php esc_url(the_post_thumbnail_url('full')); ?>"/>
          <div class="slider-inner-box">
            <h2><?php the_title(); ?></h2>
            <p class="mb-4"><?php $kids_online_store_excerpt = get_the_excerpt(); echo esc_html( kids_online_store_string_limit_words( $kids_online_store_excerpt, 40 ) ); ?></p>
            <div class="slide-btn"><a href="<?php the_permalink(); ?>"><?php esc_html_e('SHOP NOW','kids-gift-shop'); ?></a></div>
          </div>
        </div>
      <?php $i++; endwhile;
      wp_reset_postdata();?>          
    </div>
    <?php else : ?>
      <div class="no-postfound"></div>
    <?php endif;
    endif;?>
  </section>

  <section id="services-topic" class="py-5">
    <div class="container">
      <?php if(get_theme_mod('kids_gift_shop_services_category_title') != ''){ ?>
        <h3 class="mb-5 text-center "><?php echo esc_html(get_theme_mod('kids_gift_shop_services_category_title','')); ?></h3>
      <?php }?>
      <div class="row">
        <?php
          $kids_gift_shop_catData = get_theme_mod('kids_gift_shop_menu_items','');
          if($kids_gift_shop_catData){
            $kids_gift_shop_page_query = new WP_Query(array( 'category_name' => esc_html($kids_gift_shop_catData,'kids-gift-shop')));
            while( $kids_gift_shop_page_query->have_posts() ) : $kids_gift_shop_page_query->the_post(); ?>
              <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="box mb-4">
                  <?php the_post_thumbnail(); ?>
                  <div class="box-cont">
                    <h3 class="mt-2"><?php the_title(); ?></h3>
                    <p><?php $kids_gift_shop_excerpt = get_the_excerpt(); echo esc_html( kids_online_store_string_limit_words( $kids_gift_shop_excerpt, 10 )); ?></p>
                  </div>
                  <div class="box-content">
                    <h3 class="mt-2"><?php the_title(); ?></h3>
                    <p><?php $kids_gift_shop_excerpt = get_the_excerpt(); echo esc_html( kids_online_store_string_limit_words( $kids_gift_shop_excerpt, 10 )); ?></p>
                    <div class="slide-btn">
                      <a href="<?php the_permalink(); ?>"><?php esc_html_e('Read More','kids-gift-shop'); ?></a>
                    </div>
                  </div>
                </div>
              </div>
            <?php endwhile;
            wp_reset_postdata();
          } ?>
      </div>
    </div>
  </section>

  <section id="content-section" class="container">
    <?php
      if ( have_posts() ) : 
        while ( have_posts() ) : the_post(); 
            the_content();
        endwhile; 
      endif; 
    ?>
  </section>
</main>

<?php get_footer(); ?>