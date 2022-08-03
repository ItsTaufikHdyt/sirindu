@extends('admin::layouts.app')
@section('title')
Admin
@endsection
@section('title-content')
Data
@endsection
@section('item')
Data
@endsection
@section('item-active')
Edit Anak
@endsection
@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form method="post" action="{{route('admin.updateAnak',$anak->id)}}">
    @csrf
    <div class="row">
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>No KK <font color="red">*</font></label>
                <input type="number" name="no_kk" value="{{$anak->no_kk}}" class="form-control" require>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>NIK <font color="red">*</font></label>
                <input type="number" name="nik" value="{{$anak->nik}}" class="form-control" require>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Nama <font color="red">*</font></label>
                <input type="text" name="nama" value="{{$anak->nama}}" class="form-control" require>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Nik Orang Tua <font color="red">*</font></label>
                <input type="number" name="nik_ortu" value="{{$anak->nik_ortu}}" class="form-control" require>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Nama Ibu <font color="red">*</font></label>
                <input type="text" name="nama_ibu" value="{{$anak->nama_ibu}}" class="form-control" require>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Nama Ayah <font color="red">*</font></label>
                <input type="text" name="nama_ayah" value="{{$anak->nama_ayah}}" class="form-control" require>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Jenis Kelamin <font color="red">*</font></label>
                <select name="jk" class="form-control">
                    <option value="1" @if ($anak->jk == 1) selected @endif >Laki - Laki</option>
                    <option value="2" @if ($anak->jk == 2) selected @endif>Perempuan</option>
                </select>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Tempat Lahir <font color="red">*</font></label>
                <input type="text" name="tempat_lahir" value="{{$anak->tempat_lahir}}" class="form-control" require>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Tanggal Lahir <font color="red">*</font></label>
                <input type="date" name="tgl_lahir" value="{{$anak->tgl_lahir}}" class="form-control" require>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Golongan Darah <font color="red">*</font></label>
                <select name="golda" class="form-control" require>
                    <option value="A" @if ($anak->jk == 'A') selected @endif>A</option>
                    <option value="B" @if ($anak->jk == 'B') selected @endif>B</option>
                    <option value="AB" @if ($anak->jk == 'AB') selected @endif>AB</option>
                    <option value="O" @if ($anak->jk == 'O') selected @endif>O</option>
                </select>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Anak Ke - <font color="red">*</font></label>
                <input type="number" name="anak" value="{{$anak->anak}}" class="form-control" require>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Kecamatan <font color="red">*</font></label>
                <select name="id_kec" class="form-control" require>
                    @foreach ($kec as $data)
                    <option value="{{$data->id}}" @if ($data->id == $anak->id_kec) selected @endif>{{$data->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Kelurahan <font color="red">*</font></label>
                <select name="id_kel" class="form-control" require>
                    @foreach ($kel as $data)
                    <option value="{{$data->id}}" @if ($data->id == $anak->id_kel) selected @endif>{{$data->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>RT <font color="red">*</font></label>
                <input type="number" name="rt" value="{{$anak->rt}}" class="form-control" require>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>RW <font color="red">*</font></label>
                <input type="number" name="rw" value="{{$anak->rw}}" class="form-control" require>
            </div>
        </div>
        <div class="col-md-12 col-sm-12">
            <div class="form-group">
                <label>Catatan</label>
                <textarea class="form-control" name="catatan" id="" cols="30" rows="10">{{$anak->catatan}}</textarea>
            </div>
        </div>
        <div class="col-md-12 col-sm-12">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
</form>
@endsection
@section('custom_scripts')
@endsection