export const searchFilters = async () => {
  jQuery().ready(function($) {
    $('body').on('click', '.remove-cat-filter', function() {
      var sThisId = $(this).data('cat-id');
      var isRadio = $(this).hasClass('is-radio');
      $('#' + sThisId).click();
      if (isRadio) {
        $('#' + sThisId).parents('ul').find('.sf-input-radio').eq(0).click();
      }
      });
      $(document).on("sf:ajaxfinish", ".searchandfilter", function() {
        setBadges();
        lazyLoadInstance.update(); // refresh lazy loading on ajax call
      });

      setBadges();

      function setBadges() {
        $('#filterBadges').html('');

        $('.sf-input-checkbox, .sf-input-radio').each(function () {
            var radioClass = '';
            if ($(this).hasClass('sf-input-radio')) {
              radioClass = 'is-radio';
            }
            var sThisVal = (this.checked ? $(this).val() : "");
            var sThisId  = (this.checked ? $(this).attr('id') : "");
            var sThisLabel  = (this.checked ? $(this).next('label').text() : "");
            var badge = '<span data-cat-id="' + sThisId + '" class="remove-cat-filter ' + radioClass + ' inline-flex items-center rounded drop-shadow bg-white py-0.5 pl-2.5 pr-1 text-sm font-medium mr-3">' + sThisLabel + '<button type="button" class="ml-0.5 inline-flex h-4 w-4 flex-shrink-0 items-center justify-center rounded-full hover:bg-blue-200 focus:bg-blue-200 focus:outline-none"><span class="sr-only">Remove ' + sThisVal + '</span><svg class="h-2 w-2 text-action" stroke="currentColor" fill="none" viewBox="0 0 8 8"><path stroke-linecap="round" stroke-width="1.5" d="M1 1l6 6m0-6L1 7" /></svg></button></span>';

            if (sThisVal) {
              $('#filterBadges').append(badge);
            }
        });
      }
  });
}
