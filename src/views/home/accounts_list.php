<div class="bg-gradient-to-br from-sky-50 to-cyan-50 pb-20 pt-16">
  <div class="mx-auto min-[550px]:px-6 px-2">
    <!-- Section Header -->
    <div class="text-center mb-10">
      <h2 class="text-4xl md:text-5xl font-black text-gray-800 mb-4">
        DANH SÁCH
        <span class="text-transparent bg-clip-text bg-gradient-to-r from-sky-500 to-cyan-500">
          TÀI KHOẢN
        </span>
      </h2>
      <div class="w-24 h-1 bg-gradient-to-r from-sky-400 to-cyan-400 mx-auto rounded-full mb-6"></div>
      <p class="text-gray-600 text-lg max-w-2xl mx-auto">
        Tuyển chọn những tài khoản chất lượng cao.
      </p>
    </div>

    <div class="flex flex-col items-center gap-4 text-black mb-12">
      <div class="flex items-center gap-2 text-lg font-bold">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 text-black">
          <path d="M3 6h18" />
          <path d="M7 12h10" />
          <path d="M10 18h4" />
        </svg>
        <span>Lọc acc theo:</span>
      </div>
      <div class="flex items-center flex-wrap gap-2">
        <button id="account-status-btn" class="CSS-button-white-decoration py-1.5 px-4">
          Trạng thái
        </button>
        <button id="account-rank-types-btn" class="CSS-button-white-decoration py-1.5 px-4">
          Rank
        </button>
        <button id="account-device-types-btn" class="CSS-button-white-decoration py-1.5 px-4">
          Loại máy
        </button>
      </div>
    </div>

    <!-- Account Cards Grid -->
    <div id="accounts-list" class="grid min-[1242px]:grid-cols-1 gap-8 min-[830px]:grid-cols-2 grid-cols-1">
    </div>

    <!-- View More Button -->
    <div id="load-more-container" class="QUERY-is-more flex justify-center mt-12 w-full">
      <button id="load-more-btn" class="QUERY-load-more-btn CSS-button-blue-decoration py-2 px-4">
        XEM THÊM TÀI KHOẢN
      </button>
      <p class="QUERY-no-more-text text-gray-600 italic text-base font-bold">Không còn tài khoản nào.</p>
    </div>
  </div>
</div>

<?php require_once __DIR__ . '/account_rank_type_modal.php'; ?>
<?php require_once __DIR__ . '/account_status_modal.php'; ?>
<?php require_once __DIR__ . '/account_device_type_modal.php'; ?>
<?php require_once __DIR__ . '/rent_now_modal.php'; ?>