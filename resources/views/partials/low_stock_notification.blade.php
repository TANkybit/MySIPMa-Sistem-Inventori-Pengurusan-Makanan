@php
    $items = collect($lowStockItems ?? []);
    $count = $lowStockCount ?? $items->count();
    $previewItems = $items->take(3);
    $inventoryUrl = $inventoryUrl ?? null;
    $inventoryPage = $inventoryPage ?? null;
@endphp

@if($count > 0)
    <div class="alert alert-warning border-0 shadow-sm mb-4" role="alert">
        <div class="d-flex flex-column flex-lg-row gap-3 align-items-lg-center justify-content-between">
            <div class="d-flex gap-3">
                <div class="rounded-circle d-flex align-items-center justify-content-center bg-warning bg-opacity-25 text-warning-emphasis flex-shrink-0" style="width:44px;height:44px;">
                    <i class="fas fa-triangle-exclamation"></i>
                </div>
                <div>
                    <div class="fw-semibold">Notifikasi stok minimum</div>
                    <div class="small">
                        {{ $count }} bahan telah mencecah atau berada di bawah stok minimum.
                        @foreach($previewItems as $item)
                            <span class="badge text-bg-light border ms-1">
                                {{ data_get($item, 'name') }}:
                                {{ number_format((float) data_get($item, 'stock', 0), 2) }}
                                {{ data_get($item, 'unit', 'Unit') }}
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>

            @if($inventoryUrl)
                <a href="{{ $inventoryUrl }}" class="btn btn-sm btn-warning fw-semibold">
                    <i class="fas fa-boxes-stacked me-1"></i>Lihat Inventori
                </a>
            @elseif($inventoryPage)
                <button type="button" class="btn btn-sm btn-warning fw-semibold" data-page="{{ $inventoryPage }}">
                    <i class="fas fa-boxes-stacked me-1"></i>Lihat Inventori
                </button>
            @endif
        </div>
    </div>
@endif
