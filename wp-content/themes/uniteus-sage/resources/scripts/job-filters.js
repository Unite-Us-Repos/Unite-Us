export const jobFilters = async () => {
  (function($, undefined) {
    $.expr[":"].containsNoCase = function(el, i, m) {
        var search = m[3];
        if (!search) return false;
        return new RegExp(search, "i").test($(el).text());
    };

    $.fn.searchFilter = function(options) {
        var opt = $.extend({
            // target selector
            targetSelector: "",
            // number of characters before search is applied
            charCount: 1
        }, options);

        return this.each(function() {
            var $el = $(this);
            $el.keyup(function() {
                var search = $(this).val();

                // remove all pills
                $('#filterBadges').html('');

                var $target = $(opt.targetSelector);
                $target.show();
                $(".gh-result-row").removeClass("gh-hide");
                $(".gh-job-card").removeClass("gh-hide");

                if (search && search.length >= opt.charCount)
                    $target.not(":containsNoCase(" + search + ")").addClass('gh-hide');

                $('.gh-result-row').each(function(index) {
                  var children = $(this).find(".gh-job-card:visible").length;
                  if (!children) {
                    $(this).addClass("gh-hide");
                  }
                });


            });
        });
    };
})(jQuery);



jQuery().ready(function($) {
    $('body').on('click', '.remove-cat-filter', function() {
      var sThisId = $(this).data('gh-filter');
      $('#' + sThisId).click();

      $('.gh-job-card').removeClass('gh-hide');

      $('.gh-result-row').each(function(index) {
        var children = $(this).find(".gh-job-card:not(.gh-hide)").length;
        if (!children) {
          $(this).addClass("gh-hide");
        }
      });


// if not pills reset
var allPills = $(".gh-filter-pill").length;
var officePills = $(".gh-filter-pill.filter-office").length;
if (!allPills) {
  // reset all
  $('.gh-result-row').removeClass('gh-hide');
  $('.gh-job-card').removeClass('gh-hide');
}

    });

    $('.sf-input-checkbox').on("click", function() {
      setBadges();
    });

    function setBadges(sThisType) {
      $('#filterBadges').html('');

      $('.sf-input-checkbox').each(function () {
          var sThisType = $(this).data("filter-type");
          var sThisVal = (this.checked ? $(this).val() : "");
          var sThisId  = (this.checked ? $(this).attr('id') : "");
          var sThisLabel  = (this.checked ? $(this).next('label').text() : "");
          var badge = '<span data-gh-filter="' + sThisId + '" class="gh-filter-pill filter-' + sThisType + ' remove-cat-filter inline-flex items-center rounded drop-shadow bg-white py-0.5 pl-2.5 pr-1 text-sm font-medium mr-3">' + sThisLabel + '<button type="button" class="ml-0.5 inline-flex h-4 w-4 flex-shrink-0 items-center justify-center rounded-full hover:bg-blue-200 focus:bg-blue-200 focus:outline-none"><span class="sr-only">Remove ' + sThisVal + '</span><svg class="h-2 w-2 text-action" stroke="currentColor" fill="none" viewBox="0 0 8 8"><path stroke-linecap="round" stroke-width="1.5" d="M1 1l6 6m0-6L1 7" /></svg></button></span>';

          // clear search keywords
          $("#gh-search").val('');
          $('.gh-job-card').removeClass('gh-hide');

          if (sThisVal) {
            $('#filterBadges').append(badge);
            filterList(sThisVal, this.checked);
          }

          var parent = $(this).parent('li');

          if (this.checked) {
            parent.addClass('sf-option-active');
          } else {
            parent.removeClass('sf-option-active');
          }


      });

      // hide all rows
      $('.gh-result-row').addClass('gh-hide');

      if (!$(".gh-filter-pill.filter-department").length) {
        // hide all job cards
        $('.gh-result-row').removeClass('gh-hide');
        }

      if ($(".gh-filter-pill.filter-office").length) {
        // hide all job cards
        $('.gh-job-card').addClass('gh-hide');
        }


      // loop through office pills
      $(".gh-filter-pill.filter-office").each(function (i) {

       var sThisId = $(this).data('gh-filter');
       $("." + sThisId).removeClass('gh-hide');
      });




      // loop through active pills
      $(".gh-filter-pill").each(function (i) {
        var sThisId = $(this).data('gh-filter');
        // show result row corresponding to pill
        $("." + sThisId).removeClass('gh-hide');
      });

      // hide empty rows
      $('.gh-result-row').each(function() {
        var theResultRow = $(this);
          var children = theResultRow.find(".gh-job-card").length;
          var hiddenChildren = theResultRow.find(".gh-job-card.gh-hide").length;

          if (children === hiddenChildren) {
            theResultRow.addClass("gh-hide");
          }
          });
    }

    // Recruiters filter function
    function filterList(value) {
      // hide all rows
      //$('.gh-result-row').addClass('gh-hide');

      // loop through active pills
      $(".gh-filter-pill").each(function (i) {
        var sThisId = $(this).data('gh-filter');
        $("." + sThisId).removeClass('gh-hide');
		  });



    }

    $("#gh-search").searchFilter({ targetSelector: ".gh-job-card", charCount: 3})

});


}
