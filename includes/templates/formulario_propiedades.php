<fieldset>
  
        <legend>Información General</legend>

        <label for="titulo">Titulo:</label>
        <input type="text" name="propiedad[titulo]" id="titulo" placeholder="Titulo de la Propiedad" value="<?php echo s($propiedad->titulo); ?>">
        
        
        <label for="precio">Precio:</label>
        <input type="number" name="propiedad[precio]" id="precio" placeholder="Precio de la Propiedad" value="<?php echo s($propiedad->precio); ?>">

        <label for="imagen">Imagen:</label>
        <input type="file" name="propiedad[imagen]" id="imagen" accept="image/jpeg, image/png">
        <?php if($propiedad->imagen){ ?>
         
         <div style="width: 20rem;">
         <img src="/imagenesBienesRaices/<?php echo $propiedad->imagen ?>" alt="" class="imagen-tabla">
         </div>
         
        <?php } ?>    

        <label for="descripcion">Descripción: </label>
        <textarea id="descripcion" name="propiedad[descripcion]"><?php echo s($propiedad->descripcion); ?></textarea>

    </fieldset>

    <fieldset>
        <legend>Información de la Propiedad</legend>

        <label for="habitaciones">Habitaciones:</label>
        <input type="number" name="propiedad[habitaciones]" id="habitaciones" placeholder="Ej: 3" min="1" max="9" value="<?php echo s($propiedad->habitaciones); ?>">

        <label for="wc">Baños:</label>
        <input type="number" name="propiedad[wc]" id="wc" placeholder="Ej: 3" min="1" max="9" value="<?php echo s($propiedad->wc); ?>">

        <label for="estacionamiento">Estacionamiento:</label>
        <input type="number" name="propiedad[estacionamiento]" id="estacionamiento" placeholder="Ej: 3" min="1" max="9" value="<?php echo s($propiedad->estacionamiento); ?>">

    </fieldset>

    <fieldset>
        <legend>Vendedor</legend>
        
        <label for="vendedor">Seleccione el Vendedor de la Propiedad</label>

        <select name="propiedad[vendedorId]" id="vendedor">
            <option selected value="">---Seleccione---</option>

            <?php foreach($vendedores as $vendedor){ ?>
            <option <?php echo $propiedad->vendedorId === $vendedor->id ? 'selected' : ''; ?> value="<?php echo s($vendedor->id); ?>" >
              <?php echo s($vendedor->nombre) . " " . s($vendedor->apellido);?>
            </option>
            <?php } ?>

        </select>
      
    </fieldset>