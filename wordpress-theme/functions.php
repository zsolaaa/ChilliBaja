<?php
/**
 * Chili Baja téma – functions.php
 */


// Desktop nav walker
class Chili_Nav_Walker extends Walker_Nav_Menu {
    function start_el( &$output, $data_object, $depth = 0, $args = null, $current_object_id = 0 ) {
        $url   = $data_object->url;
        $title = $data_object->title;
        $output .= '<li><a href="' . esc_url( $url ) . '" class="hover:text-primary transition-colors duration-150">' . esc_html( $title ) . '</a></li>';
    }
}

// Mobil nav walker
class Chili_Mobile_Nav_Walker extends Walker_Nav_Menu {
    function start_el( &$output, $data_object, $depth = 0, $args = null, $current_object_id = 0 ) {
        $url   = $data_object->url;
        $title = $data_object->title;
        $output .= '<a href="' . esc_url( $url ) . '" class="mob-link block font-label-caps text-label-caps uppercase tracking-widest text-on-surface-variant hover:text-primary transition-colors py-2">' . esc_html( $title ) . '</a>';
    }
}

// WooCommerce támogatás bejelentése
add_action( 'after_setup_theme', function() {
    add_theme_support( 'woocommerce' );
    add_theme_support( 'custom-logo', [
        'height'      => 80,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
    ] );
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

    // Tailwind build CSS (statikus, nem CDN – gyors!)
    wp_enqueue_style(
        'tailwind',
        get_template_directory_uri() . '/assets/css/tailwind.css',
        [],
        '1.0.0'
    );

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

    // Mennyiség +/- gombok JS (termékoldalakon)
    if ( is_singular( 'product' ) ) {
        wp_add_inline_script( 'wc-add-to-cart-variation', '
        document.addEventListener("DOMContentLoaded", function() {
            function initQty() {
                document.querySelectorAll(".quantity").forEach(function(wrapper) {
                    if (wrapper.querySelector(".chili-qty-btn")) return;
                    var input = wrapper.querySelector("input.qty");
                    if (!input) return;
                    wrapper.classList.add("chili-qty-wrapper");
                    var minus = document.createElement("button");
                    minus.type = "button";
                    minus.className = "chili-qty-btn";
                    minus.textContent = "−";
                    minus.addEventListener("click", function() {
                        var val = parseInt(input.value) || 1;
                        var min = parseInt(input.getAttribute("min")) || 1;
                        if (val > min) { input.value = val - 1; input.dispatchEvent(new Event("change")); }
                    });
                    var plus = document.createElement("button");
                    plus.type = "button";
                    plus.className = "chili-qty-btn";
                    plus.textContent = "+";
                    plus.addEventListener("click", function() {
                        var val = parseInt(input.value) || 1;
                        var max = parseInt(input.getAttribute("max")) || 9999;
                        if (val < max) { input.value = val + 1; input.dispatchEvent(new Event("change")); }
                    });
                    wrapper.insertBefore(minus, input);
                    wrapper.appendChild(plus);
                });
            }
            initQty();
            document.body.addEventListener("wc_variation_form", initQty);
        });
        ' );
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

// WooCommerce termékek száma soronként
add_filter( 'loop_shop_columns', function() { return 4; } );
add_filter( 'loop_shop_per_page', function() { return 12; } );

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
