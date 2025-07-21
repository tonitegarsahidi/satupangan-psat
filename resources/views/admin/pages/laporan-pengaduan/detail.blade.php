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
                                    <th style="width: 250px;" class="bg-dark text-white">Nama Pelapor</th>
                                    <td>{{ $data->nama_pelapor }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-dark text-white">NIK Pelapor</th>
                                    <td>{{ $data->nik_pelapor }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-dark text-white">Nomor Telepon</th>
                                    <td>{{ $data->nomor_telepon_pelapor }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-dark text-white">Email</th>
                                    <td>{{ $data->email_pelapor }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-dark text-white">Lokasi Kejadian</th>
                                    <td>{{ $data->lokasi_kejadian }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-dark text-white">Provinsi</th>
                                    <td>{{ optional($data->provinsi)->nama_provinsi ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-dark text-white">Kota</th>
                                    <td>{{ optional($data->kota)->nama_kota ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-dark text-white">Isi Laporan</th>
                                    <td>{{ $data->isi_laporan }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-dark text-white">Tindak Lanjut Pertama</th>
                                    <td>{{ is_null($data->tindak_lanjut_pertama) ? "Belum Ada" : $data->tindak_lanjut_pertama }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-dark text-white">Is Active</th>
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
                            <div class="row align-items-stretch mb-3">
                                <div class="col-md-3 text-end pe-0">
                                    <div class="bg-light border rounded p-2 h-100 d-flex flex-column justify-content-center">
                                        <span class="fw-bold text-primary">
                                            {{ $item['data']->created_at ? \Carbon\Carbon::parse($item['data']->created_at)->timezone('Asia/Jakarta')->format('d F Y - H:i') : '' }}
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-9 ps-0">
                                    <div class="card shadow-sm h-100">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <span>
                                                    @if($item['type'] === 'action')
                                                        <span class="badge bg-info text-dark me-2"><i class="bx bx-bolt"></i> Action</span>
                                                    @else
                                                        <span class="badge bg-warning text-dark me-2"><i class="bx bx-message"></i> Thread</span>
                                                    @endif
                                                </span>
                                            </div>
                                            <div>
                                                @if($item['type'] === 'action')
                                                    <b>Action Type:</b>
                                                    @php
                                                        $actionType = $item['data']->action_type ?? null;
                                                        $actionTypeLabel = $actionType && config('workflow.action_types') && isset(config('workflow.action_types')[$actionType])
                                                            ? config('workflow.action_types')[$actionType]
                                                            : $actionType;
                                                    @endphp
                                                    {{ $actionTypeLabel ?? '-' }}<br>
                                                    <b>By:</b>
                                                    @if($item['data']->user && $item['data']->user->name)
                                                        <a href="{{ route('admin.user.detail', ['id' => $item['data']->user->id]) }}" target="_blank">
                                                            {{ $item['data']->user->name }}
                                                        </a>
                                                    @else
                                                        {{ $item['data']->user_id ?? '-' }}
                                                    @endif
                                                    <br>
                                                    <b>Note:</b> {{ $item['data']->notes ?? '-' }}
                                                @else
                                                    <b>Thread:</b> {{ $item['data']->message ?? '-' }}<br>
                                                    <b>By:</b>
                                                    @if($item['data']->user && $item['data']->user->name)
                                                        <a href="{{ route('admin.user.detail', ['id' => $item['data']->user->id]) }}" target="_blank">
                                                            {{ $item['data']->user->name }}
                                                        </a>
                                                    @else
                                                        {{ $item['data']->user_id ?? '-' }}
                                                    @endif
                                                @endif
                                            </div>
                                            @if($item['data']->attachments && count($item['data']->attachments) > 0)
                                                <div class="mt-2">
                                                    <b>Attachments:</b>
                                                    <ul>
                                                        @foreach($item['data']->attachments as $attachment)
                                                            <li>
                                                                <a href="{{ asset($attachment->file_path) }}" target="_blank">
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
                                        <option value="{{ config('workflow.statuses.' . $status) }}">{{ config('workflow.statuses.' . $status) }}</option>
                                    @endforeach
                                @else
                                    @foreach (['MENUNGGU_TANGGAPAN', 'SELESAI', 'DITUTUP'] as $status)
                                        <option value="{{ config('workflow.statuses.' . $status) }}">{{ config('workflow.statuses.' . $status) }}</option>
                                    @endforeach
                                @endif
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
    <script>
        function goBack() {
            window.history.back();
        }
    </script>
@endsection
