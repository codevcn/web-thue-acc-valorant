<!-- Edit Account Modal -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4 hidden">
  <div class="bg-white rounded-lg max-w-2xl w-full max-h-[90vh] overflow-y-auto">
    <div class="p-6 border-b border-gray-200">
      <h2 class="text-xl font-bold text-gray-900">Chỉnh sửa tài khoản</h2>
    </div>

    <form id="editAccountForm" class="px-6 py-4">
      <input type="hidden" name="id" id="editId">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Tên tài khoản</label>
          <input type="text" name="accountName" id="editAccountName" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-1 focus:ring-regular-blue-cl focus:border-transparent" required>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Rank</label>
          <select name="rank" id="editRank" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-1 focus:ring-regular-blue-cl focus:border-transparent" required>
            <option value="IRON 1">IRON 1</option>
            <option value="IRON 2">IRON 2</option>
            <option value="IRON 3">IRON 3</option>
            <option value="BRONZE 1">BRONZE 1</option>
            <option value="BRONZE 2">BRONZE 2</option>
            <option value="BRONZE 3">BRONZE 3</option>
            <option value="SILVER 1">SILVER 1</option>
            <option value="SILVER 2">SILVER 2</option>
            <option value="SILVER 3">SILVER 3</option>
            <option value="GOLD 1">GOLD 1</option>
            <option value="GOLD 2">GOLD 2</option>
            <option value="GOLD 3">GOLD 3</option>
            <option value="PLATINUM 1">PLATINUM 1</option>
            <option value="PLATINUM 2">PLATINUM 2</option>
            <option value="PLATINUM 3">PLATINUM 3</option>
            <option value="DIAMOND 1">DIAMOND 1</option>
            <option value="DIAMOND 2">DIAMOND 2</option>
            <option value="DIAMOND 3">DIAMOND 3</option>
            <option value="IMMORTAL 1">IMMORTAL 1</option>
            <option value="IMMORTAL 2">IMMORTAL 2</option>
            <option value="IMMORTAL 3">IMMORTAL 3</option>
            <option value="RADIANT">RADIANT</option>
          </select>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Mã game</label>
          <input type="text" name="gameCode" id="editGameCode" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-1 focus:ring-regular-blue-cl focus:border-transparent" required>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Giá (VNĐ)</label>
          <input type="number" name="price" id="editPrice" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-1 focus:ring-regular-blue-cl focus:border-transparent" required>
        </div>
      </div>

      <div class="mt-4">
        <label class="block text-sm font-medium text-gray-700 mb-2">Mô tả</label>
        <textarea name="description" id="editDescription" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-1 focus:ring-regular-blue-cl focus:border-transparent" rows="3"></textarea>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Trạng thái</label>
          <select name="status" id="editStatus" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-1 focus:ring-regular-blue-cl focus:border-transparent" required>
            <option value="AVAILABLE">Có sẵn</option>
            <option value="PENDING">Chờ xử lý</option>
            <option value="SOLD">Đã bán</option>
          </select>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Loại máy</label>
          <select name="deviceType" id="editDeviceType" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-1 focus:ring-regular-blue-cl focus:border-transparent" required>
            <option value="MÁY NHÀ">MÁY NHÀ</option>
            <option value="MÁY QUÁN">MÁY QUÁN</option>
          </select>
        </div>
      </div>
    </form>

    <div class="p-6 border-t border-gray-200 flex justify-end gap-3">
      <button onclick="hideEditModal()" class="px-4 py-2 text-gray-700 bg-gray-200 hover:bg-gray-300 rounded-lg transition-colors">
        Hủy
      </button>
      <button onclick="submitEditAccount()" class="px-4 py-2 bg-gradient-to-r from-regular-from-blue-cl to-regular-to-blue-cl hover:scale-105 text-white rounded-lg transition-colors flex items-center gap-2">
        <i data-lucide="save" class="w-4 h-4"></i>
        Cập nhật
      </button>
    </div>
  </div>
</div>