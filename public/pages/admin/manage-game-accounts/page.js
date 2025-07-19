import { GameAccountService } from "../../../services/game-account-services.js"
import { AccountPreviewRow, AccountRow } from "../../../utils/scripts/components.js"
import {
  LitHTMLHelper,
  AppLoadingHelper,
  AxiosErrorHandler,
  Toaster,
  URLHelper,
  NavigationHelper,
  LocalStorageHelper,
  ValidationHelper,
} from "../../../utils/scripts/helpers.js"
import { initUtils } from "../../../utils/scripts/init-utils.js"

const sharedData = {
  gameAccounts: [],
  rankTypes: window.APP_DATA.ranks,
}

class ManageGameAccountsPageManager {
  constructor() {
    this.accountsTableBody = document.getElementById("accounts-table-body")
    this.loadMoreContainer = document.getElementById("load-more-container")
    this.scrollToTopBtn = document.getElementById("scroll-to-top-btn")
    this.scrollToBottomBtn = document.getElementById("scroll-to-bottom-btn")

    this.isFetchingItems = false
    this.isMoreItems = true
    this.rentTimeInputId = null

    this.updateAccountRentTime()
    this.initRankSelectListeners()

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

  updateAccountRentTime() {
    AppLoadingHelper.show("Đang cập nhật thời gian cho thuê...")
    GameAccountService.updateAccountRentTime()
      .then((data) => {
        if (data && data.success) {
          AppLoadingHelper.hide()
          this.fetchAccounts()
        }
      })
      .catch((error) => {
        AppLoadingHelper.hide()
        Toaster.error(
          "Lỗi cập nhật thời gian cho thuê",
          AxiosErrorHandler.handleHTTPError(error).message
        )
      })
  }

  fetchAccounts() {
    if (this.isFetchingItems || !this.isMoreItems) return
    this.isFetchingItems = true

    AppLoadingHelper.show("Đang tải dữ liệu...")
    const lastAccount = this.getLastAccount()
    let last_id = lastAccount ? lastAccount.id : null
    let last_updated_at = lastAccount ? lastAccount.updated_at : null
    const rank = URLHelper.getUrlQueryParam("rank")
    const status = URLHelper.getUrlQueryParam("status")
    const device_type = URLHelper.getUrlQueryParam("device_type")
    const search_term = URLHelper.getUrlQueryParam("search_term")

    GameAccountService.fetchAccounts(
      last_id,
      last_updated_at,
      rank,
      status,
      device_type,
      search_term,
      "updated_at"
    )
      .then((accounts) => {
        if (accounts && accounts.length > 0) {
          const startOrderNumber = sharedData.gameAccounts.length + 1
          sharedData.gameAccounts = [...sharedData.gameAccounts, ...accounts]
          this.renderNewAccounts(accounts, startOrderNumber)
          this.initRentTimeInputListeners()
          this.initCatchDeleteAndUpdateAccountBtnClick()
          this.initCancelRentBtnListener()
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
    // khi click lên btn delete hoặc update
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
        deleteAccountManager.showModal(target.dataset.accountId * 1)
      }
      if (isUpdateBtn) {
        updateAccountManager.showModal(target.dataset.accountId * 1)
      }
    })
  }

  renderNewAccounts(newAccounts, startOrderNumber) {
    let order_number = startOrderNumber
    for (const account of newAccounts) {
      const accountRow = LitHTMLHelper.getFragment(
        AccountRow,
        account,
        order_number,
        UIEditor.convertRankTypesToRenderingRanks(sharedData.rankTypes)
      )
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

  scrollToBottom() {
    const pageScrollHeight = document.body.scrollHeight
    window.scrollTo({
      top: pageScrollHeight - document.documentElement.clientHeight - 100,
      behavior: "instant",
    })
    window.scrollTo({
      top: pageScrollHeight,
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
      if (window.scrollY < document.body.scrollHeight - window.innerHeight - THRESHOLD) {
        this.scrollToBottomBtn.classList.remove("bottom-[-60px]")
        this.scrollToBottomBtn.classList.add("bottom-[100px]")
      } else {
        this.scrollToBottomBtn.classList.remove("bottom-[100px]")
        this.scrollToBottomBtn.classList.add("bottom-[-60px]")
      }
    })
  }

  initListeners() {
    document.getElementById("load-more-btn").addEventListener("click", (e) => {
      this.fetchAccounts()
    })

    this.scrollToTopBtn.addEventListener("click", this.scrollToTop.bind(this))
    this.scrollToBottomBtn.addEventListener("click", this.scrollToBottom.bind(this))
  }

  submitRentTimeFromInput(input) {
    const value = input.value || ""
    if (value) {
      if (!ValidationHelper.isPureInteger(value)) {
        Toaster.error("Thời gian cho thuê phải là một số nguyên")
        return
      }
      if (value * 1 <= 0) {
        Toaster.error("Thời gian cho thuê phải lớn hơn 0")
        return
      }
      if (!this.rentTimeInputId) return
      let rentToTimeValue = input.dataset.rentToTimeValue
      rentToTimeValue = rentToTimeValue ? dayjs(rentToTimeValue) : dayjs() // nếu ko có thời gian cho thuê thì lấy thời gian hiện tại
      rentToTimeValue = rentToTimeValue.add(value, "hours").format("YYYY-MM-DD HH:mm:ss")
      updateAccountManager.updateRentTime(this.rentTimeInputId, rentToTimeValue)
    } else {
      Toaster.error("Thời gian thuê không được để trống")
    }
  }

  initRentTimeInputListeners() {
    document.body.addEventListener("click", (e) => {
      const target = e.target
      if (target && !target.closest(".QUERY-rent-time-input-container")) {
        const rentTimeActions = this.accountsTableBody.querySelector(
          `.QUERY-account-row-item .QUERY-rent-time-input-container-${this.rentTimeInputId} .QUERY-rent-time-actions`
        )
        if (rentTimeActions) {
          rentTimeActions.hidden = true
        }
        this.rentTimeInputId = null
      }
    })

    this.accountsTableBody.addEventListener("focusin", (e) => {
      let target = e.target
      while (target && target.tagName !== "INPUT") {
        target = target.parentElement
        if (target && target.classList.contains("accounts-table-body")) {
          return
        }
      }
      if (!target) return
      this.rentTimeInputId = target.dataset.rentTimeInputId * 1
      const actionsSection = target.nextElementSibling
      if (actionsSection) {
        actionsSection.hidden = false
      }
    })
    // bắt sự kiện lưu thời gian cho thuê
    this.accountsTableBody.addEventListener("click", (e) => {
      let target = e.target
      while (target && !target.classList.contains("QUERY-rent-time-save-action")) {
        target = target.parentElement
        if (target && target.classList.contains("accounts-table-body")) {
          return
        }
      }
      if (!target) return
      const input = target.closest(".QUERY-rent-time-input-container").querySelector("input")
      if (input) {
        this.submitRentTimeFromInput(input)
      }
    })
    // bắt sự kiện nhấn enter trong input
    this.accountsTableBody.addEventListener("keydown", (e) => {
      if (e.key === "Enter") {
        e.preventDefault()
        let target = e.target
        while (target && target.tagName !== "INPUT") {
          target = target.parentElement
          if (target && target.classList.contains("accounts-table-body")) {
            return
          }
        }
        if (!target) return
        this.submitRentTimeFromInput(target)
      }
    })
  }

  cancelRent(accountId) {
    AppLoadingHelper.show()
    GameAccountService.cancelRent(accountId)
      .then((data) => {
        if (data && data.success) {
          Toaster.success("Thông báo", "Hủy cho thuê thành công")
          uiEditor.refreshAccountRowOnUI(accountId)
        }
      })
      .catch((error) => {
        Toaster.error(AxiosErrorHandler.handleHTTPError(error).message)
      })
      .finally(() => {
        AppLoadingHelper.hide()
      })
  }

  initCancelRentBtnListener() {
    this.accountsTableBody.addEventListener("click", (e) => {
      let target = e.target
      while (target && !target.classList.contains("QUERY-cancel-rent-btn")) {
        target = target.parentElement
        if (target && target.classList.contains("accounts-table-body")) {
          return
        }
      }
      if (!target) return
      const accountId = target.closest(".QUERY-account-row-item").dataset.accountId
      this.cancelRent(accountId)
    })
  }

  initRankSelectListeners() {
    this.accountsTableBody.addEventListener("change", (e) => {
      let target = e.target
      while (target && !target.classList.contains("QUERY-ranks-select")) {
        target = target.parentElement
        if (target && target.classList.contains("accounts-table-body")) {
          return
        }
      }
      if (!target) return
      const accountId = target.dataset.accountId
      const rank = target.value
      AppLoadingHelper.show()
      GameAccountService.updateAccount(accountId, { rank })
        .then((data) => {
          if (data && data.success) {
            uiEditor.refreshAccountRowOnUI(accountId)
          }
        })
        .catch((error) => {
          Toaster.error(AxiosErrorHandler.handleHTTPError(error).message)
        })
        .finally(() => {
          AppLoadingHelper.hide()
        })
    })
  }
}

class UIEditor {
  constructor() {
    this.accountsTableBody = document.getElementById("accounts-table-body")
  }

  setAccountRow(accountRow, accountData, orderNumber, ranksToRender) {
    const newAccountRow = LitHTMLHelper.getFragment(
      AccountRow,
      accountData,
      orderNumber,
      ranksToRender
    )
    accountRow.replaceWith(newAccountRow)
  }

  static convertRankTypesToRenderingRanks(rankTypes) {
    const ranksToRender = []
    for (const { type } of rankTypes) {
      if (type !== "Radiant") {
        ranksToRender.push(`${type} 1`, `${type} 2`, `${type} 3`)
      } else {
        ranksToRender.push(type)
      }
    }
    return ranksToRender
  }

  refreshAccountRowOnUI(accountId) {
    GameAccountService.fetchSingleAccount(accountId)
      .then((data) => {
        if (data && data.success) {
          const account = data.account
          if (account) {
            sharedData.gameAccounts = sharedData.gameAccounts.map((acc) =>
              acc.id === accountId ? account : acc
            )
            const accountRow = this.accountsTableBody.querySelector(
              `.QUERY-account-row-item-${accountId}`
            )
            if (accountRow) {
              this.setAccountRow(
                accountRow,
                account,
                accountRow.dataset.accountOrderNumber * 1,
                UIEditor.convertRankTypesToRenderingRanks(sharedData.rankTypes)
              )
              initUtils.initTooltip()
            }
          }
        }
      })
      .catch((error) => {
        Toaster.error(AxiosErrorHandler.handleHTTPError(error).message)
      })
  }
}

class AddNewAccountManager {
  constructor() {
    this.addNewAccountModal = document.getElementById("add-new-account-modal")
    this.addNewAccountForm = document.getElementById("add-new-account-form")
    this.pickAvatarSection = document.getElementById("pick-avatar--add-section")
    this.avatarPreview = document.getElementById("avatar-preview-img--add-section")
    this.avatarInput = document.getElementById("avatar-input--add-section")
    this.ranksSelect = document.getElementById("ranks-select--add-section")
    this.statusSelect = document.getElementById("status-select--add-section")
    this.deviceTypesSelect = document.getElementById("device-types-select--add-section")

    this.isSubmitting = false

    this.statusOptions = []
    this.deviceTypeOptions = []

    this.initListeners()
  }

  setStatusOptions(options) {
    this.statusOptions = options
  }

  setDeviceTypeOptions(options) {
    this.deviceTypeOptions = options
  }

  renderRanksSelect() {
    const rankTypes = UIEditor.convertRankTypesToRenderingRanks(sharedData.rankTypes)
    this.ranksSelect.innerHTML = ""
    for (const rank of rankTypes) {
      const option = document.createElement("option")
      option.value = rank
      option.textContent = rank
      this.ranksSelect.appendChild(option)
    }
  }

  renderStatusSelect() {
    this.statusSelect.innerHTML = ""
    const statuses = this.statusOptions
    for (const status of statuses) {
      const option = document.createElement("option")
      option.value = status
      option.textContent = status
      this.statusSelect.appendChild(option)
    }
  }

  renderDeviceTypesSelect() {
    this.deviceTypesSelect.innerHTML = ""
    const deviceTypes = this.deviceTypeOptions
    for (const deviceType of deviceTypes) {
      const option = document.createElement("option")
      option.value = deviceType
      option.textContent = deviceType
      this.deviceTypesSelect.appendChild(option)
    }
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
    this.renderRanksSelect()
    this.renderStatusSelect()
    this.renderDeviceTypesSelect()
    this.addNewAccountModal.hidden = false
  }

  hideModal() {
    this.addNewAccountModal.hidden = true
    this.addNewAccountForm.reset()
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
    if (!this.validateFormData({ ...data })) {
      this.isSubmitting = false
      return
    }

    AppLoadingHelper.show()
    GameAccountService.addNewAccounts([data], this.avatarInput.files?.[0])
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

  showModal(accountId) {
    this.accountId = accountId
    const account = sharedData.gameAccounts.find((account) => account.id === accountId)
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
    this.ranksSelect = document.getElementById("ranks-select--update-section")
    this.statusSelect = document.getElementById("status-select--update-section")
    this.deviceTypesSelect = document.getElementById("device-types-select--update-section")

    this.isSubmitting = false
    this.statusOptions = []
    this.deviceTypeOptions = []

    this.initListeners()
    this.initSwitchStatusQuickly()
    this.initSwitchDeviceTypeQuickly()
  }

  setStatusOptions(options) {
    this.statusOptions = options
  }

  setDeviceTypeOptions(options) {
    this.deviceTypeOptions = options
  }

  renderRanksSelect(account) {
    const rankTypes = UIEditor.convertRankTypesToRenderingRanks(sharedData.rankTypes)
    this.ranksSelect.innerHTML = ""
    for (const rank of rankTypes) {
      const option = document.createElement("option")
      option.value = rank
      option.textContent = rank
      if (rank === account.rank) {
        option.selected = true
      }
      this.ranksSelect.appendChild(option)
    }
  }

  renderStatusSelect(account) {
    this.statusSelect.innerHTML = ""
    const statuses = this.statusOptions
    for (const status of statuses) {
      const option = document.createElement("option")
      option.value = status
      option.textContent = status
      if (status === account.status) {
        option.selected = true
      }
      this.statusSelect.appendChild(option)
    }
  }

  renderDeviceTypesSelect(account) {
    this.deviceTypesSelect.innerHTML = ""
    const deviceTypes = this.deviceTypeOptions
    for (const deviceType of deviceTypes) {
      const option = document.createElement("option")
      option.value = deviceType
      option.textContent = deviceType
      if (deviceType === account.device_type) {
        option.selected = true
      }
      this.deviceTypesSelect.appendChild(option)
    }
  }

  updateRentTime(accountId, toTime) {
    AppLoadingHelper.show()
    GameAccountService.updateAccount(accountId, { rentToTime: toTime })
      .then((data) => {
        if (data && data.success) {
          uiEditor.refreshAccountRowOnUI(accountId)
          Toaster.success("Thông báo", "Cập nhật thời gian cho thuê thành công")
        }
      })
      .catch((error) => {
        Toaster.error(AxiosErrorHandler.handleHTTPError(error).message)
      })
      .finally(() => {
        AppLoadingHelper.hide()
      })
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

  showModal(accountId) {
    this.accountId = accountId
    const account = sharedData.gameAccounts.find((account) => account.id === accountId)
    const { avatar, acc_name, game_code, description } = account
    document.getElementById("update-account-name").textContent = acc_name
    this.updateAccountForm.querySelector("input[name='accName']").value = acc_name
    this.updateAccountForm.querySelector("input[name='gameCode']").value = game_code
    this.updateAccountForm.querySelector("textarea[name='description']").value = description || ""
    this.renderRanksSelect(account)
    this.renderStatusSelect(account)
    this.renderDeviceTypesSelect(account)
    this.updateAccountModal.hidden = false
    this.avatarPreview.src = `/images/account/${avatar || "default-account-avatar.png"}`
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
          uiEditor.refreshAccountRowOnUI(this.accountId)
          Toaster.success("Thông báo", "Cập nhật tài khoản thành công")
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

  switchStatus() {
    if (this.isSubmitting) return
    this.isSubmitting = true

    AppLoadingHelper.show()
    GameAccountService.switchAccountStatus(this.accountId)
      .then((data) => {
        if (data && data.success) {
          uiEditor.refreshAccountRowOnUI(this.accountId)
          Toaster.success("Thông báo", "Cập nhật trạng thái tài khoản thành công")
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
        if (
          (target && target.classList.contains("QUERY-account-row-item")) ||
          target.tagName === "BODY"
        ) {
          break
        }
      }
      if (!target || !target.classList.contains("QUERY-switch-status-btn")) return
      const accountId = target.dataset.vcnAccountId * 1
      if (accountId) {
        const account = sharedData.gameAccounts.find((account) => account.id === accountId)
        if (account) {
          this.accountId = account.id
          this.switchStatus()
        }
      }
    })
  }

  switchDeviceType() {
    if (this.isSubmitting) return
    this.isSubmitting = true

    AppLoadingHelper.show()
    GameAccountService.switchDeviceType(this.accountId)
      .then((data) => {
        if (data && data.success) {
          uiEditor.refreshAccountRowOnUI(this.accountId)
          Toaster.success("Thông báo", "Cập nhật loại máy thành công")
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

  initSwitchDeviceTypeQuickly() {
    this.accountsTableBody.addEventListener("click", (e) => {
      let target = e.target
      while (target && !target.classList.contains("QUERY-switch-device-type-btn")) {
        target = target.parentElement
        if (
          (target && target.classList.contains("QUERY-account-row-item")) ||
          target.tagName === "BODY"
        ) {
          break
        }
      }
      if (!target || !target.classList.contains("QUERY-switch-device-type-btn")) return
      const accountId = target.closest(".QUERY-account-row-item").dataset.accountId * 1
      if (accountId) {
        const account = sharedData.gameAccounts.find((account) => account.id === accountId)
        if (account) {
          this.accountId = account.id
          this.switchDeviceType()
        }
      }
    })
  }
}

class ImportExportManager {
  constructor() {
    this.accountsPreviewModal = document.getElementById("accounts-preview-modal")

    this.accountsImporting = []

    this.initListeners()
  }

  initListeners() {
    document.getElementById("export-accounts-table-to-excel-btn").addEventListener("click", (e) => {
      this.exportAccountsTableToExcel()
    })

    document.getElementById("import-accounts-from-excel-btn").addEventListener("click", (e) => {
      this.importAccountsFromExcel()
    })

    this.accountsPreviewModal
      .querySelector(".QUERY-accounts-preview-overlay")
      .addEventListener("click", (e) => {
        this.accountsImporting = []
        this.hideAccountsPreviewModal()
      })

    document.getElementById("start-importing-accounts-btn").addEventListener("click", (e) => {
      this.processImportAccounts()
    })

    document.getElementById("cancel-importing-accounts-btn").addEventListener("click", (e) => {
      this.accountsImporting = []
      this.hideAccountsPreviewModal()
    })
  }

  showAccountsPreviewModal() {
    this.accountsPreviewModal.hidden = false
    const accountsPreviewTableBody = document.getElementById("accounts-preview-table-body")
    accountsPreviewTableBody.innerHTML = ""

    let order_number = 1
    const accounts = this.accountsImporting
    for (const account of accounts) {
      const accountRow = LitHTMLHelper.getFragment(AccountPreviewRow, account, order_number)
      accountsPreviewTableBody.appendChild(accountRow)
      order_number++
    }

    initUtils.initTooltip()
  }

  hideAccountsPreviewModal() {
    this.accountsPreviewModal.hidden = true
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
              deviceType: row[6] || "",
            }))
            .filter(
              (account) =>
                account.accName &&
                account.rank &&
                account.gameCode &&
                account.deviceType &&
                account.status
            )

          if (accounts.length === 0) {
            Toaster.error("Lỗi", "Không có dữ liệu hợp lệ trong file Excel")
            return
          }

          this.accountsImporting = accounts
          this.showAccountsPreviewModal()
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

  processImportAccounts() {
    const accounts = this.accountsImporting
    AppLoadingHelper.show()
    GameAccountService.addNewAccounts(accounts)
      .then((data) => {
        if (data && data.success) {
          Toaster.success("Thông báo", `Đã tải lên thành công ${accounts.length} tài khoản`, () => {
            NavigationHelper.reloadPage()
          })
        }
      })
      .catch((error) => {
        Toaster.error("Lỗi thêm tài khoản", AxiosErrorHandler.handleHTTPError(error).message)
      })
      .finally(() => {
        AppLoadingHelper.hide()
      })
  }
}

// class này có load data dùng chung cho các class khác trong cùng file này
class FilterManager {
  constructor() {
    this.filtersSection = document.getElementById("filters-section")
    this.toggleFiltersBtn = document.getElementById("toggle-filters-btn")
    this.rankTypesSelect = this.filtersSection.querySelector(".QUERY-rank-types-select")
    this.statusesSelect = this.filtersSection.querySelector(".QUERY-statuses-select")
    this.deviceTypeSelect = this.filtersSection.querySelector(".QUERY-device-type-select")
    this.searchBtn = document.getElementById("search-btn")
    this.searchInput = document.getElementById("search-input")
    this.countAppliedFilters = document.getElementById("count-applied-filters")

    this.fieldsRenderedCount = 2
    this.appliedFiltersCount = 0
    this.urlForFilters = ""

    this.renderRankTypes()
    this.fetchStatuses()
    this.fetchDeviceTypes()

    this.initShowFilters()
    this.initListeners()
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

    document
      .getElementById("apply-filters-btn")
      .addEventListener("click", this.applyFilters.bind(this))
  }

  initInputListeners() {
    this.rankTypesSelect.addEventListener("change", this.handleFilterChange.bind(this))
    this.statusesSelect.addEventListener("change", this.handleFilterChange.bind(this))
    this.deviceTypeSelect.addEventListener("change", this.handleFilterChange.bind(this))
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
    this.countAppliedFilters.dataset.countAppliedFilters = this.appliedFiltersCount
    initUtils.linkTooltip(
      this.countAppliedFilters,
      `Bộ lọc đã áp dụng: ${this.appliedFiltersCount}`
    )
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

  renderRankTypes() {
    const rankTypes = sharedData.rankTypes

    const allOption = document.createElement("option")
    allOption.value = "ALL"
    allOption.textContent = "Tất cả rank"
    this.rankTypesSelect.appendChild(allOption)

    for (const rankType of rankTypes) {
      const option = document.createElement("option")
      option.value = rankType.type
      option.textContent = rankType.type
      this.rankTypesSelect.appendChild(option)
    }

    this.fieldsRenderedCount++
    this.updateActiveFiltersDisplay()
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

      addNewAccountManager.setStatusOptions(statuses.map(({ status }) => status))
      updateAccountManager.setStatusOptions(statuses.map(({ status }) => status))
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

      addNewAccountManager.setDeviceTypeOptions(deviceTypes.map(({ device_type }) => device_type))
      updateAccountManager.setDeviceTypeOptions(deviceTypes.map(({ device_type }) => device_type))
    })
  }

  saveQueryStringForFilters(keyValuePair = "rank=&status=&device_type=") {
    const currentUrlForFilters = new URL(this.urlForFilters || window.location.href)
    const params = new URLSearchParams(keyValuePair)
    for (const [key, value] of params.entries()) {
      if (value) {
        currentUrlForFilters.searchParams.set(key, value)
      } else {
        currentUrlForFilters.searchParams.delete(key)
      }
    }
    this.urlForFilters = currentUrlForFilters.toString()
  }

  handleFilterChange(e) {
    const formField = e.currentTarget
    const value = formField.value
    switch (formField.id) {
      case "rank-type-filter-field":
        this.saveQueryStringForFilters(
          "rank=" + (value && value !== "ALL" ? encodeURIComponent(value) : "")
        )
        break
      case "status-filter-field":
        this.saveQueryStringForFilters(
          "status=" + (value && value !== "ALL" ? encodeURIComponent(value) : "")
        )
        break
      case "device-type-filter-field":
        this.saveQueryStringForFilters(
          "device_type=" + (value && value !== "ALL" ? encodeURIComponent(value) : "")
        )
        break
    }
  }

  applyFilters() {
    NavigationHelper.pureNavigateTo(this.urlForFilters)
  }

  resetAllFilters() {
    this.saveQueryStringForFilters()
    this.applyFilters()
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
      this.saveQueryStringForFilters("search_term=" + encodeURIComponent(searchTerm))
    } else {
      this.saveQueryStringForFilters("search_term=")
    }
    this.applyFilters()
  }
}

const uiEditor = new UIEditor()
new ImportExportManager()
const addNewAccountManager = new AddNewAccountManager()
const updateAccountManager = new UpdateAccountManager()
const deleteAccountManager = new DeleteAccountManager()
new FilterManager()
new ManageGameAccountsPageManager()
