<?php
/**
 * Termékoldal – WooCommerce template override
 */
get_header();
the_post();
global $product;
?>

<div class="min-h-screen bg-surface">

  <!-- Breadcrumb -->
  <div class="max-w-7xl mx-auto px-6 pt-8 pb-2">
    <?php woocommerce_breadcrumb(); ?>
  </div>

  <!-- Termék főrész -->
  <div class="max-w-7xl mx-auto px-6 py-10">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-start">

      <!-- Bal: kép (WooCommerce gallery – zoom + lightbox) -->
      <div class="woocommerce rounded-2xl overflow-hidden bg-surface-container">
        <?php woocommerce_show_product_images(); ?>
      </div>

      <!-- Jobb: adatok -->
      <div class="flex flex-col gap-6">

        <!-- Kategória -->
        <?php $cats = get_the_terms( get_the_ID(), 'product_cat' ); ?>
        <?php if ( $cats && ! is_wp_error( $cats ) ) : ?>
          <p class="text-xs font-semibold uppercase tracking-widest text-primary">
            <?php echo esc_html( $cats[0]->name ); ?>
          </p>
        <?php endif; ?>

        <!-- Cím -->
        <h1 class="font-serif text-3xl md:text-4xl font-bold text-on-surface leading-tight">
          <?php the_title(); ?>
        </h1>

        <!-- Ár -->
        <div class="text-2xl font-bold text-primary">
          <?php echo $product->get_price_html(); ?>
        </div>

        <!-- Rövid leírás -->
        <?php if ( $product->get_short_description() ) : ?>
          <div class="text-on-surface-variant font-body-lg leading-relaxed">
            <?php echo wp_kses_post( $product->get_short_description() ); ?>
          </div>
        <?php endif; ?>

        <!-- Kosár gomb -->
        <div class="woocommerce">
          <?php woocommerce_template_single_add_to_cart(); ?>
        </div>

        <!-- Meta (cikkszám, kategória, márka) -->
        <div class="pt-4 border-t border-outline-variant/20 text-sm text-on-surface-variant flex flex-col gap-1">
          <?php if ( $product->get_sku() ) : ?>
            <p>Cikkszám: <span class="text-on-surface"><?php echo esc_html( $product->get_sku() ); ?></span></p>
          <?php endif; ?>
          <?php if ( $cats && ! is_wp_error( $cats ) ) : ?>
            <p>Kategória: <span class="text-primary"><?php echo esc_html( $cats[0]->name ); ?></span></p>
          <?php endif; ?>
        </div>

      </div>
    </div>

    <!-- Leírás fül -->
    <?php if ( $product->get_description() ) : ?>
    <div class="mt-16 border-t border-outline-variant/20 pt-10">
      <h2 class="font-serif text-2xl font-bold text-on-surface mb-6">Leírás</h2>
      <div class="prose prose-invert max-w-none text-on-surface-variant font-body-lg leading-relaxed">
        <?php echo wp_kses_post( $product->get_description() ); ?>
      </div>
    </div>
    <?php endif; ?>

    <!-- Kapcsolódó termékek -->
    <?php
    $related = wc_get_related_products( get_the_ID(), 4 );
    if ( $related ) :
      $related_products = array_map( 'wc_get_product', $related );
    ?>
    <div class="mt-16 border-t border-outline-variant/20 pt-10">
      <h2 class="font-serif text-2xl font-bold text-on-surface mb-8">Kapcsolódó termékek</h2>
      <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
        <?php foreach ( $related_products as $rel ) :
          if ( ! $rel ) continue; ?>
        <a href="<?php echo esc_url( get_permalink( $rel->get_id() ) ); ?>"
           class="group bg-surface-container rounded-2xl overflow-hidden border border-outline-variant/10 hover:border-primary/30 transition-colors duration-200">
          <div class="aspect-square bg-surface-container-high overflow-hidden">
            <?php echo $rel->get_image( 'medium', [ 'class' => 'w-full h-full object-contain p-4 group-hover:scale-105 transition-transform duration-300' ] ); ?>
          </div>
          <div class="p-4">
            <p class="text-on-surface font-semibold text-sm leading-tight mb-2 group-hover:text-primary transition-colors">
              <?php echo esc_html( $rel->get_name() ); ?>
            </p>
            <p class="text-primary font-bold text-sm"><?php echo $rel->get_price_html(); ?></p>
          </div>
        </a>
        <?php endforeach; ?>
      </div>
    </div>
    <?php endif; ?>

  </div>
</div>

<?php get_footer(); ?>
