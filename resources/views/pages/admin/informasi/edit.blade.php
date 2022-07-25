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
                            <form method="post" action="{{ route('master-informasi.update', $informasi->id) }}" enctype="multipart/form-data">
                                @method('put')
                                @csrf
                                <div class="row">
                                    <div class="mb-3 col-lg-12">
                                        <label for="title" class="form-label">Judul Informasi</label>
                                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" id="title" autofocus value="{{ old('title', $informasi->title)  }}">
                                        @error('title')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-lg-12">
                                        <label for="deskripsi" class=" form-label">Deskripsi</label>
                                        <textarea name="deskripsi" id="deskripsi" rows="9" placeholder="Deskripsi..." class="form-control">{{ old('deskripsi', $informasi->deskripsi) }}</textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-lg-12">
                                        <label for="gambar" class=" form-control-label">Upload Gambar</label>
                                        <input type="file" id="gambar" name="gambar" class="form-control-file">
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
