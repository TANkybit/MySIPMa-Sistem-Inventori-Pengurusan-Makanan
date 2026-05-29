<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style>
  @page {
    margin: 20mm 15mm 20mm 15mm;
  }
  body {
    font-family: sans-serif;
    font-size: 10pt;
    line-height: 1.4;
    color: #000;
  }
  .header {
    text-align: center;
    margin-bottom: 18px;
    border-bottom: 2px solid #000;
    padding-bottom: 10px;
  }
  .header h1 {
    font-size: 14pt;
    font-weight: bold;
    margin: 0 0 4px 0;
    letter-spacing: 1px;
  }
  .header h2 {
    font-size: 11pt;
    font-weight: bold;
    margin: 0 0 2px 0;
  }
  .header .institution-name {
    font-size: 11pt;
    font-weight: bold;
    margin: 6px 0;
  }
  .header .doc-title {
    font-size: 13pt;
    font-weight: bold;
    margin: 4px 0 0 0;
    text-transform: uppercase;
  }
  .info-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 14px;
  }
  .info-table td {
    padding: 2px 4px;
    vertical-align: top;
    font-size: 9.5pt;
  }
  .info-table .label {
    font-weight: bold;
    width: 22%;
  }
  .info-table .value {
    width: 28%;
  }
  .items-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 14px;
    font-size: 8.5pt;
  }
  .items-table th {
    border: 1px solid #000;
    padding: 5px 3px;
    font-weight: bold;
    text-align: center;
    background-color: #e8e8e8;
    font-size: 8pt;
  }
  .items-table td {
    border: 1px solid #000;
    padding: 3px;
    vertical-align: top;
  }
  .items-table .col-bil { width: 5%; text-align: center; }
  .items-table .col-barang { width: 25%; }
  .items-table .col-unit { width: 7%; text-align: center; }
  .items-table .col-qty { width: 10%; text-align: right; }
  .items-table .col-terima { width: 10%; text-align: right; }
  .items-table .col-harga { width: 12%; text-align: right; }
  .items-table .col-jumlah { width: 13%; text-align: right; }
  .items-table .col-catatan { width: 18%; }
  .items-table .total-row td {
    font-weight: bold;
    text-align: right;
    padding: 4px 3px;
    border-top: 2px solid #000;
  }
  .cert-section {
    margin: 20px 0;
    font-size: 9pt;
    line-height: 1.6;
  }
  .cert-section p {
    margin: 6px 0;
    text-align: justify;
  }
  .signature-section {
    width: 100%;
    margin-top: 24px;
  }
  .signature-section td {
    vertical-align: top;
    padding: 0 10px;
    width: 25%;
    font-size: 9pt;
  }
  .signature-section .sig-title {
    font-weight: bold;
    margin-bottom: 4px;
  }
  .signature-section .sig-line {
    margin-top: 40px;
    border-top: 1px solid #000;
  }
  .signature-section .sig-label {
    font-size: 8.5pt;
    margin-top: 2px;
  }
  .staff-info {
    margin-top: 20px;
    font-size: 9pt;
  }
  .staff-info td {
    vertical-align: top;
    padding: 2px 0;
  }
  .staff-info .staff-label {
    font-weight: bold;
    width: 25%;
  }
  .page-break {
    page-break-before: always;
  }
  .grand-total {
    font-weight: bold;
    font-size: 10pt;
    text-align: right;
    margin-top: 6px;
  }
  .footer-note {
    font-size: 7.5pt;
    text-align: center;
    margin-top: 20px;
    color: #555;
    border-top: 1px solid #ccc;
    padding-top: 6px;
  }
  .session-label {
    font-size: 8.5pt;
    color: #333;
  }
</style>
</head>
<body>

<div class="header">
  <h1>JABATAN PENJARA MALAYSIA</h1>
  <div class="institution-name">{{ strtoupper($header->kepada_institusi) }}</div>
  <div class="doc-title">PESANAN DAN PENERIMAAN CATUAN HARIAN</div>
</div>

<table class="info-table">
  <tr>
    <td class="label">No. Pesanan</td>
    <td class="value">: {{ $header->no_pesanan }}</td>
    <td class="label">No. Kontrak</td>
    <td class="value">: {{ $header->no_kontrak ?? '-' }}</td>
  </tr>
  <tr>
    <td class="label">Tarikh</td>
    <td class="value">: {{ $header->tarikh_pesanan ? \Carbon\Carbon::parse($header->tarikh_pesanan)->format('d/m/Y') : '-' }}</td>
    <td class="label">Hari</td>
    <td class="value">: {{ $header->tarikh_pesanan ? strtoupper(\Carbon\Carbon::parse($header->tarikh_pesanan)->isoFormat('dddd')) : '-' }}</td>
  </tr>
  <tr>
    <td class="label">Sesi</td>
    <td class="value" colspan="3">
      : @php
        $sessions = explode('/', $header->sesi_kod ?? '');
        $sessionNames = [];
        foreach ($sessions as $s) {
          $s = trim($s);
          if (isset($mealLabels[$s])) $sessionNames[] = $s . ' - ' . $mealLabels[$s];
        }
      @endphp
      {{ !empty($sessionNames) ? implode(' &nbsp;|&nbsp; ', $sessionNames) : '-' }}
    </td>
  </tr>
  <tr>
    <td class="label">Pembekal</td>
    <td class="value" colspan="3">: {{ $header->nama_pembekal ?? '-' }}</td>
  </tr>
  @if($header->alamat_pembekal)
  <tr>
    <td class="label">Alamat</td>
    <td class="value" colspan="3">
      : {{ $header->alamat_pembekal }}{{ $header->poskod_pembekal ? ', ' . $header->poskod_pembekal : '' }}
    </td>
  </tr>
  @endif
