import { html } from "https://esm.run/lit-html@1"

export const AccountCard = (account) => {
  const { status, rank, avatar, game_code, device_type, description, acc_name, id } = account
  return html`
    <div class="bg-white rounded-lg shadow-2xl overflow-hidden w-full">
      <div
        class="CSS-styled-vt-scrollbar min-[1242px]:flex w-full min-[1242px]:aspect-[1825/612] overflow-y-auto relative aspect-auto block"
      >
        <div
          class="min-[1242px]:w-3/5 w-full h-fit min-[1242px]:h-auto bg-gradient-to-r from-regular-from-blue-cl to-regular-to-blue-cl relative flex flex-col items-center justify-center"
        >
          <img
            src="/images/account/${avatar ?? "default-game-account-avatar.png"}"
            alt="Account Avatar"
            class="aspect-[365/204] ${avatar
              ? "object-cover"
              : "object-contain py-6 min-[1242px]:py-0"}"
          />
        </div>

        <div class="min-[1242px]:w-2/5 w-full bg-white p-6 flex flex-col justify-between">
          <div class="flex items-center gap-2 mb-6">
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
              class="lucide lucide-info-icon lucide-info text-regular-blue-cl"
            >
              <circle cx="12" cy="12" r="10" />
              <path d="M12 16v-4" />
              <path d="M12 8h.01" />
            </svg>
            <h2 class="text-xl font-bold text-gray-800">THÔNG TIN TÀI KHOẢN</h2>
          </div>

          <div class="space-y-4 flex-1">
            <div class="flex justify-between items-center gap-6">
              <span class="text-gray-600 font-medium flex items-center gap-2">
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
                  class="lucide lucide-letter-text-icon lucide-letter-text text-regular-blue-cl"
                >
                  <path d="M15 12h6" />
                  <path d="M15 6h6" />
                  <path d="m3 13 3.553-7.724a.5.5 0 0 1 .894 0L11 13" />
                  <path d="M3 18h18" />
                  <path d="M3.92 11h6.16" />
                </svg>
                <span>Tên tài khoản</span>
              </span>
              <span class="font-bold text-gray-900"> ${acc_name ?? "N/A"} </span>
            </div>

            <div class="flex justify-between items-center gap-6">
              <div class="flex items-center gap-2">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  class="w-6 h-6 text-regular-blue-cl fill-current"
                  viewBox="0 0 24 24"
                >
                  <path
                    d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"
                  />
                </svg>
                <span class="text-gray-600 font-medium">Rank</span>
              </div>
              <div class="flex items-center gap-1">
                <span class="font-bold text-black"> ${rank ?? "N/A"} </span>
              </div>
            </div>

            <div class="flex justify-between items-center gap-6">
              <span class="text-gray-600 font-medium flex items-center gap-2">
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
                  class="lucide lucide-chart-no-axes-column-icon lucide-chart-no-axes-column text-regular-blue-cl"
                >
                  <line x1="18" x2="18" y1="20" y2="10" />
                  <line x1="12" x2="12" y1="20" y2="4" />
                  <line x1="6" x2="6" y1="20" y2="14" />
                </svg>
                <span>Trạng Thái</span>
              </span>
              <span
                class="font-bold text-white ${status.toLowerCase() == "rảnh"
                  ? "bg-green-600"
                  : "bg-red-600"} px-4 py-0.5 rounded-lg"
              >
                ${status}
              </span>
            </div>

            <div class="flex justify-between items-center gap-6">
              <div class="flex items-center gap-2">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  class="w-6 h-6 text-regular-blue-cl"
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
                <span class="font-bold text-black"> ${game_code ?? "N/A"} </span>
              </div>
            </div>

            <div class="flex justify-between items-center gap-6">
              <div class="flex items-center gap-2">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  class="w-6 h-6 text-regular-blue-cl"
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
                <span class="font-bold text-black"> ${device_type} </span>
              </div>
            </div>

            ${description
              ? html`
                  <div class="bg-gray-100 rounded-lg p-3 mt-4">
                    <p class="text-sm truncate">
                      <span class="font-semibold text-black">Mô tả:</span>
                      <span
                        data-vcn-tooltip-content="${description}"
                        class="QUERY-tooltip-trigger text-gray-700 ml-1"
                      >
                        ${description}
                      </span>
                    </p>
                  </div>
                `
              : html` <div class="text-gray-400 italic font-bold text-base">Chưa có mô tả</div> `}
          </div>

          <button
            data-account-id="${id}"
            class="QUERY-rent-now-btn w-full CSS-button-blue-decoration py-2 px-4 mt-6"
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
      class="QUERY-filter-by-rank-type-item CSS-hover-flash-button text-base border border-white/80 border-solid py-[15px] px-6 bg-gray-600 flex items-center gap-2 ${isActive
        ? "bg-regular-blue-cl text-black font-bold"
        : "text-white"}"
    >
      <span class="CSS-hover-flash-button-content">${rank}</span>
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
        class="lucide lucide-check-check-icon lucide-check-check ${isActive ? "block" : "hidden"}"
      >
        <path d="M18 6 7 17l-5-5" />
        <path d="m22 10-7.5 7.5L13 16" />
      </svg>
    </button>
  `
}

