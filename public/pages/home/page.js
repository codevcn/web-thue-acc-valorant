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
    this.accountRankTypes = document.getElementById("account-rank-types")
    this.accountStatuses = document.getElementById("account-statuses")
    this.accountDeviceTypes = document.getElementById("account-device-types")
    this.rentNowModal = document.getElementById("rent-now-modal")
    this.rentNowModalOverlay = this.rentNowModal.querySelector(".QUERY-modal-overlay")
    this.closeRentNowModalBtn = document.getElementById("close-rent-now-modal-btn")
    this.accNameRentNowModal = document.getElementById("acc-name--rent-now-modal")
    this.scrollToTopBtn = document.getElementById("scroll-to-top-btn")
    this.cancelAllFiltersBtn = document.getElementById("cancel-all-filters-btn")
    this.acceptRulesCheckbox = document.getElementById("accept-rules-checkbox")
    this.accountRankTypesSelect = document.getElementById("account-rank-types-select")
    this.accountStatusesSelect = document.getElementById("account-statuses-select")
    this.accountDeviceTypesSelect = document.getElementById("account-device-types-select")

    this.isFetchingItems = false
    this.isMoreItems = true
    this.gameAccounts = []
    this.selectedAccount = null

    this.initLoadMoreButtonListener()
    this.initCloseModalListener()
    this.initFilterByRankListener()
    this.initFilterByStatusListener()
    this.initFilterByDeviceTypeListener()
    this.initAccountsListListener()
    this.initCloseRentNowModalListener()
    this.initScrollToTopBtnListener()
    this.initCancelAllFiltersListener()
    this.initModalOverlayListener()
    this.initAcceptRulesCheckboxListener()

    this.watchScrolling()

    this.fetchAccounts()
    this.fetchAccountRankTypes()
    this.activateFilterItems()
  }

  getLastAccount() {
    const accounts = this.gameAccounts
    if (accounts.length > 0) {
      return accounts.at(-1)
    }
    return null
  }

  activateFilterItems() {
    const rank = URLHelper.getUrlQueryParam("rank")
    const status = URLHelper.getUrlQueryParam("status")
    const device_type = URLHelper.getUrlQueryParam("device_type")

    if (rank) {
      this.accountRankTypesSelect.value = rank
    }
    if (status) {
      this.accountStatusesSelect.value = status
    }
    if (device_type) {
      this.accountDeviceTypesSelect.value = device_type
    }
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

    GameAccountService.fetchAccounts(last_id, last_updated_at, rank, status, device_type)
      .then((accounts) => {
        if (accounts && accounts.length > 0) {
          this.gameAccounts = [...this.gameAccounts, ...accounts]
          this.renderNewAccounts(accounts)
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

  renderNewAccounts(accounts) {
    for (const account of accounts) {
      const fragment = LitHTMLHelper.getFragment(AccountCard, account)
      this.accountsList.appendChild(fragment)
    }
  }

  moveActiveItemsToTop(arr, conditionChecker) {
    const result = []

    for (const item of arr) {
      if (conditionChecker(item)) {
        result.unshift(item)
      } else {
        result.push(item)
      }
    }

    return result
  }

  fetchAccountRankTypes() {
    GameAccountService.fetchAccountRankTypes().then((rankTypes) => {
      if (rankTypes && rankTypes.length > 0) {
        const rankParam = URLHelper.getUrlQueryParam("rank")
        const orderedRankTypes = this.moveActiveItemsToTop(
          rankTypes,
          (rankType) => rankType.type === rankParam
        )
        for (const { type } of orderedRankTypes) {
          const isActive = rankParam === type
          const option = document.createElement("option")
          option.classList.add("bg-white", "text-black")
          option.value = type
          option.textContent = type
          option.selected = isActive
          this.accountRankTypesSelect.appendChild(option)
          if (isActive) {
            document
              .querySelector("#account-rank-types-container .QUERY-active-icon")
              .classList.remove("hidden")
          }
        }
      }
    })
  }

  initLoadMoreButtonListener() {
    this.loadMoreBtn.addEventListener("click", () => {
      this.fetchAccounts()
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
    this.accountRankTypesSelect.addEventListener("change", (e) => {
      const rankType = e.target.value
      if (rankType === "ALL") {
        this.filterAndNavigate("rank=")
      } else {
        this.filterAndNavigate(`rank=${rankType}`)
      }
    })
  }

  initFilterByStatusListener() {
    this.accountStatusesSelect.addEventListener("change", (e) => {
      const status = e.target.value
      if (status === "ALL") {
        this.filterAndNavigate("status=")
      } else {
        this.filterAndNavigate(`status=${status}`)
      }
    })
  }

  initFilterByDeviceTypeListener() {
    this.accountDeviceTypesSelect.addEventListener("change", (e) => {
      const deviceType = e.target.value
      if (deviceType === "ALL") {
        this.filterAndNavigate("device_type=")
      } else {
        this.filterAndNavigate(`device_type=${deviceType}`)
      }
    })
  }

  filterAndNavigate(keyValuePair = "rank=&status=&device_type=") {
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

  initModalOverlayListener() {
    this.rentNowModalOverlay.addEventListener("click", () => {
      this.hideRentNowModal()
    })
  }

  initCancelAllFiltersListener() {
    this.cancelAllFiltersBtn.addEventListener("click", () => {
      this.filterAndNavigate()
    })
  }

  showRentNowModal() {
    this.accNameRentNowModal.textContent = this.selectedAccount.acc_name
    this.acceptRulesCheckbox.checked = false
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

  initAcceptRulesCheckboxListener() {
    this.acceptRulesCheckbox.addEventListener("change", () => {
      const rentNowModalContactLinks = document.getElementById("rent-now-modal-contact-links")
      if (this.acceptRulesCheckbox.checked) {
        rentNowModalContactLinks.classList.remove("opacity-50", "pointer-events-none")
      } else {
        rentNowModalContactLinks.classList.add("opacity-50", "pointer-events-none")
      }
    })
  }
}

new HomePageManager()
