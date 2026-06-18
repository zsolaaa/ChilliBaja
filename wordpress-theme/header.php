<!DOCTYPE html>
<html <?php language_attributes(); ?> class="dark">
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="theme-color" content="#131313"/>
  <?php wp_head(); ?>
</head>

<body <?php body_class( 'bg-surface text-on-surface font-body-md overflow-x-hidden' ); ?>>
<?php wp_body_open(); ?>

<!-- ══════════════════ HEADER ══════════════════ -->
<header id="site-header" class="fixed top-0 w-full z-50 border-b border-outline-variant/20">
  <div class="absolute inset-0 bg-surface/95 backdrop-blur-md pointer-events-none -z-10" aria-hidden="true"></div>
  <nav class="flex items-center justify-between px-4 max-w-[1280px] mx-auto" style="min-height:64px">

    <!-- Logó bal -->
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex items-center gap-3 shrink-0 mr-auto md:mr-0">
      <?php if ( has_custom_logo() ) : the_custom_logo(); else : ?>
        <span class="font-display-lg-mobile text-[15px] md:text-[21px] font-extrabold text-primary tracking-tight leading-none">
          <?php bloginfo( 'name' ); ?>
        </span>
      <?php endif; ?>
    </a>

    <!-- Desktop navigáció – középen -->
    <?php
    $shop_url = function_exists( 'wc_get_page_id' ) ? get_permalink( wc_get_page_id( 'shop' ) ) : home_url( '/webshop' );
    if ( has_nav_menu( 'primary' ) ) :
      wp_nav_menu( [
        'theme_location' => 'primary',
        'container'      => false,
        'menu_class'     => 'hidden md:flex items-center gap-8 font-label-caps text-label-caps uppercase tracking-widest text-on-surface-variant',
        'link_class'     => 'hover:text-primary transition-colors duration-150',
        'walker'         => new Chili_Nav_Walker(),
      ] );
    else :
    ?>
    <ul class="hidden md:flex items-center gap-8 font-label-caps text-label-caps uppercase tracking-widest text-on-surface-variant">
      <?php
      $links = [
        'Kollekció' => $shop_url,
        'Rólunk'    => home_url( '/#rolunk' ),
        'Vélemények'=> home_url( '/#velemenyek' ),
        'Helyszínek'=> home_url( '/#helyszinek' ),
      ];
      foreach ( $links as $label => $url ) : ?>
        <li><a href="<?php echo esc_url( $url ); ?>" class="hover:text-primary transition-colors duration-150"><?php echo esc_html( $label ); ?></a></li>
      <?php endforeach; ?>
    </ul>
    <?php endif; ?>

    <!-- Jobb: kosár + CTA -->
    <div class="hidden md:flex items-center gap-4">
      <?php if ( function_exists( 'WC' ) ) : ?>
      <a href="<?php echo esc_url( wc_get_cart_url() ); ?>"
         class="relative text-on-surface-variant hover:text-primary transition-colors duration-150"
         aria-label="Kosár">
        <span class="material-symbols-outlined text-[22px]">shopping_bag</span>
        <?php $count = WC()->cart ? WC()->cart->get_cart_contents_count() : 0; ?>
        <?php if ( $count > 0 ) : ?>
        <span class="absolute -top-2 -right-2 bg-primary-container text-white text-[10px] font-bold w-4 h-4 rounded-full flex items-center justify-center">
          <?php echo esc_html( $count ); ?>
        </span>
        <?php endif; ?>
      </a>
      <?php endif; ?>

      <a id="nav-cta" href="<?php echo esc_url( $shop_url ); ?>"
         class="inline-flex items-center gap-2 px-6 py-2.5 rounded-full bg-primary-container text-white font-label-caps text-label-caps uppercase tracking-widest hover:brightness-110 hover:shadow-[0_0_24px_rgba(255,87,34,0.4)] transition-all duration-150">
        Vásárlás
      </a>
    </div>

    <!-- Mobil: kosár + hamburger -->
    <div class="flex md:hidden items-center gap-4">
      <?php if ( function_exists( 'WC' ) ) : ?>
      <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="relative text-on-surface-variant" aria-label="Kosár">
        <span class="material-symbols-outlined text-[22px]">shopping_bag</span>
        <?php if ( WC()->cart && WC()->cart->get_cart_contents_count() > 0 ) : ?>
        <span class="absolute -top-2 -right-2 bg-primary-container text-white text-[10px] font-bold w-4 h-4 rounded-full flex items-center justify-center">
          <?php echo esc_html( WC()->cart->get_cart_contents_count() ); ?>
        </span>
        <?php endif; ?>
      </a>
      <?php endif; ?>
      <button id="mobile-toggle" aria-label="Menü" aria-expanded="false"
              class="text-on-surface-variant hover:text-primary transition-colors">
        <span class="material-symbols-outlined text-[26px]" id="menu-icon">menu</span>
      </button>
    </div>
  </nav>

  <!-- Mobil lenyíló menü -->
  <div id="mobile-menu"
       class="md:hidden absolute top-full left-0 right-0 bg-surface-container-low border-b border-outline-variant/20 px-6 py-5 flex flex-col gap-1"
       aria-hidden="true">
    <?php if ( has_nav_menu( 'primary' ) ) :
      wp_nav_menu( [
        'theme_location' => 'primary',
        'container'      => false,
        'menu_class'     => 'flex flex-col gap-1',
        'walker'         => new Chili_Mobile_Nav_Walker(),
      ] );
    else :
      $links = [
        'Kollekció' => $shop_url,
        'Rólunk'    => home_url( '/#rolunk' ),
        'Vélemények'=> home_url( '/#velemenyek' ),
        'Helyszínek'=> home_url( '/#helyszinek' ),
      ];
      foreach ( $links as $label => $url ) : ?>
      <a href="<?php echo esc_url( $url ); ?>"
         class="mob-link block font-label-caps text-label-caps uppercase tracking-widest text-on-surface-variant hover:text-primary transition-colors py-2">
        <?php echo esc_html( $label ); ?>
      </a>
    <?php endforeach; endif; ?>
    <a href="<?php echo esc_url( $shop_url ); ?>"
       class="inline-flex mt-2 px-8 py-3 rounded-full bg-primary-container text-white font-label-caps text-label-caps uppercase tracking-widest text-center justify-center">
      Vásárlás
    </a>
  </div>
</header>

<!-- Spacer a fixed headernek -->
<div class="h-[65px]" aria-hidden="true"></div>

<script>
(function() {
  const header = document.getElementById('site-header');
  const toggle = document.getElementById('mobile-toggle');
  const menu   = document.getElementById('mobile-menu');
  const icon   = document.getElementById('menu-icon');

  window.addEventListener('scroll', () => {
    header.classList.toggle('scrolled', window.scrollY > 10);
  }, { passive: true });

  if (toggle) {
    toggle.addEventListener('click', () => {
      const open = menu.classList.toggle('open');
      menu.setAttribute('aria-hidden', String(!open));
      toggle.setAttribute('aria-expanded', String(open));
      icon.textContent = open ? 'close' : 'menu';
    });
  }
})();
</script>
