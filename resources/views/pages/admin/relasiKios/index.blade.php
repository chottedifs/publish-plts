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
                        @can('admin')
                        <a href="{{ route('master-relasiKios.create') }}" class="btn btn-primary text-right" style="border-radius: 10px;"><i class="fa-solid fa-square-plus mr-2"></i> Kelola Kios</a>
                        @endcan
                    </div>
                    <div class="card-body">
                        <table id="bootstrap-data-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th class="serial">#</th>
                                    <th>Nama Kios</th>
                                    <th>Lokasi Kios</th>
                                    <th>Tipe Kios</th>
                                    <th>Tipe Listrik</th>
                                    <th>Harga Kios</th>
                                    @can('admin')
                                    <th class="text-center">Action</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($relasiDataKios as $dataKios)
                                <tr>
                                    <td class="serial">{{ $loop->iteration }}</td>
                                    <td>{{ $dataKios->Kios->nama_kios }}</td>
                                    <td>{{ $dataKios->Lokasi->nama_lokasi }}</td>
                                    <td>{{ $dataKios->TarifKios->tipe }}</td>
                                    @if($dataKios->use_plts == '1')
                                        <td>PLTS</td>
                                    @else
                                        <td>PLN</td>
                                    @endif
                                    <td>{{ 'Rp '.number_format($dataKios->TarifKios->harga,0,',','.') }}</td>
                                    @can('admin')
                                    <td class="text-center">
                                        <a href="{{ route('master-relasiKios.edit', $dataKios->id) }}" class="btn-sm badge-warning" style="font-size: 14px; border-radius:10px;"><i class="fa fa-edit"></i></a>
                                    </td>
                                    @endcan
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
