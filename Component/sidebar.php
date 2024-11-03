<div class="col-md-3 md:block hidden">
  <div class="list-group">
    <a href="index.php?x=dashboard"
      class="list-group-item list-group-item-action <?php echo (isset($_GET['x']) && $_GET['x'] === 'dashboard') ? 'active' : ''; ?>"
      aria-current="true">
      The current link item
    </a>
    <a href="../admin/listMenu.php?x=menu" class="list-group-item list-group-item-action <?php echo (isset($_GET['x']) && $_GET['x'] === 'menu') ? 'active' : ''; ?>">A second link item</a>
  </div>
</div>