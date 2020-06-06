<?php
    session_start();
    require "header.php";
?>

<main role="main">

      <section class="jumbotron text-center">
        <div class="container">
          <h2 class="jumbotron-heading">Collections</h2>
        </div>
      </section>

      <div class="album py-5 bg-light">
        <div class="container">

          <div class="row">
            <div class="col-md-4">
              <div class="card mb-4 box-shadow">
                <img class="card-img-top" src="img/collection-beef.jpg" alt="Card image cap">
                <div class="card-body">
                  <p class="card-text text-capitalize">beef</p>
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group">
                      <button type="button" class="btn btn-sm btn-outline-secondary">Visit</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card mb-4 box-shadow">
                <img class="card-img-top" src="img/collection-pork.jpg" alt="Card image cap">
                <div class="card-body">
                  <p class="card-text text-capitalize">pork</p>
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group">
                      <button type="button" class="btn btn-sm btn-outline-secondary">Visit</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card mb-4 box-shadow">
                <img class="card-img-top" src="img/collection-lamb.jpg" alt="Card image cap">
                <div class="card-body">
                  <p class="card-text text-capitalize">lamb</p>
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group">
                      <button type="button" class="btn btn-sm btn-outline-secondary">Visit</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
</main>