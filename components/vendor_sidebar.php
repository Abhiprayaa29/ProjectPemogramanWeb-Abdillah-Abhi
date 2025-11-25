<div class="col-lg-3">
    <div class="card border-0 shadow-sm rounded-4 p-3 sticky-top" style="top: 100px;">
        <div class="list-group list-group-flush">
            <a href="dashboard_vendor.php" class="list-group-item list-group-item-action border-0 rounded-3 mb-1 <?php echo ($currentPage == 'dashboard') ? 'active bg-primary bg-opacity-10 text-primary fw-bold' : 'text-muted'; ?>">
                <i class="bi bi-speedometer2 me-2"></i> Ringkasan
            </a>
            <a href="vendor_packages.php" class="list-group-item list-group-item-action border-0 rounded-3 mb-1 <?php echo ($currentPage == 'packages') ? 'active bg-primary bg-opacity-10 text-primary fw-bold' : 'text-muted'; ?>">
                <i class="bi bi-box-seam me-2"></i> Paket Harga
            </a>
            <a href="portofolio.php" class="list-group-item list-group-item-action border-0 rounded-3 mb-1 <?php echo ($currentPage == 'porto') ? 'active bg-primary bg-opacity-10 text-primary fw-bold' : 'text-muted'; ?>">
                <i class="bi bi-images me-2"></i> Portofolio
            </a>
            <a href="vendor_settings.php" class="list-group-item list-group-item-action border-0 rounded-3 <?php echo ($currentPage == 'settings') ? 'active bg-primary bg-opacity-10 text-primary fw-bold' : 'text-muted'; ?>">
                <i class="bi bi-gear me-2"></i> Pengaturan
            </a>
        </div>
    </div>
</div>