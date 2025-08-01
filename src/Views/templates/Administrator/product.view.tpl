<div class="container">
    <button class="back-btn" id="back_btn">Atras</button>
    <h1>Producto #{{productId}}</h1>

    <form action="index.php?page=Administrator-Products&mode={{mode}}&id={{productId}}" method="post" class="details">
        
    <h2>Detalles del pedido</h2>
    <div class="details-grid">
      <div>
        <label for="idped" class="label">ID Producto: </label>
        <input type="text" class="input" id="idped" name="id" value="{{productId}}" readonly>
         <input type="hidden" name="xsrtoken" value="{{xsrtoken}}" />
      </div>
      <div>
        <label for="fcped" class="label">Nombre Producto: </label>
        <input type="text" class="input" id="fcped" name="date" value="{{productName}}" readonly>
      </div>
      <div>
        <label for="clped" class="label">Descripción: </label>
        <input type="text" class="input" id="clped" name="client" value="{{productDescription}}" readonly>
      </div>
      <div>
       <label for="emped" class="label">Precio: </label>
        <input type="text" class="input" id="emped" name="email" value="{{productPrice}}" readonly>
      </div>
      <div>
        <label for="totped" class="label">Cantidad Disponible: </label>
        <input type="text" class="input" id="totped" name="total" value="{{productStock}}" readonly>
      </div>
      <div class="row my-2">
            <label for="estado" class="label">Estado:</label>
            {{foreach errors_estado}}
                <div class="error col-12">{{this}}</div>
             {{endfor errors_estado}}
        </div>
    </div>
    <div class="actions">
 <button type="submit" class="btn_submit" name="btnEnviar"{{if readonly}} hidden {{endif readonly}}>Guardar cambios</button>
    </div>
  </form>