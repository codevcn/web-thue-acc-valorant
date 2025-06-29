<!-- Notification -->
<div id="notification" class="fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg hidden">
  <span id="notification-message"></span>
</div>

<!-- Header -->
<header class="bg-white shadow-sm border-b border-gray-200">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center h-16">
      <div class="flex items-center gap-4">
        <h1 class="text-xl font-bold text-gray-900">Admin Dashboard</h1>
        <span class="text-sm text-gray-500">thueaccvaloranttime.com</span>
      </div>

      <div class="flex items-center gap-4">
        <div class="flex items-center gap-3">
          <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-full flex items-center justify-center">
            <i data-lucide="user" class="w-5 h-5 text-white"></i>
          </div>
          <div class="text-sm">
            <div class="font-medium text-gray-900">Dương Anh Tuấn</div>
            <div class="text-gray-500">Quản trị viên</div>
          </div>
        </div>

        <button class="p-2 text-gray-400 hover:text-red-600 transition-colors">
          <i data-lucide="log-out" class="w-5 h-5"></i>
        </button>
      </div>
    </div>
  </div>
</header>

<!-- Main Content -->
<main class="max-w-7xl mx-auto px-4 py-8">
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
          </button>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-2">
          <button
            id="add-new-account-btn"
            class="bg-gradient-to-r from-regular-from-blue-cl to-regular-to-blue-cl hover:scale-105 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition">
            <i data-lucide="plus" class="w-4 h-4"></i>
            Thêm tài khoản
          </button>

          <div class="relative group">
            <button class="bg-gray-600 hover:scale-105 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition">
              <i data-lucide="download" class="w-4 h-4"></i>
              Xuất dữ liệu
              <i data-lucide="chevron-down" class="w-4 h-4"></i>
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
  <div id="load-more-container" class="QUERY-is-more text-center mt-12 mb-6">
    <button id="load-more-btn" class="QUERY-load-more-btn bg-gradient-to-r from-regular-from-blue-cl to-regular-to-blue-cl text-white font-bold py-4 px-8 rounded-xl text-base transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
      XEM THÊM TÀI KHOẢN
    </button>
    <p class="QUERY-no-more-text text-gray-600 italic text-base font-bold">Không còn tài khoản nào.</p>
  </div>
</main>

<?php require_once __DIR__ . '/add_new_account.php'; ?>
<?php require_once __DIR__ . '/update_account.php'; ?>
<?php require_once __DIR__ . '/delete_account.php'; ?>

<?php require_once __DIR__ . '/../../templates/app_loading.php'; ?>