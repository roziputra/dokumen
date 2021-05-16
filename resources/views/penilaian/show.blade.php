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
                    <dl class="row">
                        <dd class="col-sm-4">Nama Unit Kerja</dd>
                        <dd class="col-sm-8">: {{ $penilaian->nama_unit_kerja }}</dd>
                        <dd class="col-sm-4">Petugas Pendampingan</dd>
                        <dd class="col-sm-8">: {{ $penilaian->petugas_pendampingan }}</dd>
                    </dl>
                    <!-- @can(App\Models\Role::PERMISSION_ADD_ITEM_PENILAIAN)
                    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-form="add-item" data-target="#modal-item">
                        Tambah Item Penilaian
                    </button>
                    @endcan -->
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
                    <table id="table-role" class="table table-sm table-hover table-bordered">
                        <thead>
                            <tr>
                                <th class="align-middle" colspan="2" style="width: 40px">#</th>
                                <th class="align-middle">Data Dukung Calon ZI</th>
                                <th class="align-middle">Kelengkapan</th>
                                <th class="align-middle">Tingkat Kelengkapan</th>
                                <!-- <th class="text-center" style="width: 100px">Action</th> -->
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
                                    @if ($grup[$row->grup_penilaian] !== "")
                                    <tr>
                                        <td colspan="5" style="background-color:rgba(0, 123, 255, 0.3);">
                                            <span class="text-dark">{{ $grup[$row->grup_penilaian] }} &nbsp;</span>
                                        </td>
                                    </tr>
                                    @else
                                    <tr>
                                        <td colspan="5" style="background-color:rgba(0, 123, 255, 0.9);">
                                            <span class="text-dark">&nbsp;</span>
                                        </td>
                                    </tr>
                                    @endif
                                @endif
                                @if (($row->grup_penilaian !== $currentGrup) || ($row->sub_grup_penilaian !== $currentSubGrup))
                                    @php
                                        $currentSubGrup = $row->sub_grup_penilaian;
                                        $subUrut = 0;
                                    @endphp
                                    @if ($grup[$row->grup_penilaian] !== "")
                                    <tr>
                                        <td class="text-right" style="width: 40px; background-color:rgba(232, 62, 140, 0.2);">
                                            <span class="text-dark">{{ ++$urut }}</span>
                                        </td>
                                        <td colspan="4" style="background-color:rgba(232, 62, 140, 0.2);">
                                            <span class="text-dark">{{ $subgrup[$row->sub_grup_penilaian] }}</span>
                                        </td>
                                    </tr>
                                    @else
                                    <tr>
                                        <td colspan="5" style="background-color:rgba(0, 123, 255, 0.3);">
                                            <span class="text-dark">{{ $subgrup[$row->sub_grup_penilaian] }}</span>
                                        </td>
                                    </tr>
                                    @endif
                                @endif
                                @if ($grup[$row->grup_penilaian] !== "")
                                <tr>
                                    <td></td>
                                    <td class="text-right" style="width: 40px;"> {{ range('a', 'z')[$subUrut++] }}. </td>
                                    <td> {{ $row->item_penilaian_judul }} </td>
                                    <td> {{ $row->kelengkapan }} @can(App\Models\Role::PERMISSION_EDIT_ITEM_PENILAIAN)<button type="button" data-item="{{ $row->id }}" data-kelengkapan="{{ $row->kelengkapan }}" data-judul="{{ $row->item_penilaian_judul }}" class="btn btn-sm btn-link float-right" title="Edit Kelengkapan" data-toggle="modal" data-target="#modal-kelengkapan"><i class="fa fa-edit"></i></button>@endcan</td>
                                    <td> {{ $row->tingkat_kelengkapan }} @can(App\Models\Role::PERMISSION_EDIT_ITEM_PENILAIAN)<button type="button" data-item="{{ $row->id }}" data-tingkat="{{ $row->tingkat_kelengkapan }}" data-judul="{{ $row->item_penilaian_judul }}" class="btn btn-sm btn-link float-right" title="Edit Tingkat Kelengkapan" data-toggle="modal" data-target="#modal-tingkat"><i class="fa fa-edit"></i></button>@endcan</td>
                                    <!-- <td> -->
                                        <!-- @can(App\Models\Role::PERMISSION_SHOW_PENILAIAN)<a href="{{ route('penilaian.show', $row->id) }}" class="btn btn-sm btn-primary" title="Lihat Penilaian"><i class="far fa-eye"></i></a>@endcan -->
                                        <!-- @can(App\Models\Role::PERMISSION_EDIT_PENILAIAN)<a href="{{ route('penilaian.item.edit', [ 'penilaian' => $row->satker_penilaian_id, 'item' => $row->id ]) }}" data-id="{{ $row->id }}" data-judul="{{ $row->judul_penilaian }}" data-kelengkapan="{{ $row->kelengkapan }}" class="btn btn-sm btn-success" title="Edit Penilaian"><i class="far fa-edit"></i></a>@endcan -->
                                        <!-- @can(App\Models\Role::PERMISSION_EDIT_PENILAIAN)<button type="button" href="{{ route('penilaian.item.edit', [ 'penilaian' => $row->satker_penilaian_id, 'item' => $row->id ]) }}" data-id="{{ $row->id }}" data-judul="{{ $row->judul_penilaian }}" data-kelengkapan="{{ $row->kelengkapan }}" class="btn btn-sm btn-success" title="Edit Penilaian"><i class="far fa-edit"></i></button>@endcan -->
                                        <!-- @can(App\Models\Role::PERMISSION_DELETE_ITEM_PENILAIAN)
                                        <form class="d-inline-block" action="{{ route('penilaian.item.destroy', [$row->satker_penilaian_id, $row->id]) }}" method="POST"> @csrf @method('DELETE')
                                        <button type="submit" onClick="return confirm('Apakah yakin dihapus ?')" class="btn btn-sm btn-danger" title="Delete Item Penilaian"><i class="far fa-fw fa-trash-alt"></i></button>
                                        </form>
                                        @endcan -->
                                    <!-- </td> -->
                                </tr>
                                @else
                                <tr>
                                    <td class="text-right" style="width: 40px;"> {{ ++$subUrut }}. </td>
                                    <td></td>
                                    <td> {{ $row->item_penilaian_judul }} </td>
                                    <td> {{ $row->kelengkapan }} @can(App\Models\Role::PERMISSION_EDIT_ITEM_PENILAIAN)<button type="button" data-item="{{ $row->id }}" data-kelengkapan="{{ $row->kelengkapan }}" data-judul="{{ $row->item_penilaian_judul }}" class="btn btn-sm btn-link float-right" title="Edit Kelengkapan" data-toggle="modal" data-target="#modal-kelengkapan"><i class="fa fa-edit"></i></button>@endcan</td>
                                    <td> {{ $row->tingkat_kelengkapan }} @can(App\Models\Role::PERMISSION_EDIT_ITEM_PENILAIAN)<button type="button" data-item="{{ $row->id }}" data-tingkat="{{ $row->tingkat_kelengkapan }}" data-judul="{{ $row->item_penilaian_judul }}" class="btn btn-sm btn-link float-right" title="Edit Tingkat Kelengkapan" data-toggle="modal" data-target="#modal-tingkat"><i class="fa fa-edit"></i></button>@endcan</td>
                                    <!-- <td> -->
                                        <!-- @can(App\Models\Role::PERMISSION_SHOW_PENILAIAN)<a href="{{ route('penilaian.show', $row->id) }}" class="btn btn-sm btn-primary" title="Lihat Penilaian"><i class="far fa-eye"></i></a>@endcan -->
                                        <!-- @can(App\Models\Role::PERMISSION_EDIT_PENILAIAN)<a href="{{ route('penilaian.item.edit', [ 'penilaian' => $row->satker_penilaian_id, 'item' => $row->id ]) }}" data-id="{{ $row->id }}" data-judul="{{ $row->judul_penilaian }}" data-kelengkapan="{{ $row->kelengkapan }}" class="btn btn-sm btn-success" title="Edit Penilaian"><i class="far fa-edit"></i></a>@endcan -->
                                        <!-- @can(App\Models\Role::PERMISSION_EDIT_PENILAIAN)<button type="button" href="{{ route('penilaian.item.edit', [ 'penilaian' => $row->satker_penilaian_id, 'item' => $row->id ]) }}" data-id="{{ $row->id }}" data-judul="{{ $row->judul_penilaian }}" data-kelengkapan="{{ $row->kelengkapan }}" class="btn btn-sm btn-success" title="Edit Penilaian"><i class="far fa-edit"></i></button>@endcan -->
                                        <!-- @can(App\Models\Role::PERMISSION_DELETE_ITEM_PENILAIAN)
                                        <form class="d-inline-block" action="{{ route('penilaian.item.destroy', [$row->satker_penilaian_id, $row->id]) }}" method="POST"> @csrf @method('DELETE')
                                        <button type="submit" onClick="return confirm('Apakah yakin dihapus ?')" class="btn btn-sm btn-danger" title="Delete Item Penilaian"><i class="far fa-fw fa-trash-alt"></i></button>
                                        </form>
                                        @endcan -->
                                    <!-- </td> -->
                                </tr>
                                @endif
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
                    @include('form.select', ['name' => 'sub_grup_penilaian', 'label' => 'Sub Grup Penilaian', 'options' => $subgrup, 'type' => 'array'])
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
    <div class="modal fade" id="modal-kelengkapan">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" autocomplete="off">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h4 class="modal-title">Update Kelengkapan</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="callout callout-danger">
                            <span class="judul"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                          <input id="radio1" class="form-check-input" type="radio" value="{{ $kelengkapan[0] }}" name="kelengkapan">
                          <label for="radio1" class="form-check-label">{{ $kelengkapan[0] }}</label>
                        </div>
                        <div class="form-check">
                          <input id="radio2" class="form-check-input" type="radio" value="{{ $kelengkapan[1] }}" name="kelengkapan" checked="">
                          <label for="radio2" class="form-check-label">{{ $kelengkapan[1] }}</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Ok</button>
                </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
    <div class="modal fade" id="modal-tingkat">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" autocomplete="off">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h4 class="modal-title">Update Tingkat Kelengkapan</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <span class="judul"></span>
                    </div>
                    <div class="form-group">
                        <label for="status_tingkat">Tingkat Kelengkapan</label>
                        <select id="status_tingkat" class="@error('tingkat_kelengkapan') is-invalid @enderror form-control select2" name="tingkat_kelengkapan" style="width: 100%;">
                            <option value="">Pilih Tingkat Kelengkapan</option>
                            @foreach ($tingkat as $index => $option)
                                <option value="{{ $option }}"> {{ $option }}</option>
                            @endforeach
                        </select>
                        @error('tingkat_kelengkapan')
                        <span class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Ok</button>
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
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Ok</button>
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
            $('[data-toggle="popover"]').popover();
            $('#modal-kelengkapan').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget) // Button that triggered the modal

                var modal = $(this);

                var kelengkapan_ada = '{{ $kelengkapan[0] }}';
                var kelengkapan_tidak_ada = '{{ $kelengkapan[1] }}';
                var kelengkapan = button.data('kelengkapan');
                var judul = button.data('judul');

                var item = button.data('item');

                var urlAction = '{{ route('penilaian.kelengkapan.update', ['penilaian' => $penilaian->id, 'item' => ':id']) }}';
                urlAction = urlAction.replace(':id', item);

                var form = modal.find('.modal-content form');

                form.attr('action', urlAction);
                modal.find('.modal-body span.judul').text(judul);
                modal.find('.modal-body input#radio1').prop('checked', function() {
                    return kelengkapan_ada == kelengkapan;
                });
                modal.find('.modal-body input#radio2').prop('checked', function() {
                    return kelengkapan_tidak_ada == kelengkapan;
                });
            })
            $('#modal-tingkat').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget) // Button that triggered the modal

                var modal = $(this);
                modal.find('.modal-body input').val('');
                modal.find('.modal-body select').val('');

                var tingkat = button.data('tingkat');
                var judul = button.data('judul');

                var item = button.data('item');

                var urlAction = '{{ route('penilaian.tingkat.update', ['penilaian' => $penilaian->id, 'item' => ':id']) }}';
                urlAction = urlAction.replace(':id', item);

                var form = modal.find('.modal-content form');

                form.attr('action', urlAction);
                modal.find('.modal-body span.judul').text(judul);
                modal.find('.modal-body select#status_tingkat').val(tingkat);
            })
        });
    </script>
@stop