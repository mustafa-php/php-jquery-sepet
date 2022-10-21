<?php

$sepet = new PDO("mysql:host=mustafa;dbname=mustafa", "mustafa", "");

$ip = $_SERVER["REMOTE_ADDR"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $isim = $_POST["isim"];
  $fiyat = $_POST["fiyat"];
  $sepetekle = $sepet->prepare("INSERT INTO  sepet SET ürün_isim=:isim, ürün_fiyat=:fiyat, ip=:ip");
  $sepetekle->execute(array(
    "isim" => $isim,
    "fiyat" => $fiyat,
    "ip" => $ip
  ));
}

$toplam = 0;
$sepetcek = $sepet->prepare("SELECT * FROM sepet where ip=:ip");
$sepetcek->execute(array('ip' => $ip));
$sepetsonuc = $sepetcek->fetchAll(PDO::FETCH_OBJ);


?>
<!DOCTYPE html>
<html lang="tr">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sepet</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous" />
  <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="index.css">
</head>

<body>
 
  <header>
<h1>Mustafa Şimşek</h1>
  </header>
  <main>
    <div class="urunler col-md-8 col-6">
      <div class="urun col-md-5 col-11">
        <div class="img-div">
          <img src="https://cdn-icons-png.flaticon.com/128/135/135695.png" alt="" />
        </div>

        <div>
          <div class="text-center w-100">
            <span class="fiyat fw-bold h3">18</span> TL
          </div>
          <div class="h3">Ürün 1</div>
          <div>Ürün bilgisi örnek metinidir</div>
          <button>Ürün Seç</button>
        </div>
      </div>

      <div class="urun col-md-5 col-11">
        <div class="img-div">
          <img src="https://cdn-icons-png.flaticon.com/128/135/135695.png" alt="" />
        </div>

        <div>
          <div class="text-center w-100">
            <span class="fiyat fw-bold h3">12</span> TL
          </div>
          <div class="h3">Ürün 2</div>
          <div>Ürün bilgisi örnek metinidir</div>
          <button>Ürün Seç</button>
        </div>
      </div>

      <div class="urun col-md-5 col-11">
        <div class="img-div">
          <img src="https://cdn-icons-png.flaticon.com/128/135/135695.png" alt="" />
        </div>

        <div>
          <div class="text-center w-100">
            <span class="fiyat fw-bold h3">30</span> TL
          </div>
          <div class="h3">Ürün 3</div>
          <div>Ürün bilgisi örnek metinidir</div>
          <button>Ürün Seç</button>
        </div>
      </div>

      <div class="urun col-md-5 col-11">
        <div class="img-div">
          <img src="https://cdn-icons-png.flaticon.com/128/135/135695.png" alt="" />
        </div>

        <div>
          <div class="text-center w-100">
            <span class="fiyat fw-bold h3">20</span> TL
          </div>
          <div class="h3">Ürün 4</div>
          <div>Ürün bilgisi örnek metinidir</div>
          <button>Ürün Seç</button>
        </div>
      </div>
    </div>
  
    <div class="sepet col-md-3 col-5">
      <h3 class="text-center">Sepet</h3>
      <div class="eklenen">
        <div class="eklenen_urun">
          <?php foreach ($sepetsonuc as $sonuc) {
            $toplam = $toplam + $sonuc->ürün_fiyat;

          ?>
            <div class="urun_isim"><?php echo $sonuc->ürün_isim ?></div>
            <div class="urun_fiyat"><?php echo $sonuc->ürün_fiyat ?></div>
          <?php } ?>
        </div>
      </div>

      <div class="toplam"><span>Toplam :</span><span class="sonuc"><?php echo  $toplam ?></span><span>TL</span></div>
    </div>
  </main>

  <script>
    $(document).ready(function() {
      $(".urun button").click(function() {
        var toplam = Number($(".sonuc").html());
        var fiyat = Number($(this).parent().find(".fiyat").html());
        var isim = $(this).prev().prev().html();

        $(".eklenen").append('<div class="eklenen_urun"><div class="urun_isim">' + isim + '</div><div class="urun_fiyat">' + fiyat + '</div></div>');
        $(".sonuc").html(toplam + fiyat);
        $.ajax({
          type: "post",
          url: "https://mustafa/",
          data: {
            isim: isim,
            fiyat: fiyat,
          },
        });
      });
    });
  </script>
</body>

</html>