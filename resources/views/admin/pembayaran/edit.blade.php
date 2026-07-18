@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Pembayaran #{{ $pembayaran->id }}</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.pembayaran.update', $pembayaran) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="penyewaan_id" class="form-label">Penyewaan</label>
            <select name="penyewaan_id" id="penyewaan_id" class="form-control">
                @foreach($penyewaans as $p)
                    <option value="{{ $p->id }}" {{ $p->id == $pembayaran->penyewaan_id ? 'selected' : '' }}>#{{ $p->id }} - {{ $p->kendaraan->nama ?? 'Kendaraan' }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="user_id" class="form-label">User</label>
            <select name="user_id" id="user_id" class="form-control">
                @foreach($users as $u)
                    <option value="{{ $u->id }}" {{ $u->id == $pembayaran->user_id ? 'selected' : '' }}>{{ $u->name }} ({{ $u->email }})</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="amount" class="form-label">Amount</label>
            <input type="number" step="0.01" name="amount" id="amount" class="form-control" value="{{ $pembayaran->amount }}" required>
        </div>

        <div class="mb-3">
            <label for="payment_method" class="form-label">Payment Method</label>
            <input type="text" name="payment_method" id="payment_method" class="form-control" value="{{ $pembayaran->payment_method }}">
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-control">
                <option value="Pending" {{ $pembayaran->status === 'Pending' ? 'selected' : '' }}>Pending</option>
                <option value="Paid" {{ $pembayaran->status === 'Paid' ? 'selected' : '' }}>Paid</option>
                <option value="Failed" {{ $pembayaran->status === 'Failed' ? 'selected' : '' }}>Failed</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="paid_at" class="form-label">Paid At</label>
            <input type="datetime-local" name="paid_at" id="paid_at" class="form-control" value="{{ optional($pembayaran->paid_at)->format('Y-m-d\TH:i') }}">
        </div>

        <button class="btn btn-primary">Perbarui</button>
    </form>

    <form action="{{ route('admin.pembayaran.destroy', $pembayaran) }}" method="POST" class="mt-3">
        @csrf
        @method('DELETE')
        <button class="btn btn-danger" onclick="return confirm('Hapus pembayaran ini?')">Hapus</button>
    </form>
</div>
@endsection
