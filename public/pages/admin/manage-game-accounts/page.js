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

class ManageGameAccountsPageManager {
  constructor() {
    this.accountsTableBody = document.getElementById("accounts-table-body")
    this.loadMoreContainer = document.getElementById("load-more-container")

    this.isFetchingItems = false
    this.isMoreItems = true
    this.gameAccounts = []

    this.fetchAccounts()
    this.initListeners()
    this.initLucideIcons()
  }

  getAccountsTableBodyEle() {
    return this.accountsTableBody
  }

  getGameAccounts() {
    return this.gameAccounts
  }

  fetchAccounts() {
    if (this.isFetchingItems || !this.isMoreItems) return
    this.isFetchingItems = true

    AppLoadingHelper.show()

    let last_id
    if (this.gameAccounts.length > 0) {
      last_id = this.gameAccounts.at(-1).id
    } else {
      last_id = URLHelper.getUrlQueryParam("last_id")
    }
    const rank = URLHelper.getUrlQueryParam("rank")
    const status = URLHelper.getUrlQueryParam("status")
    const device_type = URLHelper.getUrlQueryParam("device_type")
    const search_term = URLHelper.getUrlQueryParam("search_term")
    const date_from = URLHelper.getUrlQueryParam("date_from")
    const date_to = URLHelper.getUrlQueryParam("date_to")

    GameAccountService.fetchAccounts(
      last_id,
      rank,
      status,
      device_type,
      search_term,
      date_from,
      date_to
    )
      .then((accounts) => {
        if (accounts && accounts.length > 0) {
          this.gameAccounts = [...this.gameAccounts, ...accounts]
          this.renderAccounts()
          this.initCatchDeleteAndUpdateAccountBtnClick()
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

  initLucideIcons() {
    lucide.createIcons()
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

    const gameAccounts = this.gameAccounts
    for (const account of gameAccounts) {
      const accountRow = LitHTMLHelper.getFragment(AccountRow, account)
      this.accountsTableBody.appendChild(accountRow)
    }
  }

  initListeners() {
    document.getElementById("load-more-btn").addEventListener("click", (e) => {
      this.fetchAccounts()
    })
  }
}

class AddNewAccountManager {
  constructor() {
    this.addNewAccountModal = document.getElementById("add-new-account-modal")
    this.addNewAccountForm = document.getElementById("add-new-account-form")
    this.deviceTypeSelect = this.addNewAccountModal.querySelector(".QUERY-device-type-select")
    this.rankTypesSelect = this.addNewAccountModal.querySelector(".QUERY-rank-types-select")
    this.statusesSelect = this.addNewAccountModal.querySelector(".QUERY-statuses-select")

    this.isSubmitting = false

    this.fetchDeviceTypes()
    this.fetchAccountRankTypes()
    this.fetchAccountStatuses()

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
  }

  showModal() {
    this.addNewAccountModal.hidden = false
  }

  hideModal() {
    this.addNewAccountModal.hidden = true
    this.addNewAccountForm.reset()
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
    })
  }

  fetchAccountRankTypes() {
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
    })
  }

  fetchAccountStatuses() {
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
    })
  }

  validateFormData({ accName, rank, gameCode, description, status, deviceType }) {
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
    if (!description) {
      Toaster.error("Mô tả không được để trống")
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

  submitAddAccount() {
    if (this.isSubmitting) return
    this.isSubmitting = true

    const formData = new FormData(this.addNewAccountForm)
    const accName = formData.get("accName"),
      rank = formData.get("rank"),
      gameCode = formData.get("gameCode"),
      description = formData.get("description"),
      status = formData.get("status"),
      deviceType = formData.get("deviceType")

    if (!this.validateFormData({ accName, rank, gameCode, description, status, deviceType })) return

    AppLoadingHelper.show()
    GameAccountService.addNewAccount({
      accName,
      rank,
      gameCode,
      description,
      status,
      deviceType,
    })
      .then((data) => {
        if (data && data.success) {
          Toaster.success("Thông báo", "Thêm tài khoản thành công", () => {
            NavigationHelper.reloadPage()
          })
        }
      })
      .catch((error) => {
        Toaster.error(AxiosErrorHandler.handleHTTPError(error).message)
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
    const account = manageGameAccountsPageManager
      .getGameAccounts()
      .find((account) => account.id === this.accountId)
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
    this.deviceTypeSelect = this.updateAccountModal.querySelector(".QUERY-device-type-select")
    this.rankTypesSelect = this.updateAccountModal.querySelector(".QUERY-rank-types-select")
    this.statusesSelect = this.updateAccountModal.querySelector(".QUERY-statuses-select")

    this.isSubmitting = false

    this.fetchDeviceTypes()
    this.fetchAccountRankTypes()
    this.fetchAccountStatuses()

    this.initListeners()
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
  }

  showModal(targetBtn) {
    const { accountId } = targetBtn.dataset
    this.accountId = accountId ? accountId * 1 : null
    const account = manageGameAccountsPageManager
      .getGameAccounts()
      .find((account) => account.id === this.accountId)
    document.getElementById("update-account-name").textContent = account.acc_name
    this.updateAccountForm.querySelector("input[name='accName']").value = account.acc_name
    this.updateAccountForm.querySelector("input[name='gameCode']").value = account.game_code
    this.updateAccountForm.querySelector("textarea[name='description']").value =
      account.description || ""
    this.updateAccountForm.querySelector("select[name='status']").value = account.status
    this.updateAccountForm.querySelector("select[name='deviceType']").value = account.device_type
    this.updateAccountForm.querySelector("select[name='rank']").value = account.rank
    this.updateAccountModal.hidden = false
  }

  hideModal() {
    this.updateAccountModal.hidden = true
    this.updateAccountForm.reset()
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
    })
  }

  fetchAccountRankTypes() {
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
    })
  }

  fetchAccountStatuses() {
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
    })
  }

  validateFormData({ accName, rank, gameCode, description, status, deviceType }) {
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
    if (!description) {
      Toaster.error("Mô tả không được để trống")
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
    const accName = formData.get("accName"),
      rank = formData.get("rank"),
      gameCode = formData.get("gameCode"),
      description = formData.get("description"),
      status = formData.get("status"),
      deviceType = formData.get("deviceType")

    if (!this.validateFormData({ accName, rank, gameCode, description, status, deviceType })) return

    AppLoadingHelper.show()
    GameAccountService.updateAccount(this.accountId, {
      accName,
      rank,
      gameCode,
      description,
      status,
      deviceType,
    })
      .then((data) => {
        if (data && data.success) {
          Toaster.success("Thông báo", "Cập nhật tài khoản thành công", () => {
            NavigationHelper.reloadPage()
          })
        }
      })
      .catch((error) => {
        Toaster.error(AxiosErrorHandler.handleHTTPError(error).message)
      })
      .finally(() => {
        this.isSubmitting = false
        AppLoadingHelper.hide()
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

    const today = dayjs().format("YYYY-MM-DD_HH-mm")
    XLSX.writeFile(workbook, `DanhSachTaiKhoan_${today}.xlsx`)
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

    this.fieldsRenderedCount = 2

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
        this.filterAndNavigate("date_from=" + encodeURIComponent(value))
        break
      case "date-to-filter-field":
        this.filterAndNavigate("date_to=" + encodeURIComponent(value))
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
    } else {
      this.rankTypesSelect.value = "ALL"
    }

    const statusValue = URLHelper.getUrlQueryParam("status")
    if (statusValue) {
      this.statusesSelect.value = statusValue
    } else {
      this.statusesSelect.value = "ALL"
    }

    const deviceTypeValue = URLHelper.getUrlQueryParam("device_type")
    if (deviceTypeValue) {
      this.deviceTypeSelect.value = deviceTypeValue
    } else {
      this.deviceTypeSelect.value = "ALL"
    }

    const dateFromValue = URLHelper.getUrlQueryParam("date_from")
    if (dateFromValue) {
      this.dateFromFilterField.value = dateFromValue
      if (this.dateFromFilterField._flatpickr) {
        this.dateFromFilterField._flatpickr.setDate(dateFromValue)
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
    }

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

new ImportExportManager()
new AddNewAccountManager()
const deleteAccountManager = new DeleteAccountManager()
new FilterManager()
const manageGameAccountsPageManager = new ManageGameAccountsPageManager()
const updateAccountManager = new UpdateAccountManager()
