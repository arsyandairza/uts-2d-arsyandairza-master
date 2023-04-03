@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Table</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Components</a></div>
                <div class="breadcrumb-item">Table</div>
            </div>
        </div>
        <div class="section-body">
            <h2 class="section-title">Edit Mahasiswa</h2>

            <div class="card">
                <div class="card-header">
                    <h4>Validasi Edit Mahasiswa</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('mahasiswa.update', $mahasiswa) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label for="nama">Your Name</label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama"
                                name="nama" value="{{ old('nama', $mahasiswa->nama) }}">
                            @error('nama')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group ">
                            <label for="nim">Nim</label>
                            <input id="nim" name="nim" type="text"
                                class="form-control @error('nim') is-invalid @enderror"
                                value="{{ old('nim', $mahasiswa->nim) }}">
                            @error('nim')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group ">
                            <label for="email">Email</label>
                            <input id="email" name="email" type="text"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email', $mahasiswa->email) }}">
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group ">
                            <label for="jurusan">Jurusan</label>
                            <input id="jurusan" name="jurusan" type="text"
                                class="form-control @error('jurusan') is-invalid @enderror"
                                value={{ old('jurusan', $mahasiswa->jurusan) }}>
                            @error('jurusan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group ">
                            <label for="nomor_handphone">Nomor Handphone </label>
                            <input id="nomor_handphone" name="nomor_handphone" type="text"
                                class="form-control @error('nomor_handphone') is-invalid @enderror"
                                value="{{ old('nomor_handphone', $mahasiswa->nomor_handphone) }}">
                            @error('nomor_handphone')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group ">
                            <label for="alamat">Alamat</label>
                            <input id="alamat" name="alamat" type="text"
                                class="form-control @error('alamat') is-invalid @enderror"
                                value="{{ old('alamat', $mahasiswa->alamat) }}">
                            @error('alamat')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                </div>
                <div class="card-footer text-right">
                    <button class="btn btn-primary">Submit</button>
                    <a class="btn btn-secondary" href="{{ route('mahasiswa.index') }}">Cancel</a>
                </div>
                </form>
            </div>
        </div>
    </section>
@endsection
