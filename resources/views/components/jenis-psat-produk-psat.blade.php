{{--
    Komponen partial blade: Jenis PSAT & Produk PSAT dinamis dengan AJAX
    Cara pakai di form mana pun:
    @include('components.jenis-psat-produk-psat', [
        'jenisPsats' => $jenisPsats, // array of jenis psat (wajib)
        'produkPsats' => $produkPsats ?? [], // array of produk psat (opsional, untuk edit mode)
        'selectedJenisId' => old('jenis_psat_id', $selectedJenisId ?? null), // id jenis terpilih
        'selectedProdukId' => old('produk_psat_id', $selectedProdukId ?? null), // id produk terpilih
        'jenisFieldName' => 'jenis_psat_id', // name attribute select jenis
        'produkFieldName' => 'produk_psat_id', // name attribute select produk
        'jenisLabel' => 'Jenis PSAT', // label select jenis
        'produkLabel' => 'Produk PSAT', // label select produk
        'required' => true, // wajib diisi atau tidak
        'ajaxUrl' => '/register/produk-psat-by-jenis/' // endpoint AJAX untuk load produk by jenis
    ])

    - Pastikan controller mengirimkan $jenisPsats (dan $produkPsats jika edit).
    - Untuk edit, $produkPsats bisa diisi dengan produk dari jenis terpilih.
    - AJAX akan otomatis update produk saat jenis berubah.
    - Bisa digunakan di halaman add/edit pengawasan, dsb.
--}}

@php
    $jenisFieldName = $jenisFieldName ?? 'jenis_psat_id';
    $produkFieldName = $produkFieldName ?? 'produk_psat_id';
    $jenisLabel = $jenisLabel ?? 'Jenis PSAT';
    $produkLabel = $produkLabel ?? 'Produk PSAT';
    $required = $required ?? true;
    $ajaxUrl = $ajaxUrl ?? '/register/produk-psat-by-jenis/';
    $selectedJenisId = $selectedJenisId ?? null;
    $selectedProdukId = $selectedProdukId ?? null;
    $jenisPsats = $jenisPsats ?? [];
    $produkPsats = $produkPsats ?? [];
    $uniqueId = uniqid('jenisproduk_');
@endphp

<div class="row mb-3">
    <label for="{{ $uniqueId }}_jenis" class="col-sm-2 col-form-label">{{ $jenisLabel }}@if($required)<span class="text-danger">*</span>@endif</label>
    <div class="col-sm-10">
        <select id="{{ $uniqueId }}_jenis" name="{{ $jenisFieldName }}" class="form-select" @if($required) required @endif>
            <option value="">Pilih {{ $jenisLabel }}</option>
            @foreach ($jenisPsats as $jenis)
                <option value="{{ $jenis->id }}"
                    {{ $selectedJenisId == $jenis->id ? 'selected' : '' }}>
                    {{ $jenis->nama_jenis_pangan_segar }}
                </option>
            @endforeach
        </select>
    </div>
</div>
<div class="row mb-3">
    <label for="{{ $uniqueId }}_produk" class="col-sm-2 col-form-label">{{ $produkLabel }}@if($required)<span class="text-danger">*</span>@endif</label>
    <div class="col-sm-10">
        <select id="{{ $uniqueId }}_produk" name="{{ $produkFieldName }}" class="form-select" @if($required) required @endif>
            <option value="">Pilih {{ $produkLabel }}</option>
            @foreach ($produkPsats as $produk)
                <option value="{{ $produk->id }}"
                    {{ $selectedProdukId == $produk->id ? 'selected' : '' }}>
                    {{ $produk->nama_bahan_pangan_segar }}
                </option>
            @endforeach
        </select>
    </div>
</div>

@section('footer-code')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var jenisSelect = document.getElementById('{{ $uniqueId }}_jenis');
    var produkSelect = document.getElementById('{{ $uniqueId }}_produk');

    // Function to load produk based on jenis
    function loadProduk(jenisId) {
        produkSelect.innerHTML = '<option value="">Memuat...</option>';
        if (jenisId) {
            fetch('{{ $ajaxUrl }}' + jenisId)
                .then(response => response.json())
                .then(data => {
                    produkSelect.innerHTML = '<option value="">Pilih {{ $produkLabel }}</option>';
                    var selectedProdukId = '{{ $selectedProdukId }}';
                    data.forEach(function(produk) {
                        var option = document.createElement('option');
                        option.value = produk.id;
                        option.text = produk.nama;
                        if (produk.id === selectedProdukId) {
                            option.selected = true;
                        }
                        produkSelect.appendChild(option);
                    });
                })
                .catch(() => {
                    produkSelect.innerHTML = '<option value="">Gagal memuat {{ $produkLabel }}</option>';
                });
        } else {
            produkSelect.innerHTML = '<option value="">Pilih {{ $produkLabel }}</option>';
        }
    }

    // Load produk when jenis changes
    jenisSelect.addEventListener('change', function() {
        loadProduk(this.value);
    });

    // Load produk on page load if there's a selected jenis
    if (jenisSelect.value) {
        loadProduk(jenisSelect.value);
    }
});
</script>
@endsection
