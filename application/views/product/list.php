<?php $this->load->view('template/admin/header') ?>

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1><?= $title; ?></h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-md-3 px-1">
                    <div class="card pb-3">
                        <div class="img-frame mb-2 text-center" style="height: 150px; overflow: hidden; display: flex; justify-content: center;">
                            <img src="<?= base_url('assets/majoo/standard_repo.png') ?>" alt="majoo" class="product-img" style="max-width: 100%;">
                        </div>
                        <h5 class="text-center">Title Product</h5>
                        <p class="text-center mt-2 mb-0">Rp<b class="ml-2">1.500.000</b></p>
                        <div class="p-3 mb-4" style="height: 9em; overflow-y: hidden;">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vero necessitatibus dicta molestiae rem! Voluptate obcaecati ipsum, tempore quia asperiores minus soluta totam consequuntur ea? Neque illo labore dolorum commodi saepe.
                        </div>
                        <div class="text-center">
                            <button class="btn btn-success btn-sm px-3">Beli</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 px-1">
                    <div class="card pb-3">
                        <div class="img-frame mb-2 text-center" style="height: 150px; overflow: hidden; display: flex; justify-content: center;">
                            <img src="<?= base_url('assets/majoo/paket-advance.png') ?>" alt="majoo" class="product-img" style="max-width: 100%;">
                        </div>
                        <h5 class="text-center">Title Product</h5>
                        <p class="text-center mt-2 mb-0">Rp<b class="ml-2">1.500.000</b></p>
                        <div class="p-3 mb-4" style="height: 9em; overflow-y: hidden;">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vero necessitatibus dicta molestiae rem! Voluptate obcaecati ipsum, tempore quia asperiores minus soluta totam consequuntur ea? Neque illo labore dolorum commodi saepe.
                        </div>
                        <div class="text-center">
                            <button class="btn btn-success btn-sm px-3">Beli</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 px-1">
                    <div class="card pb-3">
                        <div class="img-frame mb-2 text-center" style="height: 150px; overflow: hidden; display: flex; justify-content: center;">
                            <img src="<?= base_url('assets/majoo/paket-lifestyle.png') ?>" alt="majoo" class="product-img" style="max-width: 100%;">
                        </div>
                        <h5 class="text-center">Title Product</h5>
                        <p class="text-center mt-2 mb-0">Rp<b class="ml-2">1.500.000</b></p>
                        <div class="p-3 mb-4" style="height: 9em; overflow-y: hidden;">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vero necessitatibus dicta molestiae rem! Voluptate obcaecati ipsum, tempore quia asperiores minus soluta totam consequuntur ea? Neque illo labore dolorum commodi saepe.
                        </div>
                        <div class="text-center">
                            <button class="btn btn-success btn-sm px-3">Beli</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 px-1">
                    <div class="card pb-3">
                        <div class="img-frame mb-2 text-center" style="height: 150px; overflow: hidden; display: flex; justify-content: center;">
                            <img src="<?= base_url('assets/majoo/paket-desktop.png') ?>" alt="majoo" class="product-img" style="max-width: 100%;">
                        </div>
                        <h5 class="text-center">Title Product</h5>
                        <p class="text-center mt-2 mb-0">Rp<b class="ml-2">1.500.000</b></p>
                        <div class="p-3 mb-4" style="height: 9em; overflow-y: hidden;">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vero necessitatibus dicta molestiae rem! Voluptate obcaecati ipsum, tempore quia asperiores minus soluta totam consequuntur ea? Neque illo labore dolorum commodi saepe.
                        </div>
                        <div class="text-center">
                            <button class="btn btn-success btn-sm px-3">Beli</button>
                        </div>
                    </div>
                </div>
                <?php foreach($products as $row): ?>
                    <div class="col-md-3 px-1">
                        <div class="card pb-3">
                            <div class="img-frame mb-2 text-center" style="height: 150px; overflow: hidden; display: flex; justify-content: center;">
                                <img src="<?= base_url('storage/products/'.$row->photo); ?>" alt="<?= $row->name ?>" class="product-img" style="max-width: 100%;">
                            </div>
                            <h5 class="text-center"><?= $row->name ?></h5>
                            <p class="text-center mt-2 mb-0">Rp<b class="ml-2"><?= number_format($row->price) ?></b></p>
                            <div class="p-3 mb-4" style="height: 9em; overflow-y: hidden;">
                                <?= $row->detail ?>
                            </div>
                            <div class="text-center">
                                <button class="btn btn-success btn-sm px-3">Beli</button>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    </section>
</div>

<script>
</script>
<?php $this->load->view('template/footer') ?>