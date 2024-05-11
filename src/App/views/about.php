<!-- Header -->
<?php include $this->resolve("partials/_header.php") ?>
<!-- Body -->
<!-- Start Main Content Area -->
<section class="container mx-auto mt-12 p-4 bg-white shadow-md border border-gray-200 rounded">
    <!-- Page Title -->
    <h3>About Page</h3>

    <hr />

    <!-- Escaping Data -->
    <p>Escaping Data: </p>
    <?= escape($iAmInDanger) ?>
</section>
<!-- End Main Content Area -->

<!-- Footer -->
<?php include $this->resolve("partials/_footer.php") ?>
</body>
</hmtl>