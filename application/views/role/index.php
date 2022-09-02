<?php $this->load->view('template/admin/header') ?>

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1><?= $title; ?></h1>
            <div class="section-header-breadcrumb">
                <?php if(can('role-store')): ?>
                    <button id="create" class="btn btn-primary">Create Role</button>
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
                                        <th>Description</th>
                                        <th>Permissions</th>
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
<?php $this->load->view('role/form') ?>

<script>
let dataTable = $('#datatable').DataTable({
    processing: true,
    serverSide: true,
    order: [],
    ajax: {
        url : base_url+'role/datatable',
        type: 'POST',
    },
    columnDefs: [
        {
            'targets': [5,6],
            'orderable': false,
        },
        {
            "targets": [5,6],
            "className": "text-center",
        }
    ],
    lengthMenu: [[10, 25, 50, 75, 100, -1], [10, 25, 50, 75, 100, 'All']],
})

$(document).on('submit', '#form', function(e) {
    e.preventDefault()

    let formData = new FormData()
    formData.append('name', $('#name').val())
    formData.append('description', $('#description').val())
    
    $('.permissions').each(function(){
        if($(this).is(":checked")) {
            formData.append('permissions[]', $(this).val())
        }
    })

    swallConfirm({
        title: 'Save Role ?',
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
    $('#modal-title').text('CREATE ROLE')
    $('#form').attr('action', `${base_url}role/store`)
})

$(document).on('click', '.edit', function(e) {
    let id = $(this).attr('data-id')
    $('#form').attr('action', `${base_url}role/update/${id}`)
    $('#modal-title').text('UPDATE ROLE')
    $.getJSON(`${base_url}role/show/${id}`, function(res) {
        $('#name').val(res.data.role.name)
        $('#description').val(res.data.role.description)
        $.each(res.data.permissions, function(idx, val) {
            // console.log('val',val)
            $(`#${val.name}`).prop({checked: true})
        })
    })
    $('#modal-form').modal('show')
})

$(document).on('click', '.delete', function(e) {
    let id = $(this).attr('data-id')
    swallConfirm({
        title: 'Delete Role ?',
        url: `${base_url}role/destroy/${id}`,
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