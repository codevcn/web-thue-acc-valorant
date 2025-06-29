<!-- Add Account Modal -->
<div id="update-account-modal" hidden class="QUERY-modal fixed inset-0 flex items-center justify-center z-90 p-4">
  <div class="QUERY-modal-overlay absolute z-10 inset-0 bg-black/50"></div>

  <div class="bg-white rounded-lg max-w-2xl w-full max-h-[90vh] overflow-y-auto relative z-20">
    <div class="p-6 border-b border-gray-200">
      <h2 class="text-xl font-bold text-gray-900">Cập nhật tài khoản <span id="update-account-name"></span></h2>
    </div>

    <form id="update-account-form" class="px-6 py-4">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Tên tài khoản</label>
          <input type="text" name="accName" class="w-full px-3 py-2 border border-solid border-gray-300 rounded-lg focus:border-regular-blue-cl focus:outline outline-regular-blue-cl outline-1" placeholder="VD: PRO#1234">
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Rank</label>
          <select name="rank" class="QUERY-rank-types-select w-full px-3 py-2 border border-solid border-gray-300 rounded-lg focus:border-regular-blue-cl focus:outline outline-regular-blue-cl outline-1">
          </select>
        </div>

        <div class="col-span-2">
          <label class="block text-sm font-medium text-gray-700 mb-2">Mã game</label>
          <input type="text" name="gameCode" class="w-full px-3 py-2 border border-solid border-gray-300 rounded-lg focus:border-regular-blue-cl focus:outline outline-regular-blue-cl outline-1" placeholder="VD: Mã 001">
        </div>
      </div>

      <div class="mt-4">
        <label class="block text-sm font-medium text-gray-700 mb-2">Mô tả</label>
        <textarea name="description" class="w-full px-3 py-2 border border-solid border-gray-300 rounded-lg focus:border-regular-blue-cl focus:outline outline-regular-blue-cl outline-1" rows="3" placeholder="Mô tả chi tiết về tài khoản..."></textarea>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Trạng thái</label>
          <select name="status" class="QUERY-statuses-select w-full px-3 py-2 border border-solid border-gray-300 rounded-lg focus:border-regular-blue-cl focus:outline outline-regular-blue-cl outline-1">
          </select>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Loại máy</label>
          <select name="deviceType" class="QUERY-device-type-select w-full px-3 py-2 border border-solid border-gray-300 rounded-lg focus:border-regular-blue-cl focus:outline outline-regular-blue-cl outline-1">
          </select>
        </div>
      </div>
    </form>

    <div class="p-6 border-t border-gray-200 flex justify-end gap-3">
      <button id="update-account-cancel-btn" class="px-4 py-2 text-gray-700 bg-gray-200 hover:scale-110 rounded-lg transition">
        Hủy
      </button>
      <button id="update-account-submit-btn" class="px-4 py-2 bg-gradient-to-r from-regular-from-blue-cl to-regular-to-blue-cl hover:scale-110 text-white rounded-lg transition flex items-center gap-2">
        <i data-lucide="save" class="w-4 h-4"></i>
        Cập nhật tài khoản
      </button>
    </div>
  </div>
</div>