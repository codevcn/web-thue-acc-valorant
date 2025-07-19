<footer class="bg-gradient-to-l from-regular-from-blue-cl to-regular-to-blue-cl text-black/80">
  <div class="mx-auto px-10 pt-8 pb-4">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-8">
      <div href="/" class="pt-4 min-[600px]:block flex flex-col items-center">
        <a href="/" class="block h-[110px] w-[150px] overflow-hidden relative">
          <img src="/images/UI/ghost.webp" alt="Logo" class="absolute top-[-22px] left-0 h-[150px] min-w-[150px]">
        </a>
        <h3 class="CSS-small-text-stroke text-2xl font-bold text-white w-fit mt-4">thueaccvaloranttime.com</h3>
        <p class="text-black/80 leading-relaxed w-fit min-[600px]:text-left text-center mt-4">
          Chuyên cung cấp dịch vụ cho thuê tài khoản Valorant chất lượng cao với giá cả hợp lý.
          Đảm bảo tài khoản an toàn, không bị ban, không bị hack.
        </p>
      </div>

      <div class="grid min-[550px]:grid-cols-2 grid-cols-1 gap-12">
        <div class="space-y-4 min-[550px]:block flex flex-col items-center">
          <h4 class="text-xl font-bold text-black/80 min-[550px]:w-auto w-fit">Menu</h4>
          <div class="space-y-3 min-[550px]:block flex flex-col items-center">
            <div class="CSS-shadow-hover-container">
              <a href="/" class="CSS-shadow-hover-content z-20 relative flex items-center gap-2 w-fit text-black/80 transition-colors duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-house-icon lucide-house">
                  <path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8" />
                  <path d="M3 10a2 2 0 0 1 .709-1.528l7-5.999a2 2 0 0 1 2.582 0l7 5.999A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                </svg>
                Trang chủ
              </a>
              <span class="CSS-shadow-hover-shadow"></span>
            </div>
            <div class="CSS-shadow-hover-container">
              <a href="/admin/manage-game-accounts" class="CSS-shadow-hover-content z-20 relative flex items-center gap-2 w-fit text-black/80 transition-colors duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users-icon lucide-users">
                  <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                  <path d="M16 3.128a4 4 0 0 1 0 7.744" />
                  <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                  <circle cx="9" cy="7" r="4" />
                </svg>
                Trang quản lý
              </a>
              <span class="CSS-shadow-hover-shadow"></span>
            </div>
            <div class="CSS-shadow-hover-container">
              <a href="/intro" class="CSS-shadow-hover-content z-20 relative flex items-center gap-2 w-fit text-black/80 transition-colors duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-play-icon lucide-circle-play">
                  <circle cx="12" cy="12" r="10" />
                  <polygon points="10 8 16 12 10 16 10 8" />
                </svg>
                Trang giới thiệu
              </a>
              <span class="CSS-shadow-hover-shadow"></span>
            </div>
            <div class="CSS-shadow-hover-container">
              <a href="/sale" class="CSS-shadow-hover-content z-20 relative flex items-center gap-2 w-fit text-black/80 transition-colors duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-coins-icon lucide-coins">
                  <circle cx="8" cy="8" r="6" />
                  <path d="M18.09 10.37A6 6 0 1 1 10.34 18" />
                  <path d="M7 6h1v4" />
                  <path d="m16.71 13.88.7.71-2.82 2.82" />
                </svg>
                Sale
              </a>
              <span class="CSS-shadow-hover-shadow"></span>
            </div>
          </div>
        </div>

        <div class="space-y-4 min-[550px]:block flex flex-col items-center">
          <h4 class="text-xl font-bold text-black/80 min-[550px]:w-auto w-fit">Liên hệ</h4>
          <div class="space-y-4 min-[550px]:block flex flex-col items-center">
            <p class="text-black/80 text-base min-[550px]:text-left text-center">Liên hệ với chúng tôi qua các kênh mạng xã hội</p>
            <div class="flex flex-col space-y-3">
              <a href="<?= $admin['facebook_link'] ?>" class="flex items-center gap-3 w-fit text-white transition-all duration-300">
                <span class="w-10 h-10 bg-regular-facebook-cl rounded-full flex items-center justify-center transition-colors duration-300">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
                  </svg>
                </span>
                <span class="block CSS-shadow-hover-container">
                  <span class="CSS-shadow-hover-content relative z-20 text-black/80">Facebook</span>
                  <span class="CSS-shadow-hover-shadow"></span>
                </span>
              </a>
              <a href="<?= $admin['zalo_link'] ?>" target="_blank" class="flex items-center gap-3 w-fit text-black/80">
                <span class="w-10 h-10 bg-regular-zalo-cl rounded-full flex items-center justify-center transition-all duration-300">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 50 50" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M22.782 0.166016H27.199C33.2653 0.166016 36.8103 1.05701 39.9572 2.74421C43.1041 4.4314 45.5875 6.89585 47.2557 10.0428C48.9429 13.1897 49.8339 16.7347 49.8339 22.801V27.1991C49.8339 33.2654 48.9429 36.8104 47.2557 39.9573C45.5685 43.1042 43.1041 45.5877 39.9572 47.2559C36.8103 48.9431 33.2653 49.8341 27.199 49.8341H22.8009C16.7346 49.8341 13.1896 48.9431 10.0427 47.2559C6.89583 45.5687 4.41243 43.1042 2.7442 39.9573C1.057 36.8104 0.166016 33.2654 0.166016 27.1991V22.801C0.166016 16.7347 1.057 13.1897 2.7442 10.0428C4.43139 6.89585 6.89583 4.41245 10.0427 2.74421C13.1707 1.05701 16.7346 0.166016 22.782 0.166016Z" fill="#0068FF" />
                    <path opacity="0.12" fill-rule="evenodd" clip-rule="evenodd" d="M49.8336 26.4736V27.1994C49.8336 33.2657 48.9427 36.8107 47.2555 39.9576C45.5683 43.1045 43.1038 45.5879 39.9569 47.2562C36.81 48.9434 33.265 49.8344 27.1987 49.8344H22.8007C17.8369 49.8344 14.5612 49.2378 11.8104 48.0966L7.27539 43.4267L49.8336 26.4736Z" fill="#001A33" />
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M7.779 43.5892C10.1019 43.846 13.0061 43.1836 15.0682 42.1825C24.0225 47.1318 38.0197 46.8954 46.4923 41.4732C46.8209 40.9803 47.1279 40.4677 47.4128 39.9363C49.1062 36.7779 50.0004 33.22 50.0004 27.1316V22.7175C50.0004 16.629 49.1062 13.0711 47.4128 9.91273C45.7385 6.75436 43.2461 4.28093 40.0877 2.58758C36.9293 0.894239 33.3714 0 27.283 0H22.8499C17.6644 0 14.2982 0.652754 11.4699 1.89893C11.3153 2.03737 11.1636 2.17818 11.0151 2.32135C2.71734 10.3203 2.08658 27.6593 9.12279 37.0782C9.13064 37.0921 9.13933 37.1061 9.14889 37.1203C10.2334 38.7185 9.18694 41.5154 7.55068 43.1516C7.28431 43.399 7.37944 43.5512 7.779 43.5892Z" fill="white" />
                    <path d="M20.5632 17H10.8382V19.0853H17.5869L10.9329 27.3317C10.7244 27.635 10.5728 27.9194 10.5728 28.5639V29.0947H19.748C20.203 29.0947 20.5822 28.7156 20.5822 28.2606V27.1421H13.4922L19.748 19.2938C19.8428 19.1801 20.0134 18.9716 20.0893 18.8768L20.1272 18.8199C20.4874 18.2891 20.5632 17.8341 20.5632 17.2844V17Z" fill="#0068FF" />
                    <path d="M32.9416 29.0947H34.3255V17H32.2402V28.3933C32.2402 28.7725 32.5435 29.0947 32.9416 29.0947Z" fill="#0068FF" />
                    <path d="M25.814 19.6924C23.1979 19.6924 21.0747 21.8156 21.0747 24.4317C21.0747 27.0478 23.1979 29.171 25.814 29.171C28.4301 29.171 30.5533 27.0478 30.5533 24.4317C30.5723 21.8156 28.4491 19.6924 25.814 19.6924ZM25.814 27.2184C24.2785 27.2184 23.0273 25.9672 23.0273 24.4317C23.0273 22.8962 24.2785 21.645 25.814 21.645C27.3495 21.645 28.6007 22.8962 28.6007 24.4317C28.6007 25.9672 27.3685 27.2184 25.814 27.2184Z" fill="#0068FF" />
                    <path d="M40.4867 19.6162C37.8516 19.6162 35.7095 21.7584 35.7095 24.3934C35.7095 27.0285 37.8516 29.1707 40.4867 29.1707C43.1217 29.1707 45.2639 27.0285 45.2639 24.3934C45.2639 21.7584 43.1217 19.6162 40.4867 19.6162ZM40.4867 27.2181C38.9322 27.2181 37.681 25.9669 37.681 24.4124C37.681 22.8579 38.9322 21.6067 40.4867 21.6067C42.0412 21.6067 43.2924 22.8579 43.2924 24.4124C43.2924 25.9669 42.0412 27.2181 40.4867 27.2181Z" fill="#0068FF" />
                    <path d="M29.4562 29.0944H30.5747V19.957H28.6221V28.2793C28.6221 28.7153 29.0012 29.0944 29.4562 29.0944Z" fill="#0068FF" />
                  </svg>
                </span>
                <span class="block CSS-shadow-hover-container">
                  <span class="CSS-shadow-hover-content relative z-20 text-black/80">Zalo</span>
                  <span class="CSS-shadow-hover-shadow"></span>
                </span>
              </a>
              <a href="tel:<?= $admin['phone'] ?>" target="_blank" class="flex items-center gap-3 w-fit text-black/80">
                <span class="w-10 h-10 bg-red-600 rounded-full flex items-center justify-center transition-all duration-300">
                  <svg xmlns="http://www.w3.org/2000/svg" class="lucide lucide-phone-icon lucide-phone text-white" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M13.832 16.568a1 1 0 0 0 1.213-.303l.355-.465A2 2 0 0 1 17 15h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2A18 18 0 0 1 2 4a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2v3a2 2 0 0 1-.8 1.6l-.468.351a1 1 0 0 0-.292 1.233 14 14 0 0 0 6.392 6.384" />
                  </svg>
                </span>
                <span class="block CSS-shadow-hover-container">
                  <span class="CSS-shadow-hover-content relative z-20 text-black/80">Phone</span>
                  <span class="CSS-shadow-hover-shadow"></span>
                </span>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="flex flex-col md:flex-row justify-center items-center gap-4 border-t border-black/40">
      <div class="text-black/80 text-sm mt-4 min-[550px]:text-left text-center">
        © 2024 shopthuevalorantime.com. Tất cả quyền được bảo lưu.
      </div>
    </div>
  </div>
</footer>