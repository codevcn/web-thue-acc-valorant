import { GameAccountService } from "../../../services/game-account-services.js"
import { AccountRow } from "../../../utils/scripts/components.js"
import {
  LitHTMLHelper,
  AppLoadingHelper,
  AxiosErrorHandler,
  Toaster,
  URLHelper,
  NavigationHelper,
  LocalStorageHelper,
} from "../../../utils/scripts/helpers.js"
import { initUtils } from "../../../utils/scripts/init-utils.js"

const sharedData = {
  gameAccounts: [],
}

class ManageGameAccountsPageManager {
  constructor() {
    this.accountsTableBody = document.getElementById("accounts-table-body")
    this.loadMoreContainer = document.getElementById("load-more-container")
    this.scrollToTopBtn = document.getElementById("scroll-to-top-btn")

    this.isFetchingItems = false
    this.isMoreItems = true

    this.fetchAccounts()
    this.watchScrolling()

    this.initListeners()
  }

  getAccountsTableBodyEle() {
    return this.accountsTableBody
  }

  getLastAccount() {
    const accounts = sharedData.gameAccounts
    if (accounts.length > 0) {
      return accounts.at(-1)
    }
    return null
  }

  fetchAccounts() {
    if (this.isFetchingItems || !this.isMoreItems) return
    this.isFetchingItems = true

    AppLoadingHelper.show()
    const lastAccount = this.getLastAccount()
    let last_id = lastAccount ? lastAccount.id : null
    let last_updated_at = lastAccount ? lastAccount.updated_at : null
    const rank = URLHelper.getUrlQueryParam("rank")
    const status = URLHelper.getUrlQueryParam("status")
    const device_type = URLHelper.getUrlQueryParam("device_type")
    const search_term = URLHelper.getUrlQueryParam("search_term")
    const date_from = URLHelper.getUrlQueryParam("date_from")
    const date_to = URLHelper.getUrlQueryParam("date_to")

    GameAccountService.fetchAccounts(
      last_id,
      last_updated_at,
      rank,
      status,
      device_type,
      search_term,
      date_from,
      date_to
    )
      .then((accounts) => {
        if (accounts && accounts.length > 0) {
          sharedData.gameAccounts = [...sharedData.gameAccounts, ...accounts]
          this.renderAccounts()
          this.initCatchDeleteAndUpdateAccountBtnClick()
          initUtils.initTooltip()
        } else {
          this.isMoreItems = false
          this.loadMoreContainer.classList.remove("QUERY-is-more")
          this.loadMoreContainer.classList.add("QUERY-no-more")
        }
      })
      .catch((error) => {
        Toaster.error(AxiosErrorHandler.handleHTTPError(error).message)
      })
      .finally(() => {
        this.isFetchingItems = false
        AppLoadingHelper.hide()
      })
  }

  initCatchDeleteAndUpdateAccountBtnClick() {
    this.accountsTableBody.addEventListener("click", (e) => {
      let target = e.target
      let isDeleteBtn = false,
        isUpdateBtn = false
      while (target) {
        if (target.classList.contains("QUERY-delete-account-btn")) {
          isDeleteBtn = true
          break
        }
        if (target.classList.contains("QUERY-update-account-btn")) {
          isUpdateBtn = true
          break
        }
        target = target.parentElement
        if (target.id === "accounts-table-body" || target.tagName === "BODY" || !target) {
          return
        }
      }
      if (isDeleteBtn) {
        deleteAccountManager.showModal(target)
      }
      if (isUpdateBtn) {
        updateAccountManager.showModal(target)
      }
    })
  }

  renderAccounts() {
    this.accountsTableBody.innerHTML = ""

    const gameAccounts = sharedData.gameAccounts
    let order_number = 1
    for (const account of gameAccounts) {
      const accountRow = LitHTMLHelper.getFragment(AccountRow, account, order_number)
      this.accountsTableBody.appendChild(accountRow)
      order_number++
    }
  }

  scrollToTop() {
    window.scrollTo({
      top: 100,
      behavior: "instant",
    })
    window.scrollTo({
      top: 0,
      behavior: "smooth",
    })
  }

  watchScrolling() {
    window.addEventListener("scroll", (e) => {
      const THRESHOLD = 300
      if (window.scrollY > THRESHOLD) {
        this.scrollToTopBtn.classList.remove("bottom-[-60px]")
        this.scrollToTopBtn.classList.add("bottom-6")
      } else {
        this.scrollToTopBtn.classList.remove("bottom-6")
        this.scrollToTopBtn.classList.add("bottom-[-60px]")
      }
    })
  }

