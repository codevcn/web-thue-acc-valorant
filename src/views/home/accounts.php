<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-6">
  <?php foreach ($data['accounts'] as $acc): ?>
    <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow duration-300">
      <h3 class="text-xl font-bold text-gray-800 mb-3"><?= htmlspecialchars($acc['acc_name'] ?? '') ?></h3>
      <p class="text-gray-600 mb-2"><span class="font-semibold">Rank:</span> <?= htmlspecialchars($acc['rank'] ?? '') ?></p>
      <p class="text-gray-600 mb-2"><span class="font-semibold">Code:</span> <?= htmlspecialchars($acc['game_code'] ?? '') ?></p>
      <p class="text-gray-600 mb-2"><span class="font-semibold">Status:</span> <?= htmlspecialchars($acc['status'] ?? '') ?></p>
      <p class="text-gray-600 mb-2"><span class="font-semibold">Description:</span> <?= htmlspecialchars($acc['description'] ?? '') ?></p>
      <p class="text-gray-600 mb-2"><span class="font-semibold">Type:</span>
        <?php
        if ($acc['device_type'] === 'AT_HOME') {
          echo 'Máy nhà';
        } elseif ($acc['device_type'] === 'AT_NET') {
          echo 'Máy net';
        } else {
          echo htmlspecialchars($acc['device_type'] ?? '');
        }
        ?>
      </p>
    </div>
  <?php endforeach; ?>
</div>

<div class="flex justify-center items-center space-x-2 mt-8 mb-6">
  <?php for ($i = 1; $i <= $data['total_pages']; $i++): ?>
    <a href="?page=<?= $i ?>&limit=<?= $data['limit'] ?>"
      class="px-4 py-2 rounded-lg transition-colors duration-200 <?= $i == $data['page'] ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' ?>">
      <?= $i ?>
    </a>
  <?php endfor; ?>
</div>