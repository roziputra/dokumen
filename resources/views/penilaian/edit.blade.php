@extends('layouts.adminlte')

@section('title', 'Edit Penilaian')

@section('content_header')
    <h1 class="m-0 text-dark">Edit Penilaian</h1>
@stop

@section('content_body')
    <div class="row">
        <div class="col-12">
            <div class="card">
            <form method="POST" action="{{ route('penilaian.update', $penilaian->id) }}" autocomplete="off">
            @csrf
            @method('PUT')
            <div class="card-body">
                @include('form.input', ['name' => 'nama_unit_kerja', 'label' => 'Nama Unit Kerja', 'value' => $penilaian->nama_unit_kerja])
                @include('form.input', ['name' => 'petugas_pendampingan', 'label' => 'Petugas Pendampingan', 'value' => $penilaian->petugas_pendampingan])
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-md btn-primary">Submit</button>
                <a href="{{ route('penilaian.index') }}" class="btn btn-md btn-default">Batal</a>
            </div>
            </form>
            </div>
        </div>
    </div>
@stop