  initListeners() {
    document.getElementById("load-more-btn").addEventListener("click", (e) => {
      this.fetchAccounts()
    })

    this.scrollToTopBtn.addEventListener("click", this.scrollToTop.bind(this))
  }
}

class AddNewAccountManager {
  constructor() {
    this.addNewAccountModal = document.getElementById("add-new-account-modal")
    this.addNewAccountForm = document.getElementById("add-new-account-form")
    this.pickAvatarSection = document.getElementById("pick-avatar--add-section")
    this.avatarPreview = document.getElementById("avatar-preview-img--add-section")
    this.avatarInput = document.getElementById("avatar-input--add-section")

    this.isSubmitting = false

    this.initListeners()
  }

  initListeners() {
    document
      .getElementById("add-new-account-btn")
      .addEventListener("click", this.showModal.bind(this))

    document
      .getElementById("add-new-account-submit-btn")
      .addEventListener("click", this.submitAddAccount.bind(this))

    document
      .getElementById("add-new-account-cancel-btn")
      .addEventListener("click", this.hideModal.bind(this))

    this.addNewAccountModal.querySelector(".QUERY-modal-overlay").addEventListener("click", (e) => {
      this.hideModal()
    })

    this.avatarInput.addEventListener("change", this.handleAvatarInputChange.bind(this))
    document
      .getElementById("cancel-avatar-btn--add-section")
      .addEventListener("click", this.handleRemoveAvatar.bind(this))
  }

  handleAvatarInputChange(e) {
    const file = e.target.files[0]
    if (file) {
      const reader = new FileReader()
      reader.onload = (e) => {
        this.avatarPreview.src = e.target.result
        this.pickAvatarSection.classList.remove("QUERY-at-avatar-input-section")
        this.pickAvatarSection.classList.add("QUERY-at-avatar-preview-section")
      }
      reader.readAsDataURL(file)
    }
  }

  handleRemoveAvatar() {
    this.avatarPreview.src = ""
    this.avatarInput.value = null
    this.pickAvatarSection.classList.remove("QUERY-at-avatar-preview-section")
    this.pickAvatarSection.classList.add("QUERY-at-avatar-input-section")
  }

  showModal() {
    this.addNewAccountModal.hidden = false
  }

  hideModal() {
    this.addNewAccountModal.hidden = true
    this.addNewAccountForm.reset()
  }

  validateFormData({ accName, rank, gameCode, status, deviceType, avatar }) {
    if (!accName) {
      Toaster.error("Tên tài khoản không được để trống")
      return false
    }
    if (!rank) {
      Toaster.error("Rank không được để trống")
      return false
    }
    if (!gameCode) {
      Toaster.error("Mã game không được để trống")
      return false
    }
    if (!status) {
      Toaster.error("Trạng thái không được để trống")
      return false
    }
    if (!deviceType) {
      Toaster.error("Loại thiết bị không được để trống")
      return false
    }
    if (!avatar) {
      Toaster.error("Ảnh đại diện không được để trống")
      return false
    }
    return true
  }

  submitAddAccount() {
    if (this.isSubmitting) return
    this.isSubmitting = true

    const formData = new FormData(this.addNewAccountForm)
    const data = {
      accName: formData.get("accName"),
      rank: formData.get("rank"),
      gameCode: formData.get("gameCode"),
      description: formData.get("description"),
      status: formData.get("status"),
      deviceType: formData.get("deviceType"),
    }
    const avatar = this.avatarInput.files?.[0]
    if (!this.validateFormData({ ...data, avatar })) {
      this.isSubmitting = false
      return
    }

    AppLoadingHelper.show()
    GameAccountService.addNewAccounts([data], avatar)
      .then((data) => {
        if (data && data.success) {
          Toaster.success("Thông báo", "Thêm tài khoản thành công", () => {
            NavigationHelper.reloadPage()
          })
        }
      })
      .catch((error) => {
        Toaster.error("Thêm tài khoản thất bại", AxiosErrorHandler.handleHTTPError(error).message)
      })
      .finally(() => {
        this.isSubmitting = false
        AppLoadingHelper.hide()
      })
  }
}

