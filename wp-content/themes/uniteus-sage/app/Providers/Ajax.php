<?php
namespace App\Providers;

class Ajax
{
    public function __construct()
    {
        add_action('wp_ajax_loadmore', [$this, 'loadMoreAjaxHandler']);
        add_action('wp_ajax_nopriv_loadmore', [$this, 'loadMoreAjaxHandler']);
    }

    public function loadMoreAjaxHandler()
    {
        // prepare our arguments for the query
        $post_type = isset($_POST['post_type']) ? $_POST['post_type'] : 'press';
        $bgColor = isset($_POST['bgColor']) ? $_POST['bgColor'] : '';
        $taxonomy = ($post_type == 'post') ? 'category' : 'press_cat';
        $args = json_decode(stripslashes($_POST['query']), true);
        $args2['post_type'] = $post_type;
        $page = $_POST['page'] + 1; // load next page

        $state = isset($_POST['state']) ? $_POST['state'] : '';
        $press_cat = isset($_POST['press_cat']) ? $_POST['press_cat'] : 0;
        $template = isset($_POST['template']) ? $_POST['template'] : 'local-news';

        $bg_color = '';
        $hover_text = '';
        $text_color = 'text-brand';

        if ($bgColor == 'light') {
            $bg_color = 'bg-white';
        }

        if ($bgColor == 'dark') {
            $text_color = 'text-white';
            $hover_text = 'hover:text-blue-400';
        }

        if ($template === 'network-press') {
            $post_type = ['press', 'post'];
        }

        $ppp = isset($_POST['ppp']) ? $_POST['ppp'] : 3;

        if ($state && ('local-news' == $template)) {
            $state = $_REQUEST['state'];
            $state = ucwords($state);
            $press_cat = 'local-news';
        }

        $args2['post_type'] = $post_type;
        $args2['posts_per_page'] = $ppp;
        $args2['paged'] = $page;
        $args2['post_status'] = 'publish';

        if ($template === 'network-press') {
            $args2['tax_query'] = array(
                array(
                    'taxonomy'  => 'states',
                    'field'     => 'slug',
                    'terms'     => array($state),
                    'operator'  => 'IN',
                )
            );
        } else {

            if ($state && ('local-news' == $template)) {
                $args2['tax_query'] = array(
                    'relation' => 'AND',
                    array(
                        'taxonomy'  => 'states',
                        'field'     => 'slug',
                        'terms'     => array($state, 'all'),
                        'operator'  => 'IN',
                    ),
                    array(
                        'taxonomy'  => 'press_cat',
                        'field'     => 'slug',
                        'terms'     => $press_cat,
                    ),
                );

            } else {
                $args2['tax_query'] = array(
                    array(
                        'taxonomy'  => $taxonomy,
                        'field'     => 'term_id',
                        'terms'     => $press_cat,
                    ),
                );
            }
        }

        $ajax_query = new \WP_Query($args2);
        $post_count = 0;
        $more = $page . '|' . $ajax_query->max_num_pages;
        $more_button = true;

        if ($ajax_query->max_num_pages) {
            $more = $page . '|' . $ajax_query->max_num_pages;
        }

        if ($page == $ajax_query->max_num_pages) {
            $more_button = false;
        }

        $html = '';
        if ($ajax_query->have_posts()) {
            $post_count = $ajax_query->post_count;
            if (!$post_count) {
                $more_button = false;
            }
            // run the loop
            while ($ajax_query->have_posts()) {
                $post = $ajax_query->the_post();
                $state_label = '';
                $date = get_the_date('F j, Y');
                $link = get_the_permalink();
                $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
                $thumbnail_alt = '';
                $img_id = get_post_thumbnail_id(get_the_ID());
                $alt_text = get_post_meta($img_id, '_wp_attachment_image_alt', true);
                $external_link = get_field('external_link');
                $pill_bg = true;
                $post_cat = '';
                $default_image = '';
                $thumb_classes = 'object-cover';

                $post_taxonomies = get_the_terms(get_the_ID(), 'category');
                $press_taxonomies = get_the_terms(get_the_ID(), 'press_cat');

                if ($press_taxonomies) {
                    $post_cat = join(', ', wp_list_pluck($press_taxonomies, 'name'));

                    $post_cat_name = $press_taxonomies[0]->name;
                    //$post_cat_link = '/press_cat/' . $press_taxonomies[0]->slug .'/';
                    $post_cat_link = '/press/';
                }

                if ($post_taxonomies) {
                    $post_cat = join(', ', wp_list_pluck($post_taxonomies, 'name'));

                    $post_cat_name = $post_taxonomies[0]->name;
                    $post_cat_link = '/' . $post_taxonomies[0]->slug . '/';
                }

                $post_cat = str_replace('Local News', 'News', $post_cat);
                $post_cat_name = str_replace('Local News', 'News', $post_cat_name);


                if (!$thumbnail_url) {
                    $state_term = get_term_by('name', $state, 'states');
                    if ($state_term) {
                        $default_image = get_field('state_taxonomy_default_image', 'states_' . $state_term->term_id);
                        $thumbnail_url = $default_image['sizes']['medium_large'];
                        $thumbnail_alt = $default_image['alt'];
                        $thumb_classes = 'object-contain p-8';
                    }

                    if ($template === 'network-press') {
                        $thumbnail_url = '/wp-content/themes/uniteus-sage/public/images/unite-us-logo.svg';
                        $thumbnail_alt = '';
                        $thumb_classes = 'object-contain p-8 px-14';
                    }
                }

                if ($external_link) {
                    $link = $external_link;
                }

                $terms = get_the_terms($post, 'states');
                if (!$terms) $terms = [];



                if ((count($terms) > 1) && $state) {
                    foreach ($terms as $term) {
                        //$state_label = $term->name;
                        $state_label = $state;
                    }
                }

                if ((count($terms) === 1)) {
                    foreach ($terms as $term) {
                        $state_label = $term->name;
                        if ($term->slug == 'all' AND $state != '') {
                            $state_label = ucwords(str_replace('-', ' ', $state));
                        }
                        if ($term->slug == 'all' AND $state == '') {
                            $state_label = 'Multistate';
                        }
                    }
                }

                if ((count($terms) > 1) && (!isset($state) OR $state == '')) {
                    $state_label = 'Multistate';
                }
        ?>
<?php if ($template === 'local-news') : ?>
<?php $html .= '
<div class="relative flex flex-col overflow-hidden">
<div class="flex-1 flex flex-col justify-between">
  <div class="flex-1 mt-8 pb-10">';
  ?>
<?php if (!$state_label) {
        $pill_bg = false;
        $state_label = '&nbsp;';
        } ?>
<?php if ($state_label) : ?>
<?php $html .= '
    <p class="leading-normal text-sm font-medium text-action mb-2">
      <span class="inline-block ';
      ?>
<?php
       if ($pill_bg) {


         if ($bgColor == 'dark') {
            $html .= 'bg-action text-white ';
         } else {
            $html .= 'bg-light ';
         }

         }
         ?>
<?php
         $html .= 'font-medium rounded-full font-sm px-[15px] py-1 pill-span">' . $state_label .'
      </span>
    </p>';
    ?>
<?php endif; ?>
<?php $html .= '
    <h3 class="mb-1">'; ?>
    <?php if ($link) {
        $html .= '<a class="' . $text_color . ' no-underline ' . $hover_text . '"
          href="' . $link . '">';
    } ?>
        <?php  $html .=  get_the_title(); ?>
          <?php if ($link) {
            $html .= "</a>";
          } ?>
          <?php
          $html .= '</h3>
    <div>' . $date . '
    </div>
  </div>';
  ?>
<?php
  $html .= '
  <div>
      <a
        class="no-underline text-action font-semibold block"
        href="' . $link . '"
        target="_blank">Read More<span aria-hidden="true" class="ml-1"> &rarr;</span></a>
  </div>
</div>
    </div>';
    ?>
<?php endif; ?>
<?php if ($template === 'national-spotlight') : ?>
        <?php $html .= '<div class="relative flex flex-col rounded-lg shadow-lg overflow-hidden">
            <div class="absolute w-full top-0 p-2 bg-action rounded-t-lg"></div>'; ?>
            <?php if ($thumbnail_url) : ?>
            <?php $html .= '<div class="flex-shrink-0 bg-white border-b-2 border-light">
              <img class="lazy aspect-video w-full object-contain mt-4 p-8 px-14 mx-auto" data-src="' . $thumbnail_url . '" alt="' . $alt_text . '">
            </div>'; ?>
            <?php endif; ?>
            <?php $html .= '<div class="flex-1 bg-white flex flex-col justify-between">
              <div class="flex-1 px-6 pt-7 pb-10">
                <p class="leading-normal text-sm font-medium text-action mb-2">
                  <span class="inline-block bg-light font-medium rounded-full px-[15px] py-1 pill-span">
                    National
                  </span>
                </p>'; ?>
                <?php $html .= '
    <h3 class="mb-1">'; ?>
    <?php if ($link) {
        $html .= '<a class="' . $text_color . ' no-underline hover:' . $hover_text . '"
          href="' . $link . '">';
    } ?>
        <?php  $html .=  get_the_title(); ?>
          <?php if ($link) {
            $html .= "</a>";
          } ?>
          <?php
          $html .= '</h3>
                <div>'
                    . $date . '
                </div>
              </div>
              <div class="bg-light hover:bg-blue-200">
                  <a
                    class="no-underline text-action font-semibold p-6 block"
                    href="' . $link . '"
                    target="_blank">Read More <span class="sr-only">' . get_the_title() . '</span><span aria-hidden="true" class="ml-1"> &rarr;</span></a>
              </div>
            </div>
          </div>'; ?>
        <?php endif; ?>
        <?php if ($template === '1c-event') : ?>
        <?php $html .= '<div class="relative group flex flex-col rounded-lg shadow-lg overflow-hidden">'; ?>
       <?php if ($link) : ?>
        <?php $html .= '<a class="absolute inset-0 z-40"
          class="no-underline text-action"
          href="' . $link . '">
            <span class="sr-only">' . get_the_title() . '</span>
        </a>'; ?>
      <?php endif; ?>
      <?php $html .= '<div class="absolute inset-0 related-gradient opacity-0 group-hover:opacity-100"></div>'; ?>
            <?php $html .= '<div class="absolute w-full top-0 p-2 bg-action rounded-t-lg"></div>'; ?>
            <?php if ($thumbnail_url) : ?>
            <?php $html .= '<div class="flex-shrink-0 bg-white border-b-2 border-light z-10">
              <img class="lazy aspect-video w-full object-cover mx-auto" data-src="' . $thumbnail_url . '" alt="' . $alt_text . '">
            </div>'; ?>
            <?php endif; ?>
            <?php $html .= '<div class="flex-1 bg-white flex flex-col justify-between">
              <div class="flex-1 px-6 pt-7 pb-10 z-10">

                <h3 class="mb-1 group-hover:text-action">' . get_the_title() . '</h3>
                <div>'
                    . $date . '
                </div>

              <div class="flex flex-wrap gap-3 mt-4">
              <div class="inline-flex gap-2 px-2 py-1 justify-center items-start no-underline text-brand hover:shadow-inner border-2 border-pale-blue-dark rounded-[16px]">
                  <span>
                  <svg xmlns="http://www.w3.org/2000/svg" width="19" height="21" viewBox="0 0 19 21" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M5.69991 2.61328C5.17524 2.61328 4.74991 3.061 4.74991 3.61328V4.61328H3.79991C2.75056 4.61328 1.8999 5.50871 1.8999 6.61328V16.6133C1.8999 17.7179 2.75056 18.6133 3.79991 18.6133H15.1999C16.2493 18.6133 17.0999 17.7179 17.0999 16.6133V6.61328C17.0999 5.50871 16.2493 4.61328 15.1999 4.61328H14.2499V3.61328C14.2499 3.061 13.8246 2.61328 13.2999 2.61328C12.7752 2.61328 12.3499 3.061 12.3499 3.61328V4.61328H6.64991V3.61328C6.64991 3.061 6.22458 2.61328 5.69991 2.61328ZM5.69991 7.61328C5.17524 7.61328 4.74991 8.061 4.74991 8.61328C4.74991 9.16557 5.17524 9.61328 5.69991 9.61328H13.2999C13.8246 9.61328 14.2499 9.16557 14.2499 8.61328C14.2499 8.061 13.8246 7.61328 13.2999 7.61328H5.69991Z" fill="#216cff"/>
                  </svg>
                  </span>
                  <span class="text-brand text-sm">
                    <div class="">
                      <span class="mec-start-time">September 15, 2023</span></span>
                    </div>
                  </span>
              </div>

              <div class="inline-flex gap-2 px-2 py-1 justify-center items-start no-underline text-brand hover:shadow-inner border-2 border-pale-blue-dark rounded-[16px]">
                  <span>
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path fill-rule="evenodd" clip-rule="evenodd" d="M10.0014 18C14.1987 18 17.6014 14.4183 17.6014 10C17.6014 5.58172 14.1987 2 10.0014 2C5.804 2 2.40137 5.58172 2.40137 10C2.40137 14.4183 5.804 18 10.0014 18ZM10.9514 6C10.9514 5.44772 10.526 5 10.0014 5C9.47669 5 9.05136 5.44772 9.05136 6V10C9.05136 10.2652 9.15145 10.5196 9.32961 10.7071L12.0166 13.5355C12.3876 13.9261 12.9891 13.9261 13.3601 13.5355C13.7311 13.145 13.7311 12.5118 13.3601 12.1213L10.9514 9.58579V6Z" fill="#216cff"></path>
                    </svg>
                  </span>
                  <span class="text-brand text-sm">
                    <div class="">
                      <span class="mec-start-time">10:00 am</span> - <span class="mec-end-time">11:00 am</span>
                    </div>
                  </span>
              </div>

              <div class="inline-flex gap-2 px-2 py-1 justify-center items-start no-underline text-brand hover:shadow-inner border-2 border-pale-blue-dark rounded-[16px]">
                  <span>
                  <svg width="14" height="17" viewBox="0 0 14 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M11.7634 2.05025C14.3604 4.78392 14.3604 9.21608 11.7634 11.9497L7.06113 16.8995L2.35887 11.9497C-0.238114 9.21608 -0.238114 4.78392 2.35887 2.05025C4.95586 -0.683417 9.16641 -0.683418 11.7634 2.05025ZM7.06148 8.99996C8.11082 8.99996 8.96148 8.10453 8.96148 6.99996C8.96148 5.89539 8.11082 4.99996 7.06148 4.99996C6.01214 4.99996 5.16148 5.89539 5.16148 6.99996C5.16148 8.10453 6.01214 8.99996 7.06148 8.99996Z" fill="#216cff"></path>
                  </svg>
                  </span>
                  <span class="text-brand text-sm">
                    <div class="">
                      <span class="mec-start-time">Virtual</span></span>
                    </div>
                  </span>
              </div>

              </div>
</div>
            </div>
          </div>'; ?>
        <?php endif; ?>
<?php if ($template === 'kh') : ?>
        <?php $html .= '<div class="relative flex flex-col rounded-lg shadow-lg overflow-hidden">'; ?>
            <?php if ($thumbnail_url) : ?>
            <?php $html .= '<div class="flex-shrink-0 bg-white border-b-2 border-light">
              <a
              href="' . $link . '"'; ?>
              <?php if ($external_link) { $html .= ' target="_blank"'; } ?>
              <?php $html .= '><img class="lazy aspect-video w-full object-cover" data-src="' . $thumbnail_url . '" alt="' . $alt_text . '">
              </a>
            </div>'; ?>
            <?php endif; ?>
            <?php $html .= '<div class="flex-1 bg-white flex flex-col justify-between">
              <div class="flex-1 px-6 pt-7 pb-10">
                <p class="leading-normal text-sm font-medium text-action mb-2">
                  <span class="inline-block bg-light font-medium rounded-full px-[15px] py-1 pill-span">
                    ' . get_cat_name($press_cat) . '
                  </span>
                </p>'; ?>
                <?php $html .= '<h3 class="mb-1">
                  <a
                    class="no-underline text-brand"
                    href="' . $link . '"'; ?>
                    <?php if ($external_link) { $html .= ' target="_blank"'; } ?>
                    <?php $html .= '">'
                . get_the_title() .
                  '</a>
              </h3>'; ?>
                <?php $html .= '<div>'
                    . $date . '
                </div>
              </div>
              <div class="bg-light hover:bg-blue-200">
                  <a
                    class="no-underline text-action font-semibold p-6 block"
                    href="' . $link . '"
                    target="_blank">Read More<span aria-hidden="true" class="ml-1"> &rarr;</span></a>
              </div>
            </div>
          </div>'; ?>
        <?php endif; ?>
        <?php if ($template === 'stacked') : ?>
            <?php $html .= '<div class="relative bg-white w-full flex flex-col md:flex-row gap-10 items-center py-6 px-10 rounded-lg border border-gray-300 shadow-lg overflow-hidden">
            <div class="flex-shrink-0">'; ?>
            <?php if ($thumbnail_url) : ?>
                <?php $html .= '<img class="lazy aspect-video max-w-[200px] w-full object-contain mx-auto" data-src="' . $thumbnail_url . '" alt="' . $alt_text . '">'; ?>
                <?php endif; ?>
                <?php $html .= '</div>'; ?>
            <?php $html .= '<div class="flex-1">'; ?>
            <?php $html .= '<h3 class="mb-1">
                  <a
                    class="no-underline text-brand"
                    href="' . $link . '"'; ?>
                    <?php if ($external_link) { $html .= ' target="_blank"'; } ?>
                    <?php $html .= '">'
                . get_the_title() .
                  '</a>
              </h3>
            </div>'; ?>
            <?php $html .= '<div class="flex-shrink-0 w-full md:w-auto">'; ?>
                <?php $html .= '<a
                  class="button button-hollow inline-block w-full md:w-auto font-normal p-6 block"
                  href="' . $link . '"'; ?>
                  <?php if ($external_link) { $html .= ' target="_blank"'; } ?>
                  <?php $html .= '>Read More</a>
            </div>
          </div>'; ?>
        <?php endif; ?>
        <?php if ($template === 'press-releases') : // press release?>
        <?php $html .= '<div class="relative z-10 flex flex-col overflow-hidden">
            <div class="flex-1 flex flex-col justify-between">
              <div class="flex-1 pt-7 pb-10">
                <p class="leading-normal text-sm font-medium text-action mb-2">
                  <span class="inline-block bg-light font-medium rounded-full px-[15px] py-1 pill-span">
                    National
                  </span>
                </p>'; ?>
                <?php $html .= '
    <h3 class="mb-1">'; ?>
    <?php if ($link) {
        $html .= '<a class="' . $text_color . ' no-underline"
          href="' . $link . '">';
    } ?>
        <?php  $html .=  get_the_title(); ?>
          <?php if ($link) {
            $html .= "</a>";
          } ?>
          <?php
          $html .= '</h3>
                <div class="' . $text_color . '">'
                    . $date .
                '</div>
              </div>
              <div>
              <a
        class="no-underline text-action font-semibold block"
        href="' . $link . '"
        target="_blank">Read More<span aria-hidden="true" class="ml-1"> &rarr;</span></a>
  </div>
              </div>
            </div>
          </div>'; ?>
        <?php endif; ?>
        <?php if ($template === 'stacked-2col') : ?>
            <?php $html .= '<div @click.prevent="window.location.href=' . $link . '" class="relative group cursor-pointer bg-white w-full flex flex-col md:flex-row gap-6 items-center p-6 rounded-lg border border-gray-300 shadow-lg overflow-hidden">
              <div class="absolute p-4 flex justify-end inset-0 z-10 rounded-xl group-hover:opacity-0">
                <img class="w-5 h-5" src="' . get_template_directory_uri() . '/resources/images/arrow-diagonal-up.svg" alt="" />
              </div>
              <div class="absolute p-4 flex justify-end inset-0 z-10 rounded-xl opacity-0 group-hover:opacity-100">
                <img class="w-5 h-5" src="' . get_template_directory_uri() . '/resources/images/arrow-diagonal-up-active.svg" alt="" />
              </div>
            <div class="flex-shrink-0">'; ?>
            <?php if ($thumbnail_url) : ?>
                <?php $html .= '<img class="lazy aspect-video max-w-[200px] w-full object-contain mx-auto" data-src="' . $thumbnail_url . '" alt="' . $alt_text . '">'; ?>
                <?php endif; ?>
                <?php $html .= '</div>'; ?>
            <?php $html .= '<div class="flex-1">'; ?>
            <?php $html .= '<h3 class="mb-1">
                  <a
                    class="no-underline text-brand"
                    href="' . $link . '"'; ?>
                    <?php if ($external_link) { $html .= ' target="_blank"'; } ?>
                    <?php $html .= '">'
                . get_the_title() .
                  '</a>
              </h3>
            </div>'; ?>
            <?php $html .= '</div>'; ?>
        <?php endif; ?>
        <?php if ($template === 'network-press') : ?>
        <?php $html .= '<div class="relative flex flex-col rounded-lg shadow-lg overflow-hidden">'; ?>
            <?php if ($thumbnail_url) : ?>
            <?php $html .= '<div class="flex-shrink-0 bg-white border-b-2 border-light">
              <img class="lazy aspect-video w-full ' . $thumb_classes . ' mx-auto" data-src="' . $thumbnail_url . '" alt="' . $thumbnail_alt . '">
            </div>'; ?>
            <?php endif; ?>
            <?php $html .= '<div class="flex-1 bg-white flex flex-col justify-between">
              <div class="flex-1 px-6 pt-7 pb-10">'; ?>
              <?php if ($post_cat): ?>
                <?php $html .= '<a href="' . $post_cat_link . '" class="leading-normal inline-block text-sm font-medium text-action mb-2">
                  <span class="inline-block bg-light font-medium rounded-full px-[15px] py-1 pill-span">
                    ' . $post_cat_name . '
                  </span>
                </p>'; ?>
                <?php endif; ?>
                <?php $html .= '
    <h3 class="mb-1">'; ?>
    <?php if ($link) {
        $html .= '<a class="' . $text_color . ' no-underline ' . $hover_text . '"
          href="' . $link . '">';
    } ?>
        <?php  $html .=  get_the_title(); ?>
          <?php if ($link) {
            $html .= "</a>";
          } ?>
          <?php
          $html .= '</h3>
                <div>'
                    . $date . '
                </div>
              </div>
              <div class="bg-light hover:bg-blue-200">
                  <a
                    class="no-underline text-action flex gap-3 items-center font-semibold p-6"
                    href="' . $link . '"
                    target="_blank">Read More<span aria-hidden="true" class="ml-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="11" viewBox="0 0 13 11" fill="none">
  <path d="M7.875 1.5105L12 5.6355M12 5.6355L7.875 9.7605M12 5.6355L1 5.6355" stroke="#216cff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
                    </span></a>
              </div>
            </div>
          </div>'; ?>
        <?php endif; ?>
<?php
         }
        } else {
            $more_button = false; // no posts
        }
    $data = [
        'count' => $post_count,
        'more' => $more,
        'more_button' => $more_button,
        'html' => $html,
    ];
    echo json_encode($data);
        die(); // exit
    }
}
