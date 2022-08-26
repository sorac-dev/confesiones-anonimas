<?php
require('./core/server.php');
?>
<div class="form-conf" id="escribir" style="display: none;">
    <form action="../core/publicar.php" method="post" enctype="multipart/form-data">
        <div class="form-bar">
            <label for="edad">Tengo</label>
            <input type="number" name="edad" id="" placeholder="Edad" require class="input-conf" min="13" max="99"/>
            <label for="genero">años y soy</label>
            <select name="genero" id="" require class="input-conf">
                <option value="2">anonimo</option>
                <option value="3">mujer</option>
                <option value="4">hombre</option>
            </select>
        </div>
        <div class="textarea-justify">
            <textarea class="form-textarea" name="confesion" id="" cols="30" rows="10" maxlength="420" placeholder="Escribe tu confesion..."></textarea>
        </div>
        <div class="form-bar">
        <input type="submit" value="Enviar" class="btn-form">
        </div>
    </form>
</div>