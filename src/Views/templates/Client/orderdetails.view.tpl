<div class="container">
  <h1>Detalle del pedido #{{id}}</h1>
  <p><strong>Fecha:</strong> {{fecha}}</p>
  <p><strong>Estado:</strong> <span class="badge status-{{estado}}">{{estado}}</span></p>
  <p><strong>Total:</strong> {{total}}</p>
  <p><strong>Cliente:</strong> {{nombre}} ({{correo}})</p>

  <h2>Productos</h2>
  <table class="product-details-table">
    <thead>
      <tr>
        <th>Producto</th>
        <th>Cantidad</th>
        <th>Precio Unitario</th>
        <th>Subtotal</th>
      </tr>
    </thead>
    <tbody>
      {{ foreach productos }}
      <tr>
        <td>{{productName}}</td>
        <td>{{cantidad}}</td>
        <td>{{precio_unitario}}</td>
        <td>{{subtotal}}</td>
      </tr>
      {{ endfor productos }}
    </tbody>
  </table>
  <a href="index.php?page=Client-OrderHistory" class="btn">Volver al historial</a>
</div>

