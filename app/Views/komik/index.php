<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

<div class="container">
    <div class="row">
        <div class="col">
            <?php if (session()->getFlashdata()) : ?>

                <div class="alert alert-success mt-4" role="alert">
                    <?= session()->getFlashdata('pesan') ?>
                </div>

            <?php endif; ?>
            <h1 class="mb-3">Daftar Komik</h1>
            <a href="/komik/create" class="btn btn-primary">Tambah data</a>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Sampul</th>
                        <th scope="col">Judul</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <?php $i = 1 ?>
                <?php foreach ($komik as $dataKomik) : ?>
                    <tbody>
                        <tr>
                            <th scope="row">
                                <?= $i++ ?>
                            </th>
                            <td><img src="/img/<?= $dataKomik['sampul'] ?>" alt="" class="sampul"></td>
                            <td><?= $dataKomik['judul'] ?></td>
                            <td><a href="/komik/<?= $dataKomik['slug'] ?>" class="btn btn-success">Detail</a></td>
                        </tr>

                    </tbody>
                <?php endforeach;  ?>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>