<?php
require('core/server.php');
include('templates/head.php');
?>
<?php
if (isset($_SESSION['logeado']) != "SI") {
    echo'
    <div class="container-fluid">
    <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
        <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
            <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h3 class="text-primary"><i class="fa fa-hashtag me-2"></i>ADMINCONF</h3>
                    <h3>Registrate</h3>
                </div>
                <form action="system/register.php" method="POST" enctype="" name="login">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingInput" placeholder="Usiario" name="username" autocomplete="none">
                        <label for="floatingInput">Usuario</label>
                    </div>
                    <div class="form-floating mb-4">
                        <input type="password" class="form-control" id="floatingPassword" placeholder="Contraseña" name="password">
                        <label for="floatingPassword">Contraseña</label>
                    </div>
                    <div class="form-floating mb-4">
                        <input type="password" class="form-control" id="floatingPassword" placeholder="Repite contraseña" name="repeat-password">
                        <label for="floatingPassword">Repite Contraseña</label>
                    </div>
                    <div class="form-floating mb-4">
                        <input type="text" class="form-control" id="floatingIdInvitacion" placeholder="Codígo de tu invitacion" name="id-invitacion">
                        <label for="floatingPassword">Codigo de invitacion</label>
                    </div>
                    <button type="submit" class="btn btn-primary py-3 w-100 mb-4">Sign In</button>
                </form>
            </div>
        </div>
    </div>
</div>
    ';
} else {
    echo "<script>location.href = 'index';</script>";
}
?>
<?php include('templates/footer.php'); ?>