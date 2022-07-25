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
                            <form method="post" action="{{ route('tagihan.update', $tagihan->id) }}">
                                @method('put')
                                @csrf
                                <div class="row">
                                    <div class="mb-3 col-lg-12">
                                        <label for="user_id" class="form-label">Nama Penyewa : {{ $tagihan->SewaKios->User->nama_lengkap }}</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-lg-12">
                                        <label for="user_id" class="form-label">Kios : {{ $tagihan->SewaKios->RelasiKios->Kios->nama_kios }}</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-lg-12">
                                        <label for="user_id" class="form-label">Lokasi : {{ $tagihan->Lokasi->nama_lokasi }}</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-lg-12">
                                        <label for="total_kwh" class="form-label">Total KWH</label>
                                        <input type="number" name="total_kwh" autofocus class="form-control @error('total_kwh') is-invalid @enderror" id="total_kwh" value="{{ old('total_kwh', $tagihan->total_kwh) }}">
                                        @error('total_kwh')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary mt-3">Submit</button>
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
