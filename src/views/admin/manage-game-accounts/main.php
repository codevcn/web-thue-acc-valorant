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
        <button class="p-2 text-gray-400 hover:text-gray-600 transition-colors">
          <i data-lucide="bell" class="w-5 h-5"></i>
        </button>

        <div class="flex items-center gap-3">
          <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-full flex items-center justify-center">
            <i data-lucide="user" class="w-5 h-5 text-white"></i>
          </div>
          <div class="text-sm">
            <div class="font-medium text-gray-900">Dương Anh Tuấn</div>
            <div class="text-gray-500">Administrator</div>
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
        <div class="flex flex-col sm:flex-row gap-4 flex-1">
          <div class="relative flex-1 max-w-md">
            <i data-lucide="search" class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 w-5 h-5"></i>
            <input
              type="text"
              id="searchInput"
              placeholder="Tìm kiếm tài khoản, mã game..."
              class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
          </div>

          <select id="statusFilter" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            <option value="ALL">Tất cả trạng thái</option>
            <option value="AVAILABLE">Có sẵn</option>
            <option value="SOLD">Đã bán</option>
            <option value="PENDING">Chờ xử lý</option>
          </select>

          <select id="rankFilter" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            <option value="ALL">Tất cả rank</option>
            <option value="IRON">Iron</option>
            <option value="BRONZE">Bronze</option>
            <option value="SILVER">Silver</option>
            <option value="GOLD">Gold</option>
            <option value="PLATINUM">Platinum</option>
            <option value="DIAMOND">Diamond</option>
            <option value="IMMORTAL">Immortal</option>
            <option value="RADIANT">Radiant</option>
          </select>
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
            <button class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-colors">
              <i data-lucide="download" class="w-4 h-4"></i>
              Xuất dữ liệu
              <i data-lucide="chevron-down" class="w-4 h-4"></i>
            </button>
            <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-10">
              <button onclick="exportData('csv')" class="w-full text-left px-4 py-2 hover:bg-gray-50 rounded-t-lg">
                Xuất CSV
              </button>
              <button onclick="exportData('excel')" class="w-full text-left px-4 py-2 hover:bg-gray-50 rounded-b-lg">
                Xuất Excel
              </button>
            </div>
          </div>
        </div>
      </div>

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

    <!-- Table -->
    <div class="overflow-x-auto">
      <table class="w-full">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-3 py-3 text-left">
              <input type="checkbox" id="selectAll" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
            </th>
            <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Avatar
            </th>
            <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Tên tài khoản
            </th>
            <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Rank
            </th>
            <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Mã game
            </th>
            <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Trạng thái
            </th>
            <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Mô tả
            </th>
            <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Ngày tạo
            </th>
            <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Loại máy
            </th>
            <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Thao tác
            </th>
          </tr>
        </thead>

        <tbody id="accounts-table-body" class="bg-white divide-y divide-gray-200">
        </tbody>
      </table>
    </div>
  </div>
</main>

<?php require_once __DIR__ . '/add_new_account.php'; ?>
<?php require_once __DIR__ . '/update_account.php'; ?>
<?php require_once __DIR__ . '/view_account.php'; ?>

<?php require_once __DIR__ . '/../../templates/app_loading.php'; ?>