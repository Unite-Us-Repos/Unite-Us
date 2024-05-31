@once
@php
if (!isset($state)) {
  $state = '';
}
@endphp
<script type="text/javascript">
jQuery().ready(function($) {
	var dropdown = document.getElementById("cat");
  var loadMoreLocalNewsButton = $("#load-more-local-news");
    function onCatChange() {
        if ( dropdown.options[dropdown.selectedIndex].value != -1 ) {
			loadmore_posts_params.state = dropdown.options[dropdown.selectedIndex].value;
			loadMoreLocalNewsButton.data('current-page', '0');
      var currentPage = parseInt(loadMoreLocalNewsButton.data('current-page'));

			var queryParams = new URLSearchParams(window.location.search);
			queryParams.set("state", dropdown.options[dropdown.selectedIndex].value);
			// Replace current querystring with the new one.
			history.replaceState(null, null, "?"+queryParams.toString());
			var postsContainer = $('#ajax-posts');
      var bgColor = loadMoreLocalNewsButton.data('bg-color');
			postsContainer.html(''); // clear current state items
			smoothScrollingTo('local-news');
			loadMoreLocalNewsButton.show();
        data = {
          'action': 'loadmore',
          'query': loadmore_posts_params.posts,
          'page': currentPage,
		      'state': loadmore_posts_params.state,
          'press_cat': '{{ $category }}',
          'bgColor': bgColor,
        };

    $.ajax({
      url: loadmore_posts_params.ajaxurl, // AJAX handler
	    cache: false,
      data: data,
      type: 'POST',
      beforeSend: function (xhr) {
        loadMoreLocalNewsButton.next('span').text('Loading...'); // change the button text
      },
      success: function (data) {
        var data = JSON.parse(data);
        if (data.more) {
          if (data.more_button) {
            loadMoreLocalNewsButton.html('<span class="mr-4 inline-block">Load More</span> <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M4 2C4.55228 2 5 2.44772 5 3V5.10125C6.27009 3.80489 8.04052 3 10 3C13.0494 3 15.641 4.94932 16.6014 7.66675C16.7855 8.18747 16.5126 8.75879 15.9918 8.94284C15.4711 9.12689 14.8998 8.85396 14.7157 8.33325C14.0289 6.38991 12.1755 5 10 5C8.36507 5 6.91204 5.78502 5.99935 7H9C9.55228 7 10 7.44772 10 8C10 8.55228 9.55228 9 9 9H4C3.44772 9 3 8.55228 3 8V3C3 2.44772 3.44772 2 4 2ZM4.00817 11.0572C4.52888 10.8731 5.1002 11.146 5.28425 11.6668C5.97112 13.6101 7.82453 15 10 15C11.6349 15 13.088 14.215 14.0006 13L11 13C10.4477 13 10 12.5523 10 12C10 11.4477 10.4477 11 11 11H16C16.2652 11 16.5196 11.1054 16.7071 11.2929C16.8946 11.4804 17 11.7348 17 12V17C17 17.5523 16.5523 18 16 18C15.4477 18 15 17.5523 15 17V14.8987C13.7299 16.1951 11.9595 17 10 17C6.95059 17 4.35905 15.0507 3.39857 12.3332C3.21452 11.8125 3.48745 11.2412 4.00817 11.0572Z" fill="#3B8BCA"/></svg>');
          }  else {
            loadMoreLocalNewsButton.hide();
          }
          // insert new posts
          postsContainer.append(data.html);
          lazyLoadInstance.update(); // refresh lazy loading on ajax call
          loadmore_posts_params.current_page++;
          var nextPage = parseInt (currentPage) + 1;
          loadMoreLocalNewsButton.data('current-page', nextPage);
          //if (currentPage == loadmore_posts_params.max_page)
          //loadMoreLocalNewsButton.hide(); // if last page, remove the button
        } else {
		    postsContainer.html('<p>There are currently no press mentions for ' + dropdown.options[dropdown.selectedIndex].text + '.</p>');
        loadMoreLocalNewsButton.hide(); // if no data, remove the button
        }
      },
    });

    //   \\     location.href = "https://uniteus.com/press-2/?state="+dropdown.options[dropdown.selectedIndex].value;
        }
    }
    if (dropdown) {
      dropdown.onchange = onCatChange;
    }
});
</script>
<script>
/**
 * Ajax load posts
 */
