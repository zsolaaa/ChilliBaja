<?php get_header(); ?>

<?php
$shop_url = function_exists( 'wc_get_page_id' ) ? get_permalink( wc_get_page_id( 'shop' ) ) : home_url( '/webshop' );
?>

<!-- ══════════════════ HERO ══════════════════ -->
<section class="noise-overlay relative min-h-[100svh] flex items-end overflow-hidden">

  <!-- Háttérkép -->
  <div class="absolute inset-0 -z-10">
    <?php if ( has_post_thumbnail() ) :
        the_post_thumbnail( 'full', [ 'id' => 'hero-img', 'class' => 'w-full h-full object-cover', 'alt' => '' ] );
    else : ?>
      <img id="hero-img" src="<?php echo get_template_directory_uri(); ?>/assets/images/chilik.webp"
           class="w-full h-full object-cover" style="will-change:transform;transform:scale(1.05) translateY(0px)" alt="" />
    <?php endif; ?>
    <!-- Alsó gradient -->
    <div class="absolute inset-0 bg-gradient-to-t from-surface via-surface/55 to-transparent"></div>
    <!-- Ember glow -->
    <div id="hero-glow"
         class="absolute right-[10%] top-[15%] w-[55vw] h-[70vh] rounded-full pointer-events-none"
         style="background:radial-gradient(ellipse at center,rgba(255,87,34,0.22) 0%,transparent 70%);animation:ember-pulse 4s ease-in-out infinite"></div>
  </div>

  <!-- Szikrák -->
  <div class="absolute inset-0 pointer-events-none overflow-hidden" aria-hidden="true">
    <?php
    $sparks = [
      ['left'=>'15%','bottom'=>'18%','dur'=>'2.8s','delay'=>'0s',   'drift'=>'12px'],
      ['left'=>'28%','bottom'=>'12%','dur'=>'3.4s','delay'=>'0.7s', 'drift'=>'-8px'],
      ['left'=>'42%','bottom'=>'20%','dur'=>'2.5s','delay'=>'1.3s', 'drift'=>'6px'],
      ['left'=>'58%','bottom'=>'15%','dur'=>'3.1s','delay'=>'0.3s', 'drift'=>'-14px'],
      ['left'=>'71%','bottom'=>'22%','dur'=>'2.7s','delay'=>'1.8s', 'drift'=>'10px'],
    ];
    foreach ( $sparks as $s ) : ?>
    <div class="spark" style="left:<?= esc_attr($s['left']) ?>;bottom:<?= esc_attr($s['bottom']) ?>;--dur:<?= esc_attr($s['dur']) ?>;--delay:<?= esc_attr($s['delay']) ?>;--drift:<?= esc_attr($s['drift']) ?>"></div>
    <?php endforeach; ?>
  </div>

  <!-- Hero szöveg – bal alsó, nagy tipográfia -->
  <div class="relative z-10 px-6 pb-16 md:pb-24 max-w-[1280px] mx-auto w-full">

    <div class="hero-line inline-flex items-center gap-2 mb-6 px-4 py-1.5 rounded-full" id="hero-badge"
         style="background:linear-gradient(90deg,rgba(255,87,34,0.12) 0%,rgba(255,181,160,0.28) 40%,rgba(255,87,34,0.12) 80%);background-size:200% auto;animation:shimmer 3.5s linear infinite;border:1px solid rgba(255,87,34,0.25)">
      <span class="font-label-caps text-label-caps uppercase tracking-widest text-primary text-[10px]">Kézzel készített &middot; Baja &middot; Kis szériás</span>
    </div>

    <h1 class="hero-line font-display-lg-mobile md:font-display-lg text-display-lg-mobile md:text-display-lg mb-3 leading-tight text-on-surface">
      A parázs íze a te<br>
      <span class="text-primary">konyhádban.</span>
    </h1>

    <div id="hero-fire-line" class="mb-7 h-[2px] w-40 rounded-full"
         style="background:linear-gradient(90deg,#ff5722,#ff8a65);transform-origin:left center;animation:fire-line-grow 0.9s cubic-bezier(0.22,1,0.36,1) 0.55s both"></div>

    <p class="hero-line font-body-lg text-body-lg text-on-surface-variant mb-10 max-w-lg">
      Kézzel készített prémium chili szószok Bajáról.
    </p>

    <div class="hero-line flex flex-col sm:flex-row gap-4">
      <a href="<?php echo esc_url( $shop_url ); ?>"
         class="group relative w-full sm:w-auto px-10 py-4 rounded-full text-white font-label-caps text-label-caps uppercase tracking-widest overflow-hidden hover:brightness-110 hover:shadow-[0_0_40px_rgba(255,87,34,0.55)] transition-all duration-150"
         style="background:linear-gradient(135deg,#ff5722 0%,#ff8a65 100%)">
        Vásárlás
      </a>
      <a href="#helyszinek"
         class="hidden sm:inline-flex w-full sm:w-auto px-10 py-4 rounded-full border border-primary/25 text-primary font-label-caps text-label-caps uppercase tracking-widest hover:bg-primary/8 hover:border-primary/40 transition-colors duration-150">
        Hol kapható
      </a>
    </div>
  </div>

  <!-- Scroll caret -->
  <div id="scroll-caret" class="absolute bottom-6 left-1/2 text-on-surface-variant/50"
       style="transform:translateX(-50%);animation:caret-bounce 2.2s ease-in-out infinite" aria-hidden="true">
    <span class="material-symbols-outlined text-[28px]">keyboard_arrow_down</span>
  </div>
