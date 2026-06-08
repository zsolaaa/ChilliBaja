<?php
/**
 * Chili Baja téma – functions.php
 */

// WooCommerce támogatás bejelentése
add_action( 'after_setup_theme', function() {
    add_theme_support( 'woocommerce' );
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', [ 'search-form', 'comment-form', 'gallery', 'caption' ] );
} );

// Stílusok és scriptek betöltése
add_action( 'wp_enqueue_scripts', function() {
    // Google Fonts
    wp_enqueue_style(
        'chili-fonts',
        'https://fonts.googleapis.com/css2?family=Literata:ital,wght@0,400;0,700;0,800;1,400&family=Work+Sans:wght@400;500;700&display=swap',
        [],
        null
    );
    wp_enqueue_style(
        'chili-icons',
        'https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap',
        [],
        null
    );

    // Tailwind CDN (fejlesztési fázisban – élesítés előtt cseréld ki build-re)
    wp_enqueue_script(
        'tailwind-cdn',
        'https://cdn.tailwindcss.com?plugins=forms,container-queries',
        [],
        null,
        false
    );

    // Tailwind design token konfig – pontosan az eredeti HTML-ből
    wp_add_inline_script( 'tailwind-cdn', '
tailwind.config = {
  darkMode: "class",
  theme: {
    extend: {
      colors: {
        "primary-fixed-dim":        "#ffb5a0",
        "primary":                  "#ffb5a0",
        "surface":                  "#131313",
        "on-primary-container":     "#541200",
        "on-primary":               "#5f1500",
        "tertiary":                 "#f8b6b2",
        "background":               "#131313",
        "on-tertiary-container":    "#461e1d",
        "surface-container":        "#201f1f",
        "surface-container-lowest": "#0e0e0e",
        "on-surface":               "#e5e2e1",
        "on-surface-variant":       "#c9a99f",
        "inverse-primary":          "#b02f00",
        "outline":                  "#ab8980",
        "secondary-fixed-dim":      "#ffb3ac",
        "secondary-container":      "#a40213",
        "surface-tint":             "#ffb5a0",
        "surface-container-highest":"#353534",
        "primary-fixed":            "#ffdbd1",
        "on-primary-fixed-variant": "#862200",
        "secondary":                "#ffb3ac",
        "outline-variant":          "#5b4039",
        "on-background":            "#e5e2e1",
        "primary-container":        "#ff5722",
        "surface-variant":          "#353534",
        "surface-container-low":    "#1c1b1b",
        "surface-dim":              "#131313",
        "surface-container-high":   "#2a2a2a",
        "surface-bright":           "#393939",
      },
      borderRadius: {
        DEFAULT: "0.25rem",
        lg:      "0.5rem",
        xl:      "0.75rem",
        "2xl":   "1rem",
        full:    "9999px"
      },
      fontFamily: {
        "display-lg":        ["Literata"],
        "headline-xl":       ["Literata"],
        "label-caps":        ["Work Sans"],
        "headline-lg":       ["Literata"],
        "body-md":           ["Work Sans"],
        "body-lg":           ["Work Sans"],
        "display-lg-mobile": ["Literata"]
      },
      fontSize: {
        "display-lg":        ["62px", { lineHeight:"1.08", letterSpacing:"-0.02em", fontWeight:"800" }],
        "headline-xl":       ["46px", { lineHeight:"1.2",  fontWeight:"700" }],
        "label-caps":        ["11px", { lineHeight:"1",    letterSpacing:"0.12em", fontWeight:"700" }],
        "headline-lg":       ["28px", { lineHeight:"1.3",  fontWeight:"700" }],
        "body-md":           ["15px", { lineHeight:"1.65", fontWeight:"400" }],
        "body-lg":           ["17px", { lineHeight:"1.65", fontWeight:"400" }],
        "display-lg-mobile": ["36px", { lineHeight:"1.15", fontWeight:"800" }]
      },
      maxWidth: {
        "container-max": "1280px"
      }
    }
  }
};
    ', 'after' );

    // Téma stíluslap
    wp_enqueue_style( 'chili-style', get_stylesheet_uri(), [ 'chili-fonts' ], '1.0.0' );

    // Főoldal JS
    if ( is_front_page() ) {
        wp_enqueue_script(
            'chili-home',
            get_template_directory_uri() . '/assets/js/home.js',
            [],
            '1.0.0',
            true
        );
    }

    // WooCommerce shop JS
    if ( is_shop() || is_product_category() || is_product() ) {
        wp_enqueue_script(
            'chili-shop',
            get_template_directory_uri() . '/assets/js/shop.js',
            [],
            '1.0.0',
            true
        );
    }
} );

// Nav menü regisztráció
add_action( 'after_setup_theme', function() {
    register_nav_menus( [
        'primary' => 'Fő navigáció',
        'footer'  => 'Lábléc navigáció',
    ] );
} );

// WooCommerce: kosár darabszám AJAX frissítés
add_filter( 'woocommerce_add_to_cart_fragments', function( $fragments ) {
    $fragments['span.cart-count'] = '<span class="cart-count">' . WC()->cart->get_cart_contents_count() . '</span>';
    return $fragments;
} );

// WooCommerce: eltávolítjuk az alapértelmezett termék wrapper osztályokat
// hogy a saját grid-ünk érvényesüljön
add_filter( 'woocommerce_before_shop_loop', function() {
    echo '<div class="chili-shop-grid">';
}, 5 );
add_filter( 'woocommerce_after_shop_loop', function() {
    echo '</div>';
}, 5 );
