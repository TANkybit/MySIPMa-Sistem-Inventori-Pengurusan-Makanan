<x-mail::message>
# Mesej Baharu daripada {{ $data['name'] ?? 'Pengguna' }}

**Alamat Emel:** {{ $data['email'] }}  
**Tajuk:** {{ $data['subject'] ?? 'Tiada tajuk' }}

---

{{ $data['message'] }}

<x-mail::button :url="'mailto:'.($data['email'] ?? '')">
Balas kepada {{ $data['name'] ?? 'pengirim' }}
</x-mail::button>

Terima kasih,<br>
{{ config('app.name') }}
</x-mail::message>
