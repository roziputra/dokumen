@extends('layouts.adminlte')

@section('title', 'Edit User')

@section('content_header')
    <h1 class="m-0 text-dark">Edit User</h1>
@stop

@section('content_body')
    <div class="row">
        <div class="col-12">
            <div class="card">
            <form method="POST" action="{{ route('user.update', $user->id) }}" autocomplete="off">
            @csrf
            @method('PUT')
            <div class="card-body">
                @include('form.input', ['name' => 'name', 'label' => 'Nama Lengkap', 'value' => $user->name])
                @include('form.input', ['name' => 'email', 'label' => 'Email', 'value' => $user->email])
                @include('form.select', ['name' => 'type', 'label' => 'User Type', 'options' => $types, 'value' => $user->type, 'type' => 'array'])
                @include('form.input', ['name' => 'password', 'label' => 'Password', 'type' => 'password'])
                @include('form.input', ['name' => 'password_confirmation', 'label' => 'Confirm Password', 'type' => 'password'])
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-md btn-primary">Submit</button>
                <a href="{{ route('user.index') }}" class="btn btn-md btn-default">Batal</a>
            </div>
            </form>
            </div>
        </div>
    </div>
@stop