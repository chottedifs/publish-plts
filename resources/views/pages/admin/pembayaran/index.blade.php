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
                                {{-- <a href="{{ route('export-laporan') }}" class="btn btn-success text-right" onclick="kirimData()" style="border-radius: 10px;"><i class="fa-solid fa-cloud-arrow-down mr-2"></i> Download Report </a> --}}
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
                        {{-- @include('pages.admin.tagihan.table') --}}
                        <table id="table-datatables" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th class="serial">#</th>
                                    <th>Nama Penyewa</th>
                                    <th>Rekening</th>
                                    <th>Kode Batch</th>
                                    <th>Kode Tagihan</th>
                                    <th>Tanggal Kirim</th>
                                    <th>Tanggal Terima</th>
                                    <th>Status Bayar</th>
                                    <th>Lokasi</th>
                                    <th>Periode</th>
                                    <th>Keterangan</th>
                                    @can('plts')
                                        <th class="text-center">Action</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pembayarans as $pembayaran)
                                <tr>
                                    <td class="serial">{{ $loop->iteration }}</td>
                                    <td>{{ $pembayaran->Tagihan->SewaKios->User->nama_lengkap }}</td>
                                    <td>{{ $pembayaran->Tagihan->SewaKios->User->rekening }}</td>
                                    <td>{{ $pembayaran->kode_batch }}</td>
                                    <td>{{ $pembayaran->kode_tagihan }}</td>
                                    @if($pembayaran->tgl_kirim)
                                    <td class="text-center">{{ $pembayaran->tgl_kirim }}</td>
                                    @else
                                    <td class="text-center">-</td>
                                    @endif
                                    @if($pembayaran->tgl_terima)
                                    <td class="text-center">{{ $pembayaran->tgl_terima }}</td>
                                    @else
                                    <td class="text-center">-</td>
                                    @endif
                                    <td>{{ $pembayaran->MasterStatus->nama_status }}</td>
                                    <td>{{ $pembayaran->Lokasi->nama_lokasi }}</td>
                                    <td>{{  date('M Y', strtotime($pembayaran->periode)) }}</td>
                                    <td>{{ $pembayaran->remarks }}</td>
                                    @can('plts')
                                    <td class="text-center">
                                        <a href="{{ route('tagihan.edit', $pembayaran->id) }}" class="btn-sm badge-warning" style="font-size: 14px; border-radius:10px;"><i class="fa fa-edit"></i></a>
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



<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Masukan Template Tagihan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
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
