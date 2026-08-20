<!DOCTYPE html>
<html lang="ms">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style>
  @page { margin: 7mm 8mm; }
  * { box-sizing: border-box; }
  body { margin: 0; color: #000; font-family: DejaVu Sans, sans-serif; font-size: 7.4pt; }
  .document-code { font-size: 7pt; font-weight: bold; line-height: 1.15; margin-bottom: 1mm; }
  .document-code .right { float: right; text-align: right; }
  .title { clear: both; text-align: center; font-size: 11pt; font-weight: bold; line-height: 1.15; margin: 0 0 2mm; }
  .title .prism { display: block; font-size: 8pt; letter-spacing: 2px; }
  table { width: 100%; border-collapse: collapse; }
  .top-table { margin-bottom: 1.5mm; table-layout: fixed; }
  .top-table td { border: 1px solid #000; padding: 1.2mm 1.5mm; vertical-align: top; height: 8mm; }
  .top-table .supplier { width: 38%; }
  .top-table .institution { width: 37%; }
  .top-table .order-meta { width: 25%; }
  .label { font-weight: bold; }
  .supplier-name, .institution-name { display: block; font-weight: bold; margin-top: .6mm; }
  .schedule td { border: 1px solid #000; padding: 1mm 1.5mm; font-weight: bold; }
  .schedule .date { width: 75%; text-align: center; }
  .schedule .time { width: 25%; text-align: center; }
  .items { table-layout: fixed; }
  .items th, .items td { border: .7px solid #000; padding: .75mm .7mm; vertical-align: middle; }
  .items thead th { text-align: center; font-weight: bold; line-height: 1.1; }
  .items tbody td { height: 5.6mm; }
  .group-heading { font-size: 8pt; height: 6mm; }
  .description { text-align: left; }
  .number { text-align: right; white-space: nowrap; }
  .center { text-align: center; }
  .remarks { font-size: 6.6pt; }
  .total-row td { height: 6mm; font-weight: bold; }
  .footnote { margin-top: 1.5mm; font-size: 6.5pt; }
  .approval { margin-top: 1.5mm; page-break-inside: avoid; font-family: "Times New Roman", serif; font-size: 7.4pt; }
  .approval td { vertical-align: top; padding: .4mm 1.5mm; }
  .approval-top { border-bottom: 1px solid #000; }
  .approval-top td { height: 17mm; }
  .approval .prepared { width: 35%; }
  .approval .muster { width: 30%; text-align: center; font-weight: bold; }
  .approval .authority { width: 35%; text-align: center; }
  .signature-rule { border-top: 1px solid #000; margin: 0 auto .5mm; width: 88%; }
  .field-line { display: inline-block; border-bottom: 1px dashed #000; min-width: 46mm; height: 3mm; text-align: left; padding-left: 1mm; }
  .declaration-title { text-align: center; font-weight: bold; font-size: 8pt; }
  .declaration-text { text-align: center; line-height: 1.15; }
  .declaration { border-bottom: 1px solid #000; }
  .declaration td { height: 14mm; }
  .acknowledgement td { height: 20mm; }
  .acknowledgement .witness, .acknowledgement .receiver { width: 50%; }
  .acknowledgement .receiver { padding-left: 8mm; }
</style>
</head>
<body>
<?php
  $orderDate = $header->tarikh_pesanan ? \Carbon\Carbon::parse($header->tarikh_pesanan) : null;
  $sessionParts = array_map('trim', explode('/', (string) ($header->sesi_kod ?? '')));
  $sessions = implode('/', array_filter($sessionParts));
  $splitQuantity = static function ($quantity) {
      $quantity = max(0, (float) $quantity);
      $kg = (int) floor($quantity + 0.0000001);
      $gm = (int) round(($quantity - $kg) * 1000);
      if ($gm === 1000) { $kg++; $gm = 0; }
      return [$kg, $gm];
  };
  $rowCount = max(18, $items->count());
  $grandTotal = 0;
  $isReceipt = $isReceipt ?? false;
  $receivedGrandTotal = 0;
?>

<div class="document-code">
  ASAL<br>JABATAN PENJARA MALAYSIA
  <span class="right">Penjara 36 Pind. 1/93</span>
</div>
<div class="title">
  PESANAN DAN PENERIMAAN CATUAN HARIAN
  <span class="prism">P.R.I.S.M</span>
</div>

<table class="top-table">
  <tr>
    <td class="supplier">
      <span class="label">KEPADA:</span>
      <span class="supplier-name"><?php echo e(strtoupper($header->nama_pembekal ?? '-')); ?></span>
      <?php echo e(strtoupper($header->alamat_pembekal ?? '')); ?>

      <?php if($header->poskod_pembekal): ?><br><?php echo e($header->poskod_pembekal); ?><?php endif; ?>
    </td>
    <td class="institution">
      Sila bekalkan barang-barang berikut kepada:
      <span class="institution-name"><?php echo e(strtoupper($header->kepada_institusi ?? '-')); ?></span>
    </td>
    <td class="order-meta">
      <strong>No. Pesanan:</strong> <?php echo e($header->no_pesanan ?? '-'); ?><br>
      <strong>Tarikh:</strong> <?php echo e($orderDate ? $orderDate->format('d/m/Y') : '-'); ?><br>
      <strong>No. Kontrak:</strong> <?php echo e($header->no_kontrak ?? '-'); ?>

    </td>
  </tr>
</table>

<table class="schedule">
  <tr>
    <td class="date">
      Tarikh: <?php echo e($orderDate ? $orderDate->format('d/m/Y') : '-'); ?>

      <?php if($orderDate): ?> ( <?php echo e(strtoupper($orderDate->locale('ms')->isoFormat('dddd'))); ?> ) <?php endif; ?>
      <?php if($sessions): ?> - <?php echo e($sessions); ?> <?php endif; ?>
    </td>
    <td class="time">Masa: <?php echo e($header->masa ? \Carbon\Carbon::parse($header->masa)->format('Hi') . ' Hrs' : '________ Hrs'); ?></td>
  </tr>
</table>

<table class="items">
  <colgroup>
    <col style="width:12%"><col style="width:6%"><col style="width:4%"><col style="width:6%"><col style="width:8%">
    <col style="width:12%"><col style="width:6%"><col style="width:4%"><col style="width:6%"><col style="width:8%"><col style="width:22%">
  </colgroup>
  <thead>
    <tr>
      <th class="group-heading" colspan="5">BUTIR-BUTIR PESANAN</th>
      <th class="group-heading" colspan="6">BUTIR-BUTIR PENERIMAAN</th>
    </tr>
    <tr>
      <th rowspan="2">Perihal Barang</th>
      <th colspan="2">Kuantiti Pesanan</th>
      <th rowspan="2">Harga Seunit<br>(RM)</th>
      <th rowspan="2">Jumlah Harga<br>(RM)</th>
      <th rowspan="2">Perihal Barang</th>
      <th colspan="2">Kuantiti Terima</th>
      <th rowspan="2">Harga Seunit<br>(RM)</th>
      <th rowspan="2">Jumlah Harga<br>(RM)</th>
      <th rowspan="2">Ulasan / Catatan</th>
    </tr>
    <tr><th>Kg.</th><th>Gm.</th><th>Kg.</th><th>Gm.</th></tr>
  </thead>
  <tbody>
    <?php for($index = 0; $index < $rowCount; $index++): ?>
      <?php
        $item = $items->get($index);
        [$kg, $gm] = $item ? $splitQuantity($item->kuantiti_dipesan) : [null, null];
        [$receivedKg, $receivedGm] = ($item && $isReceipt) ? $splitQuantity($item->kuantiti_diterima ?? 0) : [null, null];
        $lineTotal = $item ? (float) $item->kuantiti_dipesan * (float) $item->harga_seunit : 0;
        $receivedTotal = ($item && $isReceipt) ? (float) ($item->jumlah_diterima ?? ((float) ($item->kuantiti_diterima ?? 0) * (float) $item->harga_seunit)) : null;
        $grandTotal += $lineTotal;
        if ($receivedTotal !== null) { $receivedGrandTotal += $receivedTotal; }
      ?>
      <tr>
        <td class="description"><?php echo e($item->nama_barang ?? ''); ?></td>
        <td class="number"><?php echo e($item ? number_format($kg) : '-'); ?></td>
        <td class="number"><?php echo e($item ? ($gm ? str_pad((string) $gm, 3, '0', STR_PAD_LEFT) : '-') : '-'); ?></td>
        <td class="number"><?php echo e($item ? number_format((float) $item->harga_seunit, 2) : '-'); ?></td>
        <td class="number"><?php echo e($item ? number_format($lineTotal, 3) : '-'); ?></td>
        <td class="description"><?php echo e($item->nama_barang ?? ''); ?></td>
        <td class="number"><?php echo e($isReceipt && $item ? number_format($receivedKg) : ''); ?></td>
        <td class="number"><?php echo e($isReceipt && $item ? ($receivedGm ? str_pad((string) $receivedGm, 3, '0', STR_PAD_LEFT) : '-') : ''); ?></td>
        <td class="number"><?php echo e($item ? number_format((float) $item->harga_seunit, 2) : '-'); ?></td>
        <td class="number"><?php echo e($isReceipt && $item ? number_format($receivedTotal, 3) : ''); ?></td>
        <td class="remarks"><?php echo e($item->catatan_item ?? ''); ?></td>
      </tr>
    <?php endfor; ?>
  </tbody>
  <tfoot>
    <tr class="total-row">
      <td colspan="4" class="center">Jumlah Harga</td>
      <td class="number"><?php echo e(number_format($grandTotal, 3)); ?></td>
      <td colspan="4" class="center">Jumlah Harga</td>
      <td class="number"><?php echo e($isReceipt ? number_format($receivedGrandTotal, 3) : '-'); ?></td>
      <td></td>
    </tr>
  </tfoot>
</table>

<?php if($header->catatan_inden): ?>
  <div class="footnote"><strong>Catatan:</strong> <?php echo e($header->catatan_inden); ?></div>
<?php endif; ?>
<?php if($isReceipt && isset($replacements) && $replacements->isNotEmpty()): ?>
  <div class="footnote"><strong>Barang gantian:</strong>
    <?php $__currentLoopData = $replacements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $replacement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <?php echo e($replacement->item_name); ?> (<?php echo e(number_format((float) $replacement->quantity, 3)); ?> <?php echo e($replacement->unit); ?>)<?php echo e(!$loop->last ? '; ' : ''); ?>

    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </div>
<?php endif; ?>

<?php
  $supplierDate = $header->tarikh_pembekal ? \Carbon\Carbon::parse($header->tarikh_pembekal)->format('d/m/Y') : '';
  $witnessDate = $header->tarikh_saksi ? \Carbon\Carbon::parse($header->tarikh_saksi)->format('d/m/Y') : $supplierDate;
  $receiverDate = $header->tarikh_penerima ? \Carbon\Carbon::parse($header->tarikh_penerima)->format('d/m/Y') : $supplierDate;
  $positionText = trim(($header->jawatan_cop ?? '') . ($header->jawatan_gred ? ' ' . $header->jawatan_gred : ''));
?>
<table class="approval">
  <tr class="approval-top">
    <td class="prepared">
      Disediakan oleh&nbsp;&nbsp;: &nbsp;<?php echo e(strtoupper($header->disediakan_oleh ?? '')); ?><br>
      <span style="display:inline-block;width:24mm"></span><?php echo e(strtoupper($positionText)); ?><br>
      Tarikh&nbsp;&nbsp;&nbsp;&nbsp;: &nbsp;<?php echo e($orderDate ? $orderDate->format('d/m/Y') : ''); ?>

    </td>
    <td class="muster">
      MUSTER KHAS (DAGING) : <?php echo e(number_format((float) ($header->muster_khas_daging ?? 0))); ?><br>
      MUSTER (DITOLAK DARI PAROL) : <?php echo e(number_format((float) ($header->muster_ditolak_parol ?? 0))); ?><br>
      PAROL : <?php echo e(number_format((float) ($header->parol ?? 0))); ?><br>
      MUSTER PENUH : <?php echo e(number_format((float) ($header->muster_penuh ?? 0))); ?>

    </td>
    <td class="authority">
      <div class="signature-rule"></div>
      (Tandatangan Pegawai Yang diberi Kuasa Memesan)<br><br>
      Jawatan / Cop&nbsp;&nbsp;: <span class="field-line"></span><br>
      Tarikh&nbsp;&nbsp;: <span class="field-line"><?php echo e($orderDate ? $orderDate->format('d/m/Y') : ''); ?></span>
    </td>
  </tr>
  <tr class="declaration">
    <td colspan="3">
      <div class="declaration-title">PERAKUAN PEMBEKAL</div>
      <div class="declaration-text">Saya memperakui bahawa barang-barang tersebut diatas telah dibekalkan mengikut penentuan/spesifikasi sebagaimana dalam kontrak No. <span class="field-line"><?php echo e($header->no_kontrak ?? ''); ?></span></div>
      <table><tr>
        <td style="width:50%">Tarikh&nbsp;&nbsp;: <span class="field-line"><?php echo e($supplierDate); ?></span></td>
        <td style="width:50%;text-align:right">Tandatangan Pembekal&nbsp;&nbsp;: <span class="field-line"></span><br>dan Cop&nbsp;&nbsp;: <span class="field-line"></span></td>
      </tr></table>
    </td>
  </tr>
  <tr>
    <td colspan="3" class="declaration-text">Adalah disahkan bahawa barang-barang seperti diatas telah diterima dengan betul dan mematuhi penentuan sebagaimana dalam kontrak No. <span class="field-line"><?php echo e($header->no_kontrak ?? ''); ?></span><br>dan dikeluarkan untuk kegunaan serta-merta.</td>
  </tr>
  <tr class="acknowledgement">
    <td class="witness" colspan="2">
      Tandatangan Saksi&nbsp;&nbsp;: <span class="field-line"></span><br>
      Nama&nbsp;&nbsp;: <span class="field-line"><?php echo e($isReceipt ? ($header->witness_name ?? '') : ''); ?></span><br>
      Jawatan / Cop&nbsp;&nbsp;: <span class="field-line"><?php echo e($isReceipt ? trim(($header->witness_position ?? '') . ' ' . ($header->witness_grade ?? '')) : ''); ?></span><br>
      Tarikh&nbsp;&nbsp;: <span class="field-line"><?php echo e($witnessDate); ?></span>
    </td>
    <td class="receiver">
      Tandatangan Penerima&nbsp;&nbsp;: <span class="field-line"></span><br>
      Nama&nbsp;&nbsp;: <span class="field-line"><?php echo e($isReceipt ? ($header->received_by_name ?? '') : ''); ?></span><br>
      Jawatan / Cop&nbsp;&nbsp;: <span class="field-line"><?php echo e($isReceipt ? trim(($header->receiver_position ?? '') . ' ' . ($header->receiver_grade ?? '')) : ''); ?></span><br>
      Tarikh&nbsp;&nbsp;: <span class="field-line"><?php echo e($receiverDate); ?></span>
    </td>
  </tr>
</table>
</body>
</html>
<?php /**PATH C:\laragon\www\MySIPMA_2\resources\views/pdf/borang_inden.blade.php ENDPATH**/ ?>