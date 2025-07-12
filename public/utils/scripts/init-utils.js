import { AppLoadingHelper, AxiosErrorHandler, NavigationHelper, Toaster } from "./helpers.js"
import { AuthService } from "../../services/auth-service.js"

class InitUtils {
  static TOOLTIP_SELECTOR = ".QUERY-tooltip-trigger"

  constructor() {
    this.initListeners()
    this.initTooltip()
  }

  hideShowDrawerMenu(isShow, drawerMenu) {
    if (isShow) {
      drawerMenu.hidden = false
      requestAnimationFrame(() => {
        drawerMenu.querySelector(".QUERY-drawer-menu-board").classList.add("QUERY-drawer-menu-open")
      })
    } else {
      drawerMenu
        .querySelector(".QUERY-drawer-menu-board")
        .classList.remove("QUERY-drawer-menu-open")
      setTimeout(() => {
        drawerMenu.hidden = true
      }, 300)
    }
  }

  initListeners() {
    const logoutBtn = document.getElementById("logout-btn")
    if (logoutBtn) {
      logoutBtn.addEventListener("click", this.logout.bind(this))
    }
    const drawerMenu = document.getElementById("header-drawer-menu")
    if (drawerMenu) {
      const openDrawerMenuBtn = document.getElementById("open-drawer-menu-btn")
      if (openDrawerMenuBtn) {
        openDrawerMenuBtn.addEventListener("click", (e) => {
          this.hideShowDrawerMenu(true, drawerMenu)
        })
      }
      const drawerMenuOverlay = drawerMenu.querySelector(".QUERY-drawer-menu-overlay")
      drawerMenuOverlay.addEventListener("click", (e) => {
        this.hideShowDrawerMenu(false, drawerMenu)
      })
      const closeDrawerMenuBtn = drawerMenu.querySelector(".QUERY-close-drawer-menu-btn")
      closeDrawerMenuBtn.addEventListener("click", (e) => {
        this.hideShowDrawerMenu(false, drawerMenu)
      })
    }
    const logoutBtnDrawer = document.getElementById("logout-btn--drawer")
    if (logoutBtnDrawer) {
      logoutBtnDrawer.addEventListener("click", this.logout.bind(this))
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

    const spacing = 8

    const onMouseMove = (e) => {
      tooltip.innerHTML = tooltipContent
      tooltip.hidden = false

      tooltip.style.left = "0px"
      tooltip.style.top = "0px"
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
    document.querySelectorAll(InitUtils.TOOLTIP_SELECTOR).forEach((trigger) => {
      this.linkTooltip(trigger, trigger.dataset.vcnTooltipContent)
    })
  }
}

export const initUtils = new InitUtils()
