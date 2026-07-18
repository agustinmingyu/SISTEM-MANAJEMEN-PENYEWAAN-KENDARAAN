@extends('layouts.admin')

@section('title', 'Detail Kendaraan')

@section('content')

<div class="container py-4">

    <div class="card shadow">

        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Detail Kendaraan</h4>

            <a href="{{ route('admin.kendaraan.index') }}" class="btn btn-light btn-sm">
                ← Kembali
            </a>
        </div>

        <div class="card-body">

            <table class="table table-bordered">

                <tr>
                    <th width="30%">ID Kendaraan</th>
                    <td>{{ $kendaraan->id }}</td>
                </tr>

                <tr>
                    <th>Nama Kendaraan</th>
                    <td>{{ $kendaraan->nama }}</td>
                </tr>

                <tr>
                    <th>Merk</th>
                    <td>{{ $kendaraan->merk }}</td>
                </tr>

                <tr>
                    <th>Plat Nomor</th>
                    <td>{{ $kendaraan->plat_nomor }}</td>
                </tr>

                <tr>
                    <th>Tahun</th>
                    <td>{{ $kendaraan->tahun }}</td>
                </tr>

                <tr>
                    <th>Harga Sewa / Hari</th>
                    <td>
                        Rp {{ number_format($kendaraan->harga_sewa, 0, ',', '.') }}
                    </td>
                </tr>

                <tr>
                    <th>Status</th>
                    <td>

                        @if($kendaraan->status == 'tersedia')

                            <span class="badge bg-success">
                                Tersedia
                            </span>

                        @else

                            <span class="badge bg-danger">
                                Disewa
                            </span>

                        @endif

                    </td>
                </tr>

                <tr>
                    <th>Dibuat Pada</th>
                    <td>{{ $kendaraan->created_at }}</td>
                </tr>

                <tr>
                    <th>Terakhir Diubah</th>
                    <td>{{ $kendaraan->updated_at }}</td>
                </tr>

            </table>

            <div class="mt-4">

                <a href="{{ route('admin.kendaraan.edit', $kendaraan->id) }}"
                   class="btn btn-warning">
                    Edit Data
                </a>

                <form action="{{ route('admin.kendaraan.destroy', $kendaraan->id) }}"
                      method="POST"
                      class="d-inline">

                    @csrf
                    @method('DELETE')

                    <button
                        type="submit"
                        class="btn btn-danger"
                        onclick="return confirm('Yakin ingin menghapus kendaraan ini?')">

                        Hapus

                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection