@extends('admin/template-base')

@section('page-title', 'Kirim Notifikasi')

{{-- MAIN CONTENT PART --}}
@section('main-content')
    <div class="container-xxl flex-grow-1 container-p-y">

        {{-- FOR BREADCRUMBS --}}
        @include('admin.components.breadcrumb.simple', $breadcrumbs)

        {{-- MAIN PARTS --}}

        <div class="card">

            {{-- FIRST ROW,  FOR TITLE --}}
            <div class="d-flex justify-content-between">

                <div class="p-2 bd-highlight">
                    <h3 class="card-header">Kirim Notifikasi ke Pemilik Usaha</h3>
                </div>

            </div>

            {{-- SECOND ROW,  FOR DISPLAY PER PAGE AND SEARCH FORM --}}
            <div class="card-body">

                {{-- to display any error if any --}}
                @if (isset($alerts))
                    @include('admin.components.notification.general', $alerts)
                @endif

                <form action="{{ route('surveilan.send-notification') }}" method="POST" class="needs-validation" novalidate>
                    @csrf

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="business_owner" class="form-label">Pemilik Bisnis</label>
                            <select class="form-select" id="business_owner" name="business_owner_id" required {{ isset($selectedBusinessOwner) ? 'disabled' : '' }}>
                                <option value="">-- Pilih Pemilik Bisnis --</option>
                                @foreach ($businessOwners as $owner)
                                    <option value="{{ $owner->id }}" {{ (isset($selectedBusinessOwner) && $selectedBusinessOwner->id === $owner->id) ? 'selected' : '' }}>
                                        {{ $owner->name }} ({{ $owner->email }}) - {{ $owner->business->nama_perusahaan }}
                                    </option>
                                @endforeach
                            </select>
                            @if(isset($selectedBusinessOwner))
                                <input type="hidden" name="business_owner_id" value="{{ $selectedBusinessOwner->id }}">
                            @endif
                            @error('business_owner_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <div class="invalid-feedback">
                                Silakan pilih pemilik bisnis.
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="title" class="form-label">Judul</label>
                            <input type="text" class="form-control" id="title" name="title" value="[PENTING] Kunjungan Surveilan untuk {{(request('jenis') ?? '')}}, Nomor {{request('nomor')}}" required>
                            @error('title')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <div class="invalid-feedback">
                                Silakan masukkan judul.
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="message" class="form-label">Pesan</label>
                            <textarea class="form-control" id="message" name="message" rows="8" required
                                placeholder="Tulis pesan yang akan dikirim ke pemilik bisnis...">Yang kami hormati {{request('pelaku_usaha') ?? ''}},
dengan ini kami memberitahukan terkait rencana surveilance/visitasi yang akan kami lakukan, terkait dokumen berikut :

{{
                                    'Jenis: ' . (request('jenis') ?? '') . "\n" .
                                    'Nomor: ' . (request('nomor') ?? '') . "\n" .
                                    'Akhir Masa Berlaku: ' . (request('akhir_masa_berlaku') ?? '')."\n"
                                }}Atas perhatiannya kami ucapkan terima kasih</textarea>
                            @error('message')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <div class="invalid-feedback">
                                Silakan tulis pesan.
                            </div>
                        </div>
                    </div>


                    <div class="d-flex justify-content-between">
                        <div>
                            <a href="{{ route('surveilan.index') }}" class="btn btn-secondary">
                                <i class="bx bx-arrow-back me-1"></i>
                                Kembali
                            </a>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary">
                                <i class="bx bx-send me-1"></i>
                                Kirim Pesan
                            </button>
                        </div>
                    </div>

                </form>

            </div>

        </div>
    </div>
@endsection

{{-- Add JavaScript for form validation --}}
@section('scripts')
<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function () {
        'use strict'

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.querySelectorAll('.needs-validation')

        // Loop over them and prevent submission
        Array.prototype.slice.call(forms).forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }

                form.classList.add('was-validated')
            }, false)
        })
    })()
</script>
@endsection
