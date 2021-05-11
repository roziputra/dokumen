@extends('layouts.adminlte')

@section('title', 'Buat Penilaian')

@section('content_header')
    <h1 class="m-0 text-dark">Buat Penilaian</h1>
@stop

@section('content_body')
    <div class="row">
        <div class="col-12">
            <div class="card">
            <form method="POST" action="{{ route('penilaian.store') }}" autocomplete="off">
            @csrf
            <div class="card-body">
                @include('form.input', ['name' => 'nama_unit_kerja', 'label' => 'Nama Unit Kerja'])
                @include('form.input', ['name' => 'petugas_pendampingan', 'label' => 'Petugas Pendampingan'])
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