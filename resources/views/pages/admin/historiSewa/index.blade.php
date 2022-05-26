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
                        {{-- <a href="{{ route('sewa-kios.create') }}" class="btn btn-primary text-right">Tambah Sewa kios</a> --}}
                    </div>
                    <div class="card-body">
                        <table id="bootstrap-data-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th class="serial">#</th>
                                    <th>Nama Penyewa</th>
                                    <th>Nama Kios</th>
                                    <th>Tanggal Awal Sewa</th>
                                    <th>Tanggal Akhir Sewa Sewa</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($historiKios as $histori)
                                <tr>
                                    <td class="serial">{{ $loop->iteration }}</td>
                                    <td>{{ $histori->User->nama_lengkap }}</td>
                                    <td>{{ $histori->SewaKios->RelasiKios->Kios->nama_kios }}</td>
                                    <td>{{ date('d M Y', strtotime($histori->tgl_awal_sewa)) }}</td>
                                    <td>
                                        @if ($histori->tgl_akhir_sewa != NULL)
                                            {{ date('d M Y', strtotime($histori->tgl_akhir_sewa)) }}
                                        @else
                                            Kios masih disewa
                                        @endif
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
