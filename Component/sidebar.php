<div class="col-md-3 md:block hidden">
  <div class="list-group">
    <a href="index.php?x=dashboard"
      class="list-group-item list-group-item-action <?php echo (isset($_GET['x']) && $_GET['x'] === 'dashboard') ? 'active' : ''; ?>"
      aria-current="true">
      Dashboard
    </a>
    <a href="../admin/listMenu.php?x=menu"
      class="list-group-item list-group-item-action <?php echo (isset($_GET['x']) && $_GET['x'] === 'menu') ? 'active' : ''; ?>">List
      Menu</a>
    <a href="../admin/historyAdmin.php?x=histori"
      class="list-group-item list-group-item-action <?php echo (isset($_GET['x']) && $_GET['x'] === 'histori') ? 'active' : ''; ?>">History Order</a>
  </div>
</div>