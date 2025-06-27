import { GameAccountService } from "../../services/game-account-services.js"
import { AccountCard, AccountRankType, AccountStatus } from "../../utils/scripts/components.js"
import {
  AppLoadingHelper,
  AxiosErrorHandler,
  LitHTMLHelper,
  NavigationHelper,
  Toaster,
  URLHelper,
} from "../../utils/scripts/helpers.js"

class HomePageManager {
  constructor() {
    this.loadMoreBtn = document.getElementById("load-more-btn")
    this.loadMoreContainer = document.getElementById("load-more-container")
    this.accountsList = document.getElementById("accounts-list")
    this.accountRankTypesModal = document.getElementById("account-rank-type-modal")
    this.accountRankTypes = document.getElementById("account-rank-types")
    this.accountStatusModal = document.getElementById("account-status-modal")
    this.accountStatuses = document.getElementById("account-statuses")
    this.accountRankTypesModalOverlay =
      this.accountRankTypesModal.querySelector(".QUERY-modal-overlay")
    this.accountStatusModalOverlay = this.accountStatusModal.querySelector(".QUERY-modal-overlay")

    this.isFetchingItems = false
    this.isMoreItems = true
    this.gameAccounts = []

    this.initLoadMoreButtonListener()
    this.initAccountRankTypesListener()
    this.initAccountStatusListener()
    this.initCloseModalListener()
    this.initFilterByRankListener()
    this.initFilterByStatusListener()
    this.initModalOverlayListeners()
    this.initCancelFilterListener()

    this.fetchAccounts()
    this.fetchAccountRankTypes()
    this.fetchAccountStatuses()
  }

  initModalOverlayListeners() {
    this.accountRankTypesModalOverlay.addEventListener("click", () => {
      this.hideShowAccountRankTypes(false)
    })
    this.accountStatusModalOverlay.addEventListener("click", () => {
      this.hideShowAccountStatus(false)
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
      this.accountStatusModal.hidden = false
    } else {
      this.accountStatusModal.hidden = true
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
        if (target.tagName === "BODY") {
          return
        }
      }
      if (target.classList.contains("QUERY-filter-by-rank-item")) {
        const rank = target.dataset.rank
        if (rank) {
          this.filterAndNavigate(`rank=${rank}`)
        }
      }
    })
  }

  initFilterByStatusListener() {
    this.accountStatusModal.addEventListener("click", (e) => {
      let target = e.target
      while (target && !target.classList.contains("QUERY-filter-by-status-item")) {
        target = target.parentElement
        if (target.tagName === "BODY") {
          return
        }
      }
      if (target.classList.contains("QUERY-filter-by-status-item")) {
        const status = target.dataset.status
        if (status) {
          this.filterAndNavigate(`status=${status}`)
        }
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
        }
      })
    }
  }

  filterAndNavigate(keyValuePair) {
    const currentUrl = new URL(window.location.href)
    const [key, value] = keyValuePair.split("=")
    if (value) {
      currentUrl.searchParams.set(key, value)
    } else {
      currentUrl.searchParams.delete(key)
    }
    NavigationHelper.pureNavigateTo(currentUrl.toString())
  }
}

new HomePageManager()
