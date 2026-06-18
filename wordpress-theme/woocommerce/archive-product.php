<?php
/**
 * Webshop főoldal (terméklista) – WooCommerce template override
 */
get_header();
?>

<!-- ══════════════════ SHOP HERO ══════════════════ -->
<section class="relative py-8 md:py-16 px-6 bg-[#0e0e0e] border-b border-[#5b4039]/20 overflow-hidden">
  <div class="absolute inset-0 pointer-events-none" aria-hidden="true">
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[600px] h-[200px] bg-[#ff5722]/8 blur-3xl rounded-full"></div>
  </div>
  <div class="max-w-7xl mx-auto relative">
    <p class="text-xs font-semibold uppercase tracking-widest text-[#5b4039] mb-3">Chili Baja</p>
    <h1 class="font-serif text-4xl md:text-5xl font-extrabold text-[#f5ede8] mb-4">Webshop</h1>
    <p class="text-[#8a706a] max-w-lg">
      Kézműves chili szószok és fűszerkeverékek közvetlenül a termelőtől. Szállítás egész Magyarországra.
    </p>
  </div>
</section>

<!-- ══════════════════ SZŰRŐ + TERMÉKEK ══════════════════ -->
<div class="max-w-7xl mx-auto px-6 py-12">

  <?php if ( woocommerce_product_loop() ) : ?>

  <!-- Sorrendezés -->
  <div class="flex flex-wrap items-center justify-between gap-4 mb-8">
    <p class="text-sm text-[#8a706a]">
      <?php woocommerce_result_count(); ?>
    </p>
    <div class="text-sm text-[#8a706a]">
      <?php woocommerce_catalog_ordering(); ?>
    </div>
  </div>

  <!-- Termékkártyák -->
  <?php woocommerce_product_loop_start(); ?>
    <?php woocommerce_product_subcategories(); ?>
    <?php while ( have_posts() ) : the_post(); ?>
      <?php wc_get_template_part( 'content', 'product' ); ?>
    <?php endwhile; ?>
  <?php woocommerce_product_loop_end(); ?>

  <!-- Lapozó -->
  <div class="mt-10">
    <?php woocommerce_pagination(); ?>
  </div>

  <?php else : ?>
  <div class="text-center py-20">
    <span class="material-symbols-outlined text-[64px] text-[#5b4039] mb-4 block">local_fire_department</span>
    <p class="text-[#8a706a]">Jelenleg nincsenek elérhető termékek.</p>
  </div>
  <?php endif; ?>
</div>

<?php get_footer(); ?>
