@extends('layouts.adminlte')

@section('title', 'User')

@section('content_header')
    <h1 class="m-0 text-dark">User</h1>
@stop

@section('content_body')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    @can(App\Models\Role::PERMISSION_CREATE_USER)
                    <a href="{{ route('user.create') }}" class="btn btn-sm btn-primary">Buat User</a>
                    @endcan
                </div>
                <div class="card-body">
                    <table id="table-role" class="table table-condensed table-hover table-striped">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Nama</th>
                                <th>Username</th>
                                <th style="width: 120px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($user as $row)
                            <tr>
                            <td> {{ $loop->iteration }} </td>
                            <td> {{ $row->name }} </td>
                            <td> {{ $row->email }} </td>
                            <td>
                                @can(App\Models\Role::PERMISSION_EDIT_USER)<a href="{{ route('user.edit', $row->id) }}" class="btn btn-sm btn-success" title="Edit User"><i class="far fa-edit"></i></a>@endcan
                                @can(App\Models\Role::PERMISSION_DELETE_USER)
                                <form class="d-inline-block" action="{{ route('user.destroy', $row->id) }}" method="POST"> @csrf @method('DELETE')
                                <button type="submit" onClick="return confirm('Apakah yakin dihapus ?')" class="btn btn-sm btn-danger" title="Delete User"><i class="far fa-fw fa-trash-alt"></i></button>
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
