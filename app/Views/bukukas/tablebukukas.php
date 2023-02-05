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
        <td><?= esc($d['keterangan']); ?></td>
        <td class="text-end"><?= esc(($d['dk'] == 'D') ? $d['total'] : '-'); ?></td>
        <td class="text-end"><?= esc(($d['dk'] == 'K') ? $d['total'] : '-'); ?></td>
        <td class="text-end"><?= esc($d['saldo']); ?></td>
    </tr>
<?php endforeach; ?>