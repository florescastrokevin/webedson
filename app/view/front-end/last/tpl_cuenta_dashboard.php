<?php
$obp = new Pedidos();
$pedidos = $obp->getNotificarPedidosXCliente($cuenta->getCliente()->__get('_id'));
?>
<body>
    <?php include(_tpl_includes_ . "inc.top.php"); ?>
    <div class="offcanvas-wrapper" style="/*background: url(<?php echo _tpl_resources_?>imgs/bg_page.jpg) fixed repeat #f1f1f1*/">
    <?php include(_tpl_includes_."inc.navegacion.php") ?>

      <div class="container padding-bottom-3x mb-2">
        <div class="row">
          <div class="col-lg-4">
            <aside class="user-info-wrapper">
              <div class="user-cover" style="background-image: url(img/account/user-cover-img.jpg);">
                <div class="info-label" data-toggle="tooltip" title="You currently have 290 Reward Points to spend"><i class="icon-medal"></i>290 points</div>
              </div>
              <div class="user-info">
                <div class="user-avatar"><a class="edit-avatar" href="#"></a><img src="img/account/user-ava.jpg" alt="User"></div>
                <div class="user-data">
                  <h4>Daniel Adams</h4><span>Joined February 06, 2017</span>
                </div>
              </div>
            </aside>
            <nav class="list-group"><a class="list-group-item with-badge" href="account-orders.html"><i class="icon-bag"></i>Orders<span class="badge badge-primary badge-pill">6</span></a><a class="list-group-item active" href="account-profile.html"><i class="icon-head"></i>Profile</a><a class="list-group-item" href="account-address.html"><i class="icon-map"></i>Addresses</a><a class="list-group-item with-badge" href="account-wishlist.html"><i class="icon-heart"></i>Wishlist<span class="badge badge-primary badge-pill">3</span></a><a class="list-group-item with-badge" href="account-tickets.html"><i class="icon-tag"></i>My Tickets<span class="badge badge-primary badge-pill">4</span></a></nav>
          </div>
          <div class="col-lg-8">
            <div class="padding-top-2x mt-2 hidden-lg-up"></div>
            <form class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="account-fn">First Name</label>
                  <input class="form-control" type="text" id="account-fn" value="Daniel" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="account-ln">Last Name</label>
                  <input class="form-control" type="text" id="account-ln" value="Adams" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="account-email">E-mail Address</label>
                  <input class="form-control" type="email" id="account-email" value="daniel.adams@mail.com" disabled>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="account-phone">Phone Number</label>
                  <input class="form-control" type="text" id="account-phone" value="+7(805) 348 95 72" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="account-pass">New Password</label>
                  <input class="form-control" type="password" id="account-pass">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="account-confirm-pass">Confirm Password</label>
                  <input class="form-control" type="password" id="account-confirm-pass">
                </div>
              </div>
              <div class="col-12">
                <hr class="mt-2 mb-3">
                <div class="d-flex flex-wrap justify-content-between align-items-center">
                  <div class="custom-control custom-checkbox d-block">
                    <input class="custom-control-input" type="checkbox" id="subscribe_me" checked>
                    <label class="custom-control-label" for="subscribe_me">Subscribe me to Newsletter</label>
                  </div>
                  <button class="btn btn-primary margin-right-none" type="button" data-toast data-toast-position="topRight" data-toast-type="success" data-toast-icon="icon-circle-check" data-toast-title="Success!" data-toast-message="Your profile updated successfuly.">Update Profile</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>

    <!-- FIN PAGINA -->
<?php include(_tpl_includes_ . "inc.bottom.php"); ?>
    </div>
    <!-- Back To Top Button--><a class="scroll-to-top-btn" href="#"><i class="icon-arrow-up"></i></a>
    <!-- Backdrop-->
    <div class="site-backdrop"></div>
    <!-- JavaScript (jQuery) libraries, plugins and custom scripts-->
    <script src="<?php echo _tpl_js_ ?>vendor.min.js"></script>
    <script src="<?php echo _tpl_js_ ?>scripts.min.js"></script>
    <script
    src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js"
    integrity="sha256-eGE6blurk5sHj+rmkfsGYeKyZx3M4bG+ZlFyA7Kns7E="
    crossorigin="anonymous"></script>
    <script src="<?php echo _tpl_js_ ?>jquery-ui-timepicker-addon.js"></script>
    <!-- Customizer scripts-->
    <script src="<?php echo _tpl_customize_ ?>customizer.min.js"></script>
  </body>
  
</html>