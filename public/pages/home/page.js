import { GameAccountService } from "../../services/game-account-services.js"
import {
  AccountCard,
  AccountDeviceType,
  AccountRankType,
  AccountStatus,
} from "../../utils/scripts/components.js"
import {
  AppLoadingHelper,
  AxiosErrorHandler,
  LitHTMLHelper,
  NavigationHelper,
  Toaster,
  URLHelper,
} from "../../utils/scripts/helpers.js"
import { initUtils } from "../../utils/scripts/init-utils.js"

class HomePageManager {
  constructor() {
    this.loadMoreBtn = document.getElementById("load-more-btn")
    this.loadMoreContainer = document.getElementById("load-more-container")
    this.accountsList = document.getElementById("accounts-list")
    this.accountRankTypesModal = document.getElementById("account-rank-type-modal")
    this.accountRankTypes = document.getElementById("account-rank-types")
    this.accountStatusesModal = document.getElementById("account-status-modal")
    this.accountStatuses = document.getElementById("account-statuses")
    this.accountDeviceTypes = document.getElementById("account-device-types")
    this.accountRankTypesModalOverlay =
      this.accountRankTypesModal.querySelector(".QUERY-modal-overlay")
    this.accountStatusesModalOverlay =
      this.accountStatusesModal.querySelector(".QUERY-modal-overlay")
    this.accountDeviceTypesModal = document.getElementById("account-device-type-modal")
    this.accountDeviceTypesModalOverlay =
      this.accountDeviceTypesModal.querySelector(".QUERY-modal-overlay")
    this.rentNowModal = document.getElementById("rent-now-modal")
    this.rentNowModalOverlay = this.rentNowModal.querySelector(".QUERY-modal-overlay")
    this.closeRentNowModalBtn = document.getElementById("close-rent-now-modal-btn")
    this.accNameRentNowModal = document.getElementById("acc-name--rent-now-modal")
    this.scrollToTopBtn = document.getElementById("scroll-to-top-btn")

    this.isFetchingItems = false
    this.isMoreItems = true
    this.gameAccounts = []
    this.selectedAccount = null

    this.initLoadMoreButtonListener()
    this.initAccountRankTypesListener()
    this.initAccountStatusListener()
    this.initAccountDeviceTypesListener()
    this.initCloseModalListener()
    this.initFilterByRankListener()
    this.initFilterByStatusListener()
    this.initFilterByDeviceTypeListener()
    this.initModalOverlayListeners()
    this.initCancelFilterListener()
    this.initAccountsListListener()
    this.initCloseRentNowModalListener()
    this.initScrollToTopBtnListener()

    this.watchScrolling()

    this.fetchAccounts()
    this.fetchAccountRankTypes()
    this.fetchAccountStatuses()
    this.fetchAccountDeviceTypes()
  }

