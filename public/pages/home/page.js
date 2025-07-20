import { GameAccountService } from "../../services/game-account-services.js"
import { AccountCard } from "../../utils/scripts/components.js"
import {
  AppLoadingHelper,
  AxiosErrorHandler,
  LitHTMLHelper,
  Toaster,
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
    this.filterHolder = {
      rank: "",
      status: "",
      device_type: "",
    }
    this.rankColors = {
      ALL: "bg-gray-200",
      Iron: "bg-[#4B4B4B] text-white", // Xám đậm – giống màu kim loại thô trong ảnh
      Bronze: "bg-[#B67B4B] text-white", // Nâu đồng – gần đúng với màu đồng trong hình
      Silver: "bg-[#C0C0C0]", // Bạc sáng
      Gold: "bg-[#F0B343]", // Vàng đậm hơi cam – đúng với icon GOLD
      Platinum: "bg-[#32BDB2]", // Xanh ngọc – đặc trưng Platinum
      Diamond: "bg-[#AE78D6]", // Tím ngọc – nổi bật trong Diamond
      Immortal: "bg-[#BD2B63] text-white", // Đỏ tím – Immortal mang tone rực, đậm ánh đỏ tím
      Ascendant: "bg-gray-200", // Không có trong hình – giữ nguyên
      Radiant: "bg-[#F9D65D]", // Vàng kim – icon Radiant nổi bật bằng màu vàng chói
    }

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
  }

  applyRankColors() {
    const options = this.accountRankTypesSelect.querySelectorAll("option")
    for (const option of options) {
      option.classList.add(...this.rankColors[option.value].split(" "))
    }
  }

  activateFilterItems() {
    const { rank, status, device_type } = this.filterHolder
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

  getLastAccountInfoForFetching() {
    let lastAccount = null
    const accounts = this.gameAccounts
    if (accounts.length > 0) {
      lastAccount = accounts.at(-1)
    }
    let last_id = lastAccount ? lastAccount.id : null
    return { last_id }
  }

  fetchAccounts() {
    const { last_id } = this.getLastAccountInfoForFetching()
    const { rank, status, device_type } = this.filterHolder
    if (this.isFetchingItems) return
    this.isFetchingItems = true

    AppLoadingHelper.show()
    GameAccountService.fetchAccounts(last_id, undefined, rank, status, device_type)
      .then((accounts) => {
        if (accounts && accounts.length > 0) {
          this.gameAccounts = [...this.gameAccounts, ...accounts]
          this.renderNewAccounts(accounts)
          initUtils.initTooltip()
          this.activateFilterItems()
        } else {
          this.isMoreItems = false
          this.hideShowLoadMoreButton(false)
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
        const rankFilter = this.filterHolder.rank
        const orderedRankTypes = this.moveActiveItemsToTop(
          rankTypes,
          (rankType) => rankType.type === rankFilter
        )
        for (const { type } of orderedRankTypes) {
          const isActive = rankFilter === type
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
        this.applyRankColors()
      }
    })
  }

  hideShowLoadMoreButton(show) {
    if (show) {
      this.loadMoreContainer.classList.remove("QUERY-no-more")
      this.loadMoreContainer.classList.add("QUERY-is-more")
    } else {
      this.loadMoreContainer.classList.remove("QUERY-is-more")
      this.loadMoreContainer.classList.add("QUERY-no-more")
    }
  }

  initLoadMoreButtonListener() {
    this.loadMoreBtn.addEventListener("click", () => {
      if (!this.isMoreItems) return
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
        this.submitFilter("rank=")
      } else {
        this.submitFilter(`rank=${rankType}`)
      }
    })
  }

  initFilterByStatusListener() {
    this.accountStatusesSelect.addEventListener("change", (e) => {
      const status = e.target.value
      if (status === "ALL") {
        this.submitFilter("status=")
      } else {
        this.submitFilter(`status=${status}`)
      }
    })
  }

  initFilterByDeviceTypeListener() {
    this.accountDeviceTypesSelect.addEventListener("change", (e) => {
      const deviceType = e.target.value
      if (deviceType === "ALL") {
        this.submitFilter("device_type=")
      } else {
        this.submitFilter(`device_type=${deviceType}`)
      }
    })
  }

  resetAccountsList() {
    this.accountsList.innerHTML = ""
    this.gameAccounts = []
    this.hideShowLoadMoreButton(true)
    this.isMoreItems = true
  }

  submitFilter(keyValuePair = "rank=&status=&device_type=") {
    this.resetAccountsList()
    const conditions = keyValuePair.split("&")
    for (const condition of conditions) {
      const [key, value] = condition.split("=")
      this.filterHolder[key] = value || ""
    }
    this.fetchAccounts()
    // NavigationHelper.pureNavigateTo(currentUrl.toString())
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

  resetFilterSection() {
    this.accountRankTypesSelect.value = "ALL"
    this.accountStatusesSelect.value = "ALL"
    this.accountDeviceTypesSelect.value = "ALL"
  }

  initCancelAllFiltersListener() {
    this.cancelAllFiltersBtn.addEventListener("click", () => {
      this.resetAccountsList()
      this.resetFilterSection()
      this.submitFilter()
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
