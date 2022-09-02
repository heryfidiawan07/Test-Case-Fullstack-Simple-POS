<?php $this->load->view('template/admin/header') ?>

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1><?= $title; ?></h1>
            <div class="section-header-breadcrumb">
                <?php if(can('user-store')): ?>
                    <button id="create" class="btn btn-primary">Create User</button>
                <?php endif; ?>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card p-3">
                        <div class="table-responsive scrollbar-custom">
                            <table id="datatable" class="table table-hover small w-100">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Created at</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php $this->load->view('user/form') ?>

<script>
let dataTable = $('#datatable').DataTable({
    processing: true,
    serverSide: true,
    order: [],
    ajax: {
        url : base_url+'user/datatable',
        type: 'POST',
    },
    columnDefs: [
        {
            'targets': [6,7],
            'orderable': false,
        },
        {
            "targets": [6,7],
            "className": "text-center",
        }
    ],
    lengthMenu: [[10, 25, 50, 75, 100, -1], [10, 25, 50, 75, 100, 'All']],
})

$(document).on('submit', '#form', function(e) {
    e.preventDefault()

    let formData = new FormData()
    formData.append('name', $('#name').val())
    formData.append('username', $('#username').val())
    formData.append('email', $('#email').val())
    formData.append('password', $('#password').val())
    formData.append('role_id', $('#role_id').val())

    swallConfirm({
        title: 'Save User ?',
        url: $(this).attr('action'),
        data: formData,
    })
    .then((result) => {
        console.log('result',result)
        if (result.isConfirmed) {
            if (!result.value.status) {
                swal.fire('Opss...!', result.value.message, 'warning')
            }
            if (result.value.status) {
                swal.fire('Good job !', result.value.message, 'success')
                .then((result) => {
                    if (result.isConfirmed || result.isDismissed) {
                        $('#modal-form').modal('hide')
                        $('#form')[0].reset()
                        dataTable.ajax.reload()
                    }
                })
            }
        }
    })
})

$(document).on('click', '#create', function(e) {
    $('#modal-form').modal('show')
    $('#modal-title').text('CREATE USER')
    $('#form').attr('action', `${base_url}user/store`)
})

$(document).on('click', '.edit', function(e) {
    let id = $(this).attr('data-id')
    $('#form').attr('action', `${base_url}user/update/${id}`)
    $('#modal-title').text('UPDATE USER')
    $.getJSON(`${base_url}user/show/${id}`, function(res) {
        $('#name').val(res.data.name)
        $('#username').val(res.data.username)
        $('#email').val(res.data.email)
        $('#role_id').val(res.data.role_id)
    })
    $('#modal-form').modal('show')
})

$(document).on('click', '.delete', function(e) {
    let id = $(this).attr('data-id')
    swallConfirm({
        title: 'Delete User ?',
        url: `${base_url}user/destroy/${id}`,
        data: new FormData(),
    })
    .then((result) => {
        console.log('result',result)
        if (result.isConfirmed) {
            if (!result.value.status) {
                swal.fire('Opss...!', result.value.message, 'warning')
            }
            if (result.value.status) {
                swal.fire('Good job !', result.value.message, 'success')
                .then((result) => {
                    if (result.isConfirmed || result.isDismissed) {
                        dataTable.ajax.reload()
                    }
                })
            }
        }
    })
})
</script>
<?php $this->load->view('template/footer') ?>