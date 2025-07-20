<div class="bg-[#aae3ff] rounded-2xl px-4 py-2 mx-auto text-black shadow-2xl relative text-[14px] min-[1441px]:text-[20px]">
  <div class="flex items-center justify-center min-[1072px]:flex-nowrap flex-wrap w-full gap-x-8 gap-y-4 max-h-[300px]">
    <div class="flex items-center gap-2 min-w-max">
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
      <span class="text-[1.43em] font-bold">Lọc acc theo:</span>
    </div>

    <!-- Filter items -->
    <div class="grid grid-cols-2 min-[840px]:grid-cols-4 w-full gap-x-8 gap-y-2 max-h-[300px]">
      <!-- Rank -->
      <div id="account-rank-types-container" class="flex-1">
        <p class="text-[1.14em] font-medium mb-1 flex items-center gap-2 pl-1">
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
        <div id="account-rank-types" class="CSS-hover-flash-button cursor-pointer">
          <select id="account-rank-types-select" class="text-[1em] w-full bg-regular-blue-cl cursor-pointer text-white font-bold rounded-lg px-4 py-1.5 text-base focus:outline-none">
            <option value="ALL" class="bg-white text-black">Tất cả loại rank</option>
          </select>
        </div>
      </div>
      <!-- Trạng thái -->
      <div id="account-statuses-container" class="flex-1">
        <p class="text-[1.14em] font-medium mb-1 flex items-center gap-2 pl-1">
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
        <div id="account-statuses" class="CSS-hover-flash-button cursor-pointer">
          <select id="account-statuses-select" class="text-[1em] w-full bg-regular-blue-cl cursor-pointer text-white font-bold rounded-lg px-4 py-1.5 text-base focus:outline-none">
            <option value="ALL" class="bg-white text-black">Tất cả trạng thái</option>
            <option value="Rảnh" class="bg-white text-black">Rảnh</option>
            <option value="Bận" class="bg-white text-black">Bận</option>
            <option value="Check" class="bg-white text-black">Check</option>
          </select>
        </div>
      </div>
      <!-- Loại máy -->
      <div id="account-device-types-container" class="flex-1">
        <p class="text-[1.14em] font-medium mb-1 flex items-center gap-2 pl-1">
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
        <div id="account-device-types" class="CSS-hover-flash-button cursor-pointer">
          <select id="account-device-types-select" class="text-[1em] w-full bg-regular-blue-cl cursor-pointer text-white font-bold rounded-lg px-4 py-1.5 text-base focus:outline-none">
            <option value="ALL" class="bg-white text-black">Tất cả loại máy</option>
            <option value="Tất cả" class="bg-white text-black">Tất cả</option>
            <option value="ALL" class="bg-white text-black">Máy nhà</option>
          </select>
        </div>
      </div>
      <!-- Actions -->
      <div class="w-full">
        <p class="text-[1.14em] font-medium mb-1 items-center gap-2 pl-1 opacity-0 flex">
          <span>Hủy lọc</span>
        </p>
        <button id="cancel-all-filters-btn" class="flex items-center gap-2 text-[1em] w-full h-[35px] bg-red-600 hover:scale-105 text-white rounded-lg px-4 py-1.5 text-base font-medium transition duration-200">
          <svg xmlns="http://www.w3.org/2000/svg" class="lucide lucide-x-icon lucide-x" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M18 6 6 18" />
            <path d="m6 6 12 12" />
          </svg>
          <span>Hủy lọc</span>
        </button>
      </div>
    </div>
  </div>
</div>