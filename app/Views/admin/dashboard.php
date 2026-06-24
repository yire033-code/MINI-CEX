<?= view('admin/parts/head') ?>

<div class="app">
    <div class="overlay" id="overlay" onclick="closeSidebar()"></div>
    
    <?= view('admin/parts/sidebar') ?>
    <?= view('admin/parts/mobile_ui') ?>
    
    <main class="main">
        <?= view('admin/tabs/dashboard') ?>
        <?= view('admin/tabs/docentes') ?>
        <?= view('admin/tabs/alumnos') ?>
        <?= view('admin/tabs/evaluaciones') ?>
    </main>
</div>

<?= view('admin/parts/modals') ?>

<script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script>
<script src="<?= base_url('js/app.js') ?>"></script>
</body>
</html>
