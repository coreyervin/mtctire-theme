<?php
/**
 * Title: Brands
 * Slug: mtctire/brands
 * Categories: featured
 */
$uploads = get_site_url() . '/wp-content/uploads/2017/05/';
$brands = [
    [ 'file' => 'nokian.jpg',              'alt' => 'Nokian Tyres' ],
    [ 'file' => 'bridgestone.jpg',         'alt' => 'Bridgestone' ],
    [ 'file' => 'michelin.jpg',            'alt' => 'Michelin' ],
    [ 'file' => 'goodyear.jpg',            'alt' => 'Goodyear' ],
    [ 'file' => 'yokohama.jpg',            'alt' => 'Yokohama' ],
    [ 'file' => 'hankook.jpg',             'alt' => 'Hankook' ],
    [ 'file' => 'kumho.jpg',               'alt' => 'Kumho' ],
    [ 'file' => 'bfgoodrich.jpg',          'alt' => 'BFGoodrich' ],
    [ 'file' => 'logo_rebate_pirelli.jpg', 'alt' => 'Pirelli' ],
    [ 'file' => 'continental.jpg',         'alt' => 'Continental' ],
];
?>
<!-- wp:html -->
<section class="mtc-brands-section">
  <div class="mtc-brands-inner">
    <p class="section-eyebrow" style="text-align:center;justify-content:center;margin-bottom:32px">Brands We Carry</p>
    <div class="mtc-brands-grid">
      <?php foreach ( $brands as $brand ) : ?>
      <a href="https://treadpro.ca/promotions/" class="mtc-brand-card" target="_blank" rel="noopener">
        <img
          src="<?php echo esc_url( $uploads . $brand['file'] ); ?>"
          alt="<?php echo esc_attr( $brand['alt'] ); ?>"
          loading="lazy"
        />
      </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<style>
.mtc-brands-section {
  background: #0d0d0d;
  border-top: 1px solid #1e1e1e;
  border-bottom: 1px solid #1e1e1e;
  padding: 48px 48px;
}
.mtc-brands-inner {
  max-width: 1140px;
  margin: 0 auto;
}
.mtc-brands-grid {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 12px;
}
.mtc-brand-card {
  background: #ffffff;
  border: 1px solid #e0e0e0;
  width: 160px;
  height: 90px;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 4px 8px;
  opacity: 0.55;
  transition: opacity 0.25s;
}
.mtc-brand-card:hover {
  opacity: 1;
}
.mtc-brand-card img {
  width: 100%;
  height: 100%;
  object-fit: contain;
  display: block;
}
@media (max-width: 768px) {
  .mtc-brands-section { padding: 40px 20px; }
  .mtc-brand-card { width: 130px; height: 65px; }
}
</style>
<!-- /wp:html -->
