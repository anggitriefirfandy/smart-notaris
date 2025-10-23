@extends('layouts.appx')

@section('content')
<div class="container mt-4">
    <h4>Edit User</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('user_notaris.update', $user->id) }}" method="POST">
    @csrf
    @method('PUT')


        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
        </div>

        <!-- <div class="mb-3">
            <label>Role</label>
            <select name="role_id" class="form-control" required>
                <option value="0" {{ $user->role_id == 0 ? 'selected' : '' }}>Admin</option>
                <option value="1" {{ $user->role_id == 1 ? 'selected' : '' }}>Bank</option>
                <option value="2" {{ $user->role_id == 2 ? 'selected' : '' }}>Notaris</option>
            </select>
        </div> -->

        <div class="mb-3">
            <label>Password (Kosongkan jika tidak ingin diubah)</label>
            <input type="password" name="password" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </form>
</div>
@endsection