export const AccountStatus = ({ status, isActive }) => {
  return html`
    <button
      data-status="${status}"
      class="QUERY-filter-by-status-item CSS-hover-flash-button text-base border border-white/80 border-solid py-[15px] px-6 bg-gray-600 flex items-center gap-2 ${isActive
        ? "bg-regular-blue-cl text-black font-bold"
        : "text-white"}"
    >
      <span class="CSS-hover-flash-button-content">${status}</span>
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
        class="lucide lucide-check-check-icon lucide-check-check ${isActive ? "block" : "hidden"}"
      >
        <path d="M18 6 7 17l-5-5" />
        <path d="m22 10-7.5 7.5L13 16" />
      </svg>
    </button>
  `
}

export const AccountDeviceType = ({ device_type, isActive }) => {
  return html`
    <button
      data-device-type="${device_type}"
      class="QUERY-filter-by-device-type-item CSS-hover-flash-button text-base border border-white/80 border-solid py-[15px] px-6 bg-gray-600 flex items-center gap-2 ${isActive
        ? "bg-regular-blue-cl text-black font-bold"
        : "text-white"}"
    >
      <span class="CSS-hover-flash-button-content">${device_type}</span>
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
        class="lucide lucide-check-check-icon lucide-check-check ${isActive ? "block" : "hidden"}"
      >
        <path d="M18 6 7 17l-5-5" />
        <path d="m22 10-7.5 7.5L13 16" />
      </svg>
    </button>
  `
}

