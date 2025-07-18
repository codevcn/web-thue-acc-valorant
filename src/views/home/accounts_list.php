<div class="bg-gradient-to-br from-sky-50 to-cyan-50 pb-20 pt-16">
  <div class="mx-auto min-[550px]:px-6 px-2">
    <!-- Section Header -->
    <div class="text-center mb-6">
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

    <?php require_once __DIR__ . '/filter_accounts.php'; ?>

    <!-- Account Cards Grid -->
    <div id="accounts-list" class="grid min-[1242px]:grid-cols-1 gap-8 min-[830px]:grid-cols-2 grid-cols-1 mt-8">
    </div>

    <!-- View More Button -->
    <div id="load-more-container" class="QUERY-is-more flex justify-center mt-12 w-full">
      <button id="load-more-btn" class="QUERY-load-more-btn CSS-button-white-line-decoration py-2 px-4">
        XEM THÊM TÀI KHOẢN
      </button>
      <p class="QUERY-no-more-text text-gray-600 italic text-base font-bold">Không còn tài khoản nào.</p>
    </div>
  </div>
</div>

<?php require_once __DIR__ . '/rent_now_modal.php'; ?>