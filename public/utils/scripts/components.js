import { html } from "https://esm.run/lit-html@1"

export const AccountCard = (account) => {
  return html`
    <div class="md:block hidden bg-white rounded-2xl shadow-2xl overflow-hidden w-full h-[408px]">
      <div class="flex h-full">
        <div
          class="w-3/5 bg-gradient-to-br from-cyan-400 via-blue-500 to-blue-600 relative flex flex-col items-center justify-center"
        >
          <img
            src="/images/account/${account.avatar ?? "default-account-avatar.webp"}"
            alt="Account Avatar"
            class="w-full h-full"
          />
        </div>

        <div class="w-2/5 bg-white p-6 flex flex-col justify-between">
          <div class="flex items-center gap-2 mb-6">
            <img src="/images/icons/icon_shield.svg" alt="Shield Icon" class="w-6 h-6" />
            <h2 class="text-xl font-bold text-gray-800">THÔNG TIN TÀI KHOẢN</h2>
          </div>

          <div class="space-y-4 flex-1">
            <div class="flex justify-between items-center gap-6">
              <span class="text-gray-600 font-medium">Tên tài khoản</span>
              <span class="font-bold text-gray-900"> ${account.acc_name ?? "N/A"} </span>
            </div>

            <div class="flex justify-between items-center gap-6">
              <div class="flex items-center gap-2">
                <img src="/images/icons/icon_star.svg" alt="Star Icon" class="w-6 h-6" />
                <span class="text-gray-600 font-medium">Rank</span>
              </div>
              <div class="flex items-center gap-1">
                <span class="font-bold text-yellow-600"> ${account.rank ?? "N/A"} </span>
              </div>
            </div>

            <div class="flex justify-between items-center gap-6">
              <span class="text-gray-600 font-medium">Trạng Thái</span>
              <div class="flex items-center gap-1">
                <span class="font-bold text-white bg-red-600 px-4 py-0.5 rounded-lg">
                  ${account.status == "AVAILABLE" ? "RẢNH" : "BẬN"}
                </span>
              </div>
            </div>

            <div class="flex justify-between items-center gap-6">
              <div class="flex items-center gap-2">
                <img src="/images/icons/icon_code.svg" alt="Code Icon" class="w-6 h-6" />
                <span class="text-gray-600 font-medium">Mã Game</span>
              </div>
              <div class="flex items-center gap-1">
                <span class="font-bold text-blue-600"> ${account.game_code ?? "N/A"} </span>
              </div>
            </div>

            <div class="flex justify-between items-center gap-6">
              <div class="flex items-center gap-2">
                <img src="/images/icons/icon_monitor.svg" alt="Monitor Icon" class="w-6 h-6" />
                <span class="text-gray-600 font-medium">Loại Máy</span>
              </div>
              <div class="flex items-center gap-1">
                <span class="font-bold text-blue-600">
                  ${account.device_type == "AT_HOME" ? "Máy nhà" : "Máy net"}
                </span>
              </div>
            </div>

            ${account.description
              ? html`
                  <div class="bg-blue-50 rounded-lg p-3 mt-4">
                    <p class="text-sm">
                      <span class="font-semibold text-blue-700">Mô tả:</span>
                      <span class="text-gray-700 ml-1"> ${account.description} </span>
                    </p>
                  </div>
                `
              : html` <div class="text-gray-400 italic font-bold text-base">Chưa có mô tả</div> `}
          </div>

          <button
            class="w-full bg-gradient-to-r from-cyan-500 to-blue-600 text-white font-bold py-3 px-6 rounded-xl hover:from-cyan-600 hover:to-blue-700 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl mt-6"
          >
            THUÊ NGAY
          </button>
        </div>
      </div>
    </div>
  `
}
