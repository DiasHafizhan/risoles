


<div class="w-full bg-red-600 sticky-top">
  <div class="container py-2 flex justify-between items-center">
    <h2 class="text-xl">
      <a href="" class="text-black no-underline">HM Risoles</a>
    </h2>

    <div class="md:hidden block">
      <button class="btn btn-primary text-center" type="button" data-bs-toggle="offcanvas"
        data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
        <i class='bx bx-menu text-lg'></i>
      </button>

      <div class="offcanvas offcanvas-end" style="width: 350px;" tabindex="-1" id="offcanvasRight"
        aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header">
          <h5 class="offcanvas-title" id="offcanvasRightLabel">Hallo <?= $username ?></h5>
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
          <div class="list-group">
            <a href="index.php?x=dashboard"
              class="list-group-item list-group-item-action <?php echo (isset($_GET['x']) && $_GET['x'] === 'dashboard') ? 'active' : ''; ?>"
              aria-current="true">
              The current link item
            </a>
            <a href="../admin/listMenu.php?x=menu"
              class="list-group-item list-group-item-action <?php echo (isset($_GET['x']) && $_GET['x'] === 'menu') ? 'active' : ''; ?>">A
              second link item</a>
          </div>
        </div>
      </div>
    </div>




    <div class="dropdown hidden md:block">
      <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        <?php echo $username ?>
      </button>
      <ul class="dropdown-menu dropdown-menu-dark">
        <li><a class="dropdown-item" href="../auth/Logout.php">Logout</a></li>
      </ul>
    </div>
  </div>
</div>