class DeleteAccountManager {
  constructor() {
    this.deleteAccountModal = document.getElementById("delete-account-modal")

    this.isDeleting = false
    this.accountId = null

    this.initListeners()
  }

  initListeners() {
    document
      .getElementById("delete-account-cancel-button")
      .addEventListener("click", this.hideModal.bind(this))

    document
      .getElementById("delete-account-confirm-button")
      .addEventListener("click", this.confirmDelete.bind(this))

    this.deleteAccountModal.querySelector(".QUERY-modal-overlay").addEventListener("click", (e) => {
      this.hideModal()
    })
  }

  showModal(targetBtn) {
    const { accountId } = targetBtn.dataset
    this.accountId = accountId ? accountId * 1 : null
    const account = sharedData.gameAccounts.find((account) => account.id === this.accountId)
    document.getElementById("delete-account-name").textContent = account.acc_name
    this.deleteAccountModal.hidden = false
  }

  hideModal() {
    this.deleteAccountModal.hidden = true
  }

  confirmDelete() {
    if (this.isDeleting) return
    this.isDeleting = true

    AppLoadingHelper.show()
    GameAccountService.deleteAccount(this.accountId)
      .then((data) => {
        if (data && data.success) {
          Toaster.success("Thông báo", "Xóa tài khoản thành công", () => {
            NavigationHelper.reloadPage()
          })
        }
      })
      .catch((error) => {
        Toaster.error(AxiosErrorHandler.handleHTTPError(error).message)
      })
      .finally(() => {
        this.isDeleting = false
        AppLoadingHelper.hide()
      })
  }
}

class UpdateAccountManager {
  constructor() {
    this.updateAccountModal = document.getElementById("update-account-modal")
    this.updateAccountForm = document.getElementById("update-account-form")
    this.pickAvatarSection = document.getElementById("pick-avatar--update-section")
    this.avatarPreview = document.getElementById("avatar-preview-img--update-section")
    this.avatarInput = document.getElementById("avatar-input--update-section")
    this.accountsTableBody = document.getElementById("accounts-table-body")

    this.isSubmitting = false

    this.initListeners()
    this.initSwitchStatusQuickly()
  }

  initListeners() {
    document
      .getElementById("update-account-submit-btn")
      .addEventListener("click", this.submitUpdateAccount.bind(this))

    document
      .getElementById("update-account-cancel-btn")
      .addEventListener("click", this.hideModal.bind(this))

    this.updateAccountModal.querySelector(".QUERY-modal-overlay").addEventListener("click", (e) => {
      this.hideModal()
    })

    this.avatarInput.addEventListener("change", this.handleAvatarInputChange.bind(this))
    document
      .getElementById("cancel-avatar-btn--update-section")
      .addEventListener("click", this.handleRemoveAvatar.bind(this))
  }

  switchToAvatarPreviewSection() {
    this.pickAvatarSection.classList.remove("QUERY-at-avatar-input-section")
    this.pickAvatarSection.classList.add("QUERY-at-avatar-preview-section")
  }

  switchToAvatarInputSection() {
    this.pickAvatarSection.classList.remove("QUERY-at-avatar-preview-section")
    this.pickAvatarSection.classList.add("QUERY-at-avatar-input-section")
  }

  handleAvatarInputChange(e) {
    const file = e.target.files[0]
    if (file) {
      const reader = new FileReader()
      reader.onload = (e) => {
        this.avatarPreview.src = e.target.result
        this.switchToAvatarPreviewSection()
      }
      reader.readAsDataURL(file)
    }
  }

  handleRemoveAvatar() {
    this.avatarPreview.src = ""
    this.avatarPreview.style.maxHeight = "fit-content"
    this.avatarInput.value = null
    this.switchToAvatarInputSection()
  }

  showModal(targetBtn) {
    const { accountId } = targetBtn.dataset
    this.accountId = accountId ? accountId * 1 : null
    const account = sharedData.gameAccounts.find((account) => account.id === this.accountId)
    const { avatar, acc_name, game_code, description, status, device_type, rank } = account
    document.getElementById("update-account-name").textContent = acc_name
    this.updateAccountForm.querySelector("input[name='accName']").value = acc_name
    this.updateAccountForm.querySelector("input[name='gameCode']").value = game_code
    this.updateAccountForm.querySelector("textarea[name='description']").value = description || ""
    this.updateAccountForm.querySelector("input[name='status']").value = status
    this.updateAccountForm.querySelector("input[name='deviceType']").value = device_type
    this.updateAccountForm.querySelector("input[name='rank']").value = rank
    this.updateAccountModal.hidden = false
    this.avatarPreview.src = `/images/account/${avatar || "default-game-account-avatar.png"}`
    if (!avatar) {
      this.avatarPreview.style.maxHeight = "200px"
    }
    this.switchToAvatarPreviewSection()
  }

