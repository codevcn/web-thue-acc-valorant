<div id="page-intro" class="fixed inset-0 z-[99] overflow-hidden">
  <!-- Background Image -->
  <div class="absolute z-10 inset-0">
    <!-- Dark Overlay -->
    <div class="absolute inset-0 bg-black/40 z-20"></div>

    <div class="absolute inset-0 z-10">
      <video src="/videos/UI/intro-bg.mp4" autoplay muted loop class="w-full h-full object-cover"></video>
    </div>
  </div>

  <!-- Left Side - Main Title -->
  <div class="QUERY-left-side-container">
    <div class="flex flex-col items-start space-y-4">
      <div class="flex items-center gap-2">
        <span class="bg-red-600 h-2 w-2 rounded-full"></span>
        <a href="/" class="text-xl lg:text-3xl font-bold text-red-600 text-left leading-tight hover:scale-105 cursor-pointer transition duration-200">
          THUÊ NGAY
        </a>
      </div>
      <div class="flex items-center gap-2">
        <span class="bg-white h-2 w-2 rounded-full"></span>
        <a href="/sale" class="CSS-notification-red-dot text-base lg:text-xl font-bold text-white text-left leading-tight hover:scale-110 cursor-pointer transition duration-200">
          SALE
        </a>
      </div>
    </div>
  </div>

  <!-- Right Side - Intro Content -->
  <div class="QUERY-right-side-container">
    <div class="flex flex-col min-[700px]:items-end space-y-4 items-center">
      <div class="flex items-center gap-2 px-4 py-2 bg-blue-600/20 w-fit backdrop-blur-sm rounded-full border border-blue-500/30">
        <svg xmlns="http://www.w3.org/2000/svg" class="text-blue-300 lucide lucide-shield-icon lucide-shield" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
          <path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z" />
        </svg>
        <span class="text-blue-300 text-sm font-medium">VALORANT ACCOUNTS</span>
      </div>

      <h1 class="text-5xl lg:text-7xl font-bold text-white min-[700px]:text-right leading-tight space-y-2 text-center">
        THUÊ ACC
        <span class="block text-transparent bg-clip-text bg-gradient-to-r from-regular-from-blue-cl via-regular-via-blue-cl to-regular-to-blue-cl">
          VALORANT
        </span>
        <span class="block text-3xl lg:text-4xl text-gray-300 font-normal">
          CHẤT LƯỢNG CAO
        </span>
      </h1>

      <p class="text-xl text-gray-300 min-[500px]:max-w-xl w-max leading-relaxed min-[700px]:text-right text-center max-w-[300px]">
        Trải nghiệm Valorant với những tài khoản premium, các loại rank, skin đẹp. Dịch vụ uy
        tín, giá cả hợp lý.
      </p>
    </div>

    <!-- Stats -->
    <div class="flex justify-end gap-16 mt-4">
      <div class="text-center">
        <div class="text-3xl font-bold text-white">98%</div>
        <div class="text-gray-400 text-sm">Hài lòng</div>
      </div>
      <div class="text-center">
        <div class="text-3xl font-bold text-white">7h - 0h</div>
        <div class="text-gray-400 text-sm">Hỗ trợ</div>
      </div>
    </div>

    <div class="block min-[700px]:hidden mt-6">
      <div class="flex items-center gap-4">
        <div class="flex items-center gap-2 rounded-lg bg-red-600 px-4 py-2 hover:scale-105 cursor-pointer transition duration-200">
          <a href="/" class="flex items-center gap-2 w-max text-xl lg:text-3xl font-bold text-white leading-tight">
            <span>THUÊ NGAY</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="lucide lucide-swords-icon lucide-swords text-white" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
              <polyline points="14.5 17.5 3 6 3 3 6 3 17.5 14.5" />
              <line x1="13" x2="19" y1="19" y2="13" />
              <line x1="16" x2="20" y1="16" y2="20" />
              <line x1="19" x2="21" y1="21" y2="19" />
              <polyline points="14.5 6.5 18 3 21 3 21 6 17.5 9.5" />
              <line x1="5" x2="9" y1="14" y2="18" />
              <line x1="7" x2="4" y1="17" y2="20" />
              <line x1="3" x2="5" y1="19" y2="21" />
            </svg>
          </a>
        </div>
        <div class="flex items-center gap-2 rounded-lg bg-white px-4 py-2 hover:scale-105 cursor-pointer transition duration-200">
          <a href="/" class="text-base lg:text-xl font-bold text-black leading-tight">
            SALE
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bottom Scroll Indicator -->
  <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2">
    <div class="animate-bounce">
      <div class="w-6 h-10 border-2 border-white/50 rounded-full flex justify-center">
        <div class="w-1 h-3 bg-white/70 rounded-full mt-2 animate-pulse"></div>
      </div>
    </div>
  </div>
</div>