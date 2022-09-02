<?php $this->load->view('template/admin/header') ?>

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1><?= $title; ?></h1>
            <div class="section-header-breadcrumb">
            </div>
        </div>
        <div class="section-body">
            <div class="row rounded border">
                <div class="col-md-5 rounded border p-0">
                    <img src="<?= base_url('storage/products/'.$product->photo) ?>" alt="" style="width: 100%; max-width: 100%">
                </div>
                <div class="col-md-7 py-3">
                    <h3><?= $product->name ?></h3>
                    <h6>Rp <?= number_format($product->price) ?></h6>
                    <p>Stock: <?= $product->qty_stock ?></p>
                    <p><i><?= $product->detail ?></i></p>
                    <div class="border-top border-bottom mb-3">
                        <?= $product->description ?>
                    </div>
                    <?php foreach($category as $row): ?>
                        <span class="bg-success text-white mx-1 px-2 py-1 rounded"><?= $row->name ?></span>
                    <?php endforeach ?>
                    <p class="mt-3"><i><?= $supplier->name ?></i></p>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
</script>
<?php $this->load->view('template/footer') ?>