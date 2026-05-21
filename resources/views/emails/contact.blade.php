@component('mail::message')
# Mesej Baru dari MySIPMa Contact Form

Anda telah menerima satu mesej baru.

**Nama:** {{ $data['name'] }}
**Emel:** {{ $data['email'] }}
**Tajuk:** {{ $data['subject'] ?? 'Tiada Tajuk' }}
**Tarikh/Masa (MYT):** {{ now()->format('d/m/Y h:i A') }}

**Mesej:**
{{ $data['message'] }}

<x-mail::button :url="'mailto:'.($data['email'] ?? '')">
Balas kepada {{ $data['name'] ?? 'pengirim' }}
</x-mail::button>

Terima Kasih,<br>
{{ config('app.name') }}
@endcomponent
