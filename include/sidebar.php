<div class="sidebar" id="sidebar">
    <div class="logo-content">
        <div class="logo">
            <i class="fa-solid fa-screwdriver-wrench"></i>
            <h1 class="logo-name">Ferretería</h1>
        </div>
        <i class="fa-solid fa-bars btn-menu" id="btn-menu"></i>
    </div>
    <ul class="nav-list">
        <li>

            <a href="home.php">
                <i class="fa-solid fa-house-chimney"></i>
                <span class="link-name">Inicio</span>
            </a>
            <ul class="sub-menu blank">
                <li>
                    <p class="submenu-name">Inicio</p>
                </li>
            </ul>
        </li>
        <li>
            <div class="icon-link">
                <a href="#">
                    <i class="fa-solid fa-graduation-cap"></i>
                    <span class="link-name">Estudiantes</span>
                </a>
                <i class="fa-solid fa-chevron-down arrow"></i>
            </div>
            <ul class="sub-menu">
                <li>
                    <p class="submenu-name">Estudiantes</p>
                </li>
                <li><a href="studentform.php">Agregar Estudiante</a></li>
                <li><a href="student.php">Ver Estudiantes</a></li>
            </ul>
        </li>

        <li>
            <div class="icon-link">
                <a href="#">
                    <i class="fa-solid fa-list-check"></i>
                    <span class="link-name">Asistencia</span>
                </a>
                <i class="fa-solid fa-chevron-down arrow"></i>
            </div>
            <ul class="sub-menu">
                <li>
                    <p class="submenu-name">Asistencia</p>
                </li>
                <li><a href="registerattendance.php">Marcar Asistencia</a></li>
                <li><a href="#">Ver Asistencias</a></li>
            </ul>
        </li>
        <li>
            <div class="icon-link">
                <a href="#">
                    <i class="fa-regular fa-calendar-days"></i>
                    <span class="link-name">Actividades</span>
                </a>
                <i class="fa-solid fa-chevron-down arrow"></i>
            </div>
            <ul class="sub-menu">
                <li>
                    <p class="submenu-name">Actividades</p>
                </li>
                <li><a href="activityform.php">Agregar Actividad</a></li>
                <li><a href="activity.php">Ver Actividades</a></li>
            </ul>
        </li>
        <li>
            <div class="icon-link">
                <a href="#">
                    <i class="fa-regular fa-calendar-xmark"></i>
                    <span class="link-name">Feriados</span>
                </a>
                <i class="fa-solid fa-chevron-down arrow"></i>
            </div>
            <ul class="sub-menu">
                <li>
                    <p class="submenu-name">Feriados</p>
                </li>
                <li><a href="#">Agregar Feriado</a></li>
                <li><a href="#">Ver Feriados</a></li>
            </ul>
        </li>
        <li>
            <div class="icon-link">
                <a href="#">
                    <i class="fa-solid fa-users"></i>
                    <span class="link-name">Usuarios</span>
                </a>
                <i class="fa-solid fa-chevron-down arrow"></i>
            </div>
            <ul class="sub-menu">
                <li>
                    <p class="submenu-name">Usuarios</p>
                </li>
                <li><a href="userform.php">Agregar Usuario</a></li>
                <li><a href="user.php">Ver Usuarios</a></li>
            </ul>
        </li>
    </ul>
    <div class="profile-content">
        <div class="profile-group">
            <div class="profile">
                <div class="profile-details">
                    <img src="../img/user.png" alt="">
                    <div class="name-user">
                        <h2 class="name"><?php echo $user_nombre; ?></h2>
                        <p class="position"><?php echo $user_rol; ?></p>
                    </div>
                </div>
                <a class='fa-solid fa-right-from-bracket btn-exit' id="log-out" href="../config/exit.php"></a>
            </div>
        </div>
    </div>
</div>