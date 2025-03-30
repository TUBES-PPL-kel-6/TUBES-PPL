@extends('layout.app')

@section('content')
<div class="container">
    <h1 class="my-4 text-center text-dark">Dashboard Pengurus</h1>
    
    <div class="row">
        <div class="col-md-4">
            <div class="card bg-danger text-white mb-3">
                <div class="card-header" style="background-color: #A94A4A;">Total Users</div>
                <div class="card-body">
                    <h2 class="card-title">120</h2>
                    <p class="card-text">Jumlah pengguna yang terdaftar.</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card bg-warning text-white mb-3">
                <div class="card-header" style="background-color: #F4D793;">Active Users</div>
                <div class="card-body">
                    <h2 class="card-title">85</h2>
                    <p class="card-text">Pengguna yang aktif saat ini.</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card bg-success text-white mb-3">
                <div class="card-header" style="background-color: #889E73;">Inactive Users</div>
                <div class="card-body">
                    <h2 class="card-title">35</h2>
                    <p class="card-text">Pengguna yang tidak aktif.</p>
                </div>
            </div>
        </div>
    </div>

    <h2 class="mt-4 text-dark">Daftar Pengguna</h2>
    <table class="table table-bordered bg-white">
        <thead style="background-color: #F4D793;">
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>John Doe</td>
                <td>john@example.com</td>
                <td>Admin</td>
            </tr>
            <tr>
                <td>Jane Smith</td>
                <td>jane@example.com</td>
                <td>User</td>
            </tr>
            <tr>
                <td>Michael Johnson</td>
                <td>michael@example.com</td>
                <td>User</td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
