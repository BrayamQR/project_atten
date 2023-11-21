<div class="sidebar" id="sidebar">
    <div class="logo-content">
        <div class="logo">
            <i class="fa-solid fa-building-columns"></i>
            <h1 class="logo-name">Colégio <span>17 SETIEMBRE</span></h1>
        </div>
    </div>
    <ul class="nav-list">
        <li>
            <div class="icon-link">
                <a href="home.php">
                    <i class="fa-solid fa-house-chimney"></i>
                    <span class="link-name">Inicio</span>
                </a>
            </div>
            <ul class="sub-menu blank">
                <li>
                    <p class="submenu-name">Inicio</p>
                </li>
            </ul>
        </li>
        <?php
        if ($act_estudiante == 1) {
        ?>
            <li>
                <div class="icon-link">
                    <a href="student.php?rute=mstudent">
                        <i class="fa-solid fa-graduation-cap"></i>
                        <span class="link-name">Estudiantes</span>
                    </a>
                    <i class="fa-solid fa-chevron-down arrow"></i>
                </div>
                <ul class="sub-menu">

                    <li>
                        <p class="submenu-name">Estudiantes</p>
                    </li>
                    <li><a href="studentform.php?rute=astudent">Agregar Estudiante</a></li>

                    <li><a href="student.php?rute=mstudent">Ver Estudiantes</a></li>
                </ul>
            </li>
        <?php
        }
        if ($act_aula == 1) {
        ?>
            <li>
                <div class="icon-link">
                    <a href="classroom.php?rute=mclassroom">
                        <i class="fa-solid fa-chalkboard-user"></i>
                        <span class="link-name">Aulas</span>
                    </a>
                    <i class="fa-solid fa-chevron-down arrow"></i>
                </div>
                <ul class="sub-menu">
                    <li>
                        <p class="submenu-name">Aulas</p>
                    </li>

                    <li><a href="classroomform.php?rute=aclassroom">Agregar Aula</a></li>

                    <li><a href="classroom.php?rute=mclassroom">Ver Aulas</a></li>
                </ul>
            </li>
        <?php
        }
        if ($act_asistencia == 1) {
        ?>
            <li>
                <div class="icon-link">
                    <a href="income.php?rute=mincome">
                        <i class="fa-solid fa-list-check"></i>
                        <span class="link-name">Asistencia</span>
                    </a>
                    <i class="fa-solid fa-chevron-down arrow"></i>
                </div>
                <ul class="sub-menu">
                    <li>

                        <p class="submenu-name">Asistencia</p>
                    </li>

                    <li><a href="registerincome.php?rute=aincome">Marcar Asistencia</a></li>

                    <li><a href="income.php?rute=mincome">Ver Asistencias</a></li>
                </ul>
            </li>
        <?php
        }
        if ($act_actividad == 1) {
        ?>
            <li>
                <div class="icon-link">
                    <a href="activity.php?rute=mactivity">
                        <i class="fa-regular fa-calendar-days"></i>
                        <span class="link-name">Actividades</span>
                    </a>
                    <i class="fa-solid fa-chevron-down arrow"></i>
                </div>
                <ul class="sub-menu">
                    <li>
                        <p class="submenu-name">Actividades</p>
                    </li>
                    <li><a href="activityform.php?rute=aactivity">Agregar Actividad</a></li>

                    <li><a href="activity.php?rute=mactivity">Ver Actividades</a></li>
                </ul>
            </li>
        <?php
        }
        if ($act_usuarios == 1) {
        ?>
            <li>
                <div class="icon-link">
                    <a href="user.php?rute=muser">
                        <i class="fa-regular fa-circle-user"></i>
                        <span class="link-name">Usuarios</span>
                    </a>
                    <i class="fa-solid fa-chevron-down arrow"></i>
                </div>
                <ul class="sub-menu">
                    <li>
                        <p class="submenu-name">Usuarios</p>
                    </li>

                    <li><a href="userform.php?rute=auser">Agregar Usuario</a></li>

                    <li><a href="user.php?rute=muser">Ver Usuarios</a></li>
                </ul>
            </li>
        <?php
        }
        if ($act_perfiles == 1) {
        ?>
            <li>
                <div class="icon-link">
                    <a href="profile.php?rute=mprofile">
                        <i class="fa-regular fa-id-card"></i>
                        <span class="link-name">Perfiles</span>
                    </a>
                    <i class="fa-solid fa-chevron-down arrow"></i>
                </div>
                <ul class="sub-menu">
                    <li>
                        <p class="submenu-name">Perfiles</p>
                    </li>

                    <li><a href="profile.php?rute=mprofile">Ver perfiles</a></li>
                </ul>
            </li>
        <?php
        }
        ?>
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