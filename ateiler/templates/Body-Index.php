<?php
require_once('./server/server.config.php');

#Consultar los post a la base de datos.
$query = $conn->query("SELECT * FROM productos ORDER BY productos.id DESC LIMIT 8");

?>
<div class="container parent j-center">
    <?php 
    while ($data = $query->fetch()) { //Obtener datos
    $cat_id = $data['categoria'];
        #Vamos a obtener el genero
        $consulta = $conn->query("SELECT * FROM categorias WHERE id = '{$cat_id}'");
        $row = $consulta->fetch();
    ?>
        <div class="post-container" id-producto="<?=$data['producto_id']?>">
            <div class="post-body">
                <div class="post-head">
                    <span class="j-center">Categoria - <?=$row['genero']?></span>
                </div>
                <div class="post-modelo">
                    <img src="images/ropa2.jpg" class="post-foto">
                    <div class="post-texto">
                        <ul>
                            <li>Talla: <?=$data['tallas']?></li>
                            <li class="fright">ID: <?=$data['producto_id']?></li>
                        </ul>
                        <button class="post-btn"><i class="bi bi-handbag"></i> Hacer pedido</button>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
</div>