  hideModal() {
    this.updateAccountModal.hidden = true
    this.updateAccountForm.reset()
  }

  validateFormData({ accName, rank, gameCode, status, deviceType }) {
    if (!accName) {
      Toaster.error("Tên tài khoản không được để trống")
      return false
    }
    if (!rank) {
      Toaster.error("Rank không được để trống")
      return false
    }
    if (!gameCode) {
      Toaster.error("Mã game không được để trống")
      return false
    }
    if (!status) {
      Toaster.error("Trạng thái không được để trống")
      return false
    }
    if (!deviceType) {
      Toaster.error("Loại thiết bị không được để trống")
      return false
    }
    return true
  }

  submitUpdateAccount() {
    if (this.isSubmitting) return
    this.isSubmitting = true

    const formData = new FormData(this.updateAccountForm)
    const data = {
      accName: formData.get("accName"),
      rank: formData.get("rank"),
      gameCode: formData.get("gameCode"),
      description: formData.get("description"),
      status: formData.get("status"),
      deviceType: formData.get("deviceType"),
    }
    if (!this.validateFormData({ ...data })) {
      this.isSubmitting = false
      return
    }

    AppLoadingHelper.show()
    GameAccountService.updateAccount(this.accountId, data, this.avatarInput.files?.[0])
      .then((data) => {
        if (data && data.success) {
          Toaster.success("Thông báo", "Cập nhật tài khoản thành công", () => {
            NavigationHelper.reloadPage()
          })
        }
      })
      .catch((error) => {
        Toaster.error(
          "Cập nhật tài khoản thất bại",
          AxiosErrorHandler.handleHTTPError(error).message
        )
      })
      .finally(() => {
        this.isSubmitting = false
        AppLoadingHelper.hide()
      })
  }

  switchStatus(status) {
    if (this.isSubmitting) return
    this.isSubmitting = true

    AppLoadingHelper.show()
    GameAccountService.updateAccount(this.accountId, { status })
      .then((data) => {
        if (data && data.success) {
          Toaster.success("Thông báo", "Cập nhật trạng thái tài khoản thành công", () => {
            NavigationHelper.reloadPage()
          })
        }
      })
      .catch((error) => {
        Toaster.error(
          "Cập nhật trạng thái tài khoản thất bại",
          AxiosErrorHandler.handleHTTPError(error).message
        )
      })
      .finally(() => {
        this.isSubmitting = false
        AppLoadingHelper.hide()
      })
  }

  initSwitchStatusQuickly() {
    this.accountsTableBody.addEventListener("click", (e) => {
      let target = e.target
      while (target && !target.classList.contains("QUERY-switch-status-btn")) {
        target = target.parentElement
        if (target.classList.contains("QUERY-account-row-item") || target.tagName === "BODY") {
          break
        }
      }
      const accountId = target.dataset.vcnAccountId * 1
      if (accountId) {
        const account = sharedData.gameAccounts.find((account) => account.id === accountId)
        if (account) {
          this.accountId = account.id
          this.switchStatus(account.status.toLowerCase() === "rảnh" ? "Bận" : "Rảnh")
        }
      }
    })
  }
}

class ImportExportManager {
  constructor() {
    this.initListeners()
  }

  initListeners() {
    document.getElementById("export-accounts-table-to-excel-btn").addEventListener("click", (e) => {
      this.exportAccountsTableToExcel()
    })

    document.getElementById("import-accounts-from-excel-btn").addEventListener("click", (e) => {
      this.importAccountsFromExcel()
    })
  }

