<?php $this->load->view('template/admin/header') ?>

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1><?= $title; ?></h1>
            <div class="section-header-breadcrumb">
                <?php if(can('category-store')): ?>
                    <button id="create" class="btn btn-primary">Create Category</button>
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
                                        <th>Category Name</th>
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
<?php $this->load->view('category/form') ?>

<script>
let dataTable = $('#datatable').DataTable({
    processing: true,
    serverSide: true,
    order: [],
    ajax: {
        url : base_url+'category/datatable',
        type: 'POST',
    },
    columnDefs: [
        {
            'targets': [3,4],
            'orderable': false,
        },
        {
            "targets": [3,4],
            "className": "text-center",
        }
    ],
    lengthMenu: [[10, 25, 50, 75, 100, -1], [10, 25, 50, 75, 100, 'All']],
})

$(document).on('submit', '#form', function(e) {
    e.preventDefault()

    let formData = new FormData()
    formData.append('name', $('#name').val())

    swallConfirm({
        title: 'Save Category ?',
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
    $('#modal-title').text('CREATE CATEGORY')
    $('#form').attr('action', `${base_url}category/store`)
})

$(document).on('click', '.edit', function(e) {
    let id = $(this).attr('data-id')
    $('#form').attr('action', `${base_url}category/update/${id}`)
    $('#modal-title').text('UPDATE CATEGORY')
    $.getJSON(`${base_url}category/show/${id}`, function(res) {
        $('#name').val(res.data.name)
    })
    $('#modal-form').modal('show')
})

$(document).on('click', '.delete', function(e) {
    let id = $(this).attr('data-id')
    swallConfirm({
        title: 'Delete Category ?',
        url: `${base_url}category/destroy/${id}`,
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