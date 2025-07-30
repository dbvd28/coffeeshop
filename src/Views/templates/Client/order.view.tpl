<div class="container">
    <button class="back-btn" id="back_btn">Atras</button>
    <h1>Pedido #{{id}}</h1>
    <h2>Detalles del pedido</h2>
    <div class="details-grid">
      <div>
        <label class="label">ID Pedido: </label>
        <input type="text" class="input" value="{{id}}" readonly>
      </div>
      <div>
        <label class="label">Fecha pedido: </label>
        <input type="text" class="input" value="{{fecha}}" readonly>
      </div>
      <div>
        <label class="label">Total a pagar: </label>
        <input type="text" class="input" value="{{total}}" readonly>
      </div>
      <div>
        <label class="label">Estado:</label>
        <input type="text" class="input" value="{{estado}}" readonly>
      </div>
    </div>
    <h2>Productos comprados</h2>
    <table>
      <thead>
        <tr>
          <th>Producto</th>
          <th>Cantidad</th>
          <th>Precio</th>
          <th>Total</th>
        </tr>
      </thead>
      <tbody>
        {{foreach productos}}
         <tr>
            <td>{{productName}}</td>
            <td>{{cantidad}}</td>
            <td>{{precio_unitario}}</td>
            <td>{{subtotal}}</td>
         </tr>
        {{endfor productos}}
      </tbody>
      <tfoot>
        <tr>
          <td colspan="3" style="text-align:right; font-weight:bold;">Total general:</td>
          <td>{{total}}</td>
        </tr>
      </tfoot>
    </table>
    <a href="index.php?page=Client-Orders" class="btn">Volver a mis pedidos</a>
  </div>
 