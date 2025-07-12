import { initUtils } from "../../utils/scripts/init-utils.js"

class SalePageManager {
  constructor() {
    this.slider = document.getElementById("slider")
    this.slidesContainer = document.getElementById("slides-container")
    this.prevButton = document.getElementById("prev-button")
    this.nextButton = document.getElementById("next-button")
    this.dots = document.querySelectorAll("#dots button")
    this.counter = document.getElementById("counter")

    this.currentIndex = 0
    this.isDragging = false
    this.startX = 0
    this.translateX = 0
    this.totalSlides = 5
    this.threshold = 100

    this.initEvents()
    this.updateSlider()

    initUtils.initTooltip()
  }

  updateSlider() {
    this.slidesContainer.style.transform = `translateX(-${this.currentIndex * 100}%)`
    this.dots.forEach((dot, index) => {
      dot.classList.toggle("w-8", index === this.currentIndex)
      dot.classList.toggle("bg-blue-500", index === this.currentIndex)
      dot.classList.toggle("w-3", index !== this.currentIndex)
      dot.classList.toggle("bg-gray-300", index !== this.currentIndex)
    })
    this.counter.textContent = (this.currentIndex + 1).toString()
  }

  nextSlide() {
    this.currentIndex = (this.currentIndex + 1) % this.totalSlides
    this.updateSlider()
  }

  prevSlide() {
    this.currentIndex = (this.currentIndex - 1 + this.totalSlides) % this.totalSlides
    this.updateSlider()
  }

  goToSlide(index) {
    this.currentIndex = index
    this.updateSlider()
  }

  handleStart(clientX) {
    this.isDragging = true
    this.startX = clientX
    this.translateX = 0
    this.slidesContainer.style.transition = "none"
  }

  handleMove(clientX) {
    if (!this.isDragging) return
    this.translateX = clientX - this.startX
    this.slidesContainer.style.transform = `translateX(calc(-${this.currentIndex * 100}% + ${
      this.translateX
    }px))`
  }

  handleEnd() {
    if (!this.isDragging) return
    this.isDragging = false
    this.slidesContainer.style.transition = "transform 0.5s ease-out"
    if (this.translateX > this.threshold) {
      this.prevSlide()
    } else if (this.translateX < -this.threshold) {
      this.nextSlide()
    } else {
      this.updateSlider()
    }
    this.translateX = 0
  }

  initEvents() {
    // Mouse events
    this.slider.addEventListener("mousedown", (e) => {
      e.preventDefault()
      this.handleStart(e.clientX)
    })

    this.slider.addEventListener("mousemove", (e) => {
      this.handleMove(e.clientX)
    })

    this.slider.addEventListener("mouseup", () => this.handleEnd())
    this.slider.addEventListener("mouseleave", () => {
      if (this.isDragging) this.handleEnd()
    })

    // Touch events
    this.slider.addEventListener("touchstart", (e) => {
      this.handleStart(e.touches[0].clientX)
    })

    this.slider.addEventListener("touchmove", (e) => {
      this.handleMove(e.touches[0].clientX)
    })

    this.slider.addEventListener("touchend", () => this.handleEnd())

    // Prevent text selection while dragging
    document.addEventListener("selectstart", (e) => {
      if (this.isDragging) e.preventDefault()
    })

    // Navigation buttons
    this.prevButton.addEventListener("click", () => this.prevSlide())
    this.nextButton.addEventListener("click", () => this.nextSlide())

    // Dots navigation
    this.dots.forEach((dot, index) => {
      dot.addEventListener("click", () => this.goToSlide(index))
    })

    // Prevent button drag interference
    document.querySelectorAll("button").forEach((button) => {
      button.addEventListener("mousedown", (e) => e.stopPropagation())
      button.addEventListener("touchstart", (e) => e.stopPropagation())
    })

    // Copy button
    document.querySelectorAll(".QUERY-copy-btn").forEach((btn) => {
      btn.addEventListener("click", (e) => {
        e.preventDefault()
        const accountId = e.target.closest(".QUERY-account-container").dataset.accountId * 1
        const account = window.APP_DATA.saleAccounts.find((account) => account.id === accountId)
        navigator.clipboard.writeText(account.description).then(() => {
          btn.classList.add("QUERY-is-copied")
          setTimeout(() => {
            btn.classList.remove("QUERY-is-copied")
          }, 1000)
        })
      })
    })
  }
}

new SalePageManager()
