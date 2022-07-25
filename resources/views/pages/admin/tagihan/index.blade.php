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
                        @can('plts')
                            <div class="float-right">
                                <a href="{{ route('export-tagihan') }}" class="btn btn-success text-right" style="border-radius: 10px;"><i class="fa-solid fa-file-export mr-2"></i> Template Tagihan </a>
                                <button type="button" data-toggle="modal" data-target="#exampleModal" class="btn btn-primary text-right" style="border-radius: 10px;"><i class="fa-solid fa-cloud-arrow-up mr-2"></i>Upload Tagihan</button>
                            </div>
                        @endcan
                        @can('admin')
                            <div class="float-right">
                                <a href="{{ route('export-tagihan-diskon') }}" class="btn btn-success text-right" style="border-radius: 10px;"><i class="fa-solid fa-file-export mr-2"></i> Template Diskon</a>
                                <button type="button" data-toggle="modal" data-target="#exampleModal" class="btn btn-primary text-right" style="border-radius: 10px;"><i class="fa-solid fa-cloud-arrow-up mr-2"></i>Upload Template</button>
                            </div>
                        @endcan
                        @can('operator')
                            <div class="float-right">
                                <a href="{{ route('export-tagihan-diskon') }}" class="btn btn-success text-right" style="border-radius: 10px;"><i class="fa-solid fa-file-export mr-2"></i> Template Diskon</a>
                                <button type="button" data-toggle="modal" data-target="#exampleModal" class="btn btn-primary text-right" style="border-radius: 10px;"><i class="fa-solid fa-cloud-arrow-up mr-2"></i>Upload Template</button>
                            </div>
                        @endcan
                        <form class="form-inline" action="{{ route('tagihan-index') }}" method="get">
                            @csrf
                            <div class="form-group mx-sm-3 mb-2">
                                <label for="bulanTagihan" class="mr-2">Periode Tagihan</label>
                                <input type="month" class="form-control" name="bulanTagihan" id="bulanTagihan" value="{{ old('bulanTagihan', $periode) }}">
                            </div>
                            <div class="form-group mx-sm-3 mb-2">
                                <select name="lokasi" id="lokasi" class="form-control @error('lokasi') is-invalid @enderror">
                                    <option value=" ">-Pilih Lokasi-</option>
                                    @foreach ($banyakLokasi as $lokasi)
                                        @if (old('lokasi') == $lokasi->id)
                                            <option value="{{ $lokasi->id }}" selected>{{ $lokasi->nama_lokasi }}</option>
                                        @else
                                            <option value="{{ $lokasi->id }}">{{ $lokasi->nama_lokasi }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary mb-2" style="border-radius: 10px;">Cari Tagihan</button>
                        </form>
                    </div>
                    <div class="card-body">
                        @can('admin')
                            <a href="{{ route('report-tagihan') }}" class="btn btn-success text-right mb-3" style="border-radius: 10px;"><i class="fa-solid fa-file-export mr-2"></i> Laporan Tagihan </a>
                            <a href="{{ route('cetak-tagihan') }}" target="_blank" class="btn btn-success text-right mb-3" style="border-radius: 10px;"><i class="fa-solid fa-print mr-2"></i> Cetak Tagihan </a>
                        @endcan
                        @can('operator')
                            <a href="{{ route('report-tagihan') }}" class="btn btn-success text-right mb-3" style="border-radius: 10px;"><i class="fa-solid fa-file-export mr-2"></i> Laporan Tagihan </a>
                            <a href="{{ route('cetak-tagihan') }}" target="_blank" class="btn btn-success text-right mb-3" style="border-radius: 10px;"><i class="fa-solid fa-print mr-2"></i> Cetak Tagihan </a>
                        @endcan
                        {{-- @include('pages.admin.tagihan.table') --}}
                        <table id="bootstrap-data-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th class="serial">#</th>
                                    <th>kode Tagihan</th>
                                    <th>Nama Penyewa</th>
                                    <th>Kios</th>
                                    <th>Lokasi</th>
                                    <th>Total Kwh</th>
                                    <th>Tagihan Kwh</th>
                                    <th>Tagihan Kios</th>
                                    <th>Diskon Tagihan</th>
                                    <th>Total Tagihan</th>
                                    <th>Periode</th>
                                    <th>Keterangan</th>
                                    @can('plts')
                                        <th class="text-center">Action</th>
                                    @endcan
                                    @can('operator')
                                        <th class="text-center">Action</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dataTagihan as $tagihan)
                                <tr>
                                    <td class="serial">{{ $loop->iteration }}</td>
                                    <td>{{ $tagihan->kode_tagihan }}</td>
                                    <td>{{ $tagihan->SewaKios->User->nama_lengkap }}</td>
                                    <td>{{ $tagihan->SewaKios->RelasiKios->Kios->nama_kios }}</td>
                                    <td>{{ $tagihan->Lokasi->nama_lokasi }}</td>
                                    <td>{{ $tagihan->total_kwh }}</td>
                                    <td>{{ 'Rp '.number_format($tagihan->tagihan_kwh,0,',','.') }}</td>
                                    <td>{{ 'Rp '.number_format($tagihan->tagihan_kios,0,',','.') }}</td>
                                    <td>{{ $tagihan->diskon}}%</td>
                                    {{-- 1.000.000 x 40/100 --}}
                                    <td>{{ 'Rp '.number_format($tagihan->tagihan_kios - ($tagihan->diskon/100*$tagihan->tagihan_kios)+ $tagihan->tagihan_kwh,0,',','.')}}</td>
                                    <td>{{  date('M Y', strtotime($tagihan->periode)) }}</td>
                                    <td>{{  $tagihan->remarks }}</td>
                                    <input type="hidden" id="periode" name="periode" value="{{ $tagihan->periode }}">
                                    @can('plts')
                                    <td class="text-center">
                                        <a href="{{ route('tagihan.edit', $tagihan->id) }}" class="btn-sm badge-warning" style="font-size: 14px; border-radius:10px;"><i class="fa fa-edit"></i></a>
                                    </td>
                                    @endcan
                                    @can('operator')
                                    <td class="text-center">
                                        <a href="{{ route('edit-diskon', $tagihan->id) }}" class="btn-sm badge-warning" style="font-size: 14px; border-radius:10px;"><i class="fa fa-edit"></i></a>
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



<!-- Modal tagihan -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Masukan Template Tagihan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @can('plts')
            <form action="{{ route('import-tagihan') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <label for="file">Masukan template</label>
                    <input type="file" name="import-file" id="import-file" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        @endcan
        @can('admin')
            <form action="{{ route('import-tagihan-diskon') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <label for="file">Masukan template</label>
                    <input type="file" name="import-file" id="import-file" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        @endcan
        @can('operator')
            <form action="{{ route('import-tagihan-diskon') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <label for="file">Masukan template</label>
                    <input type="file" name="import-file" id="import-file" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        @endcan
        </div>
    </div>
</div>

<script>
    function kirimData() {
                const bulanTagihan= document.getElementById('periode').value;
                $.ajax({
                method: 'GET',
                url: './export-laporan',
                data: {
                periode: bulanTagihan,
            },
        });
    }
</script>
