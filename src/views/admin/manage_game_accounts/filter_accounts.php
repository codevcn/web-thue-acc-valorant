<div id="filters-section" class="bg-white rounded-lg shadow mt-4" hidden>
  <div class="p-6">
    <div class="flex items-center justify-between mb-4">
      <h3 class="text-lg font-medium text-gray-900 flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-funnel-icon lucide-funnel">
          <path d="M10 20a1 1 0 0 0 .553.895l2 1A1 1 0 0 0 14 21v-7a2 2 0 0 1 .517-1.341L21.74 4.67A1 1 0 0 0 21 3H3a1 1 0 0 0-.742 1.67l7.225 7.989A2 2 0 0 1 10 14z" />
        </svg>
        <span>Bộ lọc</span>
      </h3>
      <button
        id="reset-all-filters-btn"
        class="text-sm text-red-600 hover:bg-red-100 flex items-center gap-1 py-1 px-2 rounded transition">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-refresh-cw-icon lucide-refresh-cw">
          <path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8" />
          <path d="M21 3v5h-5" />
          <path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16" />
          <path d="M8 16H3v5" />
        </svg>
        Hoàn tác tất cả
      </button>
    </div>

    <div class="flex gap-4">
      <!-- Status Filter -->
      <div class="grow">
        <label class="block text-sm font-medium text-gray-700 mb-2">Trạng thái</label>
        <select
          id="status-filter-field"
          class="QUERY-statuses-select w-full px-3 py-2 border border-solid border-gray-300 rounded-lg focus:border-regular-blue-cl focus:outline outline-2 outline-regular-blue-cl">
        </select>
      </div>

      <!-- Rank Filter -->
      <div class="grow">
        <label class="block text-sm font-medium text-gray-700 mb-2">Rank</label>
        <select
          id="rank-type-filter-field"
          class="QUERY-rank-types-select w-full px-3 py-2 border border-solid border-gray-300 rounded-lg focus:border-regular-blue-cl focus:outline outline-2 outline-regular-blue-cl">
        </select>
      </div>

      <!-- Device Type Filter -->
      <div class="grow">
        <label class="block text-sm font-medium text-gray-700 mb-2">Loại máy</label>
        <select
          id="device-type-filter-field"
          class="QUERY-device-type-select w-full px-3 py-2 border border-solid border-gray-300 rounded-lg focus:border-regular-blue-cl focus:outline outline-2 outline-regular-blue-cl">
        </select>
      </div>

      <!-- Date Range Filter -->
      <div class="grow-[2]">
        <label class="block text-sm font-medium text-gray-700 mb-2">Thời gian tạo</label>
        <div class="flex gap-2 grow">
          <div class="flex w-1/2 gap-1 items-center">
            <label for="date-from-input" class="text-sm font-medium text-gray-600 min-w-max">Từ ngày</label>
            <input
              type="text"
              class="w-full px-3 py-2 border border-solid border-gray-300 rounded-lg focus:border-regular-blue-cl focus:outline outline-2 outline-regular-blue-cl text-sm"
              id="date-from-filter-field"
              placeholder="Nhập thời gian bắt đầu" />
          </div>
          <div class="flex w-1/2 gap-1 items-center">
            <label for="date-to-input" class="text-sm font-medium text-gray-600 min-w-max">Đến ngày</label>
            <input
              type="text"
              class="w-full px-3 py-2 border border-solid border-gray-300 rounded-lg focus:border-regular-blue-cl focus:outline outline-2 outline-regular-blue-cl text-sm"
              id="date-to-filter-field"
              placeholder="Nhập thời gian kết thúc" />
          </div>
        </div>
      </div>
    </div>

    <!-- Active Filters Display -->
    <div class="mt-4 pt-4 border-t border-gray-200" style="display: none;">
      <div class="flex items-center gap-2 flex-wrap">
        <span class="text-sm text-gray-600">Bộ lọc đang áp dụng:</span>
      </div>
    </div>
  </div>
</div>