<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Core</div>
                <a class="nav-link" href="index.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>
                <a class="nav-link" href="tables.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                    Rota Sheet
                </a>
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            <?php
            // Display the role name based on the role ID stored in the session
            echo htmlspecialchars($roles[$_SESSION['role']] ?? 'Unknown Role');
            ?>
            <a class="dropdown-item mt-2 text-danger" href="javascript:void(0);" onclick="logout()">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </nav>
</div>