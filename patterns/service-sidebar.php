<?php
/**
 * Title: Service Sidebar
 * Slug: mtctire/service-sidebar
 * Categories: featured
 */
?>
<!-- wp:html -->
<div class="mtc-service-sidebar">

  <!-- CTA box -->
  <div class="mtc-sidebar-cta">
    <h3>Get a Quote</h3>
    <p>Tell us your vehicle and tire size and we'll find the best tire for your budget.</p>
    <a href="/contact/" class="mtc-sidebar-btn">Contact Us →</a>
  </div>

  <!-- Services nav -->
  <div class="mtc-sidebar-nav">
    <h3>Our Services</h3>
    <ul>
      <li><a href="/services/tires-wheels/">Tires &amp; Wheels</a></li>
      <li><a href="/services/tire-storage/">On-Site Tire Storage</a></li>
      <li><a href="/services/automotive-repairs-maintenance/">Auto Repairs</a></li>
      <li><a href="/services/wheel-alignment-oakville/">Wheel Alignment</a></li>
      <li><a href="/services/brake-inspection-repairs-oakville/">Brake Inspection</a></li>
      <li><a href="/services/provincial-safety-inspection/">Provincial Safety Inspection</a></li>
    </ul>
  </div>

  <!-- Phone -->
  <div class="mtc-sidebar-phone">
    <span>Call Us Directly</span>
    <a href="tel:9058476665">905.847.6665</a>
  </div>

</div>
<style>
.mtc-service-sidebar {
  display: flex;
  flex-direction: column;
  gap: 12px;
}
.mtc-sidebar-cta {
  background: #f3832e;
  padding: 24px;
}
.mtc-sidebar-cta h3 {
  color: #ffffff;
  font-size: 1rem;
  margin-bottom: 8px;
}
.mtc-sidebar-cta p {
  color: rgba(255,255,255,0.85);
  font-size: 0.72rem;
  margin-bottom: 16px;
  line-height: 1.5;
}
.mtc-sidebar-btn {
  display: inline-block;
  background: #111111;
  color: #ffffff !important;
  font-size: 0.65rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 1px;
  padding: 10px 18px;
  text-decoration: none;
}
.mtc-sidebar-nav {
  background: #161616;
  border: 1px solid #222222;
  padding: 20px;
}
.mtc-sidebar-nav h3 {
  color: #888888;
  font-size: 0.75rem;
  letter-spacing: 2px;
  padding-bottom: 8px;
  border-bottom: 2px solid #f3832e;
  margin-bottom: 12px;
}
.mtc-sidebar-nav ul {
  list-style: none;
  padding: 0;
  margin: 0;
}
.mtc-sidebar-nav ul li {
  border-bottom: 1px solid #222222;
}
.mtc-sidebar-nav ul li:last-child {
  border-bottom: none;
}
.mtc-sidebar-nav ul li a {
  display: block;
  color: #888888;
  font-size: 0.75rem;
  text-decoration: none;
  padding: 8px 0;
  transition: color 0.2s;
}
.mtc-sidebar-nav ul li a:hover {
  color: #f3832e;
}
.mtc-sidebar-phone {
  background: #161616;
  border: 1px solid #222222;
  padding: 16px;
  text-align: center;
  display: flex;
  flex-direction: column;
  gap: 6px;
}
.mtc-sidebar-phone span {
  color: #555555;
  font-size: 0.62rem;
  text-transform: uppercase;
  letter-spacing: 1px;
}
.mtc-sidebar-phone a {
  color: #f3832e !important;
  font-family: var(--wp--preset--font-family--oswald, Oswald, sans-serif);
  font-size: 1.3rem;
  font-weight: 700;
  text-decoration: none;
}
</style>
<!-- /wp:html -->
