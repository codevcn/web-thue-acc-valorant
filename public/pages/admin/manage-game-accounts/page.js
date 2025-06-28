import { GameAccountService } from "../../../services/game-account-services.js"
import { AccountRow } from "../../../utils/scripts/components.js"
import {
  LitHTMLHelper,
  AppLoadingHelper,
  AxiosErrorHandler,
  Toaster,
  URLHelper,
} from "../../../utils/scripts/helpers.js"

class GameAccountPageManager {
  constructor() {
    this.accountsTableBody = document.getElementById("accounts-table-body")

    this.isFetchingItems = false
    this.isMoreItems = true
    this.gameAccounts = []

    this.fetchAccounts()
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

    GameAccountService.fetchAccounts(last_id, rank, status, device_type)
      .then((accounts) => {
        if (accounts && accounts.length > 0) {
          this.gameAccounts = [...this.gameAccounts, ...accounts]
          this.renderAccounts(accounts)
        } else {
          this.isMoreItems = false
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

  renderAccounts(accounts) {
    this.accountsTableBody.innerHTML = ""

    for (const account of accounts) {
      const accountRow = LitHTMLHelper.getFragment(AccountRow, account)
      this.accountsTableBody.appendChild(accountRow)
    }
  }
}

class AddNewAccountManager {
  constructor() {
    this.addNewAccountModal = document.getElementById("add-new-account-modal")
    this.addNewAccountForm = document.getElementById("add-new-account-form")
    this.deviceTypeSelect = this.addNewAccountModal.querySelector(".QUERY-device-type-select")
    this.rankTypesSelect = this.addNewAccountModal.querySelector(".QUERY-rank-types-select")
    this.statusesSelect = this.addNewAccountModal.querySelector(".QUERY-statuses-select")

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
  }

  showModal() {
    this.addNewAccountModal.classList.remove("hidden")
  }

  hideModal() {
    this.addNewAccountModal.classList.add("hidden")
    this.addNewAccountForm.reset()
  }

  fetchDeviceTypes() {
    GameAccountService.fetchDeviceTypes().then((deviceTypes) => {
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
      if (rankTypes && rankTypes.length > 0) {
        for (const rankType of rankTypes) {
          const option = document.createElement("option")
          option.value = rankType.rank
          option.textContent = rankType.rank
          this.rankTypesSelect.appendChild(option)
        }
      }
    })
  }

  fetchAccountStatuses() {
    GameAccountService.fetchAccountStatuses().then((statuses) => {
      if (statuses && statuses.length > 0) {
        for (const status of statuses) {
          const option = document.createElement("option")
          option.value = status.status
          option.textContent = status.status
          this.statusesSelect.appendChild(option)
        }
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
          Toaster.success("Thêm tài khoản thành công")
          URLHelper.reloadPage()
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

new GameAccountPageManager()
new AddNewAccountManager()