  exportAccountsTableToExcel() {
    const rows = []
    const headerRow = [
      "Avatar",
      "Tên tài khoản",
      "Rank",
      "Mã game",
      "Trạng thái",
      "Mô tả",
      "Ngày tạo",
      "Loại máy",
    ]
    rows.push(headerRow)

    // Lấy tất cả các hàng từ tbody
    const tbody = document.getElementById("accounts-table-body")
    const trList = tbody.querySelectorAll("tr")

    trList.forEach((tr) => {
      const tds = tr.querySelectorAll("td")

      // Cấu trúc cột (dựa trên thứ tự column bạn định nghĩa):
      const avatar = tds[1]?.querySelector("img")?.src.split("images/account/")[1]
      const descRow = tds[6]
      const description = descRow?.querySelector(".QUERY-no-description")
        ? undefined
        : descRow.innerText.trim()
      const row = [
        avatar, // avatar
        tds[2]?.innerText.trim(), // acc_name
        tds[3]?.innerText.trim(), // rank
        tds[4]?.innerText.trim(), // game_code
        tds[5]?.innerText.trim(), // status
        description, // description
        tds[7]?.innerText.trim(), // created_date
        tds[8]?.innerText.trim(), // device_type
      ]

      rows.push(row)
    })

    const worksheet = XLSX.utils.aoa_to_sheet(rows)
    const workbook = XLSX.utils.book_new()
    XLSX.utils.book_append_sheet(workbook, worksheet, "GameAccounts")

    const today = dayjs().format("YYYY-MM-DD_HH-mm-ss")
    XLSX.writeFile(workbook, `DanhSachTaiKhoan_${today}.xlsx`)
  }

  importAccountsFromExcel() {
    const input = document.createElement("input")
    input.type = "file"
    input.accept = ".xlsx,.xls"
    input.style.display = "none"

    input.addEventListener("change", (event) => {
      const file = event.target.files[0]
      if (!file) return

      const reader = new FileReader()
      reader.onload = (e) => {
        try {
          const data = new Uint8Array(e.target.result)
          const workbook = XLSX.read(data, { type: "array" })
          const worksheet = workbook.Sheets[workbook.SheetNames[0]]
          const jsonData = XLSX.utils.sheet_to_json(worksheet, { header: 1 })

          // Bỏ qua header row
          const rows = jsonData.slice(1)

          if (rows.length === 0) {
            Toaster.error("Lỗi", "File Excel không có dữ liệu")
            return
          }

          const accounts = rows
            .map((row) => ({
              accName: row[1] || "",
              rank: row[2] || "",
              gameCode: row[3] || "",
              status: row[4] || "",
              description: row[5] || "",
              deviceType: row[7] || "",
            }))
            .filter(
              (account) => account.accName && account.rank && account.gameCode && account.deviceType
            )

          if (accounts.length === 0) {
            Toaster.error("Lỗi", "Không có dữ liệu hợp lệ trong file Excel")
            return
          }

          this.processImportAccounts(accounts)
        } catch (error) {
          Toaster.error("Lỗi", "Lỗi khi đọc file Excel")
        }
      }

      reader.readAsArrayBuffer(file)
    })

    document.body.appendChild(input)
    input.click()
    document.body.removeChild(input)
  }

  processImportAccounts(accounts) {
    AppLoadingHelper.show()

    GameAccountService.addNewAccounts(accounts)
      .then((data) => {
        if (data && data.success) {
          Toaster.success("Thông báo", `Đã import thành công ${accounts.length} tài khoản`, () => {
            NavigationHelper.reloadPage()
          })
        }
      })
      .catch((error) => {
        Toaster.error(AxiosErrorHandler.handleHTTPError(error).message)
      })
      .finally(() => {
        AppLoadingHelper.hide()
      })
  }
}

class FilterManager {
  constructor() {
    this.filtersSection = document.getElementById("filters-section")
    this.toggleFiltersBtn = document.getElementById("toggle-filters-btn")
    this.rankTypesSelect = this.filtersSection.querySelector(".QUERY-rank-types-select")
    this.statusesSelect = this.filtersSection.querySelector(".QUERY-statuses-select")
    this.deviceTypeSelect = this.filtersSection.querySelector(".QUERY-device-type-select")
    this.dateFromFilterField = document.getElementById("date-from-filter-field")
    this.dateToFilterField = document.getElementById("date-to-filter-field")
    this.searchBtn = document.getElementById("search-btn")
    this.searchInput = document.getElementById("search-input")
    this.countAppliedFilters = document.getElementById("count-applied-filters")

    this.fieldsRenderedCount = 2
    this.appliedFiltersCount = 0

    this.fetchRankTypes()
    this.fetchStatuses()
    this.fetchDeviceTypes()
    this.initFlatpickr()

    this.initShowFilters()
    this.initListeners()
  }

