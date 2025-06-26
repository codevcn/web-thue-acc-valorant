<div class="bg-gradient-to-br from-sky-50 to-cyan-50 py-20">
  <div class="mx-auto px-6">
    <!-- Section Header -->
    <div class="text-center mb-16">
      <h2 class="text-4xl md:text-5xl font-black text-gray-800 mb-4">
        DANH SÁCH
        <span class="text-transparent bg-clip-text bg-gradient-to-r from-sky-500 to-cyan-500 ml-3">
          TÀI KHOẢN
        </span>
      </h2>
      <div class="w-24 h-1 bg-gradient-to-r from-sky-400 to-cyan-400 mx-auto rounded-full mb-6"></div>
      <p class="text-gray-600 text-lg max-w-2xl mx-auto">
        Tuyển chọn những tài khoản chất lượng cao với đầy đủ skin và tướng
      </p>
    </div>

    <div class="flex items-center justify-between text-black mb-8">
      <div class="flex items-center gap-2">
        <img src="/images/icons/icon_filter.svg" alt="Filter Icon" class="w-6 h-6" />
        <span>Bộ lọc</span>
      </div>
      <div class="flex items-center gap-2">
        <div class="relative">
          <label id="listbox-label" class="block text-sm/6 font-medium text-gray-900">Assigned to</label>
          <div class="relative mt-2">
            <button type="button" class="grid w-full cursor-default grid-cols-1 rounded-md bg-white py-1.5 pl-3 pr-2 text-left text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" aria-haspopup="listbox" aria-expanded="true" aria-labelledby="listbox-label">
              <span class="col-start-1 row-start-1 flex items-center gap-3 pr-6">
                <span class="block truncate">Tom Cook</span>
              </span>
              <svg class="col-start-1 row-start-1 size-5 self-center justify-self-end text-gray-500 sm:size-4" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" data-slot="icon">
                <path fill-rule="evenodd" d="M5.22 10.22a.75.75 0 0 1 1.06 0L8 11.94l1.72-1.72a.75.75 0 1 1 1.06 1.06l-2.25 2.25a.75.75 0 0 1-1.06 0l-2.25-2.25a.75.75 0 0 1 0-1.06ZM10.78 5.78a.75.75 0 0 1-1.06 0L8 4.06 6.28 5.78a.75.75 0 0 1-1.06-1.06l2.25-2.25a.75.75 0 0 1 1.06 0l2.25 2.25a.75.75 0 0 1 0 1.06Z" clip-rule="evenodd" />
              </svg>
            </button>
            <ul class="absolute z-10 mt-1 max-h-56 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black/5 focus:outline-none sm:text-sm" tabindex="-1" role="listbox" aria-labelledby="listbox-label" aria-activedescendant="listbox-option-3">
              <li class="relative cursor-default select-none py-2 pl-3 pr-9 text-gray-900" id="listbox-option-0" role="option">
                <div class="flex items-center">
                  <span class="ml-3 block truncate font-normal">Wade Cooper</span>
                </div>
                <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-indigo-600">
                  <svg class="size-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clip-rule="evenodd" />
                  </svg>
                </span>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <!-- Account Cards Grid -->
    <div id="accounts-list" class="grid grid-cols-2 md:grid-cols-1 gap-8">
    </div>

    <!-- View More Button -->
    <div id="load-more-container" class="text-center mt-12">
      <button id="load-more-btn" class="bg-gradient-to-r from-sky-500 to-cyan-600 hover:from-sky-600 hover:to-cyan-700 text-white font-bold py-4 px-8 rounded-xl text-lg transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
        XEM THÊM TÀI KHOẢN
      </button>
    </div>
  </div>
</div>