<!doctype html>
<?php
// Ensure the session is started
if (session_id()) {
    // Retrieve UTM parameters from the session
    $utm_source = isset($_SESSION['utm_source']) ? $_SESSION['utm_source'] : 'Not set';
    $utm_medium = isset($_SESSION['utm_medium']) ? $_SESSION['utm_medium'] : 'Not set';
    $utm_campaign = isset($_SESSION['utm_campaign']) ? $_SESSION['utm_campaign'] : 'Not set';
    $utm_term = isset($_SESSION['utm_term']) ? $_SESSION['utm_term'] : 'Not set';
    $utm_content = isset($_SESSION['utm_content']) ? $_SESSION['utm_content'] : 'Not set';
}
?>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=2.0, user-scalable=yes">
    <?php wp_head(); ?>
    <?php
// Preload desktop hero from the front page ACF (adjust field path if needed)
$bgHeadSrc = $bgHeadSrcset = null;
if (function_exists('get_field') && is_front_page()) {
    $front_id = (int) get_option('page_on_front');
    $acfHero  = $front_id ? get_field('background', $front_id) : null; // <-- change 'background' if your field name differs
    $img      = is_array($acfHero) ? ($acfHero['image'] ?? $acfHero) : null;

    if (is_array($img)) {
        $bgHeadSrc = $img['sizes']['2048x2048'] ?? ($img['url'] ?? null);
        $parts = [];
        foreach (['1024x1024','1536x1536','2048x2048'] as $s) {
            if (!empty($img['sizes'][$s])) {
                $w = $img['sizes']["{$s}-width"] ?? null;
                if ($w) { $parts[] = $img['sizes'][$s] . ' ' . (int)$w . 'w'; }
            }
        }
        if ($parts) { $bgHeadSrcset = implode(', ', $parts); }
    }
}
?>
<?php if ($bgHeadSrc): ?>
<link rel="preload" as="image" href="<?= esc_url($bgHeadSrc) ?>" imagesizes="100vw" <?php if ($bgHeadSrcset): ?>imagesrcset="<?= esc_attr($bgHeadSrcset) ?>"<?php endif; ?>>
<?php endif; ?>

<link rel="preload" as="image" href="<?= esc_url( get_stylesheet_directory_uri() . '/resources/images/Mobile.png' ) ?>" imagesizes="100vw">

</head>

<body <?php body_class(); ?>>
    
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KCXSDZJ"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <?php wp_body_open(); ?>
    <?php do_action('get_header'); ?>

    <div id="app">
        <?php echo view(app('sage.view'), app('sage.data'))->render(); ?>
    </div>

    <?php do_action('get_footer'); ?>
    <?php wp_footer(); ?>
    <script defer>(function(d){var s = d.createElement("script");s.setAttribute("data-account", "hFkhmq6KhJ");s.setAttribute("src", "https://cdn.userway.org/widget.js");(d.body || d.head).appendChild(s);})(document)</script><noscript>Please ensure Javascript is enabled for purposes of <a href="https://userway.org">website accessibility</a></noscript>
</body>
</html>
