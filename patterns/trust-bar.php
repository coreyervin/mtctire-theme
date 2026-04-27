<?php
/**
 * Title: Trust Bar
 * Slug: mtctire/trust-bar
 * Categories: featured
 */
?>
<!-- wp:html -->
<div class="mtc-trust-bar">
  <div class="mtc-trust-bar-inner">
    <div class="mtc-trust-item">
      <span class="mtc-trust-icon">★</span>
      <span class="mtc-trust-label"><strong>4.6</strong> Google Rating</span>
    </div>
    <span class="mtc-trust-divider"></span>
    <div class="mtc-trust-item">
      <span class="mtc-trust-icon">⚡</span>
      <span class="mtc-trust-label">Same-Day Service</span>
    </div>
    <span class="mtc-trust-divider"></span>
    <div class="mtc-trust-item">
      <span class="mtc-trust-icon">✔&#xFE0E;</span>
      <span class="mtc-trust-label">Certified Technicians</span>
    </div>
    <span class="mtc-trust-divider"></span>
    <div class="mtc-trust-item">
      <span class="mtc-trust-icon">♥</span>
      <span class="mtc-trust-label">Family Owned</span>
    </div>
  </div>
</div>
<style>
.mtc-trust-bar {
  background: #161616;
  border-bottom: 1px solid #222222;
}
.mtc-trust-bar-inner {
  max-width: 1140px;
  margin: 0 auto;
  padding: 0 40px;
  display: flex;
  align-items: center;
  justify-content: center;
  height: 48px;
  gap: 0;
}
.mtc-trust-item {
  display: flex;
  align-items: center;
  gap: 8px;
  padding: 0 32px;
}
.mtc-trust-icon {
  color: #f3832e;
  font-size: 0.85rem;
  line-height: 1;
}
.mtc-trust-label {
  color: #aaaaaa;
  font-size: 0.68rem;
  font-family: Inter, sans-serif;
  text-transform: uppercase;
  letter-spacing: 1.5px;
  white-space: nowrap;
}
.mtc-trust-label strong {
  color: #ffffff;
  font-weight: 600;
}
.mtc-trust-divider {
  width: 1px;
  height: 20px;
  background: #2a2a2a;
  flex-shrink: 0;
}
@media (max-width: 768px) {
  .mtc-trust-bar-inner {
    display: grid;
    grid-template-columns: 1fr 1fr;
    height: auto;
    padding: 0;
    gap: 0;
  }
  .mtc-trust-divider { display: none; }
  /* Items sit at positions 1,3,5,7 (dividers fill 2,4,6) */
  .mtc-trust-item {
    padding: 16px 12px;
    justify-content: center;
    border-right: 1px solid #222222;
    border-bottom: 1px solid #222222;
  }
  /* Right column (Same-Day=3, Price Match=7) — no right border */
  .mtc-trust-item:nth-child(3),
  .mtc-trust-item:nth-child(7) { border-right: none; }
  /* Bottom row (Certified=5, Price Match=7) — no bottom border */
  .mtc-trust-item:nth-child(5),
  .mtc-trust-item:nth-child(7) { border-bottom: none; }
}
</style>
<!-- /wp:html -->
