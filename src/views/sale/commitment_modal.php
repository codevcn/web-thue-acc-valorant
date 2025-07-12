<!-- Commitment Modal -->
<div id="commitment-modal" hidden class="flex justify-center p-6 items-center overflow-y-auto overflow-x-hidden fixed inset-0 z-[990]">
  <div class="QUERY-modal-overlay absolute z-10 inset-0 bg-black/80"></div>

  <div
    class="inset-0 z-20 min-w-[300px] p-6 relative w-fit h-fit bg-white/10 backdrop-blur-md text-gray-700 border border-solid border-white/20 rounded-lg shadow-md">
    <!-- Close button -->
    <button id="close-commitment-modal-btn" class="absolute top-6 right-6 text-white hover:scale-125 transition duration-200 text-xl font-bold">
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x-icon lucide-x">
        <path d="M18 6 6 18" />
        <path d="m6 6 12 12" />
      </svg>
    </button>

    <h3 class="text-xl font-bold text-sky-300 mb-4">Cam kết</h3>

    <div class="mb-2">
      <h3 class="block text-sm font-semibold italic text-white mb-2">Cam kết từ chủ sở hữu acc:</h3>
      <div
        class="bg-transparent border border-white/20 border-solid w-full px-3 py-2 rounded-md text-sm text-white focus:outline-none focus:ring-2 focus:ring-regular-light-blue-cl">
        <!-- <p class="whitespace-pre-line"><?= htmlspecialchars($rules['commitment']) ?></p> -->
        <p class="whitespace-pre-line">
          Tôi cam kết không sử dụng tài khoản thuê vào các hành vi vi phạm pháp luật, hack, cheat, hoặc sử dụng phần mềm thứ ba gây ảnh hưởng đến game.
          Tôi sẽ không thay đổi thông tin tài khoản (email, mật khẩu, số điện thoại, v.v.) khi thuê tài khoản.
          Tôi cam kết không chia sẻ, cho mượn hoặc bán lại tài khoản cho bất kỳ ai khác trong thời gian thuê.
          Nếu phát hiện có hành vi gian lận, vi phạm quy định, tôi đồng ý chịu hoàn toàn trách nhiệm và bị cấm thuê vĩnh viễn.
          Tôi sẽ bảo mật thông tin tài khoản và không tiết lộ cho bên thứ ba.
          Nếu gặp sự cố hoặc có vấn đề phát sinh, tôi sẽ liên hệ ngay với quản trị viên để được hỗ trợ.
          Tôi đã đọc, hiểu và đồng ý với tất cả các điều khoản cam kết khi thuê tài khoản game tại trang web này.
        </p>
      </div>
    </div>
  </div>
</div>