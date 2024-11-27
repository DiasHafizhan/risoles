<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body style="background-color: #27262b; color: white;">
  <?php include 'Component/header.php' ?>

  <div class="container w-full" style="margin-top: 30px;">
    <div class="row">
      <div class="col-6 ">
        <div class="row items-center">
          <div class="col-6 flex flex-col">
            <div class="border rounded-lg" style="height: 307px; width: 261px; margin-bottom: 20px;">Gambar</div>
            <div class="border rounded-lg" style="height: 200px; width: 261px; margin-bottom: 20px;">Gambar</div>
          </div>
          <div class="col-6 flex flex-col">
            <div class="border rounded-lg" style="height: 307px; width: 261px; margin-bottom: 20px;">Gambar</div>
          </div>
        </div>
      </div>
      <div class="col-6 flex flex-col justify-center items-center">
        <h1 style="margin-bottom: 20px;">Lorem ipsum dolor sit amet consectetur</h1>
        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Et dolor minus dolores ratione explicabo a
          exercitationem facere, voluptatum eaque eius similique aliquam illum ab at aperiam eos ipsa quod nisi
          mollitia, soluta perferendis obcaecati repellat?</p>
        <div>

        </div>
      </div>
    </div>

  </div>

  <div class="w-full flex items-center" style="margin-top: 100px;  margin-bottom: 80px;">
    <div class="flex flex-col justify-center items-center" style="width: 50%;height: 300px; background-color: #2a2e3e;">
      <h4 style="font-size: 18px;">HM Risoles</h4>
      <h1 style="font-weight: 800; font-size: 50px;">Our History</h1>
    </div>
    <div class="flex justify-center items-center"
      style="width: 50%;height: 300px; border-top: 1px solid #2a2e3e;border-bottom: 1px solid #2a2e3e;">
      <div class="timeline">
        <div class="">
          <h3 style="margin-bottom: 20px; color: #8e8d94;">2000</h3>
          <div class="">
            <p style="font-weight: 600; color: #ffbc01;">1</p>
            <h5 style="font-size: 25px; font-weight: 600;">Lorem, ipsum dolor.</h5>
            <p style="max-width: 200px; color: #8e8d94;">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Perspiciatis, aspernatur?</p>
          </div>
        </div>
        <div class="line"></div>
        <div class="">
          <h3 style="margin-bottom: 20px; color: #8e8d94;">2024</h3>
          <div class="">
            <p style="font-weight: 600; color: #ffbc01;">2</p>
            <h5 style="font-size: 25px; font-weight: 600;">Lorem, ipsum dolor.</h5>
            <p style="max-width: 200px; color: #8e8d94;">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Perspiciatis, aspernatur?</p>
          </div>
        </div>
      </div>
    </div>

  </div>

  <?php include "./Component/footer.php" ?>



  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
</body>

</html>