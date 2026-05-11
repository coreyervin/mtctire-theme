<?php
/**
 * Title: Services Grid
 * Slug: mtctire/services-grid
 * Categories: featured
 */
?>
<!-- wp:html -->
<section class="mtc-services-list-section">
  <div class="mtc-services-list-inner">

    <div class="mtc-services-list-header">
      <p class="section-eyebrow" style="margin-bottom:12px">What We Do</p>
      <h2 class="mtc-services-list-heading">Our Services</h2>
      <a href="/services/" class="mtc-services-list-cta">View All Services →</a>
    </div>

    <div class="mtc-services-list">
      <a href="/services/tires-wheels/" class="mtc-service-row">
        <span class="mtc-service-row-name">Tires &amp; Wheels</span>
        <span class="mtc-service-row-desc">Widest selection in Oakville — all makes, models, and budgets</span>
        <span class="mtc-service-row-arrow">→</span>
      </a>
      <a href="/services/tire-storage/" class="mtc-service-row">
        <span class="mtc-service-row-name">Tire Storage</span>
        <span class="mtc-service-row-desc">Secure indoor seasonal storage — we handle the swap</span>
        <span class="mtc-service-row-arrow">→</span>
      </a>
      <a href="/services/automotive-repairs-maintenance/" class="mtc-service-row">
        <span class="mtc-service-row-name">Automotive Repair</span>
        <span class="mtc-service-row-desc">Full-service shop — honest advice, fair pricing, no surprises</span>
        <span class="mtc-service-row-arrow">→</span>
      </a>
      <a href="/services/wheel-alignment-oakville/" class="mtc-service-row">
        <span class="mtc-service-row-name">Wheel Alignment</span>
        <span class="mtc-service-row-desc">Precision computerized alignment — extends tire life</span>
        <span class="mtc-service-row-arrow">→</span>
      </a>
      <a href="/services/brake-inspection-repairs-oakville/" class="mtc-service-row">
        <span class="mtc-service-row-name">Brake Inspection</span>
        <span class="mtc-service-row-desc">Complete brake system check and repair — don't wait</span>
        <span class="mtc-service-row-arrow">→</span>
      </a>
      <a href="/services/fleet-cards/" class="mtc-service-row">
        <span class="mtc-service-row-name">Fleet Cards</span>
        <span class="mtc-service-row-desc">Simplified billing and priority service for Oakville businesses</span>
        <span class="mtc-service-row-arrow">→</span>
      </a>
    </div>

  </div>
</section>
<style>
.mtc-services-list-section {
  background: #111111;
  border-top: 1px solid #1a1a1a;
  border-bottom: 1px solid #1a1a1a;
  padding: 64px 48px;
}
.mtc-services-list-inner {
  max-width: 1200px;
  margin: 0 auto;
  display: flex;
  gap: 80px;
  align-items: flex-start;
}
.mtc-services-list-header {
  flex: 0 0 240px;
  position: sticky;
  top: 100px;
}
.mtc-services-list-heading {
  font-family: var(--wp--preset--font-family--oswald, Oswald, sans-serif);
  font-size: 2rem;
  font-weight: 700;
  text-transform: uppercase;
  color: #ffffff;
  margin: 8px 0 24px;
  line-height: 1.1;
}
.mtc-services-list-cta {
  display: inline-block;
  color: #f3832e;
  font-size: 0.68rem;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 1.5px;
  text-decoration: none;
}
.mtc-services-list-cta:hover {
  color: #ffffff;
}
.mtc-services-list {
  flex: 1;
  border-top: 1px solid #1e1e1e;
}
.mtc-service-row {
  display: flex;
  align-items: center;
  gap: 24px;
  padding: 22px 16px;
  border-bottom: 1px solid #1e1e1e;
  text-decoration: none;
  transition: background 0.15s ease;
}
.mtc-service-row:hover {
  background: #161616;
}
.mtc-service-row-name {
  font-family: var(--wp--preset--font-family--oswald, Oswald, sans-serif);
  font-size: 0.95rem;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  color: #ffffff;
  min-width: 190px;
  transition: color 0.15s ease;
}
.mtc-service-row:hover .mtc-service-row-name {
  color: #f3832e;
}
.mtc-service-row-desc {
  font-size: 0.78rem;
  color: #999999;
  flex: 1;
  line-height: 1.5;
}
.mtc-service-row-arrow {
  color: #f3832e;
  font-size: 1rem;
  flex-shrink: 0;
  opacity: 0;
  transform: translateX(-6px);
  transition: opacity 0.15s ease, transform 0.15s ease;
}
.mtc-service-row:hover .mtc-service-row-arrow {
  opacity: 1;
  transform: translateX(0);
}
@media (max-width: 768px) {
  .mtc-services-list-section {
    padding: 48px 20px;
  }
  .mtc-services-list-inner {
    flex-direction: column;
    gap: 32px;
  }
  .mtc-services-list-header {
    flex: none;
    position: static;
  }
  .mtc-services-list-heading {
    font-size: 1.5rem;
  }
  .mtc-service-row {
    flex-wrap: wrap;
    gap: 4px;
    padding: 18px 8px;
  }
  .mtc-service-row-name {
    min-width: 0;
    width: 100%;
  }
  .mtc-service-row-desc {
    font-size: 0.75rem;
  }
  .mtc-service-row-arrow {
    opacity: 1;
    transform: none;
  }
}
</style>
<!-- /wp:html -->
