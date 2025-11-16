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
<!-- Preconnects (DNS+TLS warmup for slowest external hosts) -->
<link rel="preconnect" href="https://marketing.uniteus.com" crossorigin>
<link rel="dns-prefetch" href="//marketing.uniteus.com">
<link rel="preconnect" href="https://cdn-cookieyes.com" crossorigin>
<link rel="dns-prefetch" href="//cdn-cookieyes.com">
<link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
<link rel="dns-prefetch" href="//cdnjs.cloudflare.com">

<!-- Mobile hero LCP preload -->
<link rel="preload" as="image"
      href="<?= esc_url( get_stylesheet_directory_uri() . '/resources/images/Mobile-412.webp' ) ?>"
      imagesizes="100vw"
      media="(max-width: 767px)">

    <?php wp_head(); ?>
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