export const AccountRow = (account, order_number) => {
  const { acc_name, rank, game_code, status, description, created_at, device_type, id, avatar } =
    account
  const created_date_formatted = dayjs(created_at).format("DD/MM/YYYY HH:mm")
  const lowerCasedStatus = status.toLowerCase()
  return html`
    <tr
      class="QUERY-account-row-item hover:bg-blue-50 ${lowerCasedStatus == "bận"
        ? "bg-red-100"
        : ""}"
    >
      <td class="px-3 py-3 text-center">${order_number}</td>
      <td class="px-3 py-1">
        <div class="rounded-full flex items-center justify-center">
          <img
            src="/images/account/${avatar || "default-game-account-avatar.png"}"
            alt="Account Avatar"
            class="w-[200px] aspect-[365/204] min-w-[94px] max-h-[100px] object-contain object-center"
          />
        </div>
      </td>
      <td class="px-3 py-3 whitespace-nowrap">
        <div class="text-sm font-medium text-gray-900 max-w-[150px] truncate">${acc_name}</div>
      </td>
      <td class="px-3 py-3 whitespace-nowrap">
        <div class="text-sm font-medium max-w-[100px] truncate">${rank}</div>
      </td>
      <td class="px-3 py-3 whitespace-nowrap">
        <div class="text-sm text-regular-blue-4 font-medium max-w-[100px] truncate">
          ${game_code}
        </div>
      </td>
      <td class="px-3 py-3 whitespace-nowrap">
        <div
          data-vcn-account-id="${id}"
          data-vcn-tooltip-content="Nhấn để chuyển trạng thái của tài khoản"
          class="QUERY-switch-status-btn QUERY-tooltip-trigger max-w-[100px] truncate w-fit hover:scale-125 transition duration-200 cursor-pointer px-2 py-1 text-sm font-semibold rounded-full ${lowerCasedStatus ==
          "rảnh"
            ? "bg-green-600"
            : "bg-red-600"} text-white"
        >
          ${status}
        </div>
      </td>
      <td class="px-3 py-3">
        <div class="text-sm text-gray-900 max-w-[100px] truncate">
          ${description
            ? html`<span class="QUERY-tooltip-trigger" data-vcn-tooltip-content="${description}"
                >${description}</span
              >`
            : html`<span class="QUERY-no-description text-gray-400 italic text-sm"
                >Chưa có mô tả</span
              >`}
        </div>
      </td>
      <td class="px-3 py-3 whitespace-nowrap">
        <div class="text-sm text-gray-500">${created_date_formatted}</div>
      </td>
      <td class="px-3 py-3 whitespace-nowrap">
        <div class="text-sm text-gray-900 max-w-[100px] truncate">${device_type}</div>
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

export const AccountPreviewRow = (account, order_number) => {
  const { accName, rank, gameCode, status, description, created_at, deviceType, avatar } = account
  const created_date_formatted = dayjs(created_at).format("DD/MM/YYYY HH:mm")
  const lowerCasedStatus = status.toLowerCase()
  return html`
    <tr
      class="QUERY-account-row-item hover:bg-blue-50 ${lowerCasedStatus === "bận"
        ? "bg-red-100"
        : ""}"
    >
      <td class="px-3 py-3 text-center">${order_number}</td>
      <td class="px-3 py-1">
        <div class="rounded-full flex items-center justify-center">
          <img
            src="/images/account/${avatar || "default-game-account-avatar.png"}"
            alt="Account Avatar"
            class="w-[200px] aspect-[365/204] min-w-[94px] max-h-[100px] object-contain object-center"
          />
        </div>
      </td>
      <td class="px-3 py-3 whitespace-nowrap">
        <div class="text-sm font-medium text-gray-900 max-w-[150px] truncate">${accName}</div>
      </td>
      <td class="px-3 py-3 whitespace-nowrap">
        <div class="text-sm font-medium max-w-[100px] truncate">${rank}</div>
      </td>
      <td class="px-3 py-3 whitespace-nowrap">
        <div class="text-sm text-regular-blue-4 font-medium max-w-[100px] truncate">
          ${gameCode}
        </div>
      </td>
      <td class="px-3 py-3 whitespace-nowrap">
        <div
          class="max-w-[100px] truncate w-fit px-2 py-1 text-sm font-semibold rounded-full ${lowerCasedStatus ==
          "rảnh"
            ? "bg-green-600"
            : "bg-red-600"} text-white"
        >
          ${status}
        </div>
      </td>
      <td class="px-3 py-3">
        <div class="text-sm text-gray-900 max-w-[150px] truncate">
          ${description
            ? html`<span class="QUERY-tooltip-trigger" data-vcn-tooltip-content="${description}"
                >${description}</span
              >`
            : html`<span class="QUERY-no-description text-gray-400 italic text-sm"
                >Chưa có mô tả</span
              >`}
        </div>
      </td>
      <td class="px-3 py-3 whitespace-nowrap">
        <div class="text-sm text-gray-500">${created_date_formatted}</div>
      </td>
      <td class="px-3 py-3 whitespace-nowrap">
        <div class="text-sm text-gray-900 max-w-[100px] truncate">${deviceType}</div>
      </td>
    </tr>
  `
}
