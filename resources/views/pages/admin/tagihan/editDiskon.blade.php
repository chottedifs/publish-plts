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
                            <form method="post" action="{{ route('update-diskon', $tagihan->id) }}">
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
                                        <label for="user_id" class="form-label">Total KWH : {{ $tagihan->total_kwh }}</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-lg-12">
                                        <label for="diskon" class="form-label">Diskon</label>
                                        <input type="number" name="diskon" autofocus class="form-control @error('diskon') is-invalid @enderror" id="diskon" value="{{ old('diskon', $tagihan->diskon) }}">
                                        @error('diskon')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-lg-12">
                                        <label for="remarks" class="form-label">Keterangan</label>
                                        <input type="text" name="remarks" autofocus class="form-control @error('remarks') is-invalid @enderror" id="remarks" value="{{ old('remarks', $tagihan->remarks) }}">
                                        @error('remarks')
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