</section>

<!-- ══════════════════ TERMÉKEK KIEMELVE ══════════════════ -->
<section class="py-20 px-6 max-w-7xl mx-auto">
  <div class="flex items-end justify-between mb-10">
    <div>
      <p class="text-xs font-semibold uppercase tracking-widest text-[#5b4039] mb-2">Kínálatunkból</p>
      <h2 class="font-serif text-3xl md:text-4xl font-bold text-[#f5ede8]">Kiemelt termékek</h2>
    </div>
    <?php if ( function_exists( 'wc_get_page_id' ) ) : ?>
    <a href="<?php echo get_permalink( wc_get_page_id( 'shop' ) ); ?>"
       class="text-sm text-[#ff8a65] hover:underline hidden md:block">
      Összes termék →
    </a>
    <?php endif; ?>
  </div>

  <?php if ( function_exists( 'wc_get_products' ) ) : ?>
  <?php
  $products = wc_get_products( [
    'status'   => 'publish',
    'limit'    => 4,
    'featured' => true,
  ] );
  if ( empty( $products ) ) {
    $products = wc_get_products( [ 'status' => 'publish', 'limit' => 4 ] );
  }
  ?>
  <?php if ( $products ) : ?>
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
    <?php foreach ( $products as $product ) : ?>
    <article class="bg-[#1c1b1b] border border-[#5b4039]/25 rounded-2xl overflow-hidden ember-glow group hover:-translate-y-1 transition-transform duration-300">
      <a href="<?php echo esc_url( get_permalink( $product->get_id() ) ); ?>">
        <?php echo $product->get_image( 'woocommerce_thumbnail', [ 'class' => 'w-full aspect-square object-cover' ] ); ?>
      </a>
      <div class="p-4">
        <h3 class="font-serif text-base font-semibold text-[#f5ede8] mb-1">
          <a href="<?php echo esc_url( get_permalink( $product->get_id() ) ); ?>" class="hover:text-[#ff8a65] transition-colors">
            <?php echo esc_html( $product->get_name() ); ?>
          </a>
        </h3>
        <p class="text-[#ff8a65] font-bold text-sm mb-3"><?php echo $product->get_price_html(); ?></p>
        <a href="<?php echo esc_url( $product->add_to_cart_url() ); ?>"
           class="block w-full text-center gradient-fire text-white text-sm font-semibold py-2 rounded-lg hover:opacity-90 transition-opacity">
          Kosárba
        </a>
      </div>
    </article>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>
  <?php endif; ?>
</section>

