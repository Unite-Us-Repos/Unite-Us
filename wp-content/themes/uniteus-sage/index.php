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
    
    // Output the session variables for debugging
    // echo '<pre>';
    // echo 'UTM Source: ' . $utm_source . '<br>';
    // echo 'UTM Medium: ' . $utm_medium . '<br>';
    // echo 'UTM Campaign: ' . $utm_campaign . '<br>';
    // echo 'UTM Term: ' . $utm_term . '<br>';
    // echo 'UTM Content: ' . $utm_content . '<br>';
    // echo '</pre>';
}
?>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=2.0, user-scalable=yes">
    <?php wp_head(); ?>
    <head>
    @php
        // Check if it's a 'report' post type or a specific category (if using categories)
        $post_type = get_post_type(); // Get the current post type
        $categories = get_the_category(); // Get categories (if needed)
    @endphp

    {{-- Check if it's the 'report' post type or under a specific category --}}
    @if ($post_type === 'post' && has_category('report'))
        @php
            // Fetch ACF author and reading time
            $author_name = get_field('author_name', $post->ID);
            $selected_author = get_field('select_author');
            $selected_author_name = '';
            $author_image_url = '';

            if ($selected_author) {
                $selected_author_name = get_the_title($selected_author);
                $author_image_url = get_the_post_thumbnail_url($selected_author, 'small');
            }

            // Fallback logic for author name
            if (!$selected_author_name && $author_name) {
                $selected_author_name = $author_name;
            }

            // Generate reading time based on your content logic
            $content = '';
            // Add content from WYSIWYG editors and flexible content fields...
            $word_count = str_word_count($content);
            $reading_speed = 200; // words per minute
            $reading_time = ceil($word_count / $reading_speed);
        @endphp

        {{-- OG tags only for 'report' posts --}}
        <meta property="og:title" content="{{ get_the_title() }}" />
        <meta property="og:url" content="{{ get_permalink() }}" />
        <meta property="og:type" content="article" />
        <meta property="og:description" content="@if ($selected_author_name) Written by {{ $selected_author_name }} @endif &bull; Est. reading time {{ $reading_time }} minutes" />
        <meta property="og:image" content="@if ($author_image_url) {{ $author_image_url }} @else {{ get_the_post_thumbnail_url(null, 'large') }} @endif" />

        {{-- Twitter Card Tags --}}
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="{{ get_the_title() }}">
        <meta name="twitter:description" content="@if ($selected_author_name) Written by {{ $selected_author_name }} @endif &bull; Est. reading time {{ $reading_time }} minutes">
        <meta name="twitter:image" content="@if ($author_image_url) {{ $author_image_url }} @else {{ get_the_post_thumbnail_url(null, 'large') }} @endif">
        @endif
    </head>

</head>

<body <?php body_class(); ?>>
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
