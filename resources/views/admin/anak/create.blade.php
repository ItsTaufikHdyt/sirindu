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
Anak
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
<form method="post" action="{{route('admin.storeAnak')}}">
    @csrf
    <div class="row">
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>No KK <font color="red">*</font></label>
                <input type="number" name="no_kk" class="form-control" require>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>NIK <font color="red">*</font></label>
                <input type="number" name="nik" class="form-control" require>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Nama <font color="red">*</font></label>
                <input type="text" name="nama" class="form-control" require>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Nik Orang Tua <font color="red">*</font></label>
                <input type="number" name="nik_ortu" class="form-control" require>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Nama Ibu <font color="red">*</font></label>
                <input type="text" name="nama_ibu" class="form-control" require>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Nama Ayah <font color="red">*</font></label>
                <input type="text" name="nama_ayah" class="form-control" require>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Jenis Kelamin <font color="red">*</font></label>
                <select name="jk" class="form-control">
                    <option value="1">Laki - Laki</option>
                    <option value="2">Perempuan</option>
                </select>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Tempat Lahir <font color="red">*</font></label>
                <input type="text" name="tempat_lahir" class="form-control" require>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Tanggal Lahir <font color="red">*</font></label>
                <input type="date" name="tgl_lahir" class="form-control" require>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Golongan Darah <font color="red">*</font></label>
                <select name="golda" class="form-control" require>
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="AB">AB</option>
                    <option value="O">O</option>
                </select>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Anak Ke - <font color="red">*</font></label>
                <input type="number" name="anak" class="form-control" require>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>No HP</label>
                <input type="number" name="no" class="form-control">
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Kecamatan <font color="red">*</font></label>
                <select id="kec" name="id_kec" class="form-control" require>
                    <option value="">== Select Kecamatan ==</option>
                    @foreach ($kec as $id => $data)
                    <option value="{{$data->id}}">{{$data->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Puskesmas <font color="red">*</font></label>
                <select id="puskesmas" name="id_puskesmas" class="form-control" require>
                    <option value="">== Select Puskesmas ==</option>
                </select>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Kelurahan <font color="red">*</font></label>
                <select id="kel" name="id_kel" class="form-control" require>
                    <option value="">== Select Kelurahan ==</option>
                </select>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Posyandu <font color="red">*</font></label>
                <select id="posyandu" name="id_posyandu" class="form-control" require>
                    <option value="">== Select Posyandu ==</option>
                </select>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>RT <font color="red">*</font></label>
                <select id="rt" name="id_rt" class="form-control" require>
                    <option value="">== Select RT ==</option>
                </select>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Tinggi Badan Lahir <font color="red">* gunakan titik (.) untuk koma</font></label>
                <input type="number" name="tb" class="form-control" require>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Berat Badan Lahir <font color="red">* gunakan titik (.) untuk koma</font></label>
                <input type="number" name="bb" class="form-control" require>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Lingkar Lengan Atas <font color="red">* gunakan titik (.) untuk koma</font></label>
                <input type="number" name="lla" class="form-control" require>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Lingkar Kepala <font color="red">* gunakan titik (.) untuk koma</font></label>
                <input type="number" name="lk" class="form-control" require>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <label>Asi Ekslusif <font color="red">*</font></label>
            <select name="asi" class="form-control" require>
                <option value="0">Tidak</option>
                <option value="1">Ya</option>
            </select>
        </div>
        <div class="col-md-4 col-sm-12">
            <label>Obat Cacing <font color="red">*</font></label>
            <select name="obat_cacing" class="form-control" require>
                <option value="0">Tidak</option>
                <option value="1">Ya</option>
            </select>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Tanggal Kunjungan <font color="red">*</font></label>
                <input type="date" name="tgl_kunjungan" class="form-control" require>
            </div>
        </div>
        <div class="col-md-12 col-sm-12">
            <div class="form-group">
                <label>Catatan</label>
                <textarea class="form-control" name="catatan" id="" cols="30" rows="10"></textarea>
            </div>
        </div>
        <div class="col-md-12 col-sm-12">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
</form>
@endsection
@section('custom_scripts')
<script type="text/javascript">
    $(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#kec').on('change', function() {
            var id = $(this).val();
            $.ajax({
                    url: '{{url("admin/get-kel-dasar-anak")}}' + '/' + id,
                    success: function(response) {
                        $('#kel').empty();
                        $('#kel').append(new Option('====== Kelurahan ======',0));
                        $.each(response, function(id, name) {
                            $('#kel').append(new Option(name, id))
                        })
                    }
                }),
                $.ajax({
                    url: '{{url("admin/get-puskesmas-dasar-anak")}}' + '/' + id,
                    success: function(response) {
                        $('#puskesmas').empty();
                        $('#puskesmas').append(new Option('====== Puskesmas ======',0));
                        $.each(response, function(id, name) {
                            $('#puskesmas').append(new Option(name, id))
                        })
                    }
                })
        });

        $('#puskesmas').on('change', function() {
            var id = $(this).val();
            $.ajax({
                url: '{{url("admin/get-posyandu-dasar-anak")}}' + '/' + id,
                success: function(response) {
                    $('#posyandu').empty();
                    $('#posyandu').append(new Option('====== Posyandu ======',0));
                    $.each(response, function(id, name) {
                        $('#posyandu').append(new Option(name, id))
                    })
                }
            })
        });

        $('#posyandu').on('change', function() {
            var id = $(this).val();
            $.ajax({
                url: '{{url("admin/get-rt-dasar-anak")}}' + '/' + id,
                success: function(response) {
                    $('#rt').empty();
                    $('#rt').append(new Option('====== RT ======',0));

                    $.each(response, function(id, name) {
                        $('#rt').append(new Option(name, id))
                    })
                }
            })
        });
    });
</script>
@endsection