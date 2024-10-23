@extends('admin.app')
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="viewport" content="width=device-width, initial-scale=1"> <!-- Added for mobile responsiveness -->
@section('content')
<div class="content-header-left col-md-9 col-12 mb-2">
    <div class="row breadcrumbs-top">
        <div class="col-12">
           
                <h3 class="content-header-title float-left mb-0">Staff Users</h3>
                <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                    <li class="breadcrumb-item">User Management</li>
                    <li class="breadcrumb-item active">View Staff</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<section id="basic-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h4 class="card-title">Staff Users</h4>
                    <button class="btn btn-primary" data-toggle="modal" data-target="#addEditUserModal">Add Staff</button>
                </div>
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <div class="table-responsive">
                            <table class="table" id="admin-table">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Add/Edit User Modal -->
<div class="modal fade" id="addEditUserModal" tabindex="-1" role="dialog" aria-labelledby="addEditUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document"> <!-- Added modal-lg for larger screens -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addEditUserModalLabel">Add/Edit User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addEditUserForm">
                    <div class="form-group">
                        <label for="userName">Name</label>
                        <input type="text" class="form-control" id="userName" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="userEmail">Email</label>
                        <input type="email" class="form-control" id="userEmail" name="email" required>
                        <input type="hidden" class="form-control" id="userRole" name="role" value="staff">
                    </div>
                    <div class="form-group">
                        <label for="userPassword">Password</label>
                        <input type="password" class="form-control" id="userPassword" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="userConfirmPassword">Confirm Password</label>
                        <input type="password" class="form-control" id="userConfirmPassword" name="password_confirmation" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Save</button> <!-- Full width button on small screens -->
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function () {
        // DataTable initialization
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var adminTable = $('#admin-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.users.data') }}",
            columns: [
                { data: 'name', name: 'name', searchable: true },
                { data: 'email', name: 'email', searchable: true },
                { 
                    data: 'action', 
                    name: 'action', 
                    orderable: false, 
                    searchable: false,
                    render: function(data, type, full, meta){
                        return `
                            <a href="#" class="edit-user" data-id="${full.id}" data-toggle="modal" data-target="#addEditUserModal"><i class="fa fa-edit"></i> Edit</a> |
                            <a href="#" class="delete-user" data-id="${full.id}"><i class="fa fa-trash"></i> Delete</a> |
                            <a href="{{ url('/admin/users/${full.id}/checkinout') }}" class="show-checkinout" data-id="${full.id}"><i class="fa fa-eye"></i> Show Check-In/Out</a>
                        `;
                    }
                }
            ]
        });

        // Add/Edit user modal
        $('#addEditUserModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var userId = button.data('id');

            // Clear the form fields
            $('#addEditUserForm')[0].reset();

            if (userId) {
                // If editing user, populate form fields with user details
                $.ajax({
                    url: '/admin/users/' + userId,
                    type: 'GET',
                    success: function(response) {
                        $('#addEditUserForm').attr('action', '/admin/users/update/' + userId);
                        $('#userName').val(response.name);
                        $('#userEmail').val(response.email);
                        $('#userRole').val(response.role);
                        // Hide password fields when editing
                        $('#userPassword, #userConfirmPassword').closest('.form-group').hide();
                        // Remove the 'required' attribute from both password fields
                        $('#userPassword, #userConfirmPassword').removeAttr('required');
                    }
                });
            } else {
                // If adding new user, set form action and show password fields
                $('#addEditUserForm').attr('action', '/admin/users/store');
                $('#userPassword, #userConfirmPassword').closest('.form-group').show();
                // Add the 'required' attribute to both password fields
                $('#userPassword, #userConfirmPassword').attr('required', 'required');
            }
        });

        // Submit add/edit user form
        $('#addEditUserForm').on('submit', function(e) {
            e.preventDefault();
            var formData = $(this).serialize();

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                success: function(response) {
                    // Close the modal
                    $('#addEditUserModal').modal('hide');
                    // Reload the DataTable after add/edit
                    adminTable.ajax.reload();
                    // Show success message
                    toastr.success(response.message);
                },
                error: function(xhr, status, error) {
                    var errors = xhr.responseJSON.errors;
                    // Display validation errors
                    $.each(errors, function(key, value) {
                        toastr.error(value[0]);
                        // Optionally, you can also display the validation errors under the corresponding form fields
                        $('#' + key).closest('.form-group').append('<span class="text-danger">' + value[0] + '</span>');
                    });
                }
            });
        });

        // Delete user confirmation
        $(document).on('click', '.delete-user', function(){
            var userId = $(this).data('id');
            
            // Use SweetAlert2 for confirmation
            Swal.fire({
                title: 'Are you sure?',
                text: 'You will not be able to recover this user!',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    // If user confirms deletion, send AJAX request
                    $.ajax({
                        url: '/admin/users/delete/' + userId,
                        type: 'DELETE',
                        success: function(response) {
                            // Reload the DataTable after deletion
                            adminTable.ajax.reload();
                            // Show success message
                            toastr.success(response.message);
                        },
                        error: function(xhr, status, error) {
                            toastr.error('Failed to delete user.');
                        }
                    });
                }
            });
        });
    });
</script>
@endsection
