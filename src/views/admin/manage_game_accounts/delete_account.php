<!-- Delete Confirmation Modal -->
<div id="delete-account-modal" hidden class="QUERY-modal fixed inset-0 flex items-center justify-center z-90 p-4">
  <div class="QUERY-modal-overlay absolute z-10 inset-0 bg-black/50"></div>

  <div class="bg-white rounded-lg max-w-md w-full p-6 relative z-20">
    <div class="flex items-center gap-4 mb-4">
      <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
        <i data-lucide="alert-triangle" class="w-6 h-6 text-red-600"></i>
      </div>
      <div>
        <h3 class="text-lg font-medium text-gray-900">Xác nhận xóa</h3>
        <p class="text-sm text-gray-500">Bạn có chắc chắn muốn xóa tài khoản <span id="delete-account-name"></span>?</p>
      </div>
    </div>

    <div class="flex justify-end gap-3">
      <button id="delete-account-cancel-button" class="px-4 py-2 text-gray-700 bg-gray-200 hover:scale-110 rounded-lg transition">
        Hủy
      </button>
      <button id="delete-account-confirm-button" class="px-4 py-2 bg-red-600 hover:scale-110 text-white rounded-lg transition">
        Xóa
      </button>
    </div>
  </div>
</div>