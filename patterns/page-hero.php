<?php
/**
 * Title: Page Hero
 * Slug: mtctire/page-hero
 * Categories: featured
 */
?>
<!-- wp:cover {"url":"<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/hero-bg.jpg","dimRatio":70,"minHeight":180,"minHeightUnit":"px","contentPosition":"center left","style":{"spacing":{"padding":{"top":"0","bottom":"0"}}}} -->
<div class="wp-block-cover" style="background-image:url('<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/hero-bg.jpg');min-height:180px">
  <span aria-hidden="true" class="wp-block-cover__background has-background-dim" style="opacity:0.7;background-color:#000"></span>
  <div class="wp-block-cover__inner-container">
    <!-- wp:group {"style":{"spacing":{"padding":{"top":"36px","bottom":"36px","left":"40px","right":"40px"}}},"layout":{"type":"default"}} -->
    <div class="wp-block-group">
      <!-- wp:html -->
      <?php
      $crumbs = '<a href="' . home_url( '/' ) . '" style="color:#555555;text-decoration:none">Home</a>';
      $ancestors = array_reverse( get_ancestors( get_the_ID(), 'page' ) );
      foreach ( $ancestors as $ancestor_id ) {
          $crumbs .= ' <span style="color:#333333">›</span> <a href="' . esc_url( get_permalink( $ancestor_id ) ) . '" style="color:#555555;text-decoration:none">' . esc_html( get_the_title( $ancestor_id ) ) . '</a>';
      }
      echo '<p style="color:#555555;font-size:0.62rem;text-transform:uppercase;letter-spacing:1.5px;margin-bottom:10px">' . $crumbs . '</p>';
      ?>
      <!-- /wp:html -->
      <!-- wp:post-title {"level":1,"style":{"typography":{"fontSize":"2.4rem"}}} /-->
    </div>
    <!-- /wp:group -->
  </div>
</div>
<!-- /wp:cover -->
