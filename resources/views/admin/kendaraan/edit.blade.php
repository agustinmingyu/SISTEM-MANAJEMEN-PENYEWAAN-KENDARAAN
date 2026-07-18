@extends('layouts.admin')

@section('title', 'Edit Kendaraan')

@section('content')

<div class="container py-4">

    <div class="card shadow">

        <div class="card-header bg-warning text-dark">
            <h4 class="mb-0">Edit Data Kendaraan</h4>
        </div>

        <div class="card-body">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Terjadi Kesalahan!</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.kendaraan.update', $kendaraan->id) }}" method="POST">

                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Nama Kendaraan</label>

                    <input
                        type="text"
                        name="nama"
                        class="form-control @error('nama') is-invalid @enderror"
                        value="{{ old('nama', $kendaraan->nama) }}"
                        required>

                    @error('nama')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>


                <div class="mb-3">
                    <label class="form-label">Merk</label>

                    <input
                        type="text"
                        name="merk"
                        class="form-control @error('merk') is-invalid @enderror"
                        value="{{ old('merk', $kendaraan->merk) }}"
                        required>

                    @error('merk')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>


                <div class="mb-3">
                    <label class="form-label">Plat Nomor</label>

                    <input
                        type="text"
                        name="plat_nomor"
                        class="form-control @error('plat_nomor') is-invalid @enderror"
                        value="{{ old('plat_nomor', $kendaraan->plat_nomor) }}"
                        required>

                    @error('plat_nomor')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>


                <div class="mb-3">
                    <label class="form-label">Tahun</label>

                    <input
                        type="number"
                        name="tahun"
                        class="form-control @error('tahun') is-invalid @enderror"
                        value="{{ old('tahun', $kendaraan->tahun) }}"
                        required>

                    @error('tahun')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>


                <div class="mb-3">
                    <label class="form-label">Harga Sewa / Hari</label>

                    <input
                        type="number"
                        name="harga_sewa"
                        class="form-control @error('harga_sewa') is-invalid @enderror"
                        value="{{ old('harga_sewa', $kendaraan->harga_sewa) }}"
                        required>

                    @error('harga_sewa')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>


                <div class="mb-4">
                    <label class="form-label">Status</label>

                    <select
                        name="status"
                        class="form-select @error('status') is-invalid @enderror"
                        required>

                        <option value="">-- Pilih Status --</option>

                        <option value="tersedia"
                            {{ old('status', $kendaraan->status) == 'tersedia' ? 'selected' : '' }}>
                            Tersedia
                        </option>

                        <option value="disewa"
                            {{ old('status', $kendaraan->status) == 'disewa' ? 'selected' : '' }}>
                            Disewa
                        </option>

                    </select>

                    @error('status')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>


                <div class="d-flex justify-content-between">

                    <a href="{{ route('admin.kendaraan.index') }}"
                       class="btn btn-secondary">
                        Kembali
                    </a>

                    <button type="submit"
                            class="btn btn-primary">
                        Update Data
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection