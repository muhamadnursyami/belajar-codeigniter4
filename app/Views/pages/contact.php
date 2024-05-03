<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

<h1>Contact US</h1>


<?php foreach ($alamat as $a) : ?>
    <ul>
        <li><?= $a['tipe'] ?></li>
        <li><?= $a['alamat'] ?></li>
        <li><?= $a['kota'] ?></li>
    </ul>
<?php endforeach ?>


<?= $this->endSection() ?>