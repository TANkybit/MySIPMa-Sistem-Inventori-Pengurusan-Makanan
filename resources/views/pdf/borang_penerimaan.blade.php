<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style>
  @page { margin: 20mm 15mm 20mm 15mm; }
  body { font-family: sans-serif; font-size: 10pt; line-height: 1.4; color: #000; }
  .header { text-align: center; margin-bottom: 18px; border-bottom: 2px solid #000; padding-bottom: 10px; }
  .header h1 { font-size: 14pt; font-weight: bold; margin: 0 0 4px 0; letter-spacing: 1px; }
  .header h2 { font-size: 11pt; font-weight: bold; margin: 0 0 2px 0; }
  .header .institution-name { font-size: 11pt; font-weight: bold; margin: 6px 0; }
  .header .doc-title { font-size: 13pt; font-weight: bold; margin: 4px 0 0 0; text-transform: uppercase; }
  .info-table { width: 100%; border-collapse: collapse; margin-bottom: 14px; }
  .info-table td { padding: 2px 4px; vertical-align: top; }
  .info-table .label { width: 140px; font-weight: bold; }
  .main-table { width: 100%; border-collapse: collapse; margin-bottom: 12px; }
  .main-table th { border: 1px solid #000; padding: 5px 4px; font-size: 9pt; font-weight: bold; text-align: center; background: #e0e0e0; }
  .main-table td { border: 1px solid #000; padding: 4px; font-size: 9pt; vertical-align: top; }
  .main-table .text-right { text-align: right; }
  .main-table .text-center { text-align: center; }
  .signature { margin-top: 30px; }
  .signature td { padding: 4px 20px; vertical-align: top; }
  .footer-note { margin-top: 20px; font-size: 9pt; border-top: 1px solid #000; padding-top: 8px; }
  .salah-badge { color: #c00; font-weight: bold; font-size: 8pt; }
  .replacement-row { background: #f5f5f5; }
  .replacement-row td { font-size: 8pt; padding-left: 20px; }
</style>
</head>
<body>

<div class="header">
  <h1>JABATAN PENJARA MALAYSIA</h1>
  <h2>PESANAN DAN PENERIMAAN CATUAN HARIAN</h2>
  <div class="institution-name">{{ $header->institution_name ?? '-' }}</div>
  <div class="doc-title">Borang Penerimaan Barang</div>
</div>

<table class="info-table">
  <tr>
    <td class="label">No. Pesanan</td>
    <td>: <strong>{{ $header->order_no ?? '-' }}</strong></td>
    <td class="label" style="width:100px;">Tarikh Pesanan</td>
    <td>: {{ $header->order_date ? \Carbon\Carbon::parse($header->order_date)->format('d/m/Y') : '-' }}</td>
  </tr>
  <tr>
    <td class="label">Pembekal</td>
    <td>: {{ $header->supplier_name ?? '-' }}</td>
    <td class="label">No. Kontrak</td>
    <td>: {{ $header->contract_no ?? '-' }}</td>
  </tr>
  <tr>
    <td class="label">Tarikh Terima</td>
    <td>: {{ $header->receiver_date ? \Carbon\Carbon::parse($header->receiver_date)->format('d/m/Y') : '-' }}</td>
    <td class="label">Status</td>
    <td>: {{ $header->penerimaan_status ?? '-' }}</td>
  </tr>
  <tr>
    <td class="label">Diterima Oleh</td>
    <td colspan="3">: {{ $header->received_by_name ?? '-' }}</td>
  </tr>
</table>

<table class="main-table">
  <thead>
    <tr>
      <th width="4%">Bil</th>
      <th width="28%">Nama Barang</th>
      <th width="8%">Unit</th>
      <th width="12%">Kuantiti Dipesan</th>
      <th width="12%">Kuantiti Diterima</th>
      <th width="18%">Catatan</th>
      <th width="10%">Jumlah (RM)</th>
    </tr>
  </thead>
  <tbody>
    @forelse($items as $idx => $item)
      @php
        $isSalah = $item->item_remarks && str_contains($item->item_remarks, '[SALAH]');
        $total = (float) ($item->received_quantity ?? 0) * (float) ($item->unit_price ?? 0);
      @endphp
      <tr>
        <td class="text-center">{{ $idx + 1 }}</td>
        <td>{{ $item->item_name ?? '-' }}</td>
        <td class="text-center">{{ $item->unit ?? 'Unit' }}</td>
        <td class="text-right">{{ number_format((float) ($item->ordered_quantity ?? 0), 2) }}</td>
        <td class="text-right">{{ number_format((float) ($item->received_quantity ?? 0), 2) }}</td>
        <td>
          {{ $item->item_remarks ?? '' }}
          @if($isSalah)
            <span class="salah-badge">[SALAH]</span>
          @endif
        </td>
        <td class="text-right">{{ number_format($total, 2) }}</td>
      </tr>
      @if($isSalah)
        @php
          $matching = $replacements->first();
        @endphp
        @if($matching && $matching->item_name)
          <tr class="replacement-row">
            <td colspan="7">
              <strong>Barang Gantian:</strong> {{ $matching->item_name }}
              @if($matching->unit) ({{ $matching->unit }}) @endif
              x {{ $matching->quantity ?? 0 }}
              @if($matching->total_price) — RM {{ number_format((float) $matching->total_price, 2) }} @endif
            </td>
          </tr>
        @endif
      @endif
    @empty
      <tr>
        <td colspan="7" class="text-center">Tiada item</td>
      </tr>
    @endforelse
  </tbody>
</table>

@if($header->penerimaan_catatan)
  <p><strong>Catatan Penerimaan:</strong> {{ $header->penerimaan_catatan }}</p>
@endif

<table class="signature">
  <tr>
    <td style="width:50%;">
      <p><strong>Diterima Oleh:</strong></p>
      <br><br>
      <p>.......................................</p>
      <p><strong>{{ $header->received_by_name ?? '-' }}</strong></p>
      <p>Tarikh: {{ $header->receiver_date ? \Carbon\Carbon::parse($header->receiver_date)->format('d/m/Y') : '-' }}</p>
    </td>
    <td style="width:50%;">
      <p><strong>Pengesahan Pembekal:</strong></p>
      <br><br>
      <p>.......................................</p>
      <p><strong>{{ $header->supplier_name ?? '-' }}</strong></p>
      <p>Tarikh: ________________</p>
    </td>
  </tr>
</table>

<div class="footer-note">
  <strong>Status Penerimaan:</strong> {{ $header->penerimaan_status ?? '-' }} &nbsp;|&nbsp;
  <strong>Jumlah Pesanan:</strong> RM {{ number_format((float) ($header->total_amount ?? 0), 2) }}
</div>

</body>
</html>