  initFlatpickr() {
    // Khởi tạo flatpickr cho input date từ
    flatpickr("#date-from-filter-field", {
      dateFormat: "d/m/Y H:i",
      enableTime: true,
      time_24hr: true,
      placeholder: "dd/mm/yyyy HH:mm",
      allowInput: true,
      clickOpens: true,
      minuteIncrement: 1,
    })

    // Khởi tạo flatpickr cho input date đến
    flatpickr("#date-to-filter-field", {
      dateFormat: "d/m/Y H:i",
      enableTime: true,
      time_24hr: true,
      placeholder: "dd/mm/yyyy HH:mm",
      allowInput: true,
      clickOpens: true,
      minuteIncrement: 1,
    })
  }

  initListeners() {
    this.toggleFiltersBtn.addEventListener("click", (e) => {
      if (this.filtersSection.hidden) {
        this.showFilters()
      } else {
        this.hideFilters()
      }
    })

    document
      .getElementById("reset-all-filters-btn")
      .addEventListener("click", this.resetAllFilters.bind(this))
  }

  initInputListeners() {
    this.rankTypesSelect.addEventListener("change", this.applyFilters.bind(this))
    this.statusesSelect.addEventListener("change", this.applyFilters.bind(this))
    this.deviceTypeSelect.addEventListener("change", this.applyFilters.bind(this))
    this.dateFromFilterField.addEventListener("change", this.applyFilters.bind(this))
    this.dateToFilterField.addEventListener("change", this.applyFilters.bind(this))
    this.searchBtn.addEventListener("click", this.searchAccounts.bind(this))
    this.searchInput.addEventListener("keydown", (e) => {
      if (e.key === "Enter") {
        this.searchAccounts()
      }
    })
  }

  adjustAppliedFiltersCount() {
    this.countAppliedFilters.hidden = this.appliedFiltersCount === 0
    this.countAppliedFilters.textContent = this.appliedFiltersCount
  }

  hideFilters() {
    this.toggleFiltersBtn.classList.remove("bg-blue-50", "border-blue-300", "text-blue-700")
    this.toggleFiltersBtn.classList.add("border-gray-300", "text-gray-700", "hover:bg-gray-50")
    this.filtersSection.hidden = true
    LocalStorageHelper.setShowFilters(false)
  }

  showFilters() {
    this.toggleFiltersBtn.classList.remove("border-gray-300", "text-gray-700", "hover:bg-gray-50")
    this.toggleFiltersBtn.classList.add("bg-blue-50", "border-blue-300", "text-blue-700")
    this.filtersSection.hidden = false
    LocalStorageHelper.setShowFilters(true)
  }

  initShowFilters() {
    const showFilters = LocalStorageHelper.getShowFilters()
    if (showFilters && showFilters === "true") {
      this.showFilters()
    }
  }

  fetchRankTypes() {
    GameAccountService.fetchAccountRankTypes().then((rankTypes) => {
      const allOption = document.createElement("option")
      allOption.value = "ALL"
      allOption.textContent = "Tất cả rank"
      this.rankTypesSelect.appendChild(allOption)

      for (const rankType of rankTypes) {
        const option = document.createElement("option")
        option.value = rankType.rank
        option.textContent = rankType.rank
        this.rankTypesSelect.appendChild(option)
      }

      this.fieldsRenderedCount++
      this.updateActiveFiltersDisplay()
    })
  }

  fetchStatuses() {
    GameAccountService.fetchAccountStatuses().then((statuses) => {
      const allOption = document.createElement("option")
      allOption.value = "ALL"
      allOption.textContent = "Tất cả trạng thái"
      this.statusesSelect.appendChild(allOption)

      for (const status of statuses) {
        const option = document.createElement("option")
        option.value = status.status
        option.textContent = status.status
        this.statusesSelect.appendChild(option)
      }

      this.fieldsRenderedCount++
      this.updateActiveFiltersDisplay()
    })
  }

  fetchDeviceTypes() {
    GameAccountService.fetchDeviceTypes().then((deviceTypes) => {
      const allOption = document.createElement("option")
      allOption.value = "ALL"
      allOption.textContent = "Tất cả loại máy"
      this.deviceTypeSelect.appendChild(allOption)

      for (const deviceType of deviceTypes) {
        const option = document.createElement("option")
        option.value = deviceType.device_type
        option.textContent = deviceType.device_type
        this.deviceTypeSelect.appendChild(option)
      }

      this.fieldsRenderedCount++
      this.updateActiveFiltersDisplay()
    })
  }

