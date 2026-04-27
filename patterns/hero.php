<?php
/**
 * Title: Hero
 * Slug: mtctire/hero
 * Categories: featured
 */
?>
<!-- wp:cover {"url":"<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/hero-bg.jpg","dimRatio":65,"minHeight":480,"minHeightUnit":"px","contentPosition":"center left","style":{"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"}}},"layout":{"type":"default"}} -->
<div class="wp-block-cover" style="background-image:url('<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/hero-bg.jpg');min-height:480px;position:relative;overflow:hidden">
  <span aria-hidden="true" class="wp-block-cover__background has-background-dim" style="opacity:0.45;background-color:#000"></span>
  <div class="mtc-hero-fade"></div>
  <div class="wp-block-cover__inner-container">
    <!-- wp:group {"style":{"spacing":{"padding":{"top":"80px","bottom":"80px","left":"48px","right":"48px"}}},"layout":{"type":"constrained","justifyContent":"left"}} -->
    <div class="wp-block-group" style="padding-top:80px;padding-right:48px;padding-bottom:80px;padding-left:48px">
      <!-- wp:paragraph {"className":"section-eyebrow","style":{"spacing":{"margin":{"bottom":"16px"}}}} -->
      <p class="section-eyebrow">Oakville's Tire Experts &nbsp;·&nbsp; Est. 2005</p>
      <!-- /wp:paragraph -->
      <!-- wp:heading {"level":1,"style":{"typography":{"fontSize":"4rem"},"color":{"text":"#ffffff"},"spacing":{"margin":{"bottom":"20px"}}}} -->
      <h1 style="font-size:4rem;color:#ffffff">Tires Done Right.</h1>
      <!-- /wp:heading -->
      <!-- wp:paragraph {"style":{"color":{"text":"#aaaaaa"},"typography":{"fontSize":"0.875rem"},"spacing":{"margin":{"bottom":"32px"}}}} -->
      <p style="color:#aaaaaa;font-size:0.875rem">Expert tire sales, fitting, seasonal storage, wheel alignment, brakes and full automotive service. Serving Oakville since 2005.</p>
      <!-- /wp:paragraph -->
      <!-- wp:buttons -->
      <div class="wp-block-buttons">
        <!-- wp:button {"backgroundColor":"accent","textColor":"text-primary","style":{"border":{"radius":"0"},"typography":{"fontSize":"0.7rem","fontWeight":"700","textTransform":"uppercase","letterSpacing":"1.5px"}}} -->
        <div class="wp-block-button"><a class="wp-block-button__link has-accent-background-color has-text-primary-color has-text-color has-background wp-element-button" href="/contact/">Get a Quote →</a></div>
        <!-- /wp:button -->
      </div>
      <!-- /wp:buttons -->
    </div>
    <!-- /wp:group -->
  </div>
</div>
<style>
.mtc-hero-fade {
  position: absolute;
  top: 0; left: 0; right: 0; bottom: 0;
  background: linear-gradient(to right, rgba(17,17,17,0.85) 0%, rgba(17,17,17,0.4) 50%, transparent 100%);
  pointer-events: none;
  z-index: 1;
}
.wp-block-cover__inner-container { position: relative; z-index: 2; }
</style>
<!-- /wp:cover -->