  initModalOverlayListeners() {
    this.accountRankTypesModalOverlay.addEventListener("click", () => {
      this.hideShowAccountRankTypes(false)
    })
    this.accountStatusesModalOverlay.addEventListener("click", () => {
      this.hideShowAccountStatus(false)
    })
    this.accountDeviceTypesModalOverlay.addEventListener("click", () => {
      this.hideShowAccountDeviceTypes(false)
    })
    this.rentNowModalOverlay.addEventListener("click", () => {
      this.hideRentNowModal()
    })
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

  renderAccounts(accounts) {
    for (const account of accounts) {
      const fragment = LitHTMLHelper.getFragment(AccountCard, account)
      this.accountsList.appendChild(fragment)
    }
  }

  fetchAccountRankTypes() {
    GameAccountService.fetchAccountRankTypes().then((rankTypes) => {
      const rankParam = URLHelper.getUrlQueryParam("rank")
      if (rankTypes && rankTypes.length > 0) {
        for (const rankType of rankTypes) {
          const fragment = LitHTMLHelper.getFragment(AccountRankType, {
            ...rankType,
            isActive: rankParam === rankType.rank,
          })
          this.accountRankTypes.appendChild(fragment)
        }
      }
    })
  }

  fetchAccountStatuses() {
    GameAccountService.fetchAccountStatuses().then((statuses) => {
      const statusParam = URLHelper.getUrlQueryParam("status")
      if (statuses && statuses.length > 0) {
        for (const status of statuses) {
          const fragment = LitHTMLHelper.getFragment(AccountStatus, {
            ...status,
            isActive: statusParam === status.status,
          })
          this.accountStatuses.appendChild(fragment)
        }
      }
    })
  }

  fetchAccountDeviceTypes() {
    GameAccountService.fetchDeviceTypes().then((deviceTypes) => {
      const deviceTypeParam = URLHelper.getUrlQueryParam("device_type")
      if (deviceTypes && deviceTypes.length > 0) {
        for (const deviceType of deviceTypes) {
          const fragment = LitHTMLHelper.getFragment(AccountDeviceType, {
            ...deviceType,
            isActive: deviceTypeParam === deviceType.device_type,
          })
          this.accountDeviceTypes.appendChild(fragment)
        }
      }
    })
  }

  initLoadMoreButtonListener() {
    this.loadMoreBtn.addEventListener("click", () => {
      this.fetchAccounts()
    })
  }

  hideShowAccountRankTypes(isShow) {
    if (isShow) {
      this.accountRankTypesModal.hidden = false
    } else {
      this.accountRankTypesModal.hidden = true
    }
  }

  hideShowAccountStatus(isShow) {
    if (isShow) {
      this.accountStatusesModal.hidden = false
    } else {
      this.accountStatusesModal.hidden = true
    }
  }

  hideShowAccountDeviceTypes(isShow) {
    if (isShow) {
      this.accountDeviceTypesModal.hidden = false
    } else {
      this.accountDeviceTypesModal.hidden = true
    }
  }

  initAccountRankTypesListener() {
    const accountRankTypesBtn = document.getElementById("account-rank-types-btn")
    accountRankTypesBtn.addEventListener("click", () => {
      this.hideShowAccountRankTypes(true)
    })
  }

  initAccountStatusListener() {
    const accountStatusBtn = document.getElementById("account-status-btn")
    accountStatusBtn.addEventListener("click", () => {
      this.hideShowAccountStatus(true)
    })
  }

  initAccountDeviceTypesListener() {
    const accountDeviceTypesBtn = document.getElementById("account-device-types-btn")
    accountDeviceTypesBtn.addEventListener("click", () => {
      this.hideShowAccountDeviceTypes(true)
    })
  }

  initCloseModalListener() {
    const closeModalBtns = document.querySelectorAll(".QUERY-close-modal-btn")
    for (const closeModalBtn of closeModalBtns) {
      closeModalBtn.addEventListener("click", () => {
        closeModalBtn.closest(".QUERY-modal").hidden = true
      })
    }
  }

  initFilterByRankListener() {
    this.accountRankTypesModal.addEventListener("click", (e) => {
      let target = e.target
      while (target && !target.classList.contains("QUERY-filter-by-rank-item")) {
        target = target.parentElement
        if (target.id === "account-rank-type-modal" || target.tagName === "BODY" || !target) {
          return
        }
      }
      const rank = target.dataset.rank
      if (rank) {
        this.filterAndNavigate(`rank=${rank}`)
      }
    })
  }

  initFilterByStatusListener() {
    this.accountStatusesModal.addEventListener("click", (e) => {
      let target = e.target
      while (target && !target.classList.contains("QUERY-filter-by-status-item")) {
        target = target.parentElement
        if (target.id === "account-status-modal" || target.tagName === "BODY" || !target) {
          return
        }
      }
      const status = target.dataset.status
      if (status) {
        this.filterAndNavigate(`status=${status}`)
      }
    })
  }

  initFilterByDeviceTypeListener() {
    this.accountDeviceTypesModal.addEventListener("click", (e) => {
      let target = e.target
      while (target && !target.classList.contains("QUERY-filter-by-device-type-item")) {
        target = target.parentElement
        if (target.id === "account-device-type-modal" || target.tagName === "BODY" || !target) {
          return
        }
      }
      const deviceType = target.dataset.deviceType
      if (deviceType) {
        this.filterAndNavigate(`device_type=${deviceType}`)
      }
    })
  }

  initCancelFilterListener() {
    const cancelFilterBtns = document.querySelectorAll(".QUERY-modal .QUERY-cancel-filter-btn")
    for (const cancelFilterBtn of cancelFilterBtns) {
      cancelFilterBtn.addEventListener("click", () => {
        const modal = cancelFilterBtn.closest(".QUERY-modal")
        if (modal.classList.contains("QUERY-rank-type-modal")) {
          this.filterAndNavigate("rank=")
        } else if (modal.classList.contains("QUERY-status-modal")) {
          this.filterAndNavigate("status=")
        } else if (modal.classList.contains("QUERY-device-type-modal")) {
          this.filterAndNavigate("device_type=")
        }
      })
    }
  }

  filterAndNavigate(keyValuePair) {
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

  initAccountsListListener() {
    this.accountsList.addEventListener("click", (e) => {
      let target = e.target
      while (target && !target.classList.contains("QUERY-rent-now-btn")) {
        target = target.parentElement
        if (target.id === "accounts-list" || target.tagName === "BODY" || !target) {
          return
        }
      }
      let accountId = target.dataset.accountId
      if (accountId) {
        accountId = accountId * 1
        const account = this.gameAccounts.find((account) => account.id === accountId)
        if (account) {
          this.selectedAccount = account
          this.showRentNowModal()
        }
      }
    })
  }

  showRentNowModal() {
    this.accNameRentNowModal.textContent = this.selectedAccount.acc_name
    this.rentNowModal.hidden = false
  }

  hideRentNowModal() {
    this.rentNowModal.hidden = true
  }

  initCloseRentNowModalListener() {
    this.closeRentNowModalBtn.addEventListener("click", () => {
      this.hideRentNowModal()
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

  initScrollToTopBtnListener() {
    this.scrollToTopBtn.addEventListener("click", () => {
      window.scrollTo({ top: 100, behavior: "instant" })
      window.scrollTo({ top: 0, behavior: "smooth" })
    })
  }
}

new HomePageManager()
