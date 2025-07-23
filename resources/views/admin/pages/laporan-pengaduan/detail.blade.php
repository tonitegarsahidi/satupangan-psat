@extends('admin.template-base', ['searchNavbar' => false])

@section('page-title', 'Detail Laporan Pengaduan')

@section('main-content')
    <div class="container-xxl flex-grow-1 container-p-y">

        @include('admin.components.breadcrumb.simple', $breadcrumbs)

        <div class="card">

            <div class="d-flex justify-content-between">
                <div class="bd-highlight">
                    <h3 class="card-header">Detail Laporan Pengaduan dengan id : {{ $data->id }}</h3>
                </div>
            </div>

            <div class="row m-2">
                <div class="col-md-8 col-xs-12">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-hover">
                            <tbody>
                                <tr>
                                    <th colspan="2" class="bg-primary text-white">Informasi Pelapor</th>
                                </tr>
                                <tr>
                                    <th style="width: 250px;">Nama Pelapor</th>
                                    <td>{{ $data->nama_pelapor }}</td>
                                </tr>
                                <tr>
                                    <th>NIK Pelapor</th>
                                    <td>{{ $data->nik_pelapor }}</td>
                                </tr>
                                <tr>
                                    <th>Nomor Telepon</th>
                                    <td>{{ $data->nomor_telepon_pelapor }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $data->email_pelapor }}</td>
                                </tr>
                                <tr>
                                    <th colspan="2" class="bg-primary text-white">Detail Laporan</th>
                                </tr>
                                <tr>
                                    <th>Lokasi Kejadian</th>
                                    <td>{{ $data->lokasi_kejadian }}</td>
                                </tr>
                                <tr>
                                    <th>Provinsi</th>
                                    <td>{{ optional($data->provinsi)->nama_provinsi ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Kota</th>
                                    <td>{{ optional($data->kota)->nama_kota ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Isi Laporan</th>
                                    <td>{{ $data->isi_laporan }}</td>
                                </tr>
                                <tr>
                                    <th colspan="2" class="bg-primary text-white">Status Tindak Lanjut</th>
                                </tr>
                                <tr>
                                    <th>Tindak Lanjut Pertama</th>
                                    <td>{{ is_null($data->tindak_lanjut_pertama) ? 'Belum Ada' : $data->tindak_lanjut_pertama }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Status Aktif</th>
                                    <td>
                                        @if ($data->is_active)
                                            <span class="badge rounded-pill bg-success"> Aktif </span>
                                        @else
                                            <span class="badge rounded-pill bg-danger"> Tidak Aktif </span>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        @if (config('constant.CRUD.DISPLAY_TIMESTAMPS'))
                            @include('components.crud-timestamps', $data)
                        @endif

                    </div>
                </div>
            </div>

            <div class="card mt-4">
                <div class="m-4">
                    <h4>Workflow Actions & Threads (Chronological)</h4>
                    <div class="timeline">
                        @php
                            $historyItems = collect();
                            if ($data->workflow) {
                                foreach ($data->workflow->threads as $thread) {
                                    $historyItems->push([
                                        'type' => 'thread',
                                        'timestamp' => $thread->created_at,
                                        'data' => $thread,
                                    ]);
                                }
                                foreach ($data->workflow->actions as $action) {
                                    $historyItems->push([
                                        'type' => 'action',
                                        'timestamp' => $action->action_time,
                                        'data' => $action,
                                    ]);
                                }
                            }
                            $historyItems = $historyItems->sortBy('timestamp');
                        @endphp

                        @forelse($historyItems as $item)
                            <div class="row align-items-stretch mb-2"> {{-- Reduced margin-bottom --}}
                                <div class="col-md-2 text-end pe-0">
                                    <div
                                        class="bg-light border rounded p-2 h-100 d-flex flex-column justify-content-center">
                                        <span class="fw-bold text-primary">
                                            {{ $item['data']->created_at ? \Carbon\Carbon::parse($item['data']->created_at)->timezone('Asia/Jakarta')->format('d F Y - H:i') : '' }}
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-10 ps-0">
                                    <div class="card shadow-sm h-100">
                                        <div class="card-body py-2"> {{-- Reduced padding-top/bottom --}}
                                            @if ($item['type'] === 'action')
                                                <div class="d-flex align-items-center">
                                                    <span class="badge bg-info text-dark me-2"><i class="bx bx-bolt"></i>
                                                        Action</span>
                                                    <b>Action Type:</b>
                                                    @php
                                                        $actionType = $item['data']->action_type ?? null;
                                                        $actionTypeLabel =
                                                            $actionType &&
                                                            config('workflow.action_types') &&
                                                            isset(config('workflow.action_types')[$actionType])
                                                                ? config('workflow.action_types')[$actionType]
                                                                : $actionType;
                                                    @endphp
                                                    {{ $actionTypeLabel ?? '-' }}
                                                    <span class="mx-2">|</span>
                                                    <b>By:</b>
                                                    @if ($item['data']->user && $item['data']->user->name)
                                                        <a href="{{ route('admin.user.detail', ['id' => $item['data']->user->id]) }}"
                                                            target="_blank">
                                                            {{ $item['data']->user->name }}
                                                        </a>
                                                    @else
                                                        {{ $item['data']->user_id ?? '-' }}
                                                    @endif
                                                    @if ($item['data']->notes)
                                                        <span class="mx-2">|</span>
                                                        <b>Note:</b> {{ $item['data']->notes }}
                                                    @endif
                                                </div>
                                            @else
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <span>
                                                        <span class="badge bg-warning text-dark me-2"><i
                                                                class="bx bx-message"></i> Thread</span>
                                                    </span>
                                                </div>
                                                <div>
                                                    <b>Thread:</b> {{ $item['data']->message ?? '-' }}<br>
                                                    <b>By:</b>
                                                    @if ($item['data']->user && $item['data']->user->name)
                                                        <a href="{{ route('admin.user.detail', ['id' => $item['data']->user->id]) }}"
                                                            target="_blank">
                                                            {{ $item['data']->user->name }}
                                                        </a>
                                                    @else
                                                        {{ $item['data']->user_id ?? '-' }}
                                                    @endif
                                                </div>
                                            @endif
                                            @if ($item['data']->attachments && count($item['data']->attachments) > 0)
                                                <div class="mt-2">
                                                    <b>Attachments:</b>
                                                    <ul>
                                                        @foreach ($item['data']->attachments as $attachment)
                                                            <li>
                                                                <a href="{{ asset($attachment->file_path) }}"
                                                                    target="_blank">
                                                                    {{ $attachment->file_name ?? basename($attachment->file_path) }}
                                                                </a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="alert alert-info">No actions or threads found.</div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="card mt-4">
                <div class="m-4">
                    <h4>Update Laporan Pengaduan</h4>
                    <form action="{{ route('admin.laporan-pengaduan.update', ['id' => $data->id]) }}" method="POST">
                        @csrf
                        @method('PUT') {{-- Assuming it's a PUT request for update --}}
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status">
                                @if (auth()->user()->hasAnyRole(['ROLE_ADMIN', 'ROLE_SUPERVISOR']))
                                    @foreach (['MENUNGGU_JAWABAN', 'SELESAI', 'DITUTUP', 'DIBATALKAN', 'DIARSIPKAN', 'DIPINDAHKAN', 'PROSES'] as $status)
                                        <option value="{{ config('workflow.statuses.' . $status) }}">
                                            {{ config('workflow.statuses.' . $status) }}</option>
                                    @endforeach
                                @elseif (auth()->user()->hasRole('ROLE_OPERATOR'))
                                    @foreach (['PROSES', 'SELESAI', 'MENUNGGU_JAWABAN'] as $status)
                                        <option value="{{ config('workflow.statuses.' . $status) }}">
                                            {{ config('workflow.statuses.' . $status) }}</option>
                                    @endforeach
                                @else
                                    @foreach (['MENUNGGU_TANGGAPAN', 'SELESAI', 'DITUTUP'] as $status)
                                        <option value="{{ config('workflow.statuses.' . $status) }}">
                                            {{ config('workflow.statuses.' . $status) }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="mb-3" id="initiator-field" style="display: none;">
                            <label for="initiator_user_id" class="form-label">Initiator</label>
                            @include('admin.components.notification.error-validation', [
                                'field' => 'user_id_disposisi',
                            ])
                            <select class="form-control" id="user_id_disposisi" name="user_id_disposisi" required>
                                <option value="">-- Select Initiator --</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{ old('user_id_disposisi', $user->id) == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea class="form-control" id="message" name="message" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>

            <div class="m-4">
                <a onclick="goBack()" class="btn btn-outline-secondary me-2"><i
                        class="tf-icons bx bx-left-arrow-alt me-2"></i>Kembali</a>
                <a class="btn btn-primary me-2" href="{{ route('admin.laporan-pengaduan.edit', ['id' => $data->id]) }}"
                    title="update laporan">
                    <i class='tf-icons bx bx-pencil me-2'></i>Edit</a>
                <a class="btn btn-danger me-2" href="{{ route('admin.laporan-pengaduan.delete', ['id' => $data->id]) }}"
                    title="delete laporan">
                    <i class='tf-icons bx bx-trash me-2'></i>Delete</a>
            </div>
        </div>
    </div>
@endsection

@section('footer-code')
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        function goBack() {
            window.history.back();
        }

        document.addEventListener('DOMContentLoaded', function() {
            const statusSelect = document.getElementById('status');
            const initiatorField = document.getElementById('initiator-field');
            const initiatorSelect = $('#initiator_user_id'); // Use jQuery for Select2

            function toggleInitiatorField() {
                if (statusSelect.value === "{{ config('workflow.statuses.DIPINDAHKAN') }}") {
                    initiatorField.style.display = 'block';
                    initiatorSelect.prop('required', true); // Make required when visible
                } else {
                    initiatorField.style.display = 'none';
                    initiatorSelect.prop('required', false); // Not required when hidden
                    initiatorSelect.val(null).trigger('change'); // Clear selected value
                }
            }

            // Initialize Select2 for initiator_user_id
            initiatorSelect.select2({
                placeholder: '-- Select Initiator --',
                allowClear: true,
                ajax: {
                    url: '{{ route('admin.users.search') }}', // Assuming this route exists for user search
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            q: params.term // search term
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data.map(function(user) {
                                return {
                                    id: user.id,
                                    text: user.name + ' (' + user.email + ')'
                                };
                            })
                        };
                    },
                    cache: true
                },
            });

            // Initial check on page load
            toggleInitiatorField();

            // Listen for changes on the status dropdown
            statusSelect.addEventListener('change', toggleInitiatorField);
        });
    </script>
@endsection