function smoothScrollingTo(target){
	const id = target;
	const yOffset = -0;
	const element = document.getElementById(id);
	const y = element.getBoundingClientRect().top + window.pageYOffset + yOffset;

	window.scrollTo({top: y, behavior: 'smooth'});
}
jQuery().ready(function($) {
	  $('.loadmore-posts').on('click', function () {
      var dropdown = document.getElementById("cat");
      var button = $(this);
      var postsContainer = $('#' + $(this).data('ajax-container'));
      var press_cat = button.data('press-cat');
      var press_state = button.data('state');
      var state = '';
      if (typeof dropdown !== 'undefined' && dropdown !== null) {
        state = dropdown.options[dropdown.selectedIndex].value;
      } else if (typeof press_state !== 'undefined' && press_state !== null) {
        state = press_state;
      }
      var template = button.data('template');
      var currentPage = parseInt (button.data('current-page'));
      var ppp = button.data('ppp');
      var bgColor = button.data('bg-color');
      data = {
        'action': 'loadmore',
        'query': loadmore_posts_params.posts,
        'page': currentPage,
        'state': state,
        'press_cat': press_cat,
        'template': template,
        'ppp': ppp,
        'bgColor': bgColor,
        'reset': true
      };

    $.ajax({
      url: loadmore_posts_params.ajaxurl, // AJAX handler
	    cache: false,
      data: data,
      type: 'POST',
      beforeSend: function (xhr) {
        button.html('<span class="mr-4 inline-block">Load More</span> <svg class="animate-spin" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M4 2C4.55228 2 5 2.44772 5 3V5.10125C6.27009 3.80489 8.04052 3 10 3C13.0494 3 15.641 4.94932 16.6014 7.66675C16.7855 8.18747 16.5126 8.75879 15.9918 8.94284C15.4711 9.12689 14.8998 8.85396 14.7157 8.33325C14.0289 6.38991 12.1755 5 10 5C8.36507 5 6.91204 5.78502 5.99935 7H9C9.55228 7 10 7.44772 10 8C10 8.55228 9.55228 9 9 9H4C3.44772 9 3 8.55228 3 8V3C3 2.44772 3.44772 2 4 2ZM4.00817 11.0572C4.52888 10.8731 5.1002 11.146 5.28425 11.6668C5.97112 13.6101 7.82453 15 10 15C11.6349 15 13.088 14.215 14.0006 13L11 13C10.4477 13 10 12.5523 10 12C10 11.4477 10.4477 11 11 11H16C16.2652 11 16.5196 11.1054 16.7071 11.2929C16.8946 11.4804 17 11.7348 17 12V17C17 17.5523 16.5523 18 16 18C15.4477 18 15 17.5523 15 17V14.8987C13.7299 16.1951 11.9595 17 10 17C6.95059 17 4.35905 15.0507 3.39857 12.3332C3.21452 11.8125 3.48745 11.2412 4.00817 11.0572Z" fill="#3B8BCA"/></svg>'); // change the button text
      },
      success: function (data) {
        var data = JSON.parse(data);
        if (data.more) {
          if (data.more_button) {
          button.html('<span class="mr-4 inline-block">Load More</span> <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M4 2C4.55228 2 5 2.44772 5 3V5.10125C6.27009 3.80489 8.04052 3 10 3C13.0494 3 15.641 4.94932 16.6014 7.66675C16.7855 8.18747 16.5126 8.75879 15.9918 8.94284C15.4711 9.12689 14.8998 8.85396 14.7157 8.33325C14.0289 6.38991 12.1755 5 10 5C8.36507 5 6.91204 5.78502 5.99935 7H9C9.55228 7 10 7.44772 10 8C10 8.55228 9.55228 9 9 9H4C3.44772 9 3 8.55228 3 8V3C3 2.44772 3.44772 2 4 2ZM4.00817 11.0572C4.52888 10.8731 5.1002 11.146 5.28425 11.6668C5.97112 13.6101 7.82453 15 10 15C11.6349 15 13.088 14.215 14.0006 13L11 13C10.4477 13 10 12.5523 10 12C10 11.4477 10.4477 11 11 11H16C16.2652 11 16.5196 11.1054 16.7071 11.2929C16.8946 11.4804 17 11.7348 17 12V17C17 17.5523 16.5523 18 16 18C15.4477 18 15 17.5523 15 17V14.8987C13.7299 16.1951 11.9595 17 10 17C6.95059 17 4.35905 15.0507 3.39857 12.3332C3.21452 11.8125 3.48745 11.2412 4.00817 11.0572Z" fill="#3B8BCA"/></svg>'); // change the button text
          } else {
            button.hide();
          }
          // insert new posts
          postsContainer.append(data.html);
          lazyLoadInstance.update(); // refresh lazy loading on ajax call
          //loadmore_posts_params.current_page++;
          var nextPage = currentPage + 1;
          button.data('current-page', nextPage);
          if (currentPage == loadmore_posts_params.max_page)
            button.hide(); // if last page, remove the button
          } else {
            button.hide(); // if no data, remove the button
          }
        }
    });
  });
});
</script>
<script>
jQuery().ready(function($) {
	  $('.network-loadmore-posts').on('click', function () {
      var dropdown = document.getElementById("cat");
      var button = $(this);
      var postsContainer = $('#' + $(this).data('ajax-container'));
      var press_cat = button.data('press-cat');
      var state = '{{ $state }}';
      var template = button.data('template');
      var currentPage = loadmore_posts_params.current_page;
      var ppp = button.data('ppp');
      data = {
        'action': 'loadmore',
        'query': loadmore_posts_params.posts,
        'page': currentPage,
        'state': state,
        'press_cat': press_cat,
        'template': template,
        'ppp': ppp,
        'reset': true
      };

    $.ajax({
      url: loadmore_posts_params.ajaxurl, // AJAX handler
	    cache: false,
      data: data,
      type: 'POST',
      beforeSend: function (xhr) {
        button.html('<span class="mr-4 inline-block">Load More</span> <svg class="animate-spin" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M4 2C4.55228 2 5 2.44772 5 3V5.10125C6.27009 3.80489 8.04052 3 10 3C13.0494 3 15.641 4.94932 16.6014 7.66675C16.7855 8.18747 16.5126 8.75879 15.9918 8.94284C15.4711 9.12689 14.8998 8.85396 14.7157 8.33325C14.0289 6.38991 12.1755 5 10 5C8.36507 5 6.91204 5.78502 5.99935 7H9C9.55228 7 10 7.44772 10 8C10 8.55228 9.55228 9 9 9H4C3.44772 9 3 8.55228 3 8V3C3 2.44772 3.44772 2 4 2ZM4.00817 11.0572C4.52888 10.8731 5.1002 11.146 5.28425 11.6668C5.97112 13.6101 7.82453 15 10 15C11.6349 15 13.088 14.215 14.0006 13L11 13C10.4477 13 10 12.5523 10 12C10 11.4477 10.4477 11 11 11H16C16.2652 11 16.5196 11.1054 16.7071 11.2929C16.8946 11.4804 17 11.7348 17 12V17C17 17.5523 16.5523 18 16 18C15.4477 18 15 17.5523 15 17V14.8987C13.7299 16.1951 11.9595 17 10 17C6.95059 17 4.35905 15.0507 3.39857 12.3332C3.21452 11.8125 3.48745 11.2412 4.00817 11.0572Z" fill="#3B8BCA"/></svg>'); // change the button text
      },
      success: function (data) {
        //success: function (data) {
        var data = JSON.parse(data);
        if (data.more) {
          if (data.more_button) {
          button.html('<span class="mr-4 inline-block">Load More</span> <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M4 2C4.55228 2 5 2.44772 5 3V5.10125C6.27009 3.80489 8.04052 3 10 3C13.0494 3 15.641 4.94932 16.6014 7.66675C16.7855 8.18747 16.5126 8.75879 15.9918 8.94284C15.4711 9.12689 14.8998 8.85396 14.7157 8.33325C14.0289 6.38991 12.1755 5 10 5C8.36507 5 6.91204 5.78502 5.99935 7H9C9.55228 7 10 7.44772 10 8C10 8.55228 9.55228 9 9 9H4C3.44772 9 3 8.55228 3 8V3C3 2.44772 3.44772 2 4 2ZM4.00817 11.0572C4.52888 10.8731 5.1002 11.146 5.28425 11.6668C5.97112 13.6101 7.82453 15 10 15C11.6349 15 13.088 14.215 14.0006 13L11 13C10.4477 13 10 12.5523 10 12C10 11.4477 10.4477 11 11 11H16C16.2652 11 16.5196 11.1054 16.7071 11.2929C16.8946 11.4804 17 11.7348 17 12V17C17 17.5523 16.5523 18 16 18C15.4477 18 15 17.5523 15 17V14.8987C13.7299 16.1951 11.9595 17 10 17C6.95059 17 4.35905 15.0507 3.39857 12.3332C3.21452 11.8125 3.48745 11.2412 4.00817 11.0572Z" fill="#3B8BCA"/></svg>'); // change the button text
          } else {
            button.hide();
          }
          // insert new posts
          postsContainer.append(data.html);
          lazyLoadInstance.update(); // refresh lazy loading on ajax call
          loadmore_posts_params.current_page++;
          button.data('current-page')
          if (loadmore_posts_params.current_page == loadmore_posts_params.max_page)
            button.hide(); // if last page, remove the button
        } else {
          button.hide(); // if no data, remove the button
        }
      },
    });
  });
});
</script>
@endonce
