{{--
    Komponen partial blade: Provinsi & Kota dinamis dengan AJAX
    Cara pakai di form mana pun:
    @include('components.provinsi-kota', [
        'provinsis' => $provinsis, // array of provinsi (wajib)
        'kotas' => $kotas ?? [], // array of kota (opsional, untuk edit mode)
        'selectedProvinsiId' => old('provinsi_id', $selectedProvinsiId ?? null), // id provinsi terpilih
        'selectedKotaId' => old('kota_id', $selectedKotaId ?? null), // id kota terpilih
        'provinsiFieldName' => 'provinsi_id', // name attribute select provinsi
        'kotaFieldName' => 'kota_id', // name attribute select kota
        'provinsiLabel' => 'Provinsi', // label select provinsi
        'kotaLabel' => 'Kabupaten/Kota', // label select kota
        'required' => true, // wajib diisi atau tidak
        'ajaxUrl' => '/register/kota-by-provinsi/' // endpoint AJAX untuk load kota by provinsi
    ])

    - Pastikan controller mengirimkan $provinsis (dan $kotas jika edit).
    - Untuk edit, $kotas bisa diisi dengan kota dari provinsi terpilih.
    - AJAX akan otomatis update kota saat provinsi berubah.
    - Bisa digunakan di halaman add/edit user, laporan, dsb.
--}}

@php
    $provinsiFieldName = $provinsiFieldName ?? 'provinsi_id';
    $kotaFieldName = $kotaFieldName ?? 'kota_id';
    $provinsiLabel = $provinsiLabel ?? 'Provinsi';
    $kotaLabel = $kotaLabel ?? 'Kabupaten/Kota';
    $required = $required ?? true;
    $ajaxUrl = $ajaxUrl ?? '/register/kota-by-provinsi/';
    $selectedProvinsiId = $selectedProvinsiId ?? null;
    $selectedKotaId = $selectedKotaId ?? null;
    $provinsis = $provinsis ?? [];
    $kotas = $kotas ?? [];
    $uniqueId = uniqid('provkot_');
@endphp

<div class="row mb-3">
    <label for="{{ $uniqueId }}_provinsi" class="col-sm-2 col-form-label">{{ $provinsiLabel }}@if($required)<span class="text-danger">*</span>@endif</label>
    <div class="col-sm-10">
        <select id="{{ $uniqueId }}_provinsi" name="{{ $provinsiFieldName }}" class="form-select" @if($required) required @endif>
            <option value="">Pilih {{ $provinsiLabel }}</option>
            @foreach ($provinsis as $provinsi)
                <option value="{{ $provinsi->id }}"
                    {{ $selectedProvinsiId == $provinsi->id ? 'selected' : '' }}>
                    {{ $provinsi->nama_provinsi }}
                </option>
            @endforeach
        </select>
    </div>
</div>
<div class="row mb-3">
    <label for="{{ $uniqueId }}_kota" class="col-sm-2 col-form-label">{{ $kotaLabel }}@if($required)<span class="text-danger">*</span>@endif</label>
    <div class="col-sm-10">
        <select id="{{ $uniqueId }}_kota" name="{{ $kotaFieldName }}" class="form-select" @if($required) required @endif>
            <option value="">Pilih {{ $kotaLabel }}</option>
            @foreach ($kotas as $kota)
                <option value="{{ $kota->id }}"
                    {{ $selectedKotaId == $kota->id ? 'selected' : '' }}>
                    {{ $kota->nama_kota }}
                </option>
            @endforeach
        </select>
    </div>
</div>

@section('footer-code')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var provinsiSelect = document.getElementById('{{ $uniqueId }}_provinsi');
    var kotaSelect = document.getElementById('{{ $uniqueId }}_kota');

    // Function to load kotas based on provinsi
    function loadKotas(provinsiId) {
        kotaSelect.innerHTML = '<option value="">Memuat...</option>';
        if (provinsiId) {
            fetch('{{ $ajaxUrl }}' + provinsiId)
                .then(response => response.json())
                .then(data => {
                    kotaSelect.innerHTML = '<option value="">Pilih {{ $kotaLabel }}</option>';
                    var selectedKotaId = '{{ $selectedKotaId }}';
                    data.forEach(function(kota) {
                        var option = document.createElement('option');
                        option.value = kota.id;
                        option.text = kota.nama_kota;
                        if (kota.id === selectedKotaId) {
                            option.selected = true;
                        }
                        kotaSelect.appendChild(option);
                    });
                })
                .catch(() => {
                    kotaSelect.innerHTML = '<option value="">Gagal memuat kota</option>';
                });
        } else {
            kotaSelect.innerHTML = '<option value="">Pilih {{ $kotaLabel }}</option>';
        }
    }

    // Load kotas when provinsi changes
    provinsiSelect.addEventListener('change', function() {
        loadKotas(this.value);
    });

    // Load kotas on page load if there's a selected provinsi
    if (provinsiSelect.value) {
        loadKotas(provinsiSelect.value);
    }
});
</script>
@endsection