<!-- ══════════════════ RÓLUNK ══════════════════ -->
<section id="rolunk" class="py-20 bg-[#0e0e0e]">
  <div class="max-w-7xl mx-auto px-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
      <div>
        <p class="text-xs font-semibold uppercase tracking-widest text-[#5b4039] mb-3">A mi történetünk</p>
        <h2 class="font-serif text-3xl md:text-4xl font-bold text-[#f5ede8] mb-6">Bajáról, szívvel</h2>
        <p class="text-[#8a706a] leading-relaxed mb-4">
          A Chili Baja kézműves üzem a Dél-Alföld szívéből hozza el a chili szerelmeseknek azt a fajta hőt,
          amire csak a napsütötte bajai nyarak képesek.
        </p>
        <p class="text-[#8a706a] leading-relaxed">
          Termékeinket kis tételben, gondosan válogatott alapanyagokból készítjük — tartósítószer és mesterséges
          ízfokozó nélkül. Minden üveg egy megismételhetetlen évszak lenyomata.
        </p>
      </div>
      <div class="rounded-2xl overflow-hidden ember-glow-strong">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/chilik.webp"
             alt="Chili Baja termékek"
             class="w-full object-cover aspect-[4/3]" />
      </div>
    </div>
  </div>
</section>

<!-- ══════════════════ HELYSZÍNEK ══════════════════ -->
<section id="helyszinek" class="py-28 relative overflow-hidden" style="background:#111010;">
  <div class="absolute right-0 top-1/4 w-[420px] h-[420px] rounded-full pointer-events-none" style="background:rgba(255,181,160,0.03);filter:blur(130px)"></div>

  <div class="max-w-[1280px] mx-auto px-6">

    <div class="mb-14 fade-up">
      <h2 class="font-headline-xl text-headline-xl text-on-surface text-balance">Hol találsz meg?</h2>
      <p class="text-on-surface-variant font-body-lg mt-2">Személyesen, piacon és online egyaránt.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-start">

      <!-- Bal: helyszín kártyák -->
      <div class="space-y-4">

        <!-- Bajai Városi Piac -->
        <div class="fade-up group bg-surface-container rounded-2xl p-6 border border-outline-variant/12 hover:border-primary/20 transition-colors duration-200"
             style="box-shadow:inset 1px 1px 0 rgba(255,255,255,0.05),inset -1px -1px 0 rgba(0,0,0,0.15)">
          <div class="flex items-start gap-4">
            <div class="w-10 h-10 rounded-xl bg-primary/10 border border-primary/20 flex items-center justify-center shrink-0 mt-0.5">
              <span class="material-symbols-outlined text-primary text-[18px]" style="font-variation-settings:'FILL' 1">storefront</span>
            </div>
            <div class="flex-1 min-w-0">
              <div class="flex items-center justify-between gap-3 mb-1">
                <h3 class="font-bold text-on-surface text-[15px]">Bajai Városi Piac</h3>
                <span class="font-label-caps text-[10px] uppercase tracking-widest text-primary bg-primary/10 px-2.5 py-1 rounded-full shrink-0">E07 stand</span>
              </div>
              <p class="text-on-surface-variant text-[13px] leading-snug mb-3">Szerda és szombat</p>
              <div class="flex flex-wrap gap-x-4 gap-y-1 text-[12px] text-on-surface-variant">
                <span class="flex items-center gap-1.5">
                  <span class="material-symbols-outlined text-[13px] text-primary/60">schedule</span>
                  06:00 – 12:00
                </span>
                <span class="flex items-center gap-1.5">
                  <span class="material-symbols-outlined text-[13px] text-primary/60">location_on</span>
                  Baja, Piac tér
                </span>
              </div>
            </div>
          </div>
        </div>

        <!-- Profil Bt Faház -->
        <div class="fade-up delay-1 group bg-surface-container rounded-2xl p-6 border border-outline-variant/12 hover:border-primary/20 transition-colors duration-200"
             style="box-shadow:inset 1px 1px 0 rgba(255,255,255,0.05),inset -1px -1px 0 rgba(0,0,0,0.15)">
          <div class="flex items-start gap-4">
            <div class="w-10 h-10 rounded-xl bg-primary/10 border border-primary/20 flex items-center justify-center shrink-0 mt-0.5">
              <span class="material-symbols-outlined text-primary text-[18px]" style="font-variation-settings:'FILL' 1">cottage</span>
            </div>
            <div class="flex-1 min-w-0">
              <div class="flex items-center justify-between gap-3 mb-1">
                <h3 class="font-bold text-on-surface text-[15px]">Profil Bt Faház</h3>
                <span class="font-label-caps text-[10px] uppercase tracking-widest text-on-surface-variant bg-surface-container-high px-2.5 py-1 rounded-full shrink-0">Ápr – Szept</span>
              </div>
              <p class="text-on-surface-variant text-[13px] leading-snug mb-3">Friss palánták, gyümölcsök, chili különlegességek</p>
              <div class="flex flex-wrap gap-x-4 gap-y-1 text-[12px] text-on-surface-variant">
                <span class="flex items-center gap-1.5">
                  <span class="material-symbols-outlined text-[13px] text-primary/60">location_on</span>
                  Keleti körút / Nagy István u. sarok
                </span>
              </div>
            </div>
          </div>
        </div>

        <!-- Személyes átvétel -->
        <div class="fade-up delay-2 group bg-surface-container rounded-2xl p-6 border border-outline-variant/12 hover:border-primary/20 transition-colors duration-200"
             style="box-shadow:inset 1px 1px 0 rgba(255,255,255,0.05),inset -1px -1px 0 rgba(0,0,0,0.15)">
          <div class="flex items-start gap-4">
            <div class="w-10 h-10 rounded-xl bg-primary/10 border border-primary/20 flex items-center justify-center shrink-0 mt-0.5">
              <span class="material-symbols-outlined text-primary text-[18px]" style="font-variation-settings:'FILL' 1">home</span>
            </div>
            <div class="flex-1 min-w-0">
              <div class="flex items-center justify-between gap-3 mb-1">
                <h3 class="font-bold text-on-surface text-[15px]">Személyes átvétel</h3>
                <span class="font-label-caps text-[10px] uppercase tracking-widest text-primary bg-primary/10 px-2.5 py-1 rounded-full shrink-0">Ingyenes</span>
              </div>
              <p class="text-on-surface-variant text-[13px] leading-snug mb-3">Előzetes egyeztetés alapján, Baján</p>
              <div class="flex flex-wrap gap-x-4 gap-y-1 text-[12px] text-on-surface-variant">
                <span class="flex items-center gap-1.5">
                  <span class="material-symbols-outlined text-[13px] text-primary/60">location_on</span>
                  6500 Baja, Hársfa utca 25.
                </span>
              </div>
            </div>
          </div>
        </div>

        <!-- Kapcsolat strip -->
        <div class="fade-up delay-3 flex flex-col sm:flex-row gap-3 pt-2">
          <a href="tel:+36304980690"
             class="flex items-center gap-3 flex-1 px-5 py-3.5 rounded-xl bg-surface-container border border-outline-variant/15 hover:border-primary/25 transition-colors duration-150">
            <span class="material-symbols-outlined text-primary text-[18px]" style="font-variation-settings:'FILL' 1">call</span>
            <div>
              <p class="font-label-caps text-[10px] uppercase tracking-widest text-on-surface-variant">Telefon</p>
              <p class="text-on-surface text-[13px] font-bold">+36 30 498 0690</p>
            </div>
          </a>
          <a href="mailto:chillibaja@gmail.com"
             class="flex items-center gap-3 flex-1 px-5 py-3.5 rounded-xl bg-surface-container border border-outline-variant/15 hover:border-primary/25 transition-colors duration-150">
            <span class="material-symbols-outlined text-primary text-[18px]" style="font-variation-settings:'FILL' 1">mail</span>
            <div>
              <p class="font-label-caps text-[10px] uppercase tracking-widest text-on-surface-variant">E-mail</p>
              <p class="text-on-surface text-[13px] font-bold">chillibaja@gmail.com</p>
            </div>
          </a>
        </div>

      </div>

      <!-- Jobb: térkép + online rendelés -->
      <div class="fade-up delay-1 flex flex-col gap-5">

        <!-- OpenStreetMap -->
        <div class="rounded-2xl overflow-hidden border border-outline-variant/15" style="height:340px;position:relative;box-shadow:inset 1px 1px 0 rgba(255,255,255,0.05),inset -1px -1px 0 rgba(0,0,0,0.15)">
          <iframe
            title="Chili Baja helyszín — Baja, Hársfa utca 25"
            src="https://www.openstreetmap.org/export/embed.html?bbox=18.940%2C46.172%2C18.975%2C46.200&layer=mapnik&marker=46.1848%2C18.9533"
            style="width:100%;height:100%;border:0;filter:brightness(0.82) saturate(0.7) hue-rotate(340deg);"
            loading="lazy"
            referrerpolicy="no-referrer"
            aria-label="Térkép: Baja, Hársfa utca 25"
          ></iframe>
          <a href="https://www.openstreetmap.org/?mlat=46.1848&mlon=18.9533#map=15/46.1848/18.9533"
             target="_blank" rel="noopener"
             class="absolute bottom-3 right-3 flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-[11px] text-on-surface-variant hover:text-primary transition-colors duration-150 border border-outline-variant/20"
             style="background:rgba(19,19,19,0.9);backdrop-filter:blur(8px)">
            <span class="material-symbols-outlined text-[13px]">open_in_new</span>
            Megnyitás térképen
          </a>
        </div>

        <!-- Online rendelés kártya -->
        <div class="bg-surface-container rounded-2xl p-6 border border-outline-variant/12"
             style="box-shadow:inset 1px 1px 0 rgba(255,255,255,0.05),inset -1px -1px 0 rgba(0,0,0,0.15)">
          <div class="flex items-start gap-4">
            <div class="w-10 h-10 rounded-xl bg-primary/10 border border-primary/20 flex items-center justify-center shrink-0 mt-0.5">
              <span class="material-symbols-outlined text-primary text-[18px]" style="font-variation-settings:'FILL' 1">local_shipping</span>
            </div>
            <div class="flex-1">
              <h3 class="font-bold text-on-surface text-[15px] mb-1">Online rendelés — GLS futár</h3>
              <p class="text-on-surface-variant text-[13px] leading-relaxed mb-4">Magyarország egész területére szállítunk. 20 000 Ft felett ingyenes a kiszállítás.</p>
              <div class="grid grid-cols-3 gap-3 mb-4">
                <div class="text-center">
                  <p class="text-primary font-extrabold text-[15px]">2–3</p>
                  <p class="text-on-surface-variant text-[11px] leading-tight">munkanap feldolgozás</p>
                </div>
                <div class="text-center border-x border-outline-variant/15">
                  <p class="text-primary font-extrabold text-[15px]">+1 nap</p>
                  <p class="text-on-surface-variant text-[11px] leading-tight">GLS kiszállítás</p>
                </div>
                <div class="text-center">
                  <p class="text-primary font-extrabold text-[15px]">20 e Ft</p>
                  <p class="text-on-surface-variant text-[11px] leading-tight">felett ingyenes</p>
                </div>
              </div>
              <a href="<?php echo esc_url( $shop_url ); ?>"
                 class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full text-white font-label-caps text-[11px] uppercase tracking-widest hover:brightness-110 hover:shadow-[0_0_20px_rgba(255,87,34,0.35)] transition-all"
                 style="background:linear-gradient(135deg,#ff5722 0%,#ff8a65 100%)">
                <span class="material-symbols-outlined text-[15px]">shopping_bag</span>
                Webshop megnyitása
              </a>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>

<script>
// Fade-up IntersectionObserver
document.querySelectorAll('.fade-up').forEach(el => {
  new IntersectionObserver(([e]) => {
    if (e.isIntersecting) { el.classList.add('visible'); }
  }, { threshold: 0.15 }).observe(el);
});

// Hero parallax
(function() {
  const img = document.getElementById('hero-img');
  if (!img) return;
  window.addEventListener('scroll', () => {
    const y = window.scrollY * 0.35;
    img.style.transform = `scale(1.05) translateY(${y}px)`;
  }, { passive: true });
})();
</script>

<?php get_footer(); ?>
