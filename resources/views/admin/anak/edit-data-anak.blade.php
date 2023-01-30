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
Edit Berkala Data Anak Tinggi / Berat
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
<div class="row">
    @foreach ($dataAnak as $data)
    <form method="post" action="{{route('admin.updateDataAnak',$data->id)}}">
        @csrf
        <input type="hidden" name="_method" value="PUT">
        <div class="col">
            <label>Umur {{$data->bln}} Bulan</label>
            <div class="form-group">
                <label>Posisi</label>
                <select name="posisi" class="form-control" require>
                    <option value="H" @if($data->posisi == 'H') selected @endif>H</option>
                    <option value="L" @if($data->posisi == 'L') selected @endif>L</option>
                </select>
                <label>Tinggi Badan</label>
                <input type="number" name="tb" value="{{$data->tb}}" class="form-control" require>
                <label>Berat Badan</label>
                <input type="number" name="bb" value="{{$data->bb}}" class="form-control" require>
                <label>Lingkar Lengan Atas</label>
                <input type="number" name="lla" value="{{$data->lla}}" class="form-control" require>
                <label>Lingkar Kepala</label>
                <input type="number" name="lk" value="{{$data->lk}}" class="form-control" require>
                <label>Asi Ekslusif</label>
                <select name="asi" class="form-control" require>
                    <option value="0" @if($data->asi == '0') selected @endif>Tidak</option>
                    <option value="1" @if($data->asi == '1') selected @endif>Ya</option>
                </select>
                @php
                $month = idate("m");
                @endphp
                @if ($month == 2 || $month ==8)
                <label>Vitamin A</label>
                <select name="vit_a" class="form-control" require>
                    <option value="0" @if($data->vit_a == '0') selected @endif>Tidak</option>
                    <option value="1" @if($data->vit_a == '1') selected @endif>Ya</option>
                </select>
                @endif
            </div>
        </div>
        <div class="col-md-12 col-sm-12">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
    @endforeach
</div>
@endsection
@section('custom_scripts')
@endsection