<?php
/**
 * Title: About Strip
 * Slug: mtctire/about-strip
 * Categories: featured
 */
?>
<!-- wp:columns {"style":{"spacing":{"blockGap":{"left":"0"}}},"layout":{"type":"default"}} -->
<div class="wp-block-columns">
  <!-- wp:column {"width":"50%"} -->
  <div class="wp-block-column">
    <!-- wp:cover {"url":"<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/shop.jpg","dimRatio":20,"minHeight":360,"minHeightUnit":"px","contentPosition":"center center"} -->
    <div class="wp-block-cover mtc-about-photo" style="background-image:url('<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/shop.jpg');min-height:360px;position:relative;overflow:hidden;background-size:cover;background-position:center">
      <span aria-hidden="true" class="wp-block-cover__background has-background-dim" style="opacity:0.2"></span>
      <div class="wp-block-cover__inner-container"></div>
      <div class="mtc-about-fade"></div>
    </div>
    <!-- /wp:cover -->
  </div>
  <!-- /wp:column -->
  <style>
  .mtc-about-photo { position: relative; }
  .mtc-about-fade {
    position: absolute;
    top: 0; right: 0; bottom: 0;
    width: 50%;
    background: linear-gradient(to right, transparent, #111111);
    pointer-events: none;
    z-index: 1;
  }
  @media (max-width: 768px) {
    .mtc-about-photo {
      min-height: 220px !important;
    }
    .mtc-about-fade {
      top: auto;
      right: 0;
      bottom: 0;
      left: 0;
      width: 100%;
      height: 60%;
      background: linear-gradient(to bottom, transparent, #111111);
    }
  }
  </style>
  <!-- wp:column {"width":"50%","style":{"color":{"background":"#111111"},"spacing":{"padding":{"top":"60px","bottom":"60px","left":"48px","right":"48px"}}}} -->
  <div class="wp-block-column" style="background-color:#111111;padding-top:60px;padding-right:48px;padding-bottom:60px;padding-left:48px">
    <!-- wp:paragraph {"className":"section-eyebrow","style":{"spacing":{"margin":{"bottom":"10px"}}}} --><p class="section-eyebrow">Who We Are</p><!-- /wp:paragraph -->
    <!-- wp:heading {"level":2,"style":{"typography":{"fontSize":"1.8rem"},"spacing":{"margin":{"bottom":"18px"}}}} --><h2>Oakville's Most Trusted Tire Shop</h2><!-- /wp:heading -->
    <!-- wp:paragraph {"style":{"color":{"text":"#888888"},"typography":{"fontSize":"0.82rem"}}} --><p style="color:#888888;font-size:0.82rem">MTC Tire has been serving Oakville drivers since 2005. We're not a chain — we're your neighbours. Howard and the team give straight talk, honest prices, and service that earns repeat customers for life.</p><!-- /wp:paragraph -->
    <!-- wp:paragraph {"style":{"color":{"text":"#888888"},"typography":{"fontSize":"0.78rem","fontStyle":"italic"},"spacing":{"margin":{"bottom":"24px"}}}} --><p style="color:#888888;font-size:0.78rem;font-style:italic">"Mechanics that learn your name is always nice in this day and age." — Callum McGregor</p><!-- /wp:paragraph -->
    <!-- wp:columns {"style":{"border":{"top":{"color":"#222222","style":"solid","width":"1px"}},"spacing":{"padding":{"top":"24px"}}}} -->
    <div class="wp-block-columns mtc-stats-row" style="border-top:1px solid #222222;padding-top:24px">
      <!-- wp:column -->
      <div class="wp-block-column">
        <!-- wp:paragraph {"style":{"typography":{"fontFamily":"var(--wp--preset--font-family--oswald)","fontSize":"1.8rem","fontWeight":"700"},"color":{"text":"#f3832e"}}} --><p style="font-family:var(--wp--preset--font-family--oswald);font-size:1.8rem;font-weight:700;color:#f3832e">20+</p><!-- /wp:paragraph -->
        <!-- wp:paragraph {"style":{"color":{"text":"#666666"},"typography":{"fontSize":"0.65rem","textTransform":"uppercase","letterSpacing":"1px"}}} --><p style="color:#666666;font-size:0.65rem;text-transform:uppercase;letter-spacing:1px">Years in Business</p><!-- /wp:paragraph -->
      </div>
      <!-- /wp:column -->
      <!-- wp:column -->
      <div class="wp-block-column">
        <!-- wp:paragraph {"style":{"typography":{"fontFamily":"var(--wp--preset--font-family--oswald)","fontSize":"1.8rem","fontWeight":"700"},"color":{"text":"#f3832e"}}} --><p style="font-family:var(--wp--preset--font-family--oswald);font-size:1.8rem;font-weight:700;color:#f3832e">4.6★</p><!-- /wp:paragraph -->
        <!-- wp:paragraph {"style":{"color":{"text":"#666666"},"typography":{"fontSize":"0.65rem","textTransform":"uppercase","letterSpacing":"1px"}}} --><p style="color:#666666;font-size:0.65rem;text-transform:uppercase;letter-spacing:1px">Google Rating</p><!-- /wp:paragraph -->
      </div>
      <!-- /wp:column -->
      <!-- wp:column -->
      <div class="wp-block-column">
        <!-- wp:paragraph {"style":{"typography":{"fontFamily":"var(--wp--preset--font-family--oswald)","fontSize":"1.8rem","fontWeight":"700"},"color":{"text":"#f3832e"}}} --><p style="font-family:var(--wp--preset--font-family--oswald);font-size:1.8rem;font-weight:700;color:#f3832e">100%</p><!-- /wp:paragraph -->
        <!-- wp:paragraph {"style":{"color":{"text":"#666666"},"typography":{"fontSize":"0.65rem","textTransform":"uppercase","letterSpacing":"1px"}}} --><p style="color:#666666;font-size:0.65rem;text-transform:uppercase;letter-spacing:1px">Local &amp; Independent</p><!-- /wp:paragraph -->
      </div>
      <!-- /wp:column -->
    </div>
    <!-- /wp:columns -->
  </div>
  <!-- /wp:column -->
</div>
<!-- /wp:columns -->
