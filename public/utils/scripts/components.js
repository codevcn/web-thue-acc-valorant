import { html } from "https://esm.run/lit-html@1"

export const AccountCard = (account) => {
  const { status, rank, avatar, game_code, device_type, description, acc_name } = account
  return html`
    <div class="md:block hidden bg-white rounded-2xl shadow-2xl overflow-hidden w-full h-[408px]">
      <div class="flex h-full">
        <div
          class="w-3/5 bg-gradient-to-br from-cyan-400 via-blue-500 to-blue-600 relative flex flex-col items-center justify-center"
        >
          <img
            src="/images/account/${avatar ?? "default-account-avatar.webp"}"
            alt="Account Avatar"
            class="w-full h-full"
          />
        </div>

        <div class="w-2/5 bg-white p-6 flex flex-col justify-between">
          <div class="flex items-center gap-2 mb-6">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="w-6 h-6 text-blue-500"
              fill="none"
              stroke="currentColor"
              stroke-width="2"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M12 3l8.485 4.243a2 2 0 011.058 1.753V15a6 6 0 01-3.172 5.326l-5.313 2.66a2 2 0 01-1.816 0l-5.313-2.66A6 6 0 013.5 15V9a2 2 0 011.058-1.753L12 3z"
              ></path>
            </svg>
            <h2 class="text-xl font-bold text-gray-800">THÔNG TIN TÀI KHOẢN</h2>
          </div>

          <div class="space-y-4 flex-1">
            <div class="flex justify-between items-center gap-6">
              <span class="text-gray-600 font-medium">Tên tài khoản</span>
              <span class="font-bold text-gray-900"> ${acc_name ?? "N/A"} </span>
            </div>

            <div class="flex justify-between items-center gap-6">
              <div class="flex items-center gap-2">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  class="w-6 h-6 text-yellow-500 fill-current"
                  viewBox="0 0 24 24"
                >
                  <path
                    d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"
                  />
                </svg>
                <span class="text-gray-600 font-medium">Rank</span>
              </div>
              <div class="flex items-center gap-1">
                <span class="font-bold text-yellow-600"> ${rank ?? "N/A"} </span>
              </div>
            </div>

            <div class="flex justify-between items-center gap-6">
              <span class="text-gray-600 font-medium">Trạng Thái</span>
              <div class="flex items-center gap-1">
                <span
                  class="font-bold text-white ${status == "Rảnh"
                    ? "bg-green-600"
                    : "bg-red-600"} px-4 py-0.5 rounded-lg"
                >
                  ${status}
                </span>
              </div>
            </div>

            <div class="flex justify-between items-center gap-6">
              <div class="flex items-center gap-2">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  class="w-6 h-6 text-blue-500"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="2"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M16 18l6-6-6-6M8 6l-6 6 6 6"
                  />
                </svg>
                <span class="text-gray-600 font-medium">Mã Game</span>
              </div>
              <div class="flex items-center gap-1">
                <span class="font-bold text-blue-600"> ${game_code ?? "N/A"} </span>
              </div>
            </div>

            <div class="flex justify-between items-center gap-6">
              <div class="flex items-center gap-2">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  class="w-6 h-6 text-blue-500"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="2"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M9.75 17L6 21h12l-3.75-4M3 4h18v10H3z"
                  />
                </svg>
                <span class="text-gray-600 font-medium">Loại Máy</span>
              </div>
              <div class="flex items-center gap-1">
                <span class="font-bold text-blue-600"> ${device_type} </span>
              </div>
            </div>

            ${description
              ? html`
                  <div class="bg-blue-50 rounded-lg p-3 mt-4">
                    <p class="text-sm">
                      <span class="font-semibold text-blue-700">Mô tả:</span>
                      <span class="text-gray-700 ml-1"> ${description} </span>
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

export const AccountRankType = ({ rank, isActive }) => {
  return html`
    <button
      data-rank="${rank}"
      class="CSS-button-blue-decoration QUERY-filter-by-rank-item py-1.5 px-4 ${isActive
        ? "CSS-is-active"
        : ""}"
    >
      <span>Rank </span>
      <span>${rank}</span>
    </button>
  `
}

export const AccountStatus = ({ status, isActive }) => {
  return html`
    <button
      data-status="${status}"
      class="CSS-button-blue-decoration QUERY-filter-by-status-item py-1.5 px-4 ${isActive
        ? "CSS-is-active"
        : ""}"
    >
      <span>${status}</span>
    </button>
  `
}

export const AccountDeviceType = ({ device_type, isActive }) => {
  return html`
    <button
      data-device-type="${device_type}"
      class="CSS-button-blue-decoration QUERY-filter-by-device-type-item py-1.5 px-4 ${isActive
        ? "CSS-is-active"
        : ""}"
    >
      <span>${device_type}</span>
    </button>
  `
}

export const AccountRow = (account) => {
  const { acc_name, rank, game_code, status, description, created_date, device_type, id, avatar } =
    account
  const created_date_formatted = dayjs(created_date).format("DD/MM/YYYY HH:mm")
  return html`
    <tr class="hover:bg-gray-50">
      <td class="px-3 py-3">
        <input
          type="checkbox"
          class="account-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500"
          value="${id}"
        />
      </td>
      <td class="px-3 py-1 w-[200px] aspect-[365/204]">
        <div
          class="w-full h-full bg-gradient-to-r from-blue-400 to-cyan-500 rounded-full flex items-center justify-center"
        >
          <img
            src="/images/account/${avatar ?? "default-account-avatar.webp"}"
            alt="Account Avatar"
            class="w-full h-full"
          />
        </div>
      </td>
      <td class="px-3 py-3 whitespace-nowrap">
        <div class="text-sm font-medium text-gray-900 max-w-[150px] truncate">${acc_name}</div>
      </td>
      <td class="px-3 py-3 whitespace-nowrap">
        <div class="text-sm font-medium">${rank}</div>
      </td>
      <td class="px-3 py-3 whitespace-nowrap">
        <div class="text-sm text-regular-blue-4 font-medium">${game_code}</div>
      </td>
      <td class="px-3 py-3 whitespace-nowrap">
        <span class="inline-flex px-2 py-1 text-sm font-semibold rounded-full"> ${status} </span>
      </td>
      <td class="px-3 py-3">
        <div class="text-sm text-gray-900 max-w-[100px] truncate">
          ${description ||
          html`<span class="QUERY-no-description text-gray-400 italic text-sm"
            >Chưa có mô tả</span
          >`}
        </div>
      </td>
      <td class="px-3 py-3 whitespace-nowrap">
        <div class="text-sm text-gray-500">${created_date_formatted}</div>
      </td>
      <td class="px-3 py-3 whitespace-nowrap">
        <div class="text-sm text-gray-900">${device_type}</div>
      </td>
      <td class="px-3 py-3 whitespace-nowrap">
        <div class="flex items-center gap-2">
          <button
            data-account-id="${id}"
            class="QUERY-update-account-btn text-regular-blue-cl hover:text-regular-blue-hover-cl transition-colors"
            title="Chỉnh sửa"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="24"
              height="24"
              viewBox="0 0 24 24"
              fill="none"
              stroke="currentColor"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
              class="lucide lucide-square-pen-icon lucide-square-pen"
            >
              <path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
              <path
                d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"
              />
            </svg>
          </button>
          <button
            data-account-id="${id}"
            class="QUERY-delete-account-btn text-red-600 hover:text-red-900 transition-colors"
            title="Xóa"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="24"
              height="24"
              viewBox="0 0 24 24"
              fill="none"
              stroke="currentColor"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
              class="lucide lucide-trash2-icon lucide-trash-2"
            >
              <path d="M3 6h18" />
              <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
              <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
              <line x1="10" x2="10" y1="11" y2="17" />
              <line x1="14" x2="14" y1="11" y2="17" />
            </svg>
          </button>
        </div>
      </td>
    </tr>
  `
}
