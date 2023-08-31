<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                <i class="fas fa-bars"></i>
            </a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link">
                <mark>Hi <span><?= $_SESSION['name']; ?>!</span></mark>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link a-logout-app" href="#"
                title="Sair do app" role="button"
                data-toggle="tooltip" data-original-title="Sair do app">
                <i class="fas fa-sign-out-alt"></i>
            </a>
        </li>
    </ul>
</nav>
<!-- /.navbar -->