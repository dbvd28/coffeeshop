<h1 class="site-title">
  <img src="public/imgs/hero/logo.png" alt="Logo Coffeeshop" class="logo">
  {{SITE_TITLE}}
</h1><div class="product-list">
  {{foreach productos}}
  <div class="product-card" data-productId="{{productId}}">
    <div class="product-image">
      <img src="{{productImgUrl}}" alt="{{productName}}">
      <div class="price-tag">${{productPrice}}</div>
      <div class="stock-tag">Disponible {{productStock}}</div>
    </div>
    <div class="product-info">
      <h2>{{productName}}</h2>
      <p>{{productDescription}}</p>
      <form action="index.php?page=index" method="post">
        <input type="hidden" name="productId" value="{{productId}}">
        <button type="submit" name="addToCart" class="add-to-cart">
          <i class="fa-solid fa-cart-plus"></i> Agregar al Carrito
        </button>
      </form>
    </div>
  </div>
  {{endfor productos}}
</div>
