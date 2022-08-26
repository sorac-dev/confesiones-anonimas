<?php
require('core/server.php');
?>
<?php
if (isset($_SESSION['logeado']) != "SI") {
    exit();
} else {
    #Validacion de rangos
    $mi_id    = $_SESSION['id'];
    $consulta = $conn->query('SELECT rank FROM equipo WHERE id = "' . $mi_id . '"');
    while ($datos = $consulta->fetch()) {
        $rangouser = $datos['rank'];
    }
    if ($rangouser == "1") {
        header("Location: dashboard");
    }
    if ($rangouser == "2") {
        header("Location: dashboard");
    }
    #Cargar html
    include('templates/head.php');
    include('templates/navbar.php');

    #Consultar configuracion de la pagina web
    $consulta = $conn->query("SELECT * FROM config");
    $data = $consulta->fetch();

    #Datos
    $nameweb = $data['nameweb'];
    $dscr = $data['descripcion'];
    $i_og = $data['image_og'];
    $i_logo = $data['logo'];
    $msg_mtni = $data['msg_mtni'];

    if ($data['mantenimiento'] == "1") {
        $m_estado = "Activado";
    }
    if ($data['mantenimiento'] == "0") {
        $m_estado = "Desactivado";
    }
    if ($data['confesiones'] == "1") {
        $c_estado = "Activadas";
    }
    if ($data['confesiones'] == "0") {
        $c_estado = "Desactivadas";
    }
?>
<div class="container-fluid pt-4 px-4">
   <div class="row h-100 align-items-center justify-content-center">
      <div class="col-sm-12 col-xl-6">
         <div class="bg-light rounded p-4 p-sm-5 my-4">
         <div class="d-flex align-items-center justify-content-between mb-3">
                    <h3 class="text-primary"><i class="bi bi-globe"></i> CONFIGURACION DEL SITIO</h3>
                </div>
            <form method="POST" action="system/update.php">
               <div class="form-floating mb-3">
                  <input type="text" class="form-control" id="floatingInput" placeholder="Nombre del sitio" value="<?=$nameweb?>" name="nameweb">
                  <label for="floatingInput">Nombre del sitio web</label>
               </div>
               <div class="form-floating mb-3">
                   <textarea name="descripcion" cols="30" rows="10" class="form-control" id="floatingInput"><?=$dscr?></textarea>
                  <label for="floatingInput">Descripción del sitio</label>
               </div>
               <div class="form-floating mb-3">
                  <input type="text" class="form-control" id="floatingInput" placeholder="URL logo" name="i_logo" value="<?=$i_logo?>">
                  <label for="floatingInput">Logo del sitio</label>
               </div>
               <div class="form-floating mb-3">
                  <input type="text" class="form-control" id="floatingInput" placeholder="URL og" name="i_og" value="<?=$i_og?>">
                  <label for="floatingInput">Banner OG del sitio</label>
               </div>
               <div class="form-floating mb-3">
               <select class="form-select form-select-sm mb-3" aria-label=".form-select-sm example" name="mantenimiento">
                        <option value="0">Desactivado</option>
                        <option value="1">Activado</option>
                </select>
                <label for="floatingInput">Modo de mantenimiento <b>(<?=$m_estado?>)</b></label>
               </div>
               <div class="form-floating mb-3">
                   <textarea name="msg_mtni" cols="30" rows="10" class="form-control" id="floatingInput"><?=$msg_mtni?></textarea>
                  <label for="floatingInput">Mensaje del mantenimiento</label>
               </div>
               <div class="form-floating mb-3">
               <select class="form-select form-select-sm mb-3" aria-label=".form-select-sm example" name="confesiones">
                        <option value="1">Activadas</option>
                        <option value="0">Desactivadas</option>
                </select>
                <label for="floatingInput">Estado de las confesiones <b>(<?=$c_estado?>)</b></label>
               </div>
               <button type="submit" class="btn btn-primary py-3 w-100 mb-4">Actualizar</button>
            </form>
         </div>
      </div>
   </div>
</div>
<?php
}
?>
<?php
include('templates/footer.php');
?>