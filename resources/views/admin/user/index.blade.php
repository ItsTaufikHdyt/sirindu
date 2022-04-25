@extends('admin::layouts.app')
@section('title')
Si Rindu
@endsection
@section('title-content')
User
@endsection
@section('item')
User
@endsection
@section('item-active')
Data User
@endsection
@section('content')
@if($errors->any())
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    @foreach ($errors->all() as $error)
    <ul>
        <li> <strong>{{ $error }}</strong></li>
    </ul>
    @endforeach
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif
<button data-toggle="modal" data-target="#createUserModal" type="button" class="btn btn-success">Create</button>
<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">NIK</th>
                <th scope="col">Nama</th>
                <th scope="col">Email</th>
                <th scope="col">Type</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @php
            $no = 1;
            @endphp
            @forelse ($user as $data)
            <tr>
                <th scope="row">{{$no++}}</th>
                <th scope="row">{{$data->nik}}</th>
                <th scope="row">{{$data->name}}</th>
                <th scope="row">{{$data->email}}</th>
                <th scope="row">
                    @if ($data->type == 'user')
                    <span class="badge badge-primary">User</span>
                    @elseif ($data->type == 'super-admin')
                    <span class="badge badge-info">Super Admin</span>
                    @elseif ($data->type == 'admin')
                    <span class="badge badge-success">Admin</span>
                    @endif
                </th>
                <th scope="row">
                    <button data-toggle="modal" data-target="#updateUserModal{{$data->id}}" type="button" class="btn btn-warning">Edit</button>
                    @include('admin.user.update')
                    <button data-toggle="modal" data-target="#confirmationModal{{$data->id}}" type="button" class="btn btn-danger">Delete</button>
                    @include('admin.user.delete-confirmation')
                </th>
            </tr>
            @empty
            <tr>
                <th colspan="6">
                    <center>
                        Data Not Found
                    </center>
                </th>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@include('admin.user.create')
@endsection