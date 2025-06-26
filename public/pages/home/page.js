import { GameAccountService } from "../../services/game-account-services.js"
import { AccountCard } from "../../utils/scripts/components.js"
import {
  AppLoadingHelper,
  AxiosErrorHandler,
  LitHTMLHelper,
  Toaster,
  URLHelper,
} from "../../utils/scripts/helpers.js"

class HomePageManager {
  constructor() {
    this.accountsList = document.getElementById("accounts-list")

    this.isFetchingItems = false
    this.isMoreItems = true

    this.fetchAccounts()
    this.initLoadMoreButtonListener()
  }

  fetchAccounts() {
    if (this.isFetchingItems || !this.isMoreItems) return
    this.isFetchingItems = true

    AppLoadingHelper.show()

    const last_id = URLHelper.getUrlQueryParam("last_id")
    const rank = URLHelper.getUrlQueryParam("rank")
    const status = URLHelper.getUrlQueryParam("status")
    const device_type = URLHelper.getUrlQueryParam("device_type")

    GameAccountService.fetchAccounts(last_id, rank, status, device_type)
      .then((accounts) => {
        const accountsCount = accounts?.length
        if (accounts && accountsCount > 0) {
          for (const account of accounts) {
            const fragment = LitHTMLHelper.getFragment(AccountCard, account)
            this.accountsList.appendChild(fragment)
          }
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

  initLoadMoreButtonListener() {
    const loadMoreBtn = document.getElementById("load-more-btn")
    loadMoreBtn.addEventListener("click", () => {
      this.fetchAccounts()
    })
  }
}

new HomePageManager()
