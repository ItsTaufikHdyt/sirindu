<div class="modal fade bs-example-modal-lg" id="updateUserModal{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" action="{{route('super.admin.updateUser', $data->id)}}">
                @csrf
                <input type="hidden" name="_method" value="PUT">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Update User</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>NIK</label>
                        <input name="nik" value="{{$data->nik}}" class="form-control" type="number" placeholder="NIK">
                        @error('nik') <span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Nama</label>
                        <input name="name" value="{{$data->name}}" class="form-control" type="text" placeholder="Nama">
                        @error('name') <span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input name="email" value="{{$data->email}}" class="form-control" type="email" placeholder="mail">
                        @error('email') <span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Type</label>
                        <select class="form-control" name="type">
                            <option value="0" {{$data->type == 'user' ? 'selected' : ''}}>User</option>
                            <option value="1" {{$data->type == 'super-admin' ? 'selected' : ''}}>Super Admin</option>
                            <option value="2" {{$data->type == 'admin' ? 'selected' : ''}}>Admin</option>
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