import { AppLoadingHelper, AxiosErrorHandler, NavigationHelper, Toaster } from "./helpers.js"
import { AuthService } from "../../services/auth-service.js"

class InitUtils {
  constructor() {
    this.initListeners()
    this.initTooltip()
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

  linkTooltip(trigger, tooltipContent) {
    const tooltip = document.getElementById("app-tooltip")
    tooltip.innerHTML = tooltipContent

    const spacing = 8

    const onMouseMove = (e) => {
      tooltip.style.left = "0px"
      tooltip.style.top = "0px"
      tooltip.hidden = false
      tooltip.style.opacity = 1

      const tooltipRect = tooltip.getBoundingClientRect()

      let left = e.clientX + spacing
      let top = e.clientY + spacing

      // Nếu tooltip tràn phải màn hình
      if (left + tooltipRect.width > window.innerWidth - spacing) {
        left = e.clientX - tooltipRect.width - spacing
      }

      // Nếu tooltip tràn xuống dưới màn hình
      if (top + tooltipRect.height > window.innerHeight - spacing) {
        top = e.clientY - tooltipRect.height - spacing
      }

      // Nếu tooltip tràn trái
      if (left < spacing) {
        left = spacing
      }

      // Nếu tooltip tràn lên trên
      if (top < spacing) {
        top = spacing
      }

      tooltip.style.left = `${left}px`
      tooltip.style.top = `${top}px`
    }

    trigger.addEventListener("mouseenter", () => {
      trigger.addEventListener("mousemove", onMouseMove)
    })

    trigger.addEventListener("mouseleave", () => {
      tooltip.hidden = true
      trigger.removeEventListener("mousemove", onMouseMove)
    })
  }

  initTooltip() {
    document.querySelectorAll(".QUERY-tooltip-trigger").forEach((trigger) => {
      this.linkTooltip(trigger, trigger.dataset.vcnTooltipContent)
    })
  }
}

export const initUtils = new InitUtils()
