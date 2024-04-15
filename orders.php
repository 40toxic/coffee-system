<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();

require_once('partials/_head.php');
?>

<body>
  <!-- Sidenav -->
  <?php
  require_once('partials/_sidebar.php');
  ?>
  <!-- Main content -->
  <div class="main-content">
    <!-- Top navbar -->
    <?php
    require_once('partials/_topnav.php');
    ?>
    <!-- Header -->
    <div style="background-image: url(assets/img/theme/restro00.jpg); background-size: cover;" class="header  pb-8 pt-5 pt-md-8">
      <span class="mask bg-gradient-dark opacity-8"></span>
      <div class="container-fluid">
        <div class="header-body">
        </div>
      </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--8">
      <!-- Table -->
      <div class="row">
        <div class="col">
          <div class="card shadow">
            <div class="card-header border-0">
              <!-- Add a search form -->
              <form method="GET" action="" style="margin-bottom: 20px;">
                <input type="text" name="search" id="search" placeholder="Search Product...">
                <button type="submit" id="searchBtn">Search</button>
              </form>

            </div>
            <div class="table-responsive">
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col"><b>Image</b></th>
                    <th scope="col"><b>Product Code</b></th>
                    <th scope="col"><b>Name</b></th>
                    <th scope="col"><b>Price</b></th>
                    <th scope="col"><b>Action</b></th>
                  </tr>
                </thead>
                <tbody id="productList">
                  <?php
                    // Fetch all products initially
                    $query = "SELECT * FROM colos_products";
                    $result = $mysqli->query($query);
                    while ($prod = $result->fetch_object()) {
                  ?>
                    <tr>
                      <td>
                        <?php
                        if ($prod->prod_img) {
                          echo "<img src='assets/img/products/$prod->prod_img' height='60' width='60 class='img-thumbnail'>";
                        } else {
                          echo "<img src='assets/img/products/default.jpg' height='60' width='60 class='img-thumbnail'>";
                        }
                        ?>
                      </td>
                      <td><?php echo $prod->prod_code; ?></td>
                      <td><?php echo $prod->prod_name; ?></td>
                      <td>$ <?php echo $prod->prod_price; ?></td>
                      <td>
                        <a href="make_oder.php?prod_id=<?php echo $prod->prod_id; ?>&prod_name=<?php echo $prod->prod_name; ?>&prod_price=<?php echo $prod->prod_price; ?>">
                          <button class="btn btn-sm btn-warning">
                            <i class="fas fa-cart-plus"></i>
                            Place Order
                          </button>
                        </a>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <!-- Footer -->
      <?php
      require_once('partials/_footer.php');
      ?>
    </div>
  </div>
  <!-- Argon Scripts -->
  <?php
  require_once('partials/_scripts.php');
  ?>
  <script>
    const searchInput = document.getElementById('search');
    const productList = document.getElementById('productList');

    searchInput.addEventListener('input', function() {
      const searchTerm = this.value.trim().toLowerCase();
      const products = productList.getElementsByTagName('tr');
      Array.from(products).forEach(function(product) {
        const productName = product.getElementsByTagName('td')[2].textContent.toLowerCase();
        if (productName.includes(searchTerm)) {
          product.style.display = 'table-row';
        } else {
          product.style.display = 'none';
        }
      });
    });
  </script>
  <style>
  /* Style for the search input */
  #search {
    padding: 8px 12px;
    border: 1px solid #ccc;
    border-radius: 4px;
    margin-right: 10px;
    width: 200px; /* Adjust width as needed */
  }

  /* Style for the search button */
  #searchBtn {
    padding: 8px 12px;
    border: none;
    border-radius: 4px;
    background-color: tan; 
    color: #fff;
    cursor: pointer;
  }

  /* Style for the search button on hover */
  #searchBtn:hover {
    background-color: cyan; 
  }
</style>
</body>

</html>
