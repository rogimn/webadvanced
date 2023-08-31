<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">

        <?php
            echo'
            <div class="image">
                <img
                    src="'.$prefix.'dist/img/user.webp"
                    class="img-circle elevation-2"
                    alt="User Image">
            </div>
            <!--<div class="info">
                <a 
                    href="../usuario" 
                    class="d-block a-usuario" 
                    title="Gerenciar usu&aacute;rios" 
                    data-toggle="tooltip" 
                    data-original-title="Gerenciar usu&aacute;rios">
                    <mark>Hi <span>' . $_SESSION['name'] . '!</span></mark>
                </a>
            </div>-->';
        ?>

        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" 
                role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="inicio" class="nav-link active">
                        <i class="nav-icon fas fa-home"></i>
                        <p>In&iacute;cio</p>
                    </a>
                </li>
                <li class="nav-item">
                    <div class="div-load-page d-none"></div>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
        
    </div>
    <!-- /.sidebar -->

</aside>