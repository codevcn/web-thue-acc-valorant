<div class="bg-regular-blue-5 rounded-2xl px-4 py-6 mx-auto text-black shadow-2xl relative">
  <div class="flex justify-between items-center mb-4">
    <div class="flex items-center gap-2">
      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-sliders-horizontal-icon lucide-sliders-horizontal">
        <line x1="21" x2="14" y1="4" y2="4" />
        <line x1="10" x2="3" y1="4" y2="4" />
        <line x1="21" x2="12" y1="12" y2="12" />
        <line x1="8" x2="3" y1="12" y2="12" />
        <line x1="21" x2="16" y1="20" y2="20" />
        <line x1="12" x2="3" y1="20" y2="20" />
        <line x1="14" x2="14" y1="2" y2="6" />
        <line x1="8" x2="8" y1="10" y2="14" />
        <line x1="16" x2="16" y1="18" y2="22" />
      </svg>
      <span class="text-xl font-bold">Lọc acc theo</span>
    </div>
  </div>
  <div class="grid grid-cols-1 min-[610px]:grid-cols-2 min-[860px]:grid-cols-3 gap-x-8 gap-y-4 mb-0 pr-1 CSS-styled-scrollbar max-h-[300px] overflow-y-scroll min-[860px]:overflow-y-auto">
    <!-- Rank -->
    <div id="account-rank-types-container" class="flex-1 min-w-[220px] mb-4">
      <p class="text-lg font-medium mb-1 flex items-center gap-2 pl-1">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="w-5 h-5 text-current fill-current"
          viewBox="0 0 24 24">
          <path
            d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
        </svg>
        <span>Rank</span>
        <svg xmlns="http://www.w3.org/2000/svg" class="Query-active-icon hidden lucide lucide-check-check-icon lucide-check-check" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M18 6 7 17l-5-5" />
          <path d="m22 10-7.5 7.5L13 16" />
        </svg>
      </p>
      <div id="account-rank-types" class="grid grid-cols-2 gap-2">
        <button class="QUERY-cancel-filter-btn CSS-hover-flash-button flex items-center gap-2 bg-[#3674B5] text-white rounded-lg px-4 py-1.5 text-base focus:outline-none ${isActive">
          Tất cả
        </button>
      </div>
    </div>
    <!-- Trạng thái -->
    <div id="account-statuses-container" class="flex-1 min-w-[180px] mb-4">
      <p class="text-lg font-medium mb-1 flex items-center gap-2 pl-1">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          width="20"
          height="20"
          viewBox="0 0 24 24"
          fill="none"
          stroke="currentColor"
          stroke-width="2"
          stroke-linecap="round"
          stroke-linejoin="round"
          class="lucide lucide-chart-no-axes-column-icon lucide-chart-no-axes-column text-current">
          <line x1="18" x2="18" y1="20" y2="10" />
          <line x1="12" x2="12" y1="20" y2="4" />
          <line x1="6" x2="6" y1="20" y2="14" />
        </svg>
        <span>Trạng thái</span>
        <svg xmlns="http://www.w3.org/2000/svg" class="Query-active-icon hidden lucide lucide-check-check-icon lucide-check-check" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M18 6 7 17l-5-5" />
          <path d="m22 10-7.5 7.5L13 16" />
        </svg>
      </p>
      <div id="account-statuses" class="grid grid-cols-2 gap-2">
        <button class="QUERY-cancel-filter-btn CSS-hover-flash-button flex items-center gap-2 bg-[#3674B5] text-white rounded-lg px-4 py-1.5 text-base focus:outline-none ${isActive">
          Tất cả
        </button>
      </div>
    </div>
    <!-- Loại máy -->
    <div id="account-device-types-container" class="flex-1 min-w-[180px] mb-4">
      <p class="text-lg font-medium mb-1 flex items-center gap-2 pl-1">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="w-5 h-5 text-current"
          fill="none"
          stroke="currentColor"
          stroke-width="2"
          viewBox="0 0 24 24">
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M9.75 17L6 21h12l-3.75-4M3 4h18v10H3z" />
        </svg>
        <span>Loại máy</span>
        <svg xmlns="http://www.w3.org/2000/svg" class="Query-active-icon hidden lucide lucide-check-check-icon lucide-check-check" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M18 6 7 17l-5-5" />
          <path d="m22 10-7.5 7.5L13 16" />
        </svg>
      </p>
      <div id="account-device-types" class="grid grid-cols-2 gap-2">
      </div>
    </div>
  </div>
  <!-- Actions -->
  <div class="w-full flex gap-4 justify-end mt-2">
    <button id="cancel-all-filters-btn" class="flex items-center gap-2 bg-red-600 hover:scale-110 text-white rounded-lg px-4 py-1.5 w-max text-base font-medium transition duration-200">
      <svg xmlns="http://www.w3.org/2000/svg" class="lucide lucide-x-icon lucide-x" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M18 6 6 18" />
        <path d="m6 6 12 12" />
      </svg>
      <span>Hủy lọc</span>
    </button>
  </div>
</div>