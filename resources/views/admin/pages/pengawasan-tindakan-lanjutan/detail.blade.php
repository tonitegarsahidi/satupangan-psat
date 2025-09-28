@extends('admin.template-base', ['searchNavbar' => false])

@section('page-title', 'Detail of Pengawasan Tindakan Lanjutan')

{{-- MAIN CONTENT PART --}}
@section('main-content')
    <div class="container-xxl flex-grow-1 container-p-y">

        {{-- FOR BREADCRUMBS --}}
        @include('admin.components.breadcrumb.simple', $breadcrumbs)

        {{-- MAIN PARTS --}}

        <div class="card">

            {{-- FIRST ROW,  FOR TITLE --}}
            <div class="d-flex justify-content-between">

                <div class="bd-highlight">
                    <h3 class="card-header">Detail of Pengawasan Tindakan Lanjutan with id : {{ $data->id }}</h3>
                </div>

            </div>

            <div class="row m-2">

                <div class="col-md-8 col-xs-12">
                    <div style="overflow-x: visible; width: 100%;">
                        <table class="table table-hover" style="table-layout: auto; width: 100%;">
                            <tbody>
                                <tr>
                                    <th style="width: 30%; min-width: 200px;" scope="col" class="bg-dark text-white">Tindakan Asal</th>
                                    <td>
                                        @if ($data->tindakan)
                                            <a href="{{ route('pengawasan-tindakan.detail', ['id' => $data->tindakan->id]) }}"
                                               class="text-primary text-decoration-none">
                                                <div>
                                                    @if ($data->tindakan->tindak_lanjut)
                                                        <strong>{{ $data->tindakan->tindak_lanjut }}</strong><br>
                                                    @endif
                                                    @if ($data->tindakan->rekap)
                                                        @if ($data->tindakan->rekap->judul_rekap)
                                                            <small class="text-muted">Rekap: {{ $data->tindakan->rekap->judul_rekap }}</small><br>
                                                        @endif
                                                    @endif
                                                </div>
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">PIC Tindakan Lanjutan</th>
                                    <td>
                                        @if ($data->pic)
                                            {{ $data->pic->name }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Arah Tindak Lanjut</th>
                                    <td>{{ $data->arahan_tindak_lanjut ?: '-' }}</td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Aktif</th>
                                    <td>
                                        @if ($data->is_active)
                                            <span class="badge rounded-pill bg-success"> Yes </span>
                                        @else
                                            <span class="badge rounded-pill bg-danger"> No </span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="col" class="bg-dark text-white">Attachments</th>
                                    <td>
                                        @if ($data->attachments && $data->attachments->count() > 0)
                                            <ul class="list-unstyled mb-0">
                                                @foreach ($data->attachments as $attachment)
                                                    <li>
                                                        <a href="{{ asset($attachment->file_path) }}" target="_blank" class="text-primary">
                                                            <i class='bx bx-file'></i> {{ $attachment->file_name }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    </div>

                </div>
            </div>

            {{-- CHAT BUBBLE FOR TINDAKAN LANJUTAN DETAILS --}}
            @if($tindakanLanjutanDetails && $tindakanLanjutanDetails->count() > 0)
            <div class="row m-2">
                <div class="col-12">
                    <h4 class="card-header">Detail Tindakan Lanjutan</h4>
                    <div class="chat-container" style="max-height: 600px; overflow-y: auto; padding: 20px;">
                        @foreach($tindakanLanjutanDetails as $index => $detail)
                        @php
                            $currentUserId = auth()->id();
                            $isCurrentUser = $detail->user_id === $currentUserId;
                            $userName = $detail->user ? $detail->user->name : 'Unknown User';
                            $messageTime = $detail->created_at ? date('d/m/Y H:i', strtotime($detail->created_at)) : '';
                            $attachments = $detail->getAttachments();
                        @endphp
                        <div class="chat-message {{ $isCurrentUser ? 'chat-message-current-user' : 'chat-message-other-user' }} mb-3">
                            <div class="d-flex align-items-start {{ $isCurrentUser ? 'justify-content-end' : '' }}">
                                @if(!$isCurrentUser)
                                <div class="chat-avatar me-3">
                                    <div class="avatar avatar-xs">
                                        <span class="avatar-initial bg-label-info rounded-circle">
                                            {{ strtoupper(substr($userName, 0, 1)) }}
                                        </span>
                                    </div>
                                </div>
                                @endif
                                <div class="chat-bubble flex-grow-1">
                                    @if(!$isCurrentUser)
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <span class="chat-user-name fw-semibold">{{ $userName }}</span>
                                        <small class="chat-time text-muted">{{ $messageTime }}</small>
                                    </div>
                                    @endif
                                    <div class="chat-message-content">
                                        @if($isCurrentUser)
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <small class="chat-time text-muted">{{ $messageTime }}</small>
                                        </div>
                                        @endif
                                        <p class="mb-2">{{ $detail->message ?: '-' }}</p>

                                        @if(!empty($attachments))
                                        <div class="chat-attachments">
                                            @foreach($attachments as $attachment)
                                            <div class="attachment-item mb-1">
                                                <a href="{{ $attachment['url'] }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                    <i class="bx bx-paperclip me-1"></i>
                                                    {{ $attachment['name'] }}
                                                </a>
                                            </div>
                                            @endforeach
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                @if($isCurrentUser)
                                <div class="chat-avatar ms-3">
                                    <div class="avatar avatar-xs">
                                        <span class="avatar-initial bg-label-primary rounded-circle">
                                            {{ strtoupper(substr($userName, 0, 1)) }}
                                        </span>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @else
            <div class="row m-2">
                <div class="col-12">
                    <div class="alert alert-info">
                        <i class="bx bx-info-circle me-2"></i>
                        Belum ada detail tindakan lanjutan untuk tindakan ini.
                    </div>
                </div>
            </div>
            @endif

            @if (config('constant.CRUD.DISPLAY_TIMESTAMPS'))
                @include('components.crud-timestamps', $data)
            @endif



            {{-- ROW FOR ADDITIONAL FUNCTIONALITY BUTTON --}}
            <div class="m-4">
                <a onclick="goBack()" class="btn btn-outline-secondary me-2"><i
                        class="tf-icons bx bx-left-arrow-alt me-2"></i>Back</a>
                <a class="btn btn-primary me-2" href="{{ route('pengawasan-tindakan-lanjutan.edit', ['id' => $data->id]) }}"
                    title="update this pengawasan tindakan lanjutan">
                    <i class='tf-icons bx bx-pencil me-2'></i>Edit</a>
                <a class="btn btn-danger me-2" href="{{ route('pengawasan-tindakan-lanjutan.delete', ['id' => $data->id]) }}"
                    title="delete pengawasan tindakan lanjutan">
                    <i class='tf-icons bx bx-trash me-2'></i>Delete</a>
            </div>

        </div>
    </div>

@endsection

@section('footer-code')

     <style>
         .table td {
             word-wrap: break-word;
             word-break: break-word;
             white-space: normal;
             vertical-align: top;
         }

         .table th {
             word-wrap: break-word;
             word-break: break-word;
             white-space: normal;
             vertical-align: top;
         }

         /* Ensure long URLs and text in links wrap properly */
         .table td a {
             word-break: break-all;
         }

         /* Chat bubble styles */
         .chat-container {
             background-color: #f8f9fa;
             border-radius: 10px;
             padding: 20px;
         }

         .chat-message {
             margin-bottom: 20px;
         }

         .chat-message-other-user {
             text-align: left;
         }

         .chat-message-current-user {
             text-align: right;
         }

         .chat-avatar {
             flex-shrink: 0;
         }

         .avatar-initial {
             width: 36px;
             height: 36px;
             display: flex;
             align-items: center;
             justify-content: center;
             font-weight: 600;
             font-size: 14px;
             color: white;
         }

         .chat-bubble {
             max-width: 70%;
             padding: 12px 16px;
             border-radius: 18px;
             position: relative;
         }

         .chat-message-other-user .chat-bubble {
             background-color: #fcffce;
             color: #333;
             margin-right: auto;
             border: 2px solid #fcefef;
             border-bottom-left-radius: 4px;
         }

         .chat-message-current-user .chat-bubble {
             background-color: #baf7d6;
             color: rgb(34, 22, 22);
             margin-left: auto;
             border-bottom-right-radius: 4px;
         }

         .chat-user-name {
             font-size: 12px;
             opacity: 0.8;
         }

         .chat-time {
             font-size: 11px;
             opacity: 0.7;
         }

         .chat-message-content p {
             margin: 0;
             line-height: 1.4;
         }

         .chat-attachments {
             margin-top: 8px;
         }

         .attachment-item {
             display: inline-block;
         }

         .chat-attachments .btn {
             font-size: 12px;
             padding: 4px 8px;
             border-radius: 12px;
         }

         /* Responsive adjustments */
         @media (max-width: 768px) {
             .chat-bubble {
                 max-width: 85%;
             }

             .chat-message-other-user,
             .chat-message-current-user {
                 text-align: left;
             }

             .chat-message-other-user .chat-bubble,
             .chat-message-current-user .chat-bubble {
                 margin: 0;
             }
         }
     </style>

     <script>
         function goBack() {
             window.history.back();
         }
     </script>

@endsection
