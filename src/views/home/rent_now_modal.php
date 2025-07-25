<!-- Rent Now Modal -->
<div id="rent-now-modal" hidden class="flex justify-center p-6 items-center overflow-y-auto overflow-x-hidden fixed inset-0 z-[990]">
  <div class="QUERY-modal-overlay absolute z-10 inset-0 bg-black/80"></div>

  <div
    class="inset-0 z-20 p-6 relative w-fit h-fit max-h-[90vh] overflow-y-auto CSS-styled-scrollbar bg-white/10 backdrop-blur-md text-gray-700 border border-solid border-gray-600 rounded-lg shadow-md">
    <!-- Close button -->
    <button id="close-rent-now-modal-btn" class="absolute top-6 right-6 text-white hover:scale-125 transition duration-200 font-bold">
      <svg xmlns="http://www.w3.org/2000/svg" class="lucide lucide-x-icon lucide-x w-[1.71em] h-[1.71em]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
        <path d="M18 6 6 18" />
        <path d="m6 6 12 12" />
      </svg>
    </button>

    <h3 class="text-[1.43em] font-bold text-sky-300 mb-4">Quy định thuê Acc</h3>

    <div class="mb-4">
      <h3 class="block text-[1em] font-semibold text-white mb-2">Điều khoản và điều cấm khi thuê Account:</h3>
      <div
        class="bg-transparent border border-gray-600 border-solid w-full max-h-full px-3 py-2 rounded-md text-[1em] text-white focus:outline-none focus:ring-2 focus:ring-regular-light-blue-cl">
        <p class="whitespace-pre-line">- Tên Acc: <span id="acc-name--rent-now-modal" class="font-bold text-[1.14em] text-white"></span>
          <?php echo htmlspecialchars($rules['rent_acc_rules']) ?>
        </p>
      </div>
    </div>

    <div class="flex items-center gap-2 mb-2">
      <input type="checkbox" id="accept-rules-checkbox" class="w-4 h-4">
      <label for="accept-rules-checkbox" class="text-[1em] text-white">
        <span class="font-bold leading-none">Chấp nhận điều khoản dịch vụ!</span>
      </label>
    </div>

    <p class="text-[1em] text-blue-300 mb-2 italic font-semibold">
      Thuê acc bằng cách liên hệ với người cho thuê qua Zalo hoặc Facebook!
    </p>

    <div id="rent-now-modal-contact-links" class="flex justify-center items-center gap-4 w-full mt-2 opacity-50 pointer-events-none">
      <a href="<?= htmlspecialchars($admin['zalo_link'], ENT_QUOTES, 'UTF-8') ?>" target="_blank" class="grow bg-regular-zalo-cl text-white font-bold py-3 px-6 rounded-xl transition duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-[1.71em] h-[1.71em]" viewBox="0 0 50 50" fill="none">
          <path fill-rule="evenodd" clip-rule="evenodd" d="M22.782 0.166016H27.199C33.2653 0.166016 36.8103 1.05701 39.9572 2.74421C43.1041 4.4314 45.5875 6.89585 47.2557 10.0428C48.9429 13.1897 49.8339 16.7347 49.8339 22.801V27.1991C49.8339 33.2654 48.9429 36.8104 47.2557 39.9573C45.5685 43.1042 43.1041 45.5877 39.9572 47.2559C36.8103 48.9431 33.2653 49.8341 27.199 49.8341H22.8009C16.7346 49.8341 13.1896 48.9431 10.0427 47.2559C6.89583 45.5687 4.41243 43.1042 2.7442 39.9573C1.057 36.8104 0.166016 33.2654 0.166016 27.1991V22.801C0.166016 16.7347 1.057 13.1897 2.7442 10.0428C4.43139 6.89585 6.89583 4.41245 10.0427 2.74421C13.1707 1.05701 16.7346 0.166016 22.782 0.166016Z" fill="#0068FF" />
          <path opacity="0.12" fill-rule="evenodd" clip-rule="evenodd" d="M49.8336 26.4736V27.1994C49.8336 33.2657 48.9427 36.8107 47.2555 39.9576C45.5683 43.1045 43.1038 45.5879 39.9569 47.2562C36.81 48.9434 33.265 49.8344 27.1987 49.8344H22.8007C17.8369 49.8344 14.5612 49.2378 11.8104 48.0966L7.27539 43.4267L49.8336 26.4736Z" fill="#001A33" />
          <path fill-rule="evenodd" clip-rule="evenodd" d="M7.779 43.5892C10.1019 43.846 13.0061 43.1836 15.0682 42.1825C24.0225 47.1318 38.0197 46.8954 46.4923 41.4732C46.8209 40.9803 47.1279 40.4677 47.4128 39.9363C49.1062 36.7779 50.0004 33.22 50.0004 27.1316V22.7175C50.0004 16.629 49.1062 13.0711 47.4128 9.91273C45.7385 6.75436 43.2461 4.28093 40.0877 2.58758C36.9293 0.894239 33.3714 0 27.283 0H22.8499C17.6644 0 14.2982 0.652754 11.4699 1.89893C11.3153 2.03737 11.1636 2.17818 11.0151 2.32135C2.71734 10.3203 2.08658 27.6593 9.12279 37.0782C9.13064 37.0921 9.13933 37.1061 9.14889 37.1203C10.2334 38.7185 9.18694 41.5154 7.55068 43.1516C7.28431 43.399 7.37944 43.5512 7.779 43.5892Z" fill="white" />
          <path d="M20.5632 17H10.8382V19.0853H17.5869L10.9329 27.3317C10.7244 27.635 10.5728 27.9194 10.5728 28.5639V29.0947H19.748C20.203 29.0947 20.5822 28.7156 20.5822 28.2606V27.1421H13.4922L19.748 19.2938C19.8428 19.1801 20.0134 18.9716 20.0893 18.8768L20.1272 18.8199C20.4874 18.2891 20.5632 17.8341 20.5632 17.2844V17Z" fill="#0068FF" />
          <path d="M32.9416 29.0947H34.3255V17H32.2402V28.3933C32.2402 28.7725 32.5435 29.0947 32.9416 29.0947Z" fill="#0068FF" />
          <path d="M25.814 19.6924C23.1979 19.6924 21.0747 21.8156 21.0747 24.4317C21.0747 27.0478 23.1979 29.171 25.814 29.171C28.4301 29.171 30.5533 27.0478 30.5533 24.4317C30.5723 21.8156 28.4491 19.6924 25.814 19.6924ZM25.814 27.2184C24.2785 27.2184 23.0273 25.9672 23.0273 24.4317C23.0273 22.8962 24.2785 21.645 25.814 21.645C27.3495 21.645 28.6007 22.8962 28.6007 24.4317C28.6007 25.9672 27.3685 27.2184 25.814 27.2184Z" fill="#0068FF" />
          <path d="M40.4867 19.6162C37.8516 19.6162 35.7095 21.7584 35.7095 24.3934C35.7095 27.0285 37.8516 29.1707 40.4867 29.1707C43.1217 29.1707 45.2639 27.0285 45.2639 24.3934C45.2639 21.7584 43.1217 19.6162 40.4867 19.6162ZM40.4867 27.2181C38.9322 27.2181 37.681 25.9669 37.681 24.4124C37.681 22.8579 38.9322 21.6067 40.4867 21.6067C42.0412 21.6067 43.2924 22.8579 43.2924 24.4124C43.2924 25.9669 42.0412 27.2181 40.4867 27.2181Z" fill="#0068FF" />
          <path d="M29.4562 29.0944H30.5747V19.957H28.6221V28.2793C28.6221 28.7153 29.0012 29.0944 29.4562 29.0944Z" fill="#0068FF" />
        </svg>
        Zalo
      </a>

      <a href="<?= htmlspecialchars($admin['facebook_link'], ENT_QUOTES, 'UTF-8') ?>" target="_blank" class="grow bg-regular-facebook-cl text-white font-bold py-3 px-6 rounded-xl transition duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-[1.71em] h-[1.71em]" viewBox="0 0 24 24" fill="currentColor">
          <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
        </svg>
        Facebook
      </a>
    </div>
  </div>
</div>