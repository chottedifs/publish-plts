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
                            <form method="post" action="{{ route('master-status.store') }}">
                                @csrf
                                <div class="row">
                                    <div class="mb-3 col-lg-12">
                                        <label for="nama_status" class="form-label">Masukan judul status</label>
                                        <input type="text" name="nama_status" class="form-control @error('nama_status') is-invalid @enderror" id="nama_status" autofocus value="{{ old("nama_status") }}">
                                        @error('nama_status')
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
