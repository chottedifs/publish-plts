@extends('layouts.master')

@section('content')
<div class="content">
    <!-- Animated -->
    <div class="animated fadeIn">
        <!--  /Traffic -->
        <div class="clearfix"></div>
        <!-- Orders -->
        <div class="orders">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="box-title">{{ $judul }}</h4>
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{ route('master-relasiKios.update', $dataRelasiKios->id) }}">
                                @method('put')
                                @csrf
                                <div class="row">
                                    <div class="mb-3 col-lg-12">
                                        <label for="kios_id" class="form-label">Pilih Data Kios</label>
                                        <select name="kios_id" id="kios_id" class="form-control @error('kios_id') is-invalid @enderror">
                                            {{-- <option value="" disabled selected hidden>-- Pilih Data Kios --</option> --}}
                                            @foreach($dataKios as $kios)
                                            @if($dataRelasiKios['kios_id'] == $kios->id)
                                                <option value="{{ $kios->id }}" selected>{{ $kios->nama_kios }} || {{ $kios->luas_kios }}</option>
                                            @endif
                                            @if($kios->status_kios === 0 )
                                                <option value="{{ $kios->id }}">{{ $kios->nama_kios }} || {{ $kios->luas_kios }}</option>
                                            @endif
                                            {{-- @if($kios->status_kios === 0)
                                                @if(old('kios_id') == $kios->id)
                                                    <option value="{{ $kios->id }}">{{ $kios->nama_kios }} || {{ $kios->luas_kios }}</option>
                                                @else
                                                    <option value="{{ $kios->id }}">{{ $kios->nama_kios }} || {{ $kios->luas_kios }}</option>
                                                @endif
                                            @endif --}}
                                            @endforeach
                                        </select>
                                        @error('kios_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-lg-12">
                                        <label for="tarif_kios_id" class="form-label">Pilih Tarif Kios</label>
                                        <select name="tarif_kios_id" id="tarif_kios_id" class="form-control @error('tarif_kios_id') is-invalid @enderror">
                                            @foreach($dataTarifKios as $tarifKios)
                                                @if(old('tarif_kios_id', $dataRelasiKios['tarif_kios_id']) == $tarifKios->id)
                                                    <option value="{{ $tarifKios->id }}" selected>{{ $tarifKios->tipe }} || {{ 'Rp '.number_format($tarifKios->harga,0,',','.') }}</option>
                                                @else
                                                    <option value="{{ $tarifKios->id }}">{{ $tarifKios->tipe }} || {{ 'Rp '.number_format($tarifKios->harga,0,',','.') }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @error('tarif_kios_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-lg-12">
                                        <label for="lokasi_id" class="form-label">Pilih Lokasi Kios</label>
                                        <select name="lokasi_id" id="lokasi_id" class="form-control @error('lokasi_id') is-invalid @enderror">
                                            @foreach($dataLokasi as $lokasi)
                                                @if(old('lokasi_id', $dataRelasiKios['lokasi_id']) == $lokasi->id)
                                                    <option value="{{ $lokasi->id }}" selected>{{ $lokasi->nama_lokasi }}</option>
                                                @else
                                                    <option value="{{ $lokasi->id }}">{{ $lokasi->nama_lokasi }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @error('lokasi_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div> <!-- /.card -->
                </div>  <!-- /.col-lg-8 -->
            </div>
        </div>
        <!-- /.orders -->
    <!-- /#add-category -->
    </div>
    <!-- .animated -->
</div>
@endsection
