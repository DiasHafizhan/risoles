<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// Cek apakah user sudah login
if (isset($_SESSION['user'])) {
  // Jika sesi user ada, ambil data user dari sesi
  $user = $_SESSION['user'];
} else {
  // Jika tidak ada sesi user, atur nilai default untuk $user
  $user = [
    'id' => null,
    'email' => null,
    'nama' => 'Guest',
    'telp' => null
  ];
}

$isLoggedIn = isset($_SESSION["login"]) && $_SESSION["login"] === true;

?>

<div class="w-full sticky-top" style="background-color: #1d1d1d;">
  <div class="container py-2 flex justify-between items-center navbar">
    <h2 class="text-xl">
      <a href="" class="text-white no-underline">HM Risoles</a>
    </h2>

    <ul class="hidden md:flex pt-2" style="gap: 30px;">
      <?php if (!$isLoggedIn): ?>
        <li>
          <a href="index.php?x=home"
            class="no-underline text-lg <?php echo (isset($_GET['x']) && $_GET['x'] == 'home') ? 'aktif' : ''; ?>">
            Beranda
          </a>
        </li>
        <li>
          <a href="menu.php?x=menu"
            class="no-underline text-lg <?php echo (isset($_GET['x']) && $_GET['x'] == 'menu') ? 'aktif' : ''; ?>">
            Menu
          </a>
        </li>
        <li>
          <a href="infoKami.php?x=about"
            class="no-underline text-lg <?php echo (isset($_GET['x']) && $_GET['x'] == 'about') ? 'aktif' : ''; ?>">
            About
          </a>
        </li>
      <?php else: ?>
        <li>
          <a href="index.php?x=home"
            class="no-underline text-lg <?php echo (isset($_GET['x']) && $_GET['x'] == 'home') ? 'aktif' : ''; ?>">
            Beranda
          </a>
        </li>
        <li>
          <a href="menu.php?x=menu"
            class="no-underline text-lg <?php echo (isset($_GET['x']) && $_GET['x'] == 'menu') ? 'aktif' : ''; ?>">
            Menu
          </a>
        </li>
        <li>
          <a href="infoKami.php?x=about"
            class="no-underline text-lg <?php echo (isset($_GET['x']) && $_GET['x'] == 'about') ? 'aktif' : ''; ?>">
            About
          </a>
        </li>
        <li>
          <a href="history.php?x=history"
            class="no-underline text-lg <?php echo (isset($_GET['x']) && $_GET['x'] == 'history') ? 'aktif' : ''; ?>">
            Riwayat Pemesanan
          </a>
        </li>
        <li>
          <a href="profile.php?x=profile&id=<?= $id_user['id'] ?>"
            class="no-underline text-lg <?php echo (isset($_GET['x']) && $_GET['x'] == 'profile') ? 'aktif' : ''; ?>">
            Profile
          </a>
        </li>
      <?php endif ?>

    </ul>

    <div class="">
      <?php if ($isLoggedIn): ?>
        <a href="./auth/logout.php" class="no-underline text-lg py-2 px-4 rounded-lg btn-login">
          Logout
        </a>
      <?php else: ?>
        <a href="./auth/login.php" class="no-underline text-lg py-2 px-4 rounded-lg btn-login">
          Login
        </a>
      <?php endif; ?>
    </div>

    <button class="md:hidden" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight"
      aria-controls="offcanvasRight">
      <i class='bx bx-menu text-2xl text-black'></i>
    </button>

    <div class="offcanvas offcanvas-end" style="width: 250px;" tabindex="-1" id="offcanvasRight"
      aria-labelledby="offcanvasRightLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasRightLabel">HM Risoles</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
        <ul class="flex flex-col gap-4 mx-auto">
          <li>
            <a href="" class="no-underline text-black text-lg">About</a>
          </li>
          <li>
            <a href="" class="no-underline text-black text-lg">Menu</a>
          </li>
          <li>
            <a href="" class="no-underline text-black text-lg">Store</a>
          </li>
          <?php if ($isLoggedIn): ?>
            <li>
              <a href=""
                class="no-underline text-black text-lg py-2 px-4 bg-sky-600 hover:bg-sky-500 duration-300  rounded-3xl flex justify-center">
                Logout
              </a>
            </li>
          <?php else: ?>
            <li>
              <a href="./auth/register.php"
                class="no-underline text-black text-lg py-1 px-4 border-2 border-sky-600 hover:bg-sky-600 duration-300 rounded-3xl flex justify-center">
                Register
              </a>
            </li>
            <li>
              <a href="./auth/login.php"
                class="no-underline text-black text-lg py-2 px-4 bg-sky-600 hover:bg-sky-500 duration-300  rounded-3xl flex justify-center">
                Login
              </a>
            </li>
          <?php endif ?>
        </ul>
      </div>
    </div>
  </div>
</div>