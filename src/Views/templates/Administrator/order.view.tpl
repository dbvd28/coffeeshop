<div class="container">
  <h1>Pedido #{{id}}</h1>
  <div>
    <p><strong>Fecha:</strong> {{fecha}}</p>
    <p><strong>Estado:</strong> {{estado}}</p>
    <p><strong>Cliente:</strong> {{nombre}}</p>
    <p><strong>Correo:</strong> {{correo}}</p>
    <p><strong>Total:</strong> {{total}}</p>
  </div>
  <h3>Productos Comprados</h3>
  <table class="order-details">
    <thead>
      <tr>
        <th>Producto</th>
        <th>Cantidad</th>
        <th>Precio Unitario</th>
        <th>Subtotal</th>
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
  </table>
  <a href="index.php?page=Client-Orders" class="btn">Volver a mis pedidos</a>
</div>
