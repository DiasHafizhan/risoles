<?php
session_start();

$isLoggedIn = isset($_SESSION["login"]) && $_SESSION["login"] === true;

?>

<div class="w-full bg-red-600 sticky-top">
  <div class="container py-2 flex justify-between items-center">
    <h2 class="text-xl">
      <a href="" class="text-black no-underline">HM Risoles</a>
    </h2>

    <ul class="hidden md:flex pt-2" style="gap: 30px;">
      <?php if (!$isLoggedIn): ?>
        <li>
          <a href="index.php" class="no-underline text-black text-lg">Beranda</a>
        </li>
        <li>
          <a href="menu.php" class="no-underline text-black text-lg">Menu</a>
        </li>
        <li>
          <a href="infoKami.php" class="no-underline text-black text-lg">Info Kami</a>
        </li>
        <li>
          <a href="" class="no-underline text-black text-lg">Store</a>
        </li>
      <?php else: ?>
        <li>
          <a href="index.php" class="no-underline text-black text-lg">Beranda</a>
        </li>
        <li>
          <a href="menu.php" class="no-underline text-black text-lg">Menu</a>
        </li>
        <li>
          <a href="infoKami.php" class="no-underline text-black text-lg">Info Kami</a>
        </li>
        <li>
          <a href="" class="no-underline text-black text-lg">Store</a>
        </li>
        <li>
          <a href="infoKami.php" class="no-underline text-black text-lg">Riwayat Pemesanan</a>
        </li>
        <li>
          <a href="" class="no-underline text-black text-lg">Profile</a>
        </li>
      <?php endif ?>

    </ul>

    <div class="">
      <?php if ($isLoggedIn): ?>
        <a href="./auth/logout.php"
          class="no-underline text-black text-lg py-2 px-4 bg-sky-600 hover:bg-sky-500 duration-300  rounded-3xl">
          Logout
        </a>
      <?php else: ?>
        <a href="./auth/login.php"
          class="no-underline text-black text-lg py-2 px-4 bg-sky-600 hover:bg-sky-500 duration-300  rounded-3xl">
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