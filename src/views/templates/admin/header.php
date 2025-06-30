<!-- Header -->
<header class="bg-white shadow-sm border-b border-gray-200">
  <div class="mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center h-16">
      <a href="/" class="flex items-center gap-4">
        <h1 class="text-xl font-bold text-regular-blue-cl">thueaccvaloranttime.com</h1>
      </a>

      <div class="flex items-center gap-4">
        <a href="/admin/manage-game-accounts" class="flex items-center gap-2 hover:bg-gray-100 rounded-lg p-2 transition duration-300 cursor-pointer">
          <div class="w-8 h-8 bg-gradient-to-r from-regular-from-blue-cl to-regular-to-blue-cl rounded-full flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="lucide lucide-settings-icon lucide-settings text-white" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z" />
              <circle cx="12" cy="12" r="3" />
            </svg>
          </div>
          <div class="text-sm">
            <span class="font-medium text-gray-700">Quản lý tài khoản</span>
          </div>
        </a>


        <a href="/admin/profile" class="flex items-center gap-3 hover:bg-gray-100 rounded-lg p-2 transition duration-300 cursor-pointer">
          <div class="w-8 h-8 bg-gradient-to-r from-regular-from-blue-cl to-regular-to-blue-cl rounded-full flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="lucide lucide-circle-user-icon lucide-circle-user text-white" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="12" cy="12" r="10" />
              <circle cx="12" cy="10" r="3" />
              <path d="M7 20.662V19a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v1.662" />
            </svg>
          </div>
          <div class="text-sm">
            <div class="font-medium text-gray-900"><?php echo htmlspecialchars($admin['full_name'] ?? $admin['username'] ?? 'Admin'); ?></div>
            <div class="text-gray-500">Quản trị viên</div>
          </div>
        </a>

        <button id="logout-btn" class="p-2 text-gray-500 hover:text-red-600 transition-colors" title="Đăng xuất">
          <svg xmlns="http://www.w3.org/2000/svg" class="lucide lucide-log-out-icon lucide-log-out" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="m16 17 5-5-5-5" />
            <path d="M21 12H9" />
            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
          </svg>
        </button>
      </div>
    </div>
  </div>
</header>