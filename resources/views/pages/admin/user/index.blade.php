@extends('layouts.master')

@section('content')

<div class="breadcrumbs">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>{{ $judul }}</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="">Dashboard</a></li>
                            <li class="active">{{ $judul }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Content --}}
<div class="content">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('master-user.create') }}" class="btn btn-primary text-right">Tambah Data User</a>
                    </div>
                    <div class="card-body">
                        <table id="bootstrap-data-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th class="serial">#</th>
                                    <th>Nama Lengkap</th>
                                    <th>Lokasi</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Email</th>
                                    <th>NIK</th>
                                    <th>No Handphone</th>
                                    <th>Rekening</th>
                                    <th>Status User</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                <tr>
                                    <td class="serial">{{ $loop->iteration }}</td>
                                    <td>{{ $user->nama_lengkap }}</td>
                                    <td>{{ $user->Lokasi->nama_lokasi }}</td>
                                    <td>{{ $user->jenis_kelamin }}</td>
                                    <td>{{ $user->Login->email }}</td>
                                    <td>{{ $user->nik }}</td>
                                    <td>{{ $user->no_hp }}</td>
                                    <td>{{ $user->rekening }}</td>
                                    <td>
                                        @if ($user->Login->is_active == 1)
                                        Aktif
                                        @else
                                        Tidak Aktif
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('master-user.edit', $user->id) }}" class="btn-sm badge-warning" style="font-size: 14px; border-radius:10px;"><i class="fa fa-edit"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
</div>
{{-- akhir Content --}}
</div>
@endsection