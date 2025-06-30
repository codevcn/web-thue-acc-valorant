<!-- Main Content -->
<main class="mx-auto px-4 py-8 bg-gradient-to-br from-regular-from-blue-cl via-regular-via-blue-cl to-regular-to-blue-cl">
  <!-- Controls -->
  <div class="bg-white rounded-lg shadow mb-6">
    <div class="p-6 border-b border-gray-200">
      <div class="flex flex-col lg:flex-row gap-4 justify-between">
        <!-- Search and Filters -->
        <div class="flex flex-col sm:flex-row gap-4 grow">
          <div class="flex-1 w-full relative">
            <input
              type="text"
              id="search-input"
              placeholder="Tìm kiếm theo tên acc, mã game, mô tả..."
              class="w-full pl-4 pr-10 py-2 border border-solid border-gray-300 rounded-lg focus:border-regular-blue-cl focus:outline outline-2 outline-regular-blue-cl" />
            <button id="search-btn" class="absolute right-0 top-1/2 -translate-y-1/2 h-full px-4 text-white rounded-br-lg rounded-tr-lg bg-gradient-to-r from-regular-from-blue-cl to-regular-to-blue-cl cursor-pointer transition-colors">
              <svg xmlns="http://www.w3.org/2000/svg" class="lucide lucide-search-icon lucide-search" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m21 21-4.34-4.34" />
                <circle cx="11" cy="11" r="8" />
              </svg>
            </button>
          </div>

          <button
            id="toggle-filters-btn"
            class="px-4 py-2 border border-solid rounded-lg flex items-center gap-2 border-gray-300 text-gray-700 hover:scale-110 transition">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-funnel-icon lucide-funnel">
              <path d="M10 20a1 1 0 0 0 .553.895l2 1A1 1 0 0 0 14 21v-7a2 2 0 0 1 .517-1.341L21.74 4.67A1 1 0 0 0 21 3H3a1 1 0 0 0-.742 1.67l7.225 7.989A2 2 0 0 1 10 14z" />
            </svg>
            <span>Bộ lọc</span>
            <div id="count-applied-filters" class="px-2 py-[2px] text-sm bg-regular-blue-cl text-white font-semibold rounded-full" hidden>
            </div>
          </button>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-2">
          <button
            id="add-new-account-btn"
            class="bg-gradient-to-r from-regular-from-blue-cl to-regular-to-blue-cl hover:scale-105 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="lucide lucide-plus-icon lucide-plus" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M5 12h14" />
              <path d="M12 5v14" />
            </svg>
            Thêm tài khoản
          </button>

          <div class="relative group">
            <button class="bg-gray-600 hover:scale-105 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition">
              <svg xmlns="http://www.w3.org/2000/svg" class="lucide lucide-download-icon lucide-download" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 15V3" />
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                <path d="m7 10 5 5 5-5" />
              </svg>
              Xuất dữ liệu
              <svg xmlns="http://www.w3.org/2000/svg" class="lucide lucide-chevron-down-icon lucide-chevron-down" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m6 9 6 6 6-6" />
              </svg>
            </button>
            <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-10">
              <button id="export-accounts-table-to-excel-btn" class="w-full text-left px-4 py-2 hover:bg-gray-50 rounded-b-lg">
                Xuất Excel
              </button>
            </div>
          </div>
        </div>
      </div>

      <?php require_once __DIR__ . '/filter_accounts.php'; ?>

      <!-- Bulk Actions -->
      <div id="bulkActions" class="mt-4 p-4 bg-blue-50 rounded-lg border border-blue-200 hidden">
        <div class="flex items-center justify-between">
          <span class="text-sm text-blue-800">
            Đã chọn <span id="selectedCount">0</span> tài khoản
          </span>
          <div class="flex gap-2">
            <button onclick="bulkUpdateStatus('AVAILABLE')" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm transition-colors">
              Đặt có sẵn
            </button>
            <button onclick="bulkUpdateStatus('SOLD')" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm transition-colors">
              Đặt đã bán
            </button>
            <button onclick="bulkDelete()" class="bg-gray-600 hover:bg-gray-700 text-white px-3 py-1 rounded text-sm transition-colors">
              Xóa
            </button>
          </div>
        </div>
      </div>
    </div>

    <?php require_once __DIR__ . '/accounts_table.php'; ?>
  </div>

  <!-- View More Button -->
  <div id="load-more-container" class="QUERY-is-more flex justify-center mt-12 mb-6 w-full">
    <button id="load-more-btn" class="QUERY-load-more-btn CSS-button-blue-decoration py-2 px-4">
      XEM THÊM TÀI KHOẢN
    </button>
    <p class="QUERY-no-more-text text-gray-600 italic text-base font-bold">Không còn tài khoản nào.</p>
  </div>
</main>

<?php require_once __DIR__ . '/../../templates/btn_scroll_to.php'; ?>

<?php require_once __DIR__ . '/add_new_account.php'; ?>
<?php require_once __DIR__ . '/update_account.php'; ?>
<?php require_once __DIR__ . '/delete_account.php'; ?>

<?php require_once __DIR__ . '/../../templates/app_loading.php'; ?>