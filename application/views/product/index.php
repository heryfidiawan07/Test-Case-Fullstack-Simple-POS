<?php $this->load->view('template/admin/header') ?>

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1><?= $title; ?></h1>
            <div class="section-header-breadcrumb">
                <?php if(can('product-store')): ?>
                    <a href="<?= base_url('product/create') ?>" class="btn btn-success">Create Product</a>
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
                                        <th>Photo</th>
                                        <th>Product Name</th>
                                        <th>Price</th>
                                        <th>Categories</th>
                                        <th>Supplier</th>
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

<script>
let dataTable = $('#datatable').DataTable({
    processing: true,
    serverSide: true,
    order: [],
    ajax: {
        url : base_url+'product/datatable',
        type: 'POST',
    },
    columnDefs: [
        {
            'targets': [1,5,7,8],
            'orderable': false,
        },
        {
            "targets": [7,8],
            "className": "text-center",
        }
    ],
    lengthMenu: [[10, 25, 50, 75, 100, -1], [10, 25, 50, 75, 100, 'All']],
})

$(document).on('click', '.delete', function(e) {
    let id = $(this).attr('data-id')
    swallConfirm({
        title: 'Delete Product ?',
        url: `${base_url}product/destroy/${id}`,
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