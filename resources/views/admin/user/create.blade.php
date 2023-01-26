<div class="modal fade bs-example-modal-lg" id="createUserModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" action="{{route('super.admin.storeUser')}}">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Create User</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label>NIK</label>
                        <input name="nik" class="form-control" type="number" placeholder="NIK">
                        @error('nik') <span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Nama</label>
                        <input name="name" class="form-control" type="text" placeholder="Nama">
                        @error('name') <span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input name="email" class="form-control" type="text" placeholder="mail">
                        @error('email') <span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Type</label>
                        <select class="form-control" name="type">
                            <option value="0">Super Admin</option>
                            <option value="1">Admin</option>
                            <option value="2">User</option>
                        </select>
                        @error('type') <span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Kecamatan</label>
                        <select id="kec" name="id_kec" class="form-control" require>
                            <option value="">== Select Kecamatan ==</option>
                            @foreach ($kec as $id => $data)
                            <option value="{{$data->id}}">{{$data->name}}</option>
                            @endforeach
                        </select>
                        @error('type') <span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Kelurahan</label>
                        <select id="kel" name="id_kel" class="form-control" require>
                            <option value="">== Select Kelurahan ==</option>
                        </select>
                        @error('type') <span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Puskesmas</label>
                        <select id="puskesmas" name="id_puskesmas" class="form-control" require>
                            <option value="">== Select Puskesmas ==</option>
                        </select>
                        @error('type') <span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Posyandu</label>
                        <select id="posyandu" name="id_posyandu" class="form-control" require>
                            <option value="">== Select Posyandu ==</option>
                        </select>
                        @error('type') <span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
