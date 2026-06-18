<?php
/**
 * Termékkártya – WooCommerce template override
 */
global $product;
if ( ! $product || ! $product->is_visible() ) return;
?>

<li <?php wc_product_class( 'group flex flex-col bg-surface-container rounded-2xl overflow-hidden border border-outline-variant/10 hover:border-primary/30 transition-colors duration-200', $product ); ?>>

  <!-- Kép -->
  <a href="<?php echo esc_url( get_permalink() ); ?>" class="block overflow-hidden bg-surface-container-high aspect-square">
    <?php if ( has_post_thumbnail() ) : ?>
      <?php the_post_thumbnail( 'medium', [ 'class' => 'w-full h-full object-contain p-4 group-hover:scale-105 transition-transform duration-300' ] ); ?>
    <?php else : ?>
      <div class="w-full h-full flex items-center justify-center">
        <span class="material-symbols-outlined text-[48px] text-on-surface-variant/30">image_not_supported</span>
      </div>
    <?php endif; ?>
  </a>

  <!-- Tartalom -->
  <div class="flex flex-col flex-1 p-4 gap-2">

    <!-- Cím -->
    <a href="<?php echo esc_url( get_permalink() ); ?>"
       class="font-semibold text-sm text-on-surface leading-snug hover:text-primary transition-colors line-clamp-2">
      <?php the_title(); ?>
    </a>

    <!-- Ár -->
    <p class="font-bold text-primary text-sm">
      <?php echo $product->get_price_html(); ?>
    </p>

    <!-- Spacer – ez tolja a gombot alulra -->
    <div class="flex-1"></div>

    <!-- Gomb -->
    <div class="mt-2">
      <?php woocommerce_template_loop_add_to_cart(); ?>
    </div>

  </div>
</li>
