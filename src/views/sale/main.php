<div class="relative w-full mx-auto py-12 px-[100px]">
  <div class="text-center mb-10">
    <h2 class="text-4xl md:text-5xl font-black text-gray-800 mb-4">
      DANH SÁCH
      <span class="text-transparent bg-clip-text bg-gradient-to-r from-sky-500 to-cyan-500">
        SALE
      </span>
    </h2>
    <div class="w-24 h-1 bg-gradient-to-r from-sky-400 to-cyan-400 mx-auto rounded-full mb-6"></div>
    <p class="text-gray-600 text-lg max-w-2xl mx-auto">
      Cam kết cung cấp tài khoản Valorant uy tín, chất lượng cao.
    </p>
  </div>

  <!-- Main Slider Container -->
  <div
    id="slider"
    class="relative overflow-hidden cursor-grab active:cursor-grabbing">
    <div
      id="slides-container"
      class="flex transition-transform duration-500 ease-out">
      <?php foreach ($sale_accounts as $sale_account) : ?>
        <div data-account-id="<?= $sale_account['id'] ?>" class="QUERY-account-container w-full flex-shrink-0">
          <div class="text-sm font-medium bg-blue-100 rounded-md px-4 py-1 border-l-4 border-solid border-blue-300 border">
            Sale | <span class="font-bold">00:00:00</span>
          </div>

          <div class="mt-2 rounded-lg">
            <div class="flex items-stretch gap-4">
              <div class="h-[408px] min-w-[700px] w-[700px]">
                <!-- <img class="w-full h-full object-cover" src="/images/sale-accounts/<?= $sale_account['avatar'] ?? 'default-sale-account-avatar.png' ?>" alt="Account Avatar"> -->
                <img class="w-full h-full object-cover" src="/dev/sale-account.png" alt="Account Avatar">
              </div>
              <div class="flex flex-col grow h-[408px]">
                <div class="flex items-center justify-between w-full gap-4 pt-3 pb-2 px-4 text-lg font-bold bg-white/80 backdrop-blur-md border border-solid border-b-0 border-gray-300 rounded-t-md">
                  <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="lucide lucide-text-icon lucide-text" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <path d="M15 18H3" />
                      <path d="M17 6H3" />
                      <path d="M21 12H3" />
                    </svg>
                    <span>Mô tả</span>
                  </div>
                  <button data-vcn-tooltip-content="Copy mô tả" class="QUERY-tooltip-trigger QUERY-copy-btn QUERY-not-copied p-0.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="QUERY-copy-icon lucide lucide-copy-icon lucide-copy" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <rect width="14" height="14" x="8" y="8" rx="2" ry="2" />
                      <path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2" />
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" class="QUERY-copied-icon lucide lucide-check-check-icon lucide-check-check" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <path d="M18 6 7 17l-5-5" />
                      <path d="m22 10-7.5 7.5L13 16" />
                    </svg>
                  </button>
                </div>
                <div class="grow w-full pb-4 px-4 bg-white border border-solid border-t-0 border-gray-300 rounded-b-md whitespace-pre-line overflow-y-auto CSS-styled-vt-scrollbar"><?= $sale_account['description'] ?></div>
                <div class="flex items-center gap-2 mt-4 bg-green-50 border border-solid border-green-300 py-2 px-4 w-full rounded-md">
                  <div class="rounded-full p-0.5 border-[1.5px] border-solid border-black">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="#000" width="20" height="20" viewBox="0 0 32 32">
                      <g>
                        <path d="M19.8,26.1h-0.2c-2.4,0-4.8,0-7.2,0c-0.3,0-0.5-0.1-0.6-0.3c-2.5-3.2-5.1-6.3-7.6-9.5C4.1,16.1,4,16,4,15.8   c0-3.1,0-6.1,0-9.2c0-0.1,0-0.2,0.1-0.2h0.1c5.2,6.5,10.4,13,15.5,19.5c0,0,0,0.1,0.1,0.1L19.8,26.1L19.8,26.1z" />
                        <path d="M27.8,16.3c-0.7,0.9-1.5,1.8-2.2,2.8c-0.2,0.2-0.4,0.3-0.6,0.3c-2.4,0-4.8,0-7.1,0c0,0-0.1,0-0.1,0c-0.1,0-0.2-0.1-0.1-0.2   c0,0,0-0.1,0.1-0.1c2.4-3,4.7-5.9,7.1-8.9c1-1.2,2-2.5,2.9-3.7c0-0.1,0.1-0.1,0.2-0.1c0,0,0.1,0,0.1,0c0,0.1,0,0.1,0,0.2   c0,3,0,6.1,0,9.1C28,16,27.9,16.2,27.8,16.3L27.8,16.3z" />
                      </g>
                    </svg>
                  </div>
                  <span data-vcn-tooltip-content="Giá bán" class="QUERY-tooltip-trigger"><?= $sale_account['price'] ?></span>
                </div>
                <button id="by-now-btn" class="QUERY-buy-now-btn CSS-button-blue-line-decoration min-h-[42px] mt-4">
                  MUA NGAY
                </button>
              </div>
            </div>

            <div class="flex items-stretch gap-2 mt-4">
              <div class="flex flex-col items-center justify-center flex-1 bg-blue-100 border border-solid border-blue-300 border-t-4 rounded-md py-1 px-4">
                <h4 class="text-base font-bold">Gmail</h4>
                <div><?= $sale_account['gmail'] ?></div>
              </div>
              <div class="flex flex-col items-center justify-center flex-1 bg-blue-100 border border-solid border-blue-300 border-t-4 rounded-md py-1 px-4">
                <h4 class="text-base font-bold">Thư</h4>
                <div><?= $sale_account['letter'] ?></div>
              </div>
              <div class="flex flex-col items-center justify-center flex-1 bg-blue-100 border border-solid border-blue-300 border-t-4 rounded-md py-1 px-4">
                <h4 class="text-base font-bold">Tình trạng</h4>
                <div><?= $sale_account['status'] ?></div>
              </div>
              <button class="QUERY-commitment-btn CSS-button-blue-line-decoration text-base font-bold py-1 px-4 flex-1">
                Cam kết
              </button>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- Navigation Buttons -->
  <button
    id="prev-button"
    class="absolute left-4 top-1/2 -translate-y-1/2 bg-white/90 hover:bg-white text-gray-800 p-3 rounded-full shadow-lg transition-all duration-300 hover:scale-110 active:scale-90 z-10">
    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-left-icon lucide-chevron-left">
      <path d="m15 18-6-6 6-6" />
    </svg>
  </button>
  <button
    id="next-button"
    class="absolute right-4 top-1/2 -translate-y-1/2 bg-white/90 hover:bg-white text-gray-800 p-3 rounded-full shadow-lg transition-all duration-300 hover:scale-110 active:scale-90 z-10">
    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right-icon lucide-chevron-right">
      <path d="m9 18 6-6-6-6" />
    </svg>
  </button>

  <!-- Dots Indicator -->
  <div id="pages" class="flex justify-center mt-8 gap-2 CSS-background-dot-decoration w-full py-2 px-4 relative">
    <?php foreach ($sale_accounts as $sale_account) : ?>
      <button data-vcn-tooltip-content="Nhấn để xem chi tiết" class="QUERY-tooltip-trigger h-12 min-w-[90px] border-1 box-content border-solid border-white hover:scale-110 active:scale-90 transition duration-200">
        <img class="h-full min-w-[90px] object-cover box-content" src="/dev/sale-account.png" alt="Account Avatar">
      </button>
    <?php endforeach; ?>

    <div id="counter" class="absolute top-2 right-2 rounded-md bg-white/40 text-center text-white w-fit mx-auto py-0.5 px-2 font-bold">
      <span class="QUERY-current-page">1</span> / <span><?= $slides_count ?></span>
    </div>
  </div>

  <section id="pagination" class="flex justify-center gap-1 items-center mt-6 w-full">

    <!-- Nút Previous -->
    <button
      class="<?= $current_page <= 1 ? 'opacity-60 cursor-not-allowed pointer-events-none' : '' ?> QUERY-prev-btn flex items-center justify-center rounded-md bg-blue-100 border border-solid border-blue-300 h-8 w-8 hover:scale-110 active:scale-90 transition duration-200">
      <svg xmlns="http://www.w3.org/2000/svg" class="text-gray-600 lucide lucide-chevron-left-icon lucide-chevron-left" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="m15 18-6-6 6-6" />
      </svg>
    </button>

    <?php
    function renderPageButton($pageNum, $currentPage)
    {
      $isActive = $pageNum == $currentPage;
      $class = $isActive
        ? 'rounded-md bg-blue-300 text-black font-bold border border-solid border-blue-600 h-8 w-8 hover:scale-110 active:scale-90 transition duration-200'
        : 'rounded-md bg-blue-100 border border-solid border-blue-300 h-8 w-8 hover:scale-110 active:scale-90 transition duration-200';
      echo "<button data-page-num=\"$pageNum\" class=\"$class\">$pageNum</button>";
    }

    $DOT = '<span class="px-2 font-bold">...</span>';

    if ($total_pages <= 7) {
      for ($i = 1; $i <= $total_pages; $i++) {
        renderPageButton($i, $current_page);
      }
    } else {
      renderPageButton(1, $current_page);

      if ($current_page > 3) echo $DOT;

      $start = max(2, $current_page - 1);
      $end = min($total_pages - 1, $current_page + 1);

      for ($i = $start; $i <= $end; $i++) {
        renderPageButton($i, $current_page);
      }

      if ($current_page < $total_pages - 2) echo $DOT;

      renderPageButton($total_pages, $current_page);
    }
    ?>

    <!-- Nút Next -->
    <button
      class="<?= $current_page >= $total_pages ? 'opacity-60 cursor-not-allowed pointer-events-none' : '' ?> QUERY-next-btn flex items-center justify-center rounded-md bg-blue-100 border border-solid border-blue-300 h-8 w-8 hover:scale-110 active:scale-90 transition duration-200">
      <svg xmlns="http://www.w3.org/2000/svg" class="text-gray-600 lucide lucide-chevron-right-icon lucide-chevron-right" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="m9 18 6-6-6-6" />
      </svg>
    </button>
  </section>
</div>

<script>

</script>

<script>
  window.APP_DATA = {
    saleAccounts: <?= json_encode($sale_accounts) ?>,
    slidesCount: <?= $slides_count ?>,
    totalPages: <?= $total_pages ?>,
    currentPage: <?= $current_page ?>,
    limit: <?= $limit ?>
  }
</script>

<?php require_once __DIR__ . '/commitment_modal.php'; ?>

<?php require_once __DIR__ . '/../templates/tooltip.php'; ?>