</table>

<table class="items-table" cellpadding="0" cellspacing="0">
  <thead>
    <tr>
      <th class="col-bil">Bil</th>
      <th class="col-barang">Perihal Barang</th>
      <th class="col-unit">Unit</th>
      <th class="col-qty">Kuantiti Pesanan</th>
      <th class="col-terima">Kuantiti Terima</th>
      <th class="col-harga">Harga Seunit (RM)</th>
      <th class="col-jumlah">Jumlah Harga (RM)</th>
      <th class="col-catatan">Ulasan / Catatan</th>
    </tr>
  </thead>
  <tbody>
    @php $grandTotal = 0; @endphp
    @foreach($items as $idx => $item)
    @php
      $lineTotal = (float)$item->kuantiti_dipesan * (float)$item->harga_seunit;
      $grandTotal += $lineTotal;
    @endphp
    <tr>
      <td class="col-bil">{{ $idx + 1 }}</td>
      <td class="col-barang">{{ $item->nama_barang }}</td>
      <td class="col-unit">{{ $item->unit }}</td>
      <td class="col-qty">{{ number_format((float)$item->kuantiti_dipesan, 2) }}</td>
      <td class="col-terima">________</td>
      <td class="col-harga">{{ number_format((float)$item->harga_seunit, 2) }}</td>
      <td class="col-jumlah">{{ number_format($lineTotal, 2) }}</td>
      <td class="col-catatan">{{ $item->catatan_item ?? '' }}</td>
    </tr>
    @endforeach
  </tbody>
  <tfoot>
    <tr class="total-row">
      <td colspan="6" style="text-align: right; font-weight: bold;">JUMLAH BESAR (RM)</td>
      <td style="font-weight: bold; text-align: right;">{{ number_format($grandTotal, 2) }}</td>
      <td></td>
    </tr>
  </tfoot>
</table>

@if($header->catatan_inden)
<div style="margin-bottom: 10px; font-size: 9pt;">
  <strong>Catatan:</strong> {{ $header->catatan_inden }}
</div>
@endif

<div class="cert-section">
  <p>Saya memperakui bahawa barang-barang tersebut telah dibekalkan mengikut penentuan/spesifikasi sebagaimana dalam kontrak.</p>
  <p>Adalah disahkan bahawa barang-barang seperti di atas telah diterima dengan betul dan mematuhi penentuan kontrak.</p>
</div>

<table class="signature-section">
  <tr>
    <td>
      <div class="sig-title">Tandatangan Pembekal</div>
      <div class="sig-line"></div>
      <div class="sig-label">Nama: {{ $header->wakil_pembekal ?? '___________________' }}</div>
      <div class="sig-label">Tarikh: {{ $header->tarikh_pembekal ? \Carbon\Carbon::parse($header->tarikh_pembekal)->format('d/m/Y') : '________' }}</div>
    </td>
    <td>
      <div class="sig-title">Tandatangan Saksi</div>
      <div class="sig-line"></div>
      <div class="sig-label">Nama: ___________________</div>
      <div class="sig-label">Tarikh: ________</div>
    </td>
    <td>
      <div class="sig-title">Tandatangan Penerima</div>
      <div class="sig-line"></div>
      <div class="sig-label">Nama: ___________________</div>
      <div class="sig-label">Tarikh: ________</div>
    </td>
    <td>
      <div class="sig-title">Pegawai Penyedia</div>
      <div class="sig-line"></div>
      <div class="sig-label">Nama: {{ $header->disediakan_oleh ?? '___________________' }}</div>
      <div class="sig-label">Jawatan/Cop: {{ $header->jawatan_cop ?? '' }}{{ $header->jawatan_gred ? ' Gred ' . $header->jawatan_gred : '' }}</div>
      <div class="sig-label">Tarikh: {{ $header->tarikh_pesanan ? \Carbon\Carbon::parse($header->tarikh_pesanan)->format('d/m/Y') : '________' }}</div>
    </td>
  </tr>
</table>

<table class="staff-info">
  <tr>
    <td class="staff-label">Disediakan oleh:</td>
    <td>{{ $header->disediakan_oleh ?? '___________________' }}</td>
  </tr>
  <tr>
    <td class="staff-label">Jawatan:</td>
    <td>{{ $header->jawatan_cop ?? '' }}{{ $header->jawatan_gred ? ' Gred ' . $header->jawatan_gred : '' }}</td>
  </tr>
</table>

<div class="footer-note">
  Dokumen ini dijana secara automatik. {{ date('d/m/Y H:i') }}
</div>

</body>
</html>