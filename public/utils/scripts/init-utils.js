import { AppLoadingHelper, AxiosErrorHandler, NavigationHelper, Toaster } from "./helpers.js"
import { AuthService } from "../../services/auth-service.js"

class InitUtils {
  constructor() {
    this.initListeners()
  }

  initListeners() {
    const logoutBtn = document.getElementById("logout-btn")
    if (logoutBtn) {
      logoutBtn.addEventListener("click", this.logout.bind(this))
    }
  }

  logout() {
    AppLoadingHelper.show()
    AuthService.logout()
      .then((res) => {
        if (res.success) {
          Toaster.success("Đăng xuất thành công", "", () => {
            NavigationHelper.pureNavigateTo("/admin/login")
          })
        }
      })
      .catch((err) => {
        Toaster.error("Lỗi đăng xuất", AxiosErrorHandler.handleHTTPError(err).message)
      })
      .finally(() => {
        AppLoadingHelper.hide()
      })
  }
}

new InitUtils()
