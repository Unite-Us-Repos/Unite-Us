<?php
/**
 * Search & Filter Pro
 *
 * Sample Results Template
 *
 * @package   Search_Filter
 * @author    Ross Morsali
 * @link      https://searchandfilter.com
 * @copyright 2018 Search & Filter
 *
 * Note: these templates are not full page templates, rather
 * just an encaspulation of the your results loop which should
 * be inserted in to other pages by using a shortcode - think
 * of it as a template part
 *
 * This template is an absolute base example showing you what
 * you can do, for more customisation see the WordPress docs
 * and using template tags -
 *
 * http://codex.wordpress.org/Template_Tags
 *
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( $query->have_posts() )
{
	?>



	<div class="mx-auto flex flex-col sm:grid gap-y-6 sm:gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
	<?php
	$i=1;
    $activeCampaign = true;
    $campaignAd     = get_field('campaign_ad', 'options');

    // What page are we actually on?
    $paged = max( 1,
      get_query_var('paged'),
      get_query_var('page'),
      ( isset($_GET['sf_paged']) ? absint($_GET['sf_paged']) : 1 )
    );

    // If we’re beyond page 1, or on any of these templates/archives, turn it off:
    if (
      $paged > 1
      || is_archive()
      || is_page_template('template-studies-data-collection.blade.php')
      || is_page_template('template-company-news.blade.php')
      || is_page_template('template-partnerships.blade.php')
    ) {
      $activeCampaign = false;
    }

  
	while ($query->have_posts())
	{
		$query->the_post();

		?>
		<?php
		$category = get_the_category(get_the_ID());
		foreach ($category as $cat) {
			$category = $cat->cat_name;
			$catSlug = $cat->category_nicename;
		}
        $link = get_the_permalink();
        $external_link = get_field('external_link');

        $target = '';
        if ($external_link) {
            $link = $external_link;
            $target = ' target="_blank"';
        }
        $img_id = get_post_thumbnail_id(get_the_ID());
        $alt_text = get_post_meta($img_id , '_wp_attachment_image_alt', true);
		?>

		<?php if ($activeCampaign && ($i==11)) : ?>
		<div class="bg-brand col-span-2 relative w-full sm:mb-0 mx-auto p-10 flex flex-col rounded-lg shadow-lg overflow-hidden">
            <div class="h-full flex flex-col sm:grid sm:grid-cols-2 gap-8">
                <div class="flex flex-col justify-center order-2 sm:order-1">
                    <div class="text-3xl mb-0 font-extrabold text-white"><?php echo $campaignAd['title']; ?></div>
                    <div class="campaign-description my-6 text-white text-lg">
                        <?php echo $campaignAd['description']; ?>
                    </div>
                    <p>
                        <a href="<?php echo $campaignAd['button_link']; ?>" class="w-full align-middle justify-center sm:w-auto inline-flex bg-action text-white hover:bg-action-dark hover:text-white text-lg font-semibold no-underline line-none px-4 py-2 rounded-full"><?php echo $campaignAd['button_text']; ?></a>
                    </p>
                </div>
                <div class="h-full flex flex-col justify-center">
                    <img class="lazy w-full h-auto" data-src="<?php echo $campaignAd['image']['sizes']['medium_large']; ?>" alt="<?php echo $alt_text; ?>" />
                </div>
            </div>
        </div>
		<?php endif; ?>
		<div class="relative max-w-md w-full sm:mb-0 mx-auto flex flex-col rounded-lg shadow-lg overflow-hidden">
		  <?php if (has_post_thumbnail()) : ?>
		  <div class="flex-shrink-0 bg-white border-b-2 border-light">
            <a href="<?php echo $link; ?>" title="<?php the_title(); ?>">
			    <img class="lazy aspect-video w-full object-cover" data-src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'medium_large') ?>" alt="<?php echo $alt_text; ?>">
            </a>
		  </div>
		  <?php endif ?>
		  <div class="flex-1 bg-white flex flex-col justify-between">
			<div class="flex-1 px-6 pt-7 mb-6">
				<?php if ($category) : ?>
			  <p class="leading-normal text-sm font-medium text-action mb-2">
				<a href="/<?php echo $catSlug ?>/">
				  <span class="inline-block bg-light font-medium rounded-full px-[15px] py-1 pill-span">
					<?php echo $category; ?>
				  </span>
				</a>
			  </p>
			  <?php endif; ?>

			  <h3 class="mb-1">
				  <a
					class="no-underline text-brand"
					href="<?php echo $link; ?>" <?php echo $target; ?>>

				<?php the_title(); ?>
				  </a>
			  </h3>
			  <?php echo get_the_date(); ?>
			</div>

			<div class="bg-light hover:bg-blue-200">
				<a
				  class="no-underline text-action font-semibold p-6 block"
                  aria-label="Read More - <?php echo htmlentities(get_the_title()); ?>"
				  href="<?php echo $link; ?>" <?php echo $target; ?>>Read More<span class="sr-only"> - <?php echo get_the_title(); ?></span><span aria-hidden="true" class="ml-1"> &rarr;</span></a>
			</div>
		  </div>
		</div>




				<?php
				$i++;
	}
	?>
</div>







	<div class="pagination relative">
        <?php
			/* example code for using the wp_pagenavi plugin */
			if (function_exists('wp_pagenavi'))
			{
				$navigation = wp_pagenavi(array( 'query' => $query, 'echo' => false));
                $navigation = str_replace('Next Page', 'next', $navigation);
                $navigation = str_replace('Previous Page', 'previous', $navigation);
                echo $navigation;
			}
		?>
	</div>
	<?php
}
else
{
	echo "No Results Found";
}
?>
