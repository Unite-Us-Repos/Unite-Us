<?php
/**
 * Search & Filter Pro
 * Results Template — campaign removed; plain 20 posts/page.
 */

if (!defined('ABSPATH')) exit;

if ($query->have_posts()) : ?>

  <div class="mx-auto flex flex-col sm:grid sm:grid-flow-row-dense gap-y-6 sm:gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
    <?php
    $i = 1;

    // Current page (S&F may use sf_paged) — optional debug helper if needed:
    // $paged = max(1, get_query_var('paged'), get_query_var('page'), (isset($_GET['sf_paged']) ? absint($_GET['sf_paged']) : 1));
    // echo '<!-- posts_per_page=' . esc_html($query->get('posts_per_page')) . ' post_count=' . esc_html($query->post_count) . ' found_posts=' . esc_html($query->found_posts) . ' paged=' . esc_html($paged) . ' -->';

    while ($query->have_posts()) :
      $query->the_post();

      $category = get_the_category(get_the_ID());
      foreach ($category as $cat) {
        $category = $cat->cat_name;
        $catSlug  = $cat->category_nicename;
      }

      $link          = get_the_permalink();
      $external_link = get_field('external_link');
      $target        = '';
      if ($external_link) {
        $link   = $external_link;
        $target = ' target="_blank"';
      }

      $img_id   = get_post_thumbnail_id(get_the_ID());
      $alt_text = get_post_meta($img_id, '_wp_attachment_image_alt', true);

      // Image logic
      $img_url    = '';
      $inTheNews  = is_page_template('template-in-the-news.blade.php');
      if (has_post_thumbnail()) {
        $img_url = get_the_post_thumbnail_url(get_the_ID(), 'medium_large');
      } elseif (get_post_type(get_the_ID()) === 'press') {
        if (function_exists('\Roots\asset')) {
          $img_url = \Roots\asset('images/Press-thumb.png')->uri();
        } else {
          $img_url = get_theme_file_uri('images/Press-thumb.png');
        }
        if (!$alt_text) {
          $alt_text = 'Press article';
        }
      }
      $img_fit_class = $inTheNews ? 'object-contain' : 'object-cover';
      ?>

      <div class="relative max-w-md w-full sm:mb-0 mx-auto flex flex-col rounded-lg shadow-lg overflow-hidden">
        <?php if ($img_url) : ?>
          <div class="flex-shrink-0 bg-white border-b-2 border-light">
            <a href="<?php echo esc_url($link); ?>" title="<?php the_title_attribute(); ?>"<?php echo $target; ?>>
              <img class="<?php echo esc_attr('lazy aspect-video w-full ' . $img_fit_class); ?>"
                   data-src="<?php echo esc_url($img_url); ?>"
                   alt="<?php echo esc_attr($alt_text); ?>">
            </a>
          </div>
        <?php endif; ?>

        <div class="flex-1 bg-white flex flex-col justify-between">
          <div class="flex-1 px-6 pt-7 mb-6">
            <?php if ($category): ?>
              <p class="leading-normal text-sm font-medium text-action mb-2">
                <a href="/<?php echo esc_attr($catSlug); ?>/">
                  <span class="inline-block bg-light font-medium rounded-full px-[15px] py-1 pill-span">
                    <?php echo esc_html($category); ?>
                  </span>
                </a>
              </p>
            <?php endif; ?>

            <h3 class="mb-1">
              <a class="no-underline text-brand" href="<?php echo esc_url($link); ?>" <?php echo $target; ?>>
                <?php the_title(); ?>
              </a>
            </h3>
            <?php echo get_the_date(); ?>
          </div>

          <div class="bg-light hover:bg-blue-200">
            <a class="no-underline text-action font-semibold p-6 block"
               aria-label="Read More - <?php echo htmlentities(get_the_title()); ?>"
               href="<?php echo esc_url($link); ?>"
               <?php echo $target; ?>>
              Read More<span class="sr-only"> - <?php echo get_the_title(); ?></span><span aria-hidden="true" class="ml-1"> &rarr;</span>
            </a>
          </div>
        </div>
      </div>

      <?php
      $i++;
    endwhile; ?>
  </div>

  <div class="pagination relative">
    <?php
    if (function_exists('wp_pagenavi')) {
      $navigation = wp_pagenavi(array('query' => $query, 'echo' => false));
      $navigation = str_replace('Next Page', 'next', $navigation);
      $navigation = str_replace('Previous Page', 'previous', $navigation);
      echo $navigation;
    }
    ?>
  </div>

<?php else : ?>
  No Results Found
<?php endif; ?>
