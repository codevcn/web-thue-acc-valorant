import { render } from "https://esm.run/lit-html@1"

export class LitHTMLHelper {
  static getFragment(Render, ...data) {
    const component = Render(...data)
    const fragment = document.createDocumentFragment()
    render(component, fragment)
    return fragment
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
