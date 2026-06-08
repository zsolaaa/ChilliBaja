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

// WooCommerce oldalsáv kikapcsolása
add_filter( 'woocommerce_sidebar', '__return_false' );
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

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

// ── ACF mezők regisztrálása kódból ──────────────────────────────────────────
add_action( 'acf/init', function() {
    if ( ! function_exists( 'acf_add_local_field_group' ) ) return;

    acf_add_local_field_group( [
        'key'      => 'group_chili_fooldal',
        'title'    => 'Főoldal szövegek',
        'location' => [ [ [ 'param' => 'page_type', 'operator' => '==', 'value' => 'front_page' ] ] ],
        'fields'   => [

            // ── HERO ──
            [ 'key' => 'field_hero_tab', 'label' => '🔥 Hero szekció', 'type' => 'tab' ],
            [ 'key' => 'field_hero_badge',    'label' => 'Badge szöveg',   'name' => 'hero_badge',    'type' => 'text',     'default_value' => 'Kézzel készített · Baja · Kis szériás' ],
            [ 'key' => 'field_hero_cim1',     'label' => 'Cím – 1. sor',   'name' => 'hero_cim1',     'type' => 'text',     'default_value' => 'A parázs íze a te' ],
            [ 'key' => 'field_hero_cim2',     'label' => 'Cím – 2. sor (narancssárga)', 'name' => 'hero_cim2', 'type' => 'text', 'default_value' => 'konyhádban.' ],
            [ 'key' => 'field_hero_alcim',    'label' => 'Alcím szöveg',   'name' => 'hero_alcim',    'type' => 'text',     'default_value' => 'Kézzel készített prémium chili szószok Bajáról.' ],
            [ 'key' => 'field_hero_gomb1',    'label' => 'Gomb 1 szöveg',  'name' => 'hero_gomb1',    'type' => 'text',     'default_value' => 'Vásárlás' ],
            [ 'key' => 'field_hero_gomb2',    'label' => 'Gomb 2 szöveg',  'name' => 'hero_gomb2',    'type' => 'text',     'default_value' => 'Hol kapható' ],

            // ── RÓLUNK ──
            [ 'key' => 'field_rolunk_tab', 'label' => '📖 Rólunk szekció', 'type' => 'tab' ],
            [ 'key' => 'field_rolunk_label',  'label' => 'Felső label',     'name' => 'rolunk_label',  'type' => 'text',     'default_value' => 'A mi történetünk' ],
            [ 'key' => 'field_rolunk_cim',    'label' => 'Főcím',           'name' => 'rolunk_cim',    'type' => 'text',     'default_value' => 'A farmtól az asztalig' ],
            [ 'key' => 'field_rolunk_szoveg1','label' => 'Bekezdés 1',      'name' => 'rolunk_szoveg1','type' => 'textarea', 'default_value' => 'A Chili Baja nem csupán egy márka, hanem egy szenvedélyprojekt, amely a bajai Duna-part napsütötte földjein született. Hiszünk abban, hogy a prémium minőség alapja a tisztelet: a föld, a növény és a vásárló iránt.' ],
            [ 'key' => 'field_rolunk_szoveg2','label' => 'Bekezdés 2',      'name' => 'rolunk_szoveg2','type' => 'textarea', 'default_value' => 'Minden egyes üveg szósz kis szériás gyártással készül. Kézzel válogatjuk a paprikákat, és hagyományos, lassú érlelési technikákat alkalmazunk, hogy megőrizzük a chilik eredeti ízvilágát.' ],
            [ 'key' => 'field_rolunk_check1', 'label' => 'Check pont 1',    'name' => 'rolunk_check1', 'type' => 'text',     'default_value' => 'Tartósítószer-mentes receptúra' ],
            [ 'key' => 'field_rolunk_check2', 'label' => 'Check pont 2',    'name' => 'rolunk_check2', 'type' => 'text',     'default_value' => 'Tradicionális eljárások' ],
            [ 'key' => 'field_rolunk_check3', 'label' => 'Check pont 3',    'name' => 'rolunk_check3', 'type' => 'text',     'default_value' => 'Közvetlen kapcsolat a termelőkkel' ],
            [ 'key' => 'field_rolunk_badge',  'label' => 'Badge szám',      'name' => 'rolunk_badge',  'type' => 'text',     'default_value' => '100%' ],
            [ 'key' => 'field_rolunk_badge_szoveg', 'label' => 'Badge szöveg', 'name' => 'rolunk_badge_szoveg', 'type' => 'text', 'default_value' => 'Helyi termesztésű alapanyagok, közvetlen kistermelőktől.' ],

            // ── VÉLEMÉNYEK ──
            [ 'key' => 'field_velemeny_tab', 'label' => '💬 Vélemények', 'type' => 'tab' ],
            [ 'key' => 'field_vel1_szoveg',  'label' => 'Vélemény 1 – szöveg', 'name' => 'vel1_szoveg', 'type' => 'textarea', 'default_value' => '"A Füstös Fenevad az új kedvencem. Nem csak csíp, hanem tényleg íze is van. Érezni rajta a gondos odafigyelést."' ],
            [ 'key' => 'field_vel1_nev',     'label' => 'Vélemény 1 – név',    'name' => 'vel1_nev',    'type' => 'text',     'default_value' => 'Kovács Gábor' ],
            [ 'key' => 'field_vel1_szerep',  'label' => 'Vélemény 1 – szerep', 'name' => 'vel1_szerep', 'type' => 'text',     'default_value' => 'Séf' ],
            [ 'key' => 'field_vel2_szoveg',  'label' => 'Vélemény 2 – szöveg', 'name' => 'vel2_szoveg', 'type' => 'textarea', 'default_value' => '"Végre egy magyar chili, ami nem csak a brutális erőről szól, hanem a gasztronómiai élményről is. A Mézes Méreg zseniális!"' ],
            [ 'key' => 'field_vel2_nev',     'label' => 'Vélemény 2 – név',    'name' => 'vel2_nev',    'type' => 'text',     'default_value' => 'Nagy Emese' ],
            [ 'key' => 'field_vel2_szerep',  'label' => 'Vélemény 2 – szerep', 'name' => 'vel2_szerep', 'type' => 'text',     'default_value' => 'Food Blogger' ],
            [ 'key' => 'field_vel3_szoveg',  'label' => 'Vélemény 3 – szöveg', 'name' => 'vel3_szoveg', 'type' => 'textarea', 'default_value' => '"A kiszállítás gyors volt, a csomagolás prémium. A Hajnali Harag tényleg odaver. Azóta is rendszeresen rendelem."' ],
            [ 'key' => 'field_vel3_nev',     'label' => 'Vélemény 3 – név',    'name' => 'vel3_nev',    'type' => 'text',     'default_value' => 'Molnár Péter' ],
            [ 'key' => 'field_vel3_szerep',  'label' => 'Vélemény 3 – szerep', 'name' => 'vel3_szerep', 'type' => 'text',     'default_value' => 'Vásárló' ],

            // ── HELYSZÍNEK ──
            [ 'key' => 'field_helyszin_tab', 'label' => '📍 Helyszínek', 'type' => 'tab' ],
            [ 'key' => 'field_telefon',      'label' => 'Telefonszám',        'name' => 'telefon',      'type' => 'text', 'default_value' => '+36 30 498 0690' ],
            [ 'key' => 'field_email',        'label' => 'E-mail cím',         'name' => 'email',        'type' => 'text', 'default_value' => 'chillibaja@gmail.com' ],
            [ 'key' => 'field_cim',          'label' => 'Személyes átvétel cím', 'name' => 'cim',       'type' => 'text', 'default_value' => '6500 Baja, Hársfa utca 25.' ],
        ],
    ] );
} );

// ACF helper – visszaadja a mező értékét vagy a default-ot ha ACF nincs/nincs kitöltve
function chili_field( $name, $default = '' ) {
    if ( function_exists( 'get_field' ) ) {
        $val = get_field( $name );
        return ( $val !== false && $val !== '' && $val !== null ) ? $val : $default;
    }
    return $default;
}

// ── WooCommerce: eltávolítjuk az alapértelmezett termék wrapper osztályokat
// hogy a saját grid-ünk érvényesüljön
add_filter( 'woocommerce_before_shop_loop', function() {
    echo '<div class="chili-shop-grid">';
}, 5 );
add_filter( 'woocommerce_after_shop_loop', function() {
    echo '</div>';
}, 5 );
