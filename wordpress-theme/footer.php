<!-- ══════════════════ FOOTER ══════════════════ -->
<footer class="bg-surface-container-lowest border-t border-outline-variant/15 pt-14 pb-10">
  <div class="max-w-[1280px] mx-auto px-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-10 md:gap-16 mb-12">

      <!-- Márka -->
      <div>
        <div class="flex items-center gap-3 mb-4">
          <?php if ( has_custom_logo() ) :
            $logo_id  = get_theme_mod( 'custom_logo' );
            $logo_url = wp_get_attachment_image_url( $logo_id, 'full' );
          ?>
          <img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php bloginfo( 'name' ); ?>" style="height:40px;width:auto;object-fit:contain;">
          <?php else : ?>
          <span class="font-display-lg-mobile text-[15px] font-extrabold text-primary tracking-tight leading-none"><?php bloginfo( 'name' ); ?></span>
          <?php endif; ?>
        </div>
        <p class="text-on-surface-variant text-[13px] leading-relaxed max-w-[26ch] mb-5">
          Kézzel készített prémium chili szószok, kis szériás gyártással, Bajáról.
        </p>
        <div class="flex items-center gap-3">
          <a href="https://www.instagram.com/chillibaja/" target="_blank" rel="noopener" aria-label="Instagram"
             class="w-9 h-9 rounded-full border border-outline-variant/22 flex items-center justify-center text-on-surface-variant hover:text-primary hover:border-primary/38"
             style="transition:color 140ms ease,border-color 140ms ease">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
          </a>
          <a href="https://www.facebook.com/bajaiokoporta/" target="_blank" rel="noopener" aria-label="Facebook"
             class="w-9 h-9 rounded-full border border-outline-variant/22 flex items-center justify-center text-on-surface-variant hover:text-primary hover:border-primary/38"
             style="transition:color 140ms ease,border-color 140ms ease">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
          </a>
          <a href="mailto:chillibaja@gmail.com" aria-label="E-mail"
             class="w-9 h-9 rounded-full border border-outline-variant/22 flex items-center justify-center text-on-surface-variant hover:text-primary hover:border-primary/38"
             style="transition:color 140ms ease,border-color 140ms ease">
            <span class="material-symbols-outlined text-[16px]">mail</span>
          </a>
        </div>
      </div>

      <!-- Linkek -->
      <div>
        <h4 class="font-label-caps text-[11px] uppercase tracking-widest text-on-surface mb-5">Információ</h4>
        <ul class="space-y-3 text-on-surface-variant text-[13px]">
          <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="hover:text-primary transition-colors duration-150">Főoldal</a></li>
          <?php if ( function_exists( 'wc_get_page_id' ) ) : ?>
          <li><a href="<?php echo get_permalink( wc_get_page_id( 'shop' ) ); ?>" class="hover:text-primary transition-colors duration-150">Webshop</a></li>
          <?php endif; ?>
          <li><a href="<?php echo esc_url( home_url( '/#rolunk' ) ); ?>" class="hover:text-primary transition-colors duration-150">Rólunk</a></li>
          <li><a href="<?php echo esc_url( home_url( '/#helyszinek' ) ); ?>" class="hover:text-primary transition-colors duration-150">Piaci helyszínek</a></li>
        </ul>
      </div>

      <!-- Jogi linkek -->
      <div>
        <h4 class="font-label-caps text-[11px] uppercase tracking-widest text-on-surface mb-5">Jogi információk</h4>
        <ul class="space-y-3 text-on-surface-variant text-[13px]">
          <li><a href="<?php echo esc_url( get_privacy_policy_url() ); ?>" class="hover:text-primary transition-colors duration-150">Adatvédelmi tájékoztató</a></li>
          <li><a href="<?php echo esc_url( home_url( '/aszf' ) ); ?>" class="hover:text-primary transition-colors duration-150">ÁSZF</a></li>
          <?php if ( function_exists( 'wc_get_page_id' ) ) : ?>
          <li><a href="<?php echo get_permalink( wc_get_page_id( 'terms' ) ); ?>" class="hover:text-primary transition-colors duration-150">Szállítási feltételek</a></li>
          <?php endif; ?>
        </ul>
      </div>
    </div>

    <!-- Copyright -->
    <div class="border-t border-outline-variant/15 pt-8 flex flex-col md:flex-row items-center justify-between gap-4">
      <p class="text-on-surface-variant text-xs">
        &copy; <?php echo date( 'Y' ); ?> <?php bloginfo( 'name' ); ?> Artisanal Hot Sauce. Kézzel készítve, szenvedéllyel.
      </p>
      <p class="text-on-surface-variant text-xs">🌶️ Kézműves termékek Bajáról</p>
    </div>
  </div>
</footer>

<?php wp_footer(); ?>
<script>
// Értesítések automatikus eltüntetése 4 másodperc után
function chiliAutoHideNotices() {
  const notices = document.querySelectorAll('.woocommerce-notices-wrapper');
  notices.forEach(function(notice) {
    setTimeout(function() {
      notice.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
      notice.style.opacity = '0';
      notice.style.transform = 'translateX(-50%) translateY(20px)';
      setTimeout(function() { notice.style.display = 'none'; }, 500);
    }, 4000);
  });
}
document.addEventListener('DOMContentLoaded', chiliAutoHideNotices);
// AJAX kosárba rakás utáni értesítésekre is
jQuery(document.body).on('added_to_cart', function() {
  setTimeout(chiliAutoHideNotices, 100);
});
</script>
</body>
</html>
