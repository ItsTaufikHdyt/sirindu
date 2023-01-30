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
Data Imunisasi Dasar Lengkap
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
<form method="post" action="{{route('admin.updateImunisasi',$data->id)}}">
    @csrf
    <input type="hidden" name="_method" value="PUT">
    <div class="row">
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>HBo</label>
                <select name="hbo" class="form-control" require>
                    <option value="0" @if($data->hbo == '0') selected @endif>Tidak</option>
                    <option value="1" @if($data->hbo == '1') selected @endif>Ya</option>
                </select>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>BCG</label>
                <select name="bcg" class="form-control" require>
                    <option value="0" @if($data->bcg == '0') selected @endif>Tidak</option>
                    <option value="1" @if($data->bcg == '1') selected @endif>Ya</option>
                </select>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Polio 1</label>
                <select name="polio1" class="form-control" require>
                    <option value="0" @if($data->polio1 == '0') selected @endif>Tidak</option>
                    <option value="1" @if($data->polio1 == '1') selected @endif>Ya</option>
                </select>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>DPT HB-Hib1</label>
                <select name="dpthb_hib1" class="form-control" require>
                    <option value="0" @if($data->dpthb_hib1 == '0') selected @endif>Tidak</option>
                    <option value="1" @if($data->dpthb_hib1 == '1') selected @endif>Ya</option>
                </select>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Polio 2</label>
                <select name="polio2" class="form-control" require>
                    <option value="0" @if($data->polio2 == '0') selected @endif>Tidak</option>
                    <option value="1" @if($data->polio2 == '1') selected @endif>Ya</option>
                </select>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>DPT HB-Hib2</label>
                <select name="dpthb_hib2" class="form-control" require>
                    <option value="0" @if($data->dpthb_hib2 == '0') selected @endif>Tidak</option>
                    <option value="1" @if($data->dpthb_hib2 == '1') selected @endif>Ya</option>
                </select>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Polio 3</label>
                <select name="polio3" class="form-control" require>
                    <option value="0" @if($data->polio3 == '0') selected @endif>Tidak</option>
                    <option value="1" @if($data->polio3 == '1') selected @endif>Ya</option>
                </select>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>DPT HB-Hib3</label>
                <select name="dpthb_hib3" class="form-control" require>
                    <option value="0" @if($data->dpthb_hib3 == '0') selected @endif>Tidak</option>
                    <option value="1" @if($data->dpthb_hib3 == '1') selected @endif>Ya</option>
                </select>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Polio 4</label>
                <select name="polio4" class="form-control" require>
                    <option value="0" @if($data->polio4 == '0') selected @endif>Tidak</option>
                    <option value="1" @if($data->polio4 == '1') selected @endif>Ya</option>
                </select>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Campak</label>
                <select name="campak" class="form-control" require>
                    <option value="0" @if($data->campak == '0') selected @endif>Tidak</option>
                    <option value="1" @if($data->campak == '1') selected @endif>Ya</option>
                </select>
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