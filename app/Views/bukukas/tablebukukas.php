<div class="table-responsive">
    <table class="table table-bordered table-hover" id="dataTable-Bukukas">
        <thead class="ave-bg-th">
            <tr>
                <th class="text-uppercase fw-bold head-no">No</th>
                <th class="text-uppercase fw-bold">Tanggal</th>
                <th class="text-uppercase fw-bold">Keterangan</th>
                <th class="text-uppercase fw-bold">Pemasukan</th>
                <th class="text-uppercase fw-bold">Pengeluaran</th>
                <th class="text-uppercase fw-bold">Saldo</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($datas as $i => $data): ?>
                <tr>
                    <td><?= $i + 1; ?></td>
                    <td><?= esc($data['tanggal']); ?></td>
                    <td><?= esc($data['keterangan']); ?></td>
                    <td><?= esc($data['pemasukan']); ?></td>
                    <td><?= esc($data['pengeluaran']); ?></td>
                    <td><?= esc($data['saldo']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>