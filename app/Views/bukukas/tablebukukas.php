<thead class="ave-bg-th">
    <tr class="text-center">
        <th class="text-uppercase fw-bold head-no">No</th>
        <th class="text-uppercase fw-bold">Tanggal</th>
        <th class="text-uppercase fw-bold">Keterangan</th>
        <th class="text-uppercase fw-bold">Pemasukan</th>
        <th class="text-uppercase fw-bold">Pengeluaran</th>
        <th class="text-uppercase fw-bold">Saldo</th>
    </tr>
</thead>
<tbody class="sectiondatabukukas">
    <?php //echo dd($data); ?>
    <tr>
        <td class="text-center">0</td>
        <td></td>
        <td>Saldo Sebelumnya</td>
        <td></td>
        <td></td>
        <td class="text-end"><?= esc($saldoA); ?></td>
    </tr>
    <?php foreach ($data as $i => $d): ?>
        <tr>
            <td class="text-center"><?= $i + 1; ?></td>
            <td class="text-center"><?= esc($d['tanggal']); ?></td>
            <td><?= esc($d['ket']); ?></td>
            <td class="text-end"><?= esc(($d['dk'] == 'D') ? $d['total2'] : '-'); ?></td>
            <td class="text-end"><?= esc(($d['dk'] == 'K') ? $d['total2'] : '-'); ?></td>
            <td class="text-end"><?= esc($d['saldo2']); ?></td>
        </tr>
    <?php endforeach; ?>
</tbody>
<tfoot>
    <tr>
        <th colspan="3" class="text-end">Total</th>
        <th class="text-end"><?= numfmt_format($currfmt, $totDeb); ?></th>
        <th class="text-end"><?= numfmt_format($currfmt, $totKre); ?></th>
        <th class="text-end"><?= numfmt_format($currfmt, $saldoN); ?></th>
    </tr>
    <tr>
        <th colspan="3" class="text-end">Laba / Rugi</th>
        <?php if ($totDeb < $totKre): ?>
            <th class="rugikas text-end" data-bs-toggle="tooltip" data-bs-placement="bottom"
                title="Rugi (Pengeluaran > Pemasukan)">
                <?php $rugi = $totKre - $totDeb; ?>
                <?= numfmt_format($currfmt, $rugi); ?>
            </th>
            <th class="text-end">0</th>
        <?php elseif ($totDeb > $totKre): ?>
            <th class="text-end">0</th>
            <th class="labakas text-end" data-bs-toggle="tooltip" data-bs-placement="bottom"
                title="Laba (Pemasukan > Pengeluaran)">
                <?php $laba = $totDeb - $totKre; ?>
                <?= numfmt_format($currfmt, $laba); ?>
            </th>
        <?php else: ?>
            <th class="text-end">0</th>
            <th class="text-end">0</th>
        <?php endif; ?>
        <th></th>
    </tr>
</tfoot>