import { render } from "https://esm.run/lit-html@1"

export class LitHTMLHelper {
  static getFragment(Render, ...data) {
    const container = document.createElement("div")
    render(Render(...data), container)
    return container.firstElementChild
  }
}

export class AxiosErrorHandler {
  static MAX_LEN_OF_ERROR_MESSAGE = 100

  static handleHTTPError(originalError) {
    console.error(">>> original error:", originalError)

    let statusCode = 500 // Internal Server Error
    let message = "Unknown Error!"
    let isCanceled = false

    if (this.isAxiosError(originalError)) {
      const responseOfError = originalError.response

      if (responseOfError) {
        // if error was made by server at backend
        statusCode = responseOfError.status // update error status

        const dataOfResponse = responseOfError.data

        if (typeof dataOfResponse === "string") {
          message = "Invalid request"
        } else {
          message = dataOfResponse.message // update error message

          if (message.length > AxiosErrorHandler.MAX_LEN_OF_ERROR_MESSAGE) {
            message = `${message.slice(0, AxiosErrorHandler.MAX_LEN_OF_ERROR_MESSAGE)}...`
          }
        }
      } else if (originalError.request) {
        // The request was made but no response was received
        statusCode = 502 // Bad Gateway
        message = "Bad network or error from server."
      } else {
        // Something happened in setting up the request that triggered an Error
        message = originalError.message
      }
    } else if (originalError instanceof axios.CanceledError) {
      isCanceled = true
      message = originalError.message
    } else if (originalError instanceof Error) {
      message = originalError.message
    }

    return {
      originalError,
      statusCode,
      message,
      isCanceled,
    }
  }

  static isAxiosError(error) {
    return error instanceof axios.AxiosError
  }
}

export class Toaster {
  static success(title, message, callback) {
    Swal.fire({
      icon: "success",
      title,
      text: message,
    }).then((result) => {
      if (result.isConfirmed) {
        if (callback) {
          callback()
        }
      }
    })
  }

  static error(title, message, callback) {
    Swal.fire({
      icon: "error",
      title,
      text: message,
    }).then((result) => {
      if (result.isConfirmed) {
        if (callback) {
          callback()
        }
      }
    })
  }
}

export class AppLoadingHelper {
  static show() {
    const appLoading = document.getElementById("app-loading")
    appLoading.hidden = false
  }

  static hide() {
    const appLoading = document.getElementById("app-loading")
    appLoading.hidden = true
  }
}

export class URLHelper {
  static currentUrlSearchParams = new URLSearchParams(window.location.search)

  static getUrlQueryParam(key) {
    const value = this.currentUrlSearchParams.get(key)
    return value ? decodeURIComponent(value) : ""
  }
}

export class NavigationHelper {
  static pureNavigateTo(locationHref) {
    window.location.href = locationHref
  }

  static reloadPage() {
    window.location.reload()
  }
}

export class LocalStorageHelper {
  static KEY_SHOW_FILTERS = "show-filters"

  static setShowFilters(show) {
    localStorage.setItem(this.KEY_SHOW_FILTERS, show)
  }

  static getShowFilters() {
    return localStorage.getItem(this.KEY_SHOW_FILTERS)
  }
}

export class TimeHelper {
  static NOT_STARTED = "NOT_STARTED"
  static OUT_OF_TIME = "OUT_OF_TIME"

  static getRemainingRentalTime(rentFrom, rentTo) {
    const now = new Date()
    const fromTime = new Date(rentFrom)
    const toTime = new Date(rentTo)

    // Nếu chưa đến thời gian bắt đầu thuê
    if (now < fromTime) {
      return this.NOT_STARTED
    }

    // Nếu đã hết thời gian thuê
    if (now >= toTime) {
      return this.OUT_OF_TIME
    }

    const remainingMs = toTime - now

    const totalSeconds = Math.floor(remainingMs / 1000)
    const hours = Math.floor(totalSeconds / 3600)
    const minutes = Math.floor((totalSeconds % 3600) / 60)
    const seconds = totalSeconds % 60

    return `${hours} giờ ${minutes} phút ${seconds} giây`
  }

  static getRentalDuration(rentFrom, rentTo) {
    const from = new Date(rentFrom)
    const to = new Date(rentTo)

    if (isNaN(from) || isNaN(to)) {
      return "INVALID_TIME"
    }

    const durationMs = to - from

    if (durationMs <= 0) {
      return "INVALID_TIME"
    }

    const totalMinutes = Math.floor(durationMs / 60000)
    const hours = Math.floor(totalMinutes / 60)
    const minutes = totalMinutes % 60

    return `${hours} giờ ${minutes} phút`
  }
}
