@extends('layouts.adminlte')

@section('title', 'Penilaian')

@section('content_header')
    <h1 class="m-0 text-dark">Penilaian</h1>
@stop

@section('content_body')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    @can(App\Models\Role::PERMISSION_CREATE_PENILAIAN)
                    <a href="{{ route('penilaian.create') }}" class="btn btn-sm btn-primary">Buat Penilaian</a>
                    @endcan
                </div>
                <div class="card-body">
                    <table id="table-role" class="table table-condensed table-hover table-striped">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Nama Unit Kerja</th>
                                <th>Petugas Pendampingan</th>
                                <th style="width: 200px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($penilaian as $row)
                            <tr>
                            <td> {{ $loop->iteration }} </td>
                            <td> {{ $row->nama_unit_kerja }} </td>
                            <td> {{ $row->petugas_pendampingan }} </td>
                            <td>
                                @can(App\Models\Role::PERMISSION_SHOW_PENILAIAN)<a href="{{ route('penilaian.show', $row->id) }}" class="btn btn-sm btn-primary" title="Lihat Penilaian"><i class="far fa-eye"></i></a>@endcan
                                @can(App\Models\Role::PERMISSION_EDIT_PENILAIAN)<a href="{{ route('penilaian.edit', $row->id) }}" class="btn btn-sm btn-success" title="Edit Penilaian"><i class="far fa-edit"></i></a>@endcan
                                @can(App\Models\Role::PERMISSION_DELETE_PENILAIAN)
                                <form class="d-inline-block" action="{{ route('penilaian.destroy', $row->id) }}" method="POST"> @csrf @method('DELETE')
                                <button type="submit" onClick="return confirm('Apakah yakin dihapus ?')" class="btn btn-sm btn-danger" title="Delete Penilaian"><i class="far fa-fw fa-trash-alt"></i></button>
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
@stop
