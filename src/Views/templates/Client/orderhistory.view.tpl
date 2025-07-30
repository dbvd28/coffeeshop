<div class="container">
  <h1 class="title">Historial de Pedidos</h1>

  <div class="tabs">
    <span class="tab active" data-status="PEND">Pendiente</span>
    <span class="tab" data-status="PAG">Aceptado</span>
    <span class="tab" data-status="ENV">Enviado</span>
    <span class="tab" data-status="ALL">Todos</span>
  </div>

  {{ if ~historial && ~historial|count > 0 }}
  <table class="order-history-table">
    <thead>
      <tr>
        <th>ID Pedido</th>
        <th>Fecha</th>
        <th>Total</th>
        <th>Estado</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody id="orderHistoryTable">
      {{ foreach historial }}
      <tr data-status="{{estado}}">
        <td>{{pedidoId}}</td>
        <td>{{fchpedido}}</td>
        <td>{{total}}</td>
        <td><span class="badge status-{{estado}}">{{estado}}</span></td>
        <td>
          <a class="btn view" href="index.php?page=Client-OrderDetails&mode=DSP&id={{pedidoId}}">
            <i class="fas fa-eye"></i> Ver detalles
          </a>
        </td>
      </tr>
      {{ endfor historial }}
    </tbody>
  </table>
  {{ else }}
  <p>No hay pedidos en su historial.</p>
  {{ endif }}
</div>

<script>
  const tabs = document.querySelectorAll('.tab');
  const rows = document.querySelectorAll('#orderHistoryTable tr');

  tabs.forEach(tab => {
    tab.addEventListener('click', () => {
      tabs.forEach(t => t.classList.remove('active'));
      tab.classList.add('active');
      const status = tab.dataset.status;
      rows.forEach(row => {
        if (status === 'ALL') {
          row.style.display = '';
        } else {
          row.style.display = (row.dataset.status === status) ? '' : 'none';
        }
      });
    });
  });
  // Activar la primera pestaña al cargar
  tabs[0].click();
</script>

