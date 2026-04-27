<?php
/**
 * Title: About: Content
 * Slug: mtctire/about-content
 * Categories: mtctire
 */
$uploads = get_site_url() . '/wp-content/uploads/2019/09/';
?>
<!-- wp:html -->
<div class="mtc-about-page">

  <!-- Intro -->
  <p class="section-eyebrow">Who We Are</p>
  <h2>About MTC Tire Oakville</h2>
  <p class="mtc-service-intro">MTC Tire Oakville is a comprehensive automotive shop specializing in tire service and automotive repairs. Our team has the skills and expertise to service all makes and models — from the family van to the exotic sports car and everything in between.</p>

  <!-- Shop photo -->
  <div class="mtc-about-photo-full">
    <img src="<?php echo esc_url( $uploads . 'mtctire_photoshoot_aug2019-52.jpg' ); ?>" alt="MTC Tire Oakville shop" loading="lazy" />
  </div>

  <p class="mtc-about-body">We know that anyone can sell you a tire, but we believe in the importance of working with a professional who can provide all of the necessary services after the purchase has been made. Our commitment to a personal experience is what sets us apart — we do everything we can to get you in and out quickly, with honest advice every step of the way.</p>

  <!-- YouTube video -->
  <div class="mtc-about-video">
    <iframe src="https://www.youtube.com/embed/X6LjEJ27uQ0?rel=0" title="MTC Tire Oakville" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
  </div>

  <!-- Howard bio — photo + text side by side -->
  <div class="mtc-about-bio-row">
    <div class="mtc-about-bio-photo">
      <img src="<?php echo esc_url( $uploads . 'mtctire_photoshoot_aug2019-48.jpg' ); ?>" alt="Howard Cox — Owner, MTC Tire Oakville" loading="lazy" />
      <p class="mtc-about-photo-caption">Howard Cox — Owner</p>
    </div>
    <div class="mtc-about-bio-text">
      <h3 class="mtc-service-subheading">About Howard Cox</h3>
      <p>Howard Cox is an award-winning licensed automotive technician who has been serving the Oakville area for over 25 years. His love for cars began at 16, fixing up and modifying vehicles in his parents' driveway.</p>
      <p>Howard apprenticed as an automotive technician while attending Mohawk College, where he received the <strong>Outstanding Achievement Award</strong> for the highest mark in his graduating class. He went on to earn a Business Diploma from Sheridan College.</p>
      <p>After graduating in 1988, Howard opened his first shop on Speers Road. The business grew into a large Petro-Canada Certigard operation before MTC Tire Oakville was founded in 2002. Howard has also been actively involved in auto racing for years, translating that hands-on knowledge of vehicle dynamics directly into the work done for customers.</p>
      <p>Many things have changed since 1988 — one thing hasn't: Howard's commitment to quality, personal service, and integrity in everything MTC Tire does.</p>
    </div>
  </div>

  <!-- Team -->
  <h3 class="mtc-service-subheading" style="margin-top:36px">Our Team</h3>
  <div class="mtc-feature-grid">
    <div class="mtc-feature-card">
      <span class="mtc-feature-title">Howard Cox</span>
      <span class="mtc-feature-desc">Owner &amp; Licensed Automotive Technician</span>
    </div>
    <div class="mtc-feature-card">
      <span class="mtc-feature-title">Donna Cox</span>
      <span class="mtc-feature-desc">Co-Owner &amp; Office Manager</span>
    </div>
    <div class="mtc-feature-card">
      <span class="mtc-feature-title">Matthew Wells</span>
      <span class="mtc-feature-desc">Tire Sales &amp; Service Manager · Licensed Automotive Technician</span>
    </div>
    <div class="mtc-feature-card">
      <span class="mtc-feature-title">Robert Durdin</span>
      <span class="mtc-feature-desc">Tire Sales &amp; Service Advisor · Licensed Automotive Technician</span>
    </div>
  </div>

  <!-- Shop photos strip -->
  <div class="mtc-about-photo-strip">
    <img src="<?php echo esc_url( $uploads . 'mtctire_photoshoot_aug2019-43.jpg' ); ?>" alt="MTC Tire shop" loading="lazy" />
    <img src="<?php echo esc_url( $uploads . 'mtctire_photoshoot_aug2019-44.jpg' ); ?>" alt="MTC Tire team" loading="lazy" />
    <img src="<?php echo esc_url( $uploads . 'mtctire_photoshoot_aug2019-47.jpg' ); ?>" alt="MTC Tire service" loading="lazy" />
  </div>

  <!-- Drop-off note -->
  <p class="mtc-service-note">
    <strong style="color:#f3832e">Early Bird / Night Owl Drop-Off</strong> — We understand not everyone works 9 to 5. Drop off or pick up your vehicle after normal working hours. It's that simple.
  </p>

</div>
<style>
.mtc-about-page h2 {
  font-size: 1.8rem;
  color: #ffffff;
  margin-bottom: 16px;
  margin-top: 16px;
}
.mtc-about-body {
  color: #888888;
  font-size: 0.95rem;
  line-height: 1.7;
  margin-bottom: 32px;
}
.mtc-about-video {
  position: relative;
  padding-bottom: 56.25%;
  height: 0;
  overflow: hidden;
  margin-bottom: 32px;
}
.mtc-about-video iframe {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  border: 0;
}
.mtc-about-photo-full {
  width: 100%;
  margin-bottom: 28px;
  overflow: hidden;
  max-height: 340px;
}
.mtc-about-photo-full img {
  width: 100%;
  height: 340px;
  object-fit: cover;
  object-position: center;
  display: block;
}
.mtc-about-bio-row {
  display: flex;
  gap: 28px;
  margin-bottom: 36px;
  align-items: flex-start;
}
.mtc-about-bio-photo {
  flex: 0 0 200px;
}
.mtc-about-bio-photo img {
  width: 200px;
  height: 240px;
  object-fit: cover;
  object-position: center top;
  display: block;
}
.mtc-about-photo-caption {
  color: #555555;
  font-size: 0.65rem;
  text-transform: uppercase;
  letter-spacing: 1px;
  margin-top: 8px;
  text-align: center;
}
.mtc-about-bio-text p {
  color: #888888;
  font-size: 0.95rem;
  line-height: 1.7;
  margin-bottom: 12px;
}
.mtc-about-bio-text strong {
  color: #cccccc;
}
.mtc-about-photo-strip {
  display: grid;
  grid-template-columns: 1fr 1fr 1fr;
  gap: 2px;
  margin-bottom: 28px;
}
.mtc-about-photo-strip img {
  width: 100%;
  height: 160px;
  object-fit: cover;
  display: block;
}
@media (max-width: 768px) {
  .mtc-about-bio-row {
    flex-direction: column;
  }
  .mtc-about-bio-photo {
    flex: none;
    width: 100%;
  }
  .mtc-about-bio-photo img {
    width: 100%;
    height: 220px;
  }
  .mtc-about-photo-strip {
    grid-template-columns: 1fr 1fr;
  }
  .mtc-about-photo-strip img:last-child {
    display: none;
  }
}
</style>
<!-- /wp:html -->
