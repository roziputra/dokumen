@extends('layouts.adminlte')

@section('title', 'Lihat Penilaian')

@section('content_header')
    <h1 class="m-0 text-dark">Penilaian</h1>
@stop

@section('content_body')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    @can(App\Models\Role::PERMISSION_ADD_ITEM_PENILAIAN)
                    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-form="add-item" data-target="#modal-item">
                        Tambah Item Penilaian
                    </button>
                    @endcan
                    @can(App\Models\Role::PERMISSION_ADD_ITEM_PENILAIAN)
                    <!-- <button type="button" class="btn btn-sm btn-success float-right" data-toggle="modal" data-form="add-item" data-target="#modal-item-add"> -->
                        <!-- Tambah Item Penilaian -->
                    <!-- </button> -->
                    @endcan
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="callout callout-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li class="text-danger">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <table id="table-role" class="table table-sm table-condensed table-hover">
                        <thead>
                            <tr>
                                <th colspan="2" style="width: 40px">#</th>
                                <th>Data Dukung Calon ZI</th>
                                <th>Kelengkapan</th>
                                <th>Tingkat Kelengkapan</th>
                                <th style="width: 150px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $currentGrup = null;
                                $currentSubGrup = null;
                            @endphp
                            @foreach ($item as $row)
                                @if ($row->grup_penilaian !== $currentGrup)
                                    @php
                                        $currentGrup = $row->grup_penilaian;
                                        $urut = 0;
                                    @endphp
                                    <tr>
                                        <td colspan="6" class="bg-primary">
                                            <span class="text-dark">{{ $grup[$row->grup_penilaian] }}</span>
                                        </td>
                                    </tr>
                                @endif
                                @if (($row->grup_penilaian !== $currentGrup) || ($row->sub_grup_penilaian !== $currentSubGrup))
                                    @php
                                        $currentSubGrup = $row->sub_grup_penilaian;
                                        $subUrut = 0;
                                    @endphp
                                    <tr>
                                        <td class="bg-pink text-right" style="width: 40px;">
                                            <span class="text-dark">{{ ++$urut }}</span>
                                        </td>
                                        <td colspan="5" class="bg-pink">
                                            <span class="text-dark">{{ $subgrup[$row->sub_grup_penilaian]['judul'] }}</span>
                                        </td>
                                    </tr>
                                @endif
                                <tr>
                                    <td></td>
                                    <td class="text-right" style="width: 40px;"> {{ range('a', 'z')[$subUrut++] }}. </td>
                                    <td> {{ $row->judul_penilaian }} </td>
                                    <td> {{ $row->kelengkapan }} </td>
                                    <td> {{ $row->tingkat_kelengkapan }} </td>
                                    <td>
                                        <!-- @can(App\Models\Role::PERMISSION_SHOW_PENILAIAN)<a href="{{ route('penilaian.show', $row->id) }}" class="btn btn-sm btn-primary" title="Lihat Penilaian"><i class="far fa-eye"></i></a>@endcan -->
                                        <!-- @can(App\Models\Role::PERMISSION_EDIT_PENILAIAN)<a href="{{ route('penilaian.item.edit', [ 'penilaian' => $row->satker_penilaian_id, 'item' => $row->id ]) }}" data-id="{{ $row->id }}" data-judul="{{ $row->judul_penilaian }}" data-kelengkapan="{{ $row->kelengkapan }}" class="btn btn-sm btn-success" title="Edit Penilaian"><i class="far fa-edit"></i></a>@endcan -->
                                        <!-- @can(App\Models\Role::PERMISSION_EDIT_PENILAIAN)<button type="button" href="{{ route('penilaian.item.edit', [ 'penilaian' => $row->satker_penilaian_id, 'item' => $row->id ]) }}" data-id="{{ $row->id }}" data-judul="{{ $row->judul_penilaian }}" data-kelengkapan="{{ $row->kelengkapan }}" class="btn btn-sm btn-success" title="Edit Penilaian"><i class="far fa-edit"></i></button>@endcan -->
                                        @can(App\Models\Role::PERMISSION_EDIT_ITEM_PENILAIAN)<button type="button" data-item="{{ $row->id }}" data-kelengkapan="{{ $row->kelengkapan }}" data-tingkat="{{ $row->tingkat_kelengkapan }}" class="btn btn-sm btn-warning" title="Edit Status" data-toggle="modal" data-target="#modal-status"><i class="fa fa-check"></i></button>@endcan
                                        @can(App\Models\Role::PERMISSION_DELETE_ITEM_PENILAIAN)
                                        <form class="d-inline-block" action="{{ route('penilaian.item.destroy', [$row->satker_penilaian_id, $row->id]) }}" method="POST"> @csrf @method('DELETE')
                                        <button type="submit" onClick="return confirm('Apakah yakin dihapus ?')" class="btn btn-sm btn-danger" title="Delete Item Penilaian"><i class="far fa-fw fa-trash-alt"></i></button>
                                        </form>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-item">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('penilaian.item.store', $penilaian->id) }}" autocomplete="off">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Item Penilaian</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @include('form.select', ['name' => 'grup_penilaian', 'label' => 'Grup Penilaian', 'options' => $grup, 'type' => 'array'])
                    @include('form.select', ['name' => 'sub_grup_penilaian', 'label' => 'Sub Grup Penilaian', 'options' => $subgrup, 'type' => 'array', 'optionValueColumn' => 'judul', 'optionGroup' => 'grup', 'filterGroup' => 'grup_penilaian'])
                    @include('form.input', ['name' => 'judul_penilaian', 'label' => 'Judul'])
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
    <div class="modal fade" id="modal-status">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" autocomplete="off">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h4 class="modal-title">Update Status</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="status_kelengkapan">Kelengkapan</label>
                        <select id="status_kelengkapan" class="@error('kelengkapan') is-invalid @enderror form-control select2" name="kelengkapan" style="width: 100%;">
                            <option value="">Pilih Status Kelengkapan</option>
                            @foreach ($kelengkapan as $index => $option)
                                @if (!$loop->first || $index !== 0)
                                @if ($index == old('kelengkapan', $value ?? null))
                                <option selected value="{{ $index }}"> {{ $option }}</option>
                                @else
                                <option value="{{ $index }}"> {{ $option }}</option>
                                @endif
                                @endif
                            @endforeach
                        </select>
                        @error('kelengkapan')
                        <span class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="status_tingkat">Tingkat Kelengkapan</label>
                        <select id="status_tingkat" class="@error('tingkat_kelengkapan') is-invalid @enderror form-control select2" name="tingkat_kelengkapan" style="width: 100%;">
                            <option value="">Pilih Tingkat Kelengkapan</option>
                            @foreach ($tingkat as $index => $option)
                                @if (!$loop->first || $index !== 0)
                                @if ($index == old('tingkat_kelengkapan', $value ?? null))
                                <option selected value="{{ $index }}"> {{ $option }}</option>
                                @else
                                <option value="{{ $index }}"> {{ $option }}</option>
                                @endif
                                @endif
                            @endforeach
                        </select>
                        @error('tingkat_kelengkapan')
                        <span class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
    <div class="modal fade" id="modal-item-edit">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('penilaian.item.update', ['penilaian' => $penilaian->id, 'item' => ':id']) }}" autocomplete="off">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h4 class="modal-title">Edit Item Penilaian</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @include('form.input', ['name' => 'judul_penilaian', 'label' => 'Judul'])
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@stop
@section('js')
    <script type="text/javascript">
        $(function () {
            $('#modal-status').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget) // Button that triggered the modal

                var modal = $(this);
                modal.find('.modal-body input').val('');
                modal.find('.modal-body select').val('');

                var kelengkapan = button.data('kelengkapan');
                var tingkat = button.data('tingkat');
                var item = button.data('item');

                var urlAction = '{{ route('penilaian.status.update', ['penilaian' => $penilaian->id, 'item' => ':id']) }}';
                urlAction = urlAction.replace(':id', item);

                var form = modal.find('.modal-content form');

                form.attr('action', urlAction);
                modal.find('.modal-body input#kelengkapan').val(kelengkapan);
                modal.find('.modal-body input#tingkat').val(tingkat);
            })
        });
    </script>
@stop