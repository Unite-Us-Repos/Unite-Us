@isset ($widget["data_table"])
  @isset($widget["data_table"]['caption'])
    <p class="mb-4">{!! $widget["data_table"]['caption'] !!}</p>
  @endisset
  <div class="flex flex-col">
    <div class="overflow-x-auto">
      <div class="inline-block min-w-full">
        <div class="overflow-hidden md:rounded-md border border-action">
        <table class="acf-data-table divide-y divide-gray-300 overflow-hidden w-full table-auto">
            @isset ($widget["data_table"]['header'])
              <thead class="bg-action">
                <tr>
                  @foreach ($widget["data_table"]['header'] as $th)
                    <th scope="col" class="px-6 py-3 uppercase text-left text-sm align-top font-semibold text-white">
                        {{ $th['c'] }}
                    </th>
                  @endforeach
                </tr>
              </thead>
            @endif

            @isset ($widget["data_table"]['body'])
              <tbody class="bg-white">
                @foreach ($widget["data_table"]['body'] as $index => $tr)
                  @if ($index % 2 == 0)
                    <tr>
                  @else
                    <tr class="bg-light">
                  @endif

                  @foreach ($tr as $i => $td)
                    @if ($i == 0 AND $widget['data_table']['header'][$i]['c'] == '')
                      <th data-label="{{ $widget['data_table']['header'][$i]['c'] }}" class="block text-center font-bold text-lg uppercase align-top px-6 py-3 xl:text-left xl:text-sm xl:font-semibold">
                        {{ $td['c'] }}
                      </th>
                    @else
                      <td data-label="{{ $widget['data_table']['header'][$i]['c'] }}" class="align-center px-6 py-3 text-medium font-medium">
                        {{ $td['c'] }}
                      </td>
                    @endif
                  @endforeach
                  </tr>
                @endforeach
              </tbody>
            @endif
          </table>
          </div>
      </div>
    </div>
  </div>
  @endisset
