<?php $this->load->view('template/admin/header') ?>

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1><?= $title; ?></h1>
            <div class="section-header-breadcrumb">
                <?php if(can('product-index')): ?>
                    <a href="<?= base_url('product') ?>" class="btn btn-secondary">Back</a>
                <?php endif; ?>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card p-3">
                        <form id="form" action="<?= base_url('product/update/'.$product->id) ?>" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="name">Product Name<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" value="<?= $product->name ?>" autocomplete="off" required>
                            </div>
                            <div class="form-group">
                                <label for="detail">Detail<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="detail" name="detail" value="<?= $product->detail ?>" autocomplete="off" required>
                            </div>
                            <div class="form-group">
                                <label for="price">Price<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="price" name="price" value="<?= $product->price ?>" autocomplete="off" required>
                            </div>
                            <div class="form-group">
                                <label for="qty_stock">Qty Stock<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="qty_stock" name="qty_stock" value="<?= $product->qty_stock ?>" autocomplete="off" required>
                            </div>
                            <div class="form-group">
                                <label for="supplier_id">Supplier<span class="text-danger">*</span></label>
                                <select class="form-control" id="supplier_id" name="supplier_id">
                                    <option value="">Select Supplier</option>
                                    <?php foreach ($supplier as $row): ?>
                                        <option <?= $product->supplier_id == $row->id ? 'selected' : '' ?> value="<?= $row->id ?>"><?= $row->name ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="description">Description<span class="text-danger">*</span></label>
                                <textarea class="form-control description" id="description" name="description" required><?= $product->description ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="categories">Category</label>
                                <select class="js-example-basic-multiple form-control" id="categories" name="categories[]" multiple="multiple" style="max-width: 100%;">
                                    <?php foreach ($categories as $row): ?>
                                        <option <?= in_array($row->id, $product_category) ? 'selected' : '' ?> value="<?= $row->id ?>"><?= $row->name ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label id="photo-label">Photo</label>
                                <input type="file" class="form-control dropify" id="photo" name="photo" data-height="285" data-max-file-size="3M" data-default-file="<?= base_url('storage/products/'.$product->photo) ?>" accept="image/png, image/jpeg" style="height: 285px;">
                            </div>
                            <p id="upload-message"></p>
                            <div class="progress mb-5">
                                <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success w-100">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
$(document).ready(function() {
    $('.dropify').dropify({
        messages: {
            default: 'Drag or drop for choose image',
            replace: 'change image',
            remove: 'delete image',
            error: 'error'
        }
    })
})

$(document).on('submit', '#form', function(e) {
    e.preventDefault()

    let formData = new FormData()
    formData.append('name', $('#name').val())
    formData.append('price', $('#price').val())
    formData.append('qty_stock', $('#qty_stock').val())
    formData.append('detail', $('#detail').val())
    formData.append('supplier_id', $('#supplier_id').val())
    formData.append('description', $('#description').val())
    formData.append('categories[]', $('#categories').val())
    formData.append('photo', $('#photo')[0].files[0])

    swallConfirm({
        title: 'Save Product ?',
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
                        $('#form')[0].reset()
                        $('.dropify-clear').trigger('click')
                        $('#categories').val(null).trigger('change')
                        $('.description').summernote('reset')
                        $('.progress').hide()
                    }
                })
            }
        }
    })
})

$('.progress').hide()
$('#upload-message').hide()
$(document).on('change', '#photo', function() {
    $('#upload-message').hide()
    $('.progress').show()
    progress()
})

function progress() {
    let formData = new FormData()
    formData.append('photo', $('#photo')[0].files[0])

    $.ajax({
        url: `${base_url}/product/temporary`,
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        dataType: "json",
        beforeSend: function() {
            console.log('beforeSend')
            $('.progress-bar').attr('aria-valuenow', '0')
            $('.progress-bar').css('width', '0%')
            $('.progress-bar').text(0+'%')
        },
        uploadProgress: function(event, position, total, percentComplete) {
            console.log('uploadProgress event', event)
            console.log('uploadProgress position', position)
            console.log('uploadProgress total', total)
            console.log('uploadProgress percentComplete', percentComplete)

            $('.progress-bar').attr('aria-valuenow', percentComplete)
            $('.progress-bar').css('width', `${percentComplete}%`)
            $('.progress-bar').text(`${percentComplete}%`)
        },
        complete: function(xhr) {
            console.log('complete xhr', xhr)
            $('.progress-bar').attr('aria-valuenow', '100')
            $('.progress-bar').css('width', `100%`)
            $('.progress-bar').text(`100%`)
        },
        success: function(response){
            console.log('success',response)
            $('#upload-message').show()
            $('#upload-message').text(response.message)
            $('#upload-message').attr('class','text-success text-center')
        }, error: function(error) {
            $('#upload-message').show()
            $('#upload-message').text(error.statusText)
            $('#upload-message').attr('class','text-danger text-center')
        }
    })
}

$(document).on('keyup', '#price', async function() {
    this.value.replace(/\D/g,'')
    $(this).val(await formatRupiah($(this).val()))
})

$(document).on('keyup', '#qty_stock', async function() {
    this.value.replace(/\D/g,'')
    $(this).val(await formatRupiah($(this).val()))
})

function formatRupiah(angka) {
	let numbStr = angka.replace(/[^,\d]/g, '').toString(),
	split       = numbStr.split(','),
	sisa        = split[0].length % 3,
	rupiah      = split[0].substr(0, sisa),
	ribuan      = split[0].substr(sisa).match(/\d{3}/gi)
 
	// tambahkan titik jika yang di input sudah menjadi angka ribuan
	if(ribuan){
		separator = sisa ? '.' : ''
		rupiah += separator + ribuan.join('.')
	}
 
	return rupiah
}
</script>
<?php $this->load->view('template/footer') ?>