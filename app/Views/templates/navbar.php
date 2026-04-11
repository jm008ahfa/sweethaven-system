<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
        <a class="navbar-brand" href="<?= base_url('/dashboard') ?>">
            🍰 <span>Sweet</span> Haven
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('/dashboard') ?>">
                        <i class="fas fa-home"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('/products') ?>">
                        <i class="fas fa-cake-candles"></i> Products
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('/products/create') ?>">
                        <i class="fas fa-plus-circle"></i> Add Product
                    </a>
                </li>
            </ul>
            <div class="user-info">
                <i class="fas fa-user-circle"></i>
                <?= session()->get('name') ?>
                <a href="<?= base_url('/logout') ?>" class="btn btn-danger btn-sm ms-2">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>
    </div>
</nav>