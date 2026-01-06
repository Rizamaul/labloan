<?php
/*
  LABLOAN – INVENTORY SYSTEM
  Simulasi logika peminjaman & pengembalian
  (tanpa database, tanpa config)
*/

// SIMULASI DATA BARANG
$items = [
    1 => ['name' => 'Multimeter', 'stock' => 2],
    2 => ['name' => 'Oscilloscope', 'stock' => 1],
    3 => ['name' => 'Power Supply', 'stock' => 3]
];

// SIMULASI DATA PEMINJAMAN
$loans = [];

// PROSES PINJAM
if (isset($_GET['borrow'])) {
    $id = $_GET['borrow'];

    if ($items[$id]['stock'] > 0) {
        $items[$id]['stock']--;
        $loans[] = [
            'item' => $items[$id]['name'],
            'date' => date('Y-m-d'),
            'status' => 'borrowed'
        ];
        $msg = "Peminjaman berhasil";
    } else {
        $msg = "Stok habis";
    }
}

// PROSES KEMBALI
if (isset($_GET['return'])) {
    $idx = $_GET['return'];
    if (isset($loans[$idx]) && $loans[$idx]['status'] == 'borrowed') {
        $loans[$idx]['status'] = 'returned';
        $msg = "Pengembalian berhasil";
    }
}
?>

<h2>📦 Inventory Lab (Simulasi)</h2>

<?php if (isset($msg)) echo "<p><b>$msg</b></p>"; ?>

<table border="1" cellpadding="8">
<tr>
    <th>Barang</th>
    <th>Stok</th>
    <th>Aksi</th>
</tr>

<?php foreach ($items as $id => $item): ?>
<tr>
    <td><?= $item['name'] ?></td>
    <td><?= $item['stock'] ?></td>
    <td>
        <?php if ($item['stock'] > 0): ?>
            <a href="?borrow=<?= $id ?>">Pinjam</a>
        <?php else: ?>
            Habis
        <?php endif; ?>
    </td>
</tr>
<?php endforeach; ?>
</table>

<hr>

<h3>📋 Riwayat Peminjaman</h3>
<ul>
<?php foreach ($loans as $i => $loan): ?>
    <li>
        <?= $loan['item'] ?> |
        <?= $loan['date'] ?> |
        <?= $loan['status'] ?>
        <?php if ($loan['status'] == 'borrowed'): ?>
            <a href="?return=<?= $i ?>">[Kembalikan]</a>
        <?php endif; ?>
    </li>
<?php endforeach; ?>
</ul>
