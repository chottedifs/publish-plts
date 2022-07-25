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
                        <a href="{{ route('master-plts.create') }}" class="btn btn-primary text-right" style="border-radius: 10px;"><i class="fa-solid fa-square-plus mr-2"></i> Data PLTS</a>
                    </div>
                    <div class="card-body">
                        <table id="bootstrap-data-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th class="serial">#</th>
                                    <th>Nama Lengkap</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Email</th>
                                    <th>NIP</th>
                                    <th>No Handphone</th>
                                    <th>Lokasi</th>
                                    <th>Status User</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dataPlts as $plts)
                                <tr>
                                    <td class="serial">{{ $loop->iteration }}</td>
                                    <td>{{ $plts->nama_lengkap }}</td>
                                    <td>{{ $plts->jenis_kelamin }}</td>
                                    <td>{{ $plts->Login->email }}</td>
                                    <td>{{ $plts->nip }}</td>
                                    <td>{{ $plts->no_hp }}</td>
                                    <td>{{ $plts->Lokasi->nama_lokasi }}</td>
                                    <td>
                                        @if ($plts->Login->is_active)
                                        <form action="{{ route('plts-isActive', $plts->id)}}" method="post">
                                            @csrf
                                            <button class="btn btn-success mb-2" style="border-radius: 10px;">Aktif</button>
                                        </form>
                                        @else
                                        <form action="{{ route('plts-isActive', $plts->id)}}" method="post">
                                            @csrf
                                            <button class="btn btn-danger mb-2" style="border-radius: 10px;">Tidak Aktif</button>
                                        </form>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('master-plts.edit', $plts->id) }}" class="btn-sm badge-warning" style="font-size: 14px; border-radius:10px;"><i class="fa fa-edit"></i></a>
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
