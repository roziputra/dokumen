@extends('layouts.adminlte')

@section('title', 'User Profile')

@section('content_header')
    <h1 class="m-0 text-dark">Profile</h1>
@stop

@section('content_body')
    <div class="row">
        <div class="col-12">
            <div class="card card-primary">
            <form method="POST" action="{{ route('profile.update') }}" autocomplete="off">
            @csrf
            @method('PUT')
                <div class="card-header">
                    <h3 class="card-title">About Me</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <strong><i class="fas fa-user mr-1"></i> Tipe User : </strong>
                    <span class="text-muted text-capitalize">{{ $user->type }}</span>
                    <hr>
                    @include('form.input', ['name' => 'name', 'label' => 'Nama Lengkap', 'value' => $user['name']])
                    @include('form.input', ['name' => 'email', 'label' => 'Email', 'value' => $user['email']])
                </div>
                <!-- /.card-body -->
                <div class="card-footer d-flex justify-content-end">
                    <button type="submit" class="btn btn-md btn-primary"><i class="fas fa-fw fa-save"></i> Simpan</button>
                </div>
            </form>
            </div>

            <div class="card card-primary">
            <form method="POST" action="{{ route('password.update') }}" autocomplete="off">
            @csrf
            @method('PUT')
                <div class="card-header">
                    <h3 class="card-title">Update Password</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    @include('form.input', ['name' => 'current_password', 'label' => 'Password Saat ini', 'type' => 'password'])
                    @include('form.input', ['name' => 'password', 'label' => 'Password Baru', 'type' => 'password'])
                    @include('form.input', ['name' => 'password_confirmation', 'label' => 'Konfirmasi Password', 'type' => 'password'])
                </div>
                <!-- /.card-body -->
                <div class="card-footer d-flex justify-content-end">
                    <button type="submit" class="btn btn-md btn-primary"><i class="fas fa-fw fa-lock"></i> Save</button>
                </div>
            </form>
            </div>
        </div>
    </div>
@stop
