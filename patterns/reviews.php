<?php
/**
 * Title: Reviews
 * Slug: mtctire/reviews
 * Categories: featured
 */
?>
<!-- wp:html -->
<section class="mtc-reviews-section">
  <div class="mtc-reviews-inner">
    <p class="section-eyebrow" style="margin-bottom:12px">What Customers Say</p>
    <h2 class="mtc-reviews-heading">Real Reviews From Real Customers</h2>
    <?php echo do_shortcode('[trustindex no-registration=google]'); ?>
  </div>
</section>
<style>
.mtc-reviews-section {
  background: #0d0d0d;
  padding: 64px 0;
  border-top: 1px solid #1a1a1a;
  border-bottom: 1px solid #1a1a1a;
}
.mtc-reviews-inner {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 48px;
}
.mtc-reviews-heading {
  font-family: var(--wp--preset--font-family--oswald, Oswald, sans-serif);
  font-size: 1.8rem;
  font-weight: 700;
  text-transform: uppercase;
  color: #ffffff;
  margin: 8px 0 32px;
}
@media (max-width: 768px) {
  .mtc-reviews-inner {
    padding: 0 20px;
  }
  .mtc-reviews-heading {
    font-size: 1.3rem;
  }
}
</style>
<!-- /wp:html -->
