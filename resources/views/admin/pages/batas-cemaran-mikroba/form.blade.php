@extends('admin.template-base', ['searchNavbar' => false])

@section('page-title', 'Batas Cemaran Mikroba')

@section('main-content')

<div class="container-xxl flex-grow-1 container-p-y">

    @include('admin.components.breadcrumb.simple', $breadcrumb)

    <x-alert></x-alert>

    <div class="card">
        <div class="card-body">
            <form id="form-batas-cemaran-mikroba" method="POST" action="{{ $mode == 'add'? route('admin.batas-cemaran-mikroba.store') : ($mode == 'edit' ? route('admin.batas-cemaran-mikroba.update', ['id' => $data->id]) : '/')}}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="mb-3 col-12">
                      <label for="jenis_pangan" class="form-label">Jenis Pangan</label>
                      <select
                        class="form-control"
                        type="text"
                        id="jenis_pangan"
                        name="jenis_pangan"
                        {{ $mode == 'view' ? 'readonly' : '' }}
                      >
                        <option value="">-- Select Jenis Pangan --</option>
                        @foreach ($jenisPangans as $jenisPangan)
                            <option value="{{ $jenisPangan->id }}" {{ (old('jenis_pangan', $data->jenis_pangan_id) == $jenisPangan->id) ? 'selected' : '' }}>
                                {{ $jenisPangan->nama_jenis_pangan }}
                            </option>
                        @endforeach
                      </select>
                    </div>

                    <div class="mb-3 col-12">
                      <label for="cemaran_mikroba" class="form-label">Cemaran Mikroba</label>
                      <select
                        class="form-control"
                        type="text"
                        id="cemaran_mikroba"
                        name="cemaran_mikroba"
                        {{ $mode == 'view' ? 'readonly' : '' }}
                      >
                        <option value="">-- Select Cemaran Mikroba --</option>
                        @foreach ($cemaranMikrobas as $cm)
                            <option value="{{ $cm->id }}" {{ (old('cemaran_mikroba', $data->cemaran_mikroba_id) == $cm->id) ? 'selected' : '' }}>
                                {{ $cm->nama_cemaran_mikroba }}
                            </option>
                        @endforeach
                      </select>
                    </div>

                    <div class="mb-3 col-12">
                      <label for="value_min" class="form-label">Minimum Value</label>
                      <input
                        class="form-control"
                        type="number"
                        id="value_min"
                        name="value_min"
                        placeholder="Minimum Value"
                        value="{{old('value_min', $data->value_min)}}"
                        step="any"
                        {{ $mode == 'view' ? 'readonly' : '' }}
                      />
                    </div>

                    <div class="mb-3 col-12">
                      <label for="value_max" class="form-label">Maximum Value</label>
                      <input
                        class="form-control"
                        type="number"
                        id="value_max"
                        name="value_max"
                        placeholder="Maximum Value"
                        value="{{old('value_max', $data->value_max)}}"
                        step="any"
                        {{ $mode == 'view' ? 'readonly' : '' }}
                      />
                    </div>

                    <div class="mb-3 col-12">
                      <label for="satuan" class="form-label">Satuan</label>
                      <input
                        class="form-control"
                        type="text"
                        id="satuan"
                        name="satuan"
                        placeholder="Satuan"
                        value="{{old('satuan', $data->satuan)}}"
                        {{ $mode == 'view' ? 'readonly' : '' }}
                      />
                    </div>

                    <div class="mb-3 col-12">
                      <label for="metode" class="form-label">Metode</label>
                      <input
                        class="form-control"
                        type="text"
                        id="metode"
                        name="metode"
                        placeholder="Metode"
                        value="{{old('metode', $data->metode)}}"
                        {{ $mode == 'view' ? 'readonly' : '' }}
                      />
                    </div>

                    <div class="mb-3 col-12">
                      <label for="keterangan" class="form-label">Keterangan</label>
                      <textarea
                        class="form-control"
                        id="keterangan"
                        name="keterangan"
                        rows="3"
                        {{ $mode == 'view' ? 'readonly' : '' }}
                      >{{old('keterangan', $data->keterangan)}}</textarea>
                    </div>

                    @if ($mode != 'view')
                    <div class="mb-3 col-12">
                        <label class="form-label" for="is_active">Is Active</label>
                        <div class="form-check">
                          <input name="is_active" class="form-check-input" type="radio" value="1" id="is_active_1" {{old('is_active', $data->is_active) == 1 ? "checked" : ""}}>
                          <label class="form-check-label" for="is_active_1">
                            Active
                          </label>
                        </div>
                        <div class="form-check">
                          <input name="is_active" class="form-check-input" type="radio" value="0" id="is_active_2" {{old('is_active', $data->is_active) == 0 ? "checked" : ""}}>
                          <label class="form-check-label" for="is_active_2">
                            In Active
                          </label>
                        </div>
                    </div>
                    @endif

                    @if ($mode == 'view')
                    <div class="mb-3 col-12">
                      <label for="is_active" class="form-label">Is Active</label>
                      <input
                        class="form-control"
                        type="text"
                        id="is_active"
                        name="is_active"
                        placeholder="Is Active"
                        value="{{$data->is_active == 1 ? 'Active' : 'Inactive'}}"
                        readonly
                      />
                    </div>
                    @endif>
                </div>

                <div class="">
                    <a href="{{route('admin.batas-cemaran-mikroba.index')}}" class="btn btn-outline-secondary me-2"><i class="tf-icons bx bx-left-arrow-alt me-2"></i>Back</a>
                    @if ($mode != 'view')
                    <button type="submit" class="btn btn-primary me-2"><i class="tf-icons bx bx-save me-2"></i>Save</button>
                    @endif
                    @if ($mode == 'view')
                    <a class="btn btn-primary me-2" href="{{ route('admin.batas-cemaran-mikroba.edit', ['id' => $data->id]) }}" title="update"><i class='tf-icons bx bx-pencil me-2'></i>Edit</a>
                    <a class="btn btn-danger me-2" href="{{ route('admin.batas-cemaran-mikroba.delete', ['id' => $data->id]) }}" title="delete"><i class='tf-icons bx bx-trash me-2'></i>Delete</a>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
<script src="{{ asset('assets/js/sambel/form-batas-cemaran-mikroba.js') }}"></script>
@endsection
