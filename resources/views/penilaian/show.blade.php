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
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <table id="table-role" class="table table-sm table-condensed table-hover">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
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
                                    @php $currentGrup = $row->grup_penilaian; @endphp
                                    <tr>
                                        <td colspan="5" class="bg-primary text-dark" style="opacity: 0.9;"> {{ $grup[$row->grup_penilaian] }}</td>
                                    </tr>
                                @endif
                                @if (($row->grup_penilaian !== $currentGrup) || ($row->sub_grup_penilaian !== $currentSubGrup))
                                    @php $currentSubGrup = $row->sub_grup_penilaian; @endphp
                                    <tr>
                                        <td colspan="5" class="bg-danger text-dark" style="opacity: 0.9;"> {{ $subgrup[$row->sub_grup_penilaian]['judul'] }}</td>
                                    </tr>
                                @endif
                                <tr>
                                    <td> {{ $loop->iteration }} </td>
                                    <td> {{ $row->judul_penilaian }} </td>
                                    <td> {{ $row->kelengkapan }} </td>
                                    <td> {{ $row->tingkat_kelengkapan }} </td>
                                    <td>
                                        <!-- @can(App\Models\Role::PERMISSION_SHOW_PENILAIAN)<a href="{{ route('penilaian.show', $row->id) }}" class="btn btn-sm btn-primary" title="Lihat Penilaian"><i class="far fa-eye"></i></a>@endcan -->
                                        <!-- @can(App\Models\Role::PERMISSION_EDIT_PENILAIAN)<a href="{{ route('penilaian.item.edit', [ 'penilaian' => $row->satker_penilaian_id, 'item' => $row->id ]) }}" data-id="{{ $row->id }}" data-judul="{{ $row->judul_penilaian }}" data-kelengkapan="{{ $row->kelengkapan }}" class="btn btn-sm btn-success" title="Edit Penilaian"><i class="far fa-edit"></i></a>@endcan -->
                                        <!-- @can(App\Models\Role::PERMISSION_EDIT_PENILAIAN)<button type="button" href="{{ route('penilaian.item.edit', [ 'penilaian' => $row->satker_penilaian_id, 'item' => $row->id ]) }}" data-id="{{ $row->id }}" data-judul="{{ $row->judul_penilaian }}" data-kelengkapan="{{ $row->kelengkapan }}" class="btn btn-sm btn-success" title="Edit Penilaian"><i class="far fa-edit"></i></button>@endcan -->
                                        @can(App\Models\Role::PERMISSION_EDIT_ITEM_PENILAIAN)<button type="button" data-id="{{ $row->id }}" data-kelengkapan="{{ $row->kelengkapan }}" data-tingkat="{{ $row->tingkat_kelengkapan }}" class="btn btn-sm btn-warning" title="Edit Status" data-toggle="modal" data-target="#modal-status"><i class="fa fa-check"></i></button>@endcan
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
                <form method="POST" action="{{ route('penilaian.status.update', ['penilaian' => ':penilaian', 'item' => ':item']) }}" autocomplete="off">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h4 class="modal-title">Update Status</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @include('form.select', ['name' => 'kelengkapan', 'label' => 'Kelengkapan', 'options' => $kelengkapan, 'type' => 'array'])
                    @include('form.select', ['name' => 'tingkat_kelengkapan', 'label' => 'Tingkat Kelengkapan', 'options' => $tingkat, 'type' => 'array'])
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
@stop
@section('js')
    <script type="text/javascript">
        $(function () {
            $('#modal-item').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget) // Button that triggered the modal
                var form = button.data('form');
                var modal = $(this);

                if (form !== 'add-item') {
                    modal.find('.modal-body input').val('');
                    modal.find('.modal-body select').val('');

                    var urlAction = '{{'
                    var grup_penilaian = button.data('group_penilaian') // Extract info from data-* attributes
                    var sub_grup_penilaian = button.data('sub_group_penilaian');
                    var judul = button.data('judul');

                    modal.find('.modal-title').text('Edit Item Penilaian');
                    modal.find('.modal-body input#grup_penilaian').val(grup_penilaian);
                    modal.find('.modal-body input#sub_grup_penilaian').val(sub_grup_penilaian);
                    modal.find('.modal-body input#judul').val(judul);
                }

            })
        });
    </script>
@stop