  applyFilters(e) {
    const formField = e.currentTarget
    const value = formField.value
    switch (formField.id) {
      case "date-from-filter-field":
        this.filterAndNavigate("date_from=" + (value ? encodeURIComponent(value) : ""))
        break
      case "date-to-filter-field":
        this.filterAndNavigate("date_to=" + (value ? encodeURIComponent(value) : ""))
        break
      case "rank-type-filter-field":
        this.filterAndNavigate("rank=" + (value === "ALL" ? "" : encodeURIComponent(value)))
        break
      case "status-filter-field":
        this.filterAndNavigate("status=" + (value === "ALL" ? "" : encodeURIComponent(value)))
        break
      case "device-type-filter-field":
        this.filterAndNavigate("device_type=" + (value === "ALL" ? "" : encodeURIComponent(value)))
        break
    }
  }

  filterAndNavigate(keyValuePair = "rank=&status=&device_type=&date_from=&date_to=") {
    const currentUrl = new URL(window.location.href)
    const params = new URLSearchParams(keyValuePair)
    for (const [key, value] of params.entries()) {
      if (value) {
        currentUrl.searchParams.set(key, value)
      } else {
        currentUrl.searchParams.delete(key)
      }
    }
    NavigationHelper.pureNavigateTo(currentUrl.toString())
  }

  resetAllFilters() {
    this.filterAndNavigate()
  }

  updateActiveFiltersDisplay() {
    if (this.fieldsRenderedCount < 5) return

    const rankValue = URLHelper.getUrlQueryParam("rank")
    if (rankValue) {
      this.rankTypesSelect.value = rankValue
      this.appliedFiltersCount++
    } else {
      this.rankTypesSelect.value = "ALL"
    }

    const statusValue = URLHelper.getUrlQueryParam("status")
    if (statusValue) {
      this.statusesSelect.value = statusValue
      this.appliedFiltersCount++
    } else {
      this.statusesSelect.value = "ALL"
    }

    const deviceTypeValue = URLHelper.getUrlQueryParam("device_type")
    if (deviceTypeValue) {
      this.deviceTypeSelect.value = deviceTypeValue
      this.appliedFiltersCount++
    } else {
      this.deviceTypeSelect.value = "ALL"
    }

    const dateFromValue = URLHelper.getUrlQueryParam("date_from")
    if (dateFromValue) {
      this.dateFromFilterField.value = dateFromValue
      if (this.dateFromFilterField._flatpickr) {
        this.dateFromFilterField._flatpickr.setDate(dateFromValue)
        this.appliedFiltersCount++
      }
    } else {
      this.dateFromFilterField.value = ""
      if (this.dateFromFilterField._flatpickr) {
        this.dateFromFilterField._flatpickr.clear()
      }
    }

    const dateToValue = URLHelper.getUrlQueryParam("date_to")
    if (dateToValue) {
      this.dateToFilterField.value = dateToValue
      if (this.dateToFilterField._flatpickr) {
        this.dateToFilterField._flatpickr.setDate(dateToValue)
        this.appliedFiltersCount++
      }
    } else {
      this.dateToFilterField.value = ""
      if (this.dateToFilterField._flatpickr) {
        this.dateToFilterField._flatpickr.clear()
      }
    }

    const searchTerm = URLHelper.getUrlQueryParam("search_term")
    if (searchTerm) {
      this.searchInput.value = searchTerm
      this.appliedFiltersCount++
    } else {
      this.searchInput.value = ""
    }

    this.adjustAppliedFiltersCount()
    this.initInputListeners()
  }

  searchAccounts() {
    const searchTerm = this.searchInput.value.trim()
    if (searchTerm) {
      this.filterAndNavigate("search_term=" + encodeURIComponent(searchTerm))
    } else {
      this.filterAndNavigate("search_term=")
    }
  }
}

// new ImportExportManager()
new AddNewAccountManager()
const updateAccountManager = new UpdateAccountManager()
const deleteAccountManager = new DeleteAccountManager()
new FilterManager()
const manageGameAccountsPageManager = new ManageGameAccountsPageManager()
