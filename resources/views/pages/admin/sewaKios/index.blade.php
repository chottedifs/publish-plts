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
                        <a href="{{ route('sewa-kios.create') }}" class="btn btn-primary text-right">Tambah Sewa kios</a>
                    </div>
                    <div class="card-body">
                        <table id="bootstrap-data-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th class="serial">#</th>
                                    <th>Nama Penyewa</th>
                                    <th>Nama Kios</th>
                                    <th>Lokasi Kios</th>
                                    <th>Tipe Kios</th>
                                    <th>Status Kios</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sewaKios as $sewa)
                                <tr>
                                    <td class="serial">{{ $loop->iteration }}</td>
                                    <td>{{ $sewa->User->nama_lengkap }}</td>
                                    <td>{{ $sewa->RelasiKios->Kios->nama_kios }}</td>
                                    <td>{{ $sewa->RelasiKios->Lokasi->nama_lokasi }}</td>
                                    <td>{{ $sewa->RelasiKios->TarifKios->tipe }}</td>
                                    <td>
                                        @if ($sewa->status_sewa)
                                            Berhenti Sewa
                                        @else
                                            Disewakan
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('sewa-kios.edit', $sewa->id) }}" class="btn-sm badge-warning" style="font-size: 14px; border-radius:10px;"><i class="fa fa-edit"></i></a>
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
