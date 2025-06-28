<?php

function getDBConnection()
{
  global $db;
  return $db;
}

function addAccount($data)
{
  try {
    $pdo = getDBConnection();
    $stmt = $pdo->prepare("
            INSERT INTO accounts (account_name, rank, game_code, status, description, device_type, price, created_date)
            VALUES (?, ?, ?, ?, ?, ?, ?, NOW())
        ");

    $stmt->execute([
      $data['accountName'],
      $data['rank'],
      $data['gameCode'],
      $data['status'],
      $data['description'],
      $data['deviceType'],
      $data['price']
    ]);

    return ['success' => true, 'message' => 'Tài khoản đã được thêm thành công'];
  } catch (Exception $e) {
    return ['success' => false, 'message' => 'Lỗi: ' . $e->getMessage()];
  }
}

function getStatusColor($status)
{
  switch ($status) {
    case 'AVAILABLE':
      return 'bg-green-100 text-green-800';
    case 'SOLD':
      return 'bg-red-100 text-red-800';
    case 'PENDING':
      return 'bg-yellow-100 text-yellow-800';
    default:
      return 'bg-gray-100 text-gray-800';
  }
}

function getRankColor($rank)
{
  if (strpos($rank, 'IRON') !== false || strpos($rank, 'BRONZE') !== false) return 'text-orange-600';
  if (strpos($rank, 'SILVER') !== false) return 'text-gray-600';
  if (strpos($rank, 'GOLD') !== false) return 'text-yellow-600';
  if (strpos($rank, 'PLATINUM') !== false) return 'text-cyan-600';
  if (strpos($rank, 'DIAMOND') !== false) return 'text-blue-600';
  if (strpos($rank, 'IMMORTAL') !== false) return 'text-purple-600';
  if (strpos($rank, 'RADIANT') !== false) return 'text-red-600';
  return 'text-gray-600';
}

function updateAccount($data)
{
  try {
    $pdo = getDBConnection();
    $stmt = $pdo->prepare("
            UPDATE accounts 
            SET account_name = ?, rank = ?, game_code = ?, status = ?, description = ?, device_type = ?, price = ?
            WHERE id = ?
        ");

    $stmt->execute([
      $data['accountName'],
      $data['rank'],
      $data['gameCode'],
      $data['status'],
      $data['description'],
      $data['deviceType'],
      $data['price'],
      $data['id']
    ]);

    return ['success' => true, 'message' => 'Tài khoản đã được cập nhật thành công'];
  } catch (Exception $e) {
    return ['success' => false, 'message' => 'Lỗi: ' . $e->getMessage()];
  }
}

function deleteAccount($id)
{
  try {
    $pdo = getDBConnection();
    $stmt = $pdo->prepare("DELETE FROM accounts WHERE id = ?");
    $stmt->execute([$id]);

    return ['success' => true, 'message' => 'Tài khoản đã được xóa thành công'];
  } catch (Exception $e) {
    return ['success' => false, 'message' => 'Lỗi: ' . $e->getMessage()];
  }
}

function bulkUpdateStatus($data)
{
  try {
    $pdo = getDBConnection();
    $ids = explode(',', $data['ids']);
    $status = $data['status'];

    $placeholders = str_repeat('?,', count($ids) - 1) . '?';
    $stmt = $pdo->prepare("UPDATE accounts SET status = ? WHERE id IN ($placeholders)");

    $params = array_merge([$status], $ids);
    $stmt->execute($params);

    return ['success' => true, 'message' => "Đã cập nhật trạng thái cho " . count($ids) . " tài khoản"];
  } catch (Exception $e) {
    return ['success' => false, 'message' => 'Lỗi: ' . $e->getMessage()];
  }
}

function getAccounts($filters = [])
{
  try {
    $pdo = getDBConnection();

    $where = [];
    $params = [];

    if (!empty($filters['search'])) {
      $where[] = "(account_name LIKE ? OR game_code LIKE ?)";
      $search = '%' . $filters['search'] . '%';
      $params[] = $search;
      $params[] = $search;
    }

    if (!empty($filters['status']) && $filters['status'] !== 'ALL') {
      $where[] = "status = ?";
      $params[] = $filters['status'];
    }

    if (!empty($filters['rank']) && $filters['rank'] !== 'ALL') {
      $where[] = "rank LIKE ?";
      $params[] = $filters['rank'] . '%';
    }

    $whereClause = !empty($where) ? 'WHERE ' . implode(' AND ', $where) : '';

    $stmt = $pdo->prepare("SELECT * FROM accounts $whereClause ORDER BY created_date DESC");
    $stmt->execute($params);

    return ['success' => true, 'data' => $stmt->fetchAll(PDO::FETCH_ASSOC)];
  } catch (Exception $e) {
    return ['success' => false, 'message' => 'Lỗi: ' . $e->getMessage()];
  }
}

function getStats()
{
  try {
    $pdo = getDBConnection();

    $stats = [];

    // Total accounts
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM accounts");
    $stats['totalAccounts'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

    // Available accounts
    $stmt = $pdo->query("SELECT COUNT(*) as available FROM accounts WHERE status = 'AVAILABLE'");
    $stats['availableAccounts'] = $stmt->fetch(PDO::FETCH_ASSOC)['available'];

    // Sold accounts
    $stmt = $pdo->query("SELECT COUNT(*) as sold FROM accounts WHERE status = 'SOLD'");
    $stats['soldAccounts'] = $stmt->fetch(PDO::FETCH_ASSOC)['sold'];

    // Pending accounts
    $stmt = $pdo->query("SELECT COUNT(*) as pending FROM accounts WHERE status = 'PENDING'");
    $stats['pendingAccounts'] = $stmt->fetch(PDO::FETCH_ASSOC)['pending'];

    // Monthly revenue (sum of sold accounts)
    $stmt = $pdo->query("SELECT SUM(price) as monthly_revenue FROM accounts WHERE status = 'SOLD' AND MONTH(created_date) = MONTH(NOW())");
    $stats['monthlyRevenue'] = $stmt->fetch(PDO::FETCH_ASSOC)['monthly_revenue'] ?? 0;

    // Today revenue
    $stmt = $pdo->query("SELECT SUM(price) as today_revenue FROM accounts WHERE status = 'SOLD' AND DATE(created_date) = CURDATE()");
    $stats['todayRevenue'] = $stmt->fetch(PDO::FETCH_ASSOC)['today_revenue'] ?? 0;

    return $stats;
  } catch (Exception $e) {
    return [
      'totalAccounts' => 0,
      'availableAccounts' => 0,
      'soldAccounts' => 0,
      'pendingAccounts' => 0,
      'monthlyRevenue' => 0,
      'todayRevenue' => 0
    ];
  }
}

$stats = getStats();
$accounts = getAccounts();
$accountsData = $accounts['success'] ? $accounts['data'] : [];
?>

<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Trang quản lý - Thuê Acc Valorant</title>
  <?php require_once __DIR__ . '/../../templates/head.php'; ?>
  <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
  <style>
    .notification {
      transition: all 0.3s ease;
    }
  </style>
</head>

<body class="min-h-screen bg-gray-50">
  <?php require_once __DIR__ . '/main.php'; ?>
  <?php require_once __DIR__ . '/../../templates/bottom_scripts.php'; ?>
  <script src="/pages/admin/manage-game-accounts/page.js" type="module" defer></script>
  <script>
    // Initialize Lucide icons
    lucide.createIcons();

    // Global variables
    let selectedAccounts = [];
    let deleteAccountId = null;

    // Utility functions
    function getStatusColor(status) {
      switch (status) {
        case 'AVAILABLE':
          return 'bg-green-100 text-green-800';
        case 'SOLD':
          return 'bg-red-100 text-red-800';
        case 'PENDING':
          return 'bg-yellow-100 text-yellow-800';
        default:
          return 'bg-gray-100 text-gray-800';
      }
    }

    function getRankColor(rank) {
      if (rank.includes('IRON') || rank.includes('BRONZE')) return 'text-orange-600';
      if (rank.includes('SILVER')) return 'text-gray-600';
      if (rank.includes('GOLD')) return 'text-yellow-600';
      if (rank.includes('PLATINUM')) return 'text-cyan-600';
      if (rank.includes('DIAMOND')) return 'text-blue-600';
      if (rank.includes('IMMORTAL')) return 'text-purple-600';
      if (rank.includes('RADIANT')) return 'text-red-600';
      return 'text-gray-600';
    }

    function showNotification(type, message) {
      const notification = document.getElementById('notification');
      const messageEl = document.getElementById('notification-message');

      notification.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg notification`;

      if (type === 'success') {
        notification.classList.add('bg-green-500', 'text-white');
      } else if (type === 'error') {
        notification.classList.add('bg-red-500', 'text-white');
      } else {
        notification.classList.add('bg-blue-500', 'text-white');
      }

      messageEl.textContent = message;
      notification.classList.remove('hidden');

      setTimeout(() => {
        notification.classList.add('hidden');
      }, 3000);
    }

    // Modal functions
    function showEditModal() {
      document.getElementById('editModal').classList.remove('hidden');
    }

    function hideEditModal() {
      document.getElementById('editModal').classList.add('hidden');
    }

    function showDeleteModal() {
      document.getElementById('deleteModal').classList.remove('hidden');
    }

    function hideDeleteModal() {
      document.getElementById('deleteModal').classList.add('hidden');
      deleteAccountId = null;
    }

    // Account management functions
    function submitAddAccount() {
      const form = document.getElementById('addAccountForm');
      const formData = new FormData(form);
      formData.append('action', 'add_account');

      $.ajax({
        url: '',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
          const result = JSON.parse(response);
          if (result.success) {
            showNotification('success', result.message);
            hideAddModal();
            loadAccounts();
          } else {
            showNotification('error', result.message);
          }
        },
        error: function() {
          showNotification('error', 'Có lỗi xảy ra khi thêm tài khoản');
        }
      });
    }

    function editAccount(account) {
      document.getElementById('editId').value = account.id;
      document.getElementById('editAccountName').value = account.account_name;
      document.getElementById('editRank').value = account.rank;
      document.getElementById('editGameCode').value = account.game_code;
      document.getElementById('editStatus').value = account.status;
      document.getElementById('editDescription').value = account.description;
      document.getElementById('editDeviceType').value = account.device_type;
      document.getElementById('editPrice').value = account.price;
      showEditModal();
    }

    function submitEditAccount() {
      const form = document.getElementById('editAccountForm');
      const formData = new FormData(form);
      formData.append('action', 'update_account');

      $.ajax({
        url: '',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
          const result = JSON.parse(response);
          if (result.success) {
            showNotification('success', result.message);
            hideEditModal();
            loadAccounts();
          } else {
            showNotification('error', result.message);
          }
        },
        error: function() {
          showNotification('error', 'Có lỗi xảy ra khi cập nhật tài khoản');
        }
      });
    }

    function deleteAccount(id) {
      deleteAccountId = id;
      showDeleteModal();
    }

    function confirmDelete() {
      if (!deleteAccountId) return;

      $.ajax({
        url: '',
        type: 'POST',
        data: {
          action: 'delete_account',
          id: deleteAccountId
        },
        success: function(response) {
          const result = JSON.parse(response);
          if (result.success) {
            showNotification('success', result.message);
            hideDeleteModal();
            loadAccounts();
          } else {
            showNotification('error', result.message);
          }
        },
        error: function() {
          showNotification('error', 'Có lỗi xảy ra khi xóa tài khoản');
        }
      });
    }

    function bulkUpdateStatus(status) {
      if (selectedAccounts.length === 0) {
        showNotification('error', 'Vui lòng chọn ít nhất một tài khoản');
        return;
      }

      $.ajax({
        url: '',
        type: 'POST',
        data: {
          action: 'bulk_update',
          ids: selectedAccounts.join(','),
          status: status
        },
        success: function(response) {
          const result = JSON.parse(response);
          if (result.success) {
            showNotification('success', result.message);
            selectedAccounts = [];
            updateBulkActions();
            loadAccounts();
          } else {
            showNotification('error', result.message);
          }
        },
        error: function() {
          showNotification('error', 'Có lỗi xảy ra khi cập nhật trạng thái');
        }
      });
    }

    function bulkDelete() {
      if (selectedAccounts.length === 0) {
        showNotification('error', 'Vui lòng chọn ít nhất một tài khoản');
        return;
      }

      if (!confirm(`Bạn có chắc chắn muốn xóa ${selectedAccounts.length} tài khoản đã chọn?`)) {
        return;
      }

      // Delete each account
      let deletedCount = 0;
      selectedAccounts.forEach(id => {
        $.ajax({
          url: '',
          type: 'POST',
          data: {
            action: 'delete_account',
            id: id
          },
          success: function(response) {
            const result = JSON.parse(response);
            if (result.success) {
              deletedCount++;
              if (deletedCount === selectedAccounts.length) {
                showNotification('success', `Đã xóa ${deletedCount} tài khoản thành công`);
                selectedAccounts = [];
                updateBulkActions();
                loadAccounts();
              }
            }
          }
        });
      });
    }

    function loadAccounts() {
      const search = document.getElementById('searchInput').value;
      const status = document.getElementById('statusFilter').value;
      const rank = document.getElementById('rankFilter').value;

      $.ajax({
        url: '',
        type: 'POST',
        data: {
          action: 'get_accounts',
          search: search,
          status: status,
          rank: rank
        },
        success: function(response) {
          const result = JSON.parse(response);
          if (result.success) {
            renderAccountsTable(result.data);
          } else {
            showNotification('error', result.message);
          }
        },
        error: function() {
          showNotification('error', 'Có lỗi xảy ra khi tải dữ liệu');
        }
      });
    }


    function updateBulkActions() {
      const bulkActions = document.getElementById('bulkActions');
      const selectedCount = document.getElementById('selectedCount');

      if (selectedAccounts.length > 0) {
        bulkActions.classList.remove('hidden');
        selectedCount.textContent = selectedAccounts.length;
      } else {
        bulkActions.classList.add('hidden');
      }
    }

    function exportData(format) {
      const search = document.getElementById('searchInput').value;
      const status = document.getElementById('statusFilter').value;
      const rank = document.getElementById('rankFilter').value;

      // Create a form to submit the export request
      const form = document.createElement('form');
      form.method = 'POST';
      form.action = '';

      const actionInput = document.createElement('input');
      actionInput.type = 'hidden';
      actionInput.name = 'action';
      actionInput.value = 'export_' + format;

      const searchInput = document.createElement('input');
      searchInput.type = 'hidden';
      searchInput.name = 'search';
      searchInput.value = search;

      const statusInput = document.createElement('input');
      statusInput.type = 'hidden';
      statusInput.name = 'status';
      statusInput.value = status;

      const rankInput = document.createElement('input');
      rankInput.type = 'hidden';
      rankInput.name = 'rank';
      rankInput.value = rank;

      form.appendChild(actionInput);
      form.appendChild(searchInput);
      form.appendChild(statusInput);
      form.appendChild(rankInput);

      document.body.appendChild(form);
      form.submit();
      document.body.removeChild(form);
    }

    // Event listeners
    document.addEventListener('DOMContentLoaded', function() {
      // Search and filter functionality
      const searchInput = document.getElementById('searchInput');
      const statusFilter = document.getElementById('statusFilter');
      const rankFilter = document.getElementById('rankFilter');

      [searchInput, statusFilter, rankFilter].forEach(element => {
        element.addEventListener('change', loadAccounts);
        element.addEventListener('keyup', loadAccounts);
      });

      // Select all functionality
      const selectAll = document.getElementById('selectAll');
      selectAll.addEventListener('change', function() {
        const isChecked = this.checked;
        const accountCheckboxes = document.querySelectorAll('.account-checkbox');

        accountCheckboxes.forEach(checkbox => {
          checkbox.checked = isChecked;
        });

        if (isChecked) {
          selectedAccounts = Array.from(accountCheckboxes).map(checkbox => checkbox.value);
        } else {
          selectedAccounts = [];
        }

        updateBulkActions();
      });

      // Individual checkbox functionality
      document.addEventListener('change', function(e) {
        if (e.target.classList.contains('account-checkbox')) {
          const id = e.target.value;
          const isChecked = e.target.checked;

          if (isChecked) {
            if (!selectedAccounts.includes(id)) {
              selectedAccounts.push(id);
            }
          } else {
            selectedAccounts = selectedAccounts.filter(accountId => accountId !== id);
          }

          updateBulkActions();

          // Update select all checkbox
          const totalCheckboxes = document.querySelectorAll('.account-checkbox').length;
          const checkedCheckboxes = document.querySelectorAll('.account-checkbox:checked').length;

          if (checkedCheckboxes === 0) {
            selectAll.indeterminate = false;
            selectAll.checked = false;
          } else if (checkedCheckboxes === totalCheckboxes) {
            selectAll.indeterminate = false;
            selectAll.checked = true;
          } else {
            selectAll.indeterminate = true;
          }
        }
      });

      // Modal close on outside click
      document.addEventListener('click', function(e) {
        if (e.target.classList.contains('fixed') && e.target.classList.contains('inset-0')) {
          e.target.classList.add('hidden');
        }
      });

      // Escape key to close modals
      document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
          const modals = document.querySelectorAll('.fixed.inset-0');
          modals.forEach(modal => modal.classList.add('hidden'));
        }
      });
    });
  </script>
</body>

</html>