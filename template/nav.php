<nav>
    <div class="navbar">
        <div class="logo">
            <h1>PHP CRUD</h1>
        </div>
        <ul class="nav-links">
            <li><a href="index.php">Home</a></li>
            <li><a href="cadastro.php">Cadastrar</a></li>
            <li class="dropdown">
                <div id="dropdown-toggle" class="dropbtn">
                    <i class="fas fa-user-circle user-icon"></i>
                    <span class="nav-dropdown-link">Olá, <?php echo $_SESSION['usuario']; ?></span>
                    <i class="fas fa-chevron-down chevron-down-icon"></i>
                </div>
                <div class="dropdown-content">
                    <a href="perfil.php">Perfil</a>
                    <a href="backend/service/logout_backend.php">Sair</a>
                </div>
            </li>
        </ul>
    </div>
</nav>