<?php 
if(!isset($_POST["membership"])) return header("Location: index.html");

function formatNumber($number) {
    return preg_replace('/[^0-9]/', '', $number);
}

function formatRibuan($number) {
    return number_format($number, 0, ',', '.');
}

$pembelianFormat = $_POST["jumlah_pembelian"];
$pembelian = (int)formatNumber($pembelianFormat);

function diskon($number) {
    if($_POST["membership"] === "basic") {
        if($number < 100000) {
            return 0;
        } else {
            return 0.05 * $number;
        }
    } else {
        return 0.1 * $number;
    }
}

$diskonTitle = "10%";
$diskonHarga = formatRibuan(diskon($pembelian));

function memberPoint($number) {
    $poin = 0.01 * $number;
    return $poin;
}

$poinMember = memberPoint($pembelian);
$poinMemberFormat = formatRibuan($poinMember);

if($_POST["membership"] === "basic") {
    $poinMemberFormat = 0;
    $diskonTitle = "5%";
    if($pembelian < 100000) {
        $diskonTitle = "0%";
    }
};

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Detail Pembayaran</title>
    <link rel="stylesheet" href="style.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  </head>
  <body>
    <div class="navbar">
      <div class="brand">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          width="24"
          height="24"
          viewBox="0 0 24 24"
        >
          <path
            fill="currentColor"
            d="M17 18a2 2 0 0 1 2 2a2 2 0 0 1-2 2a2 2 0 0 1-2-2c0-1.11.89-2 2-2M1 2h3.27l.94 2H20a1 1 0 0 1 1 1c0 .17-.05.34-.12.5l-3.58 6.47c-.34.61-1 1.03-1.75 1.03H8.1l-.9 1.63l-.03.12a.25.25 0 0 0 .25.25H19v2H7a2 2 0 0 1-2-2c0-.35.09-.68.24-.96l1.36-2.45L3 4H1zm6 16a2 2 0 0 1 2 2a2 2 0 0 1-2 2a2 2 0 0 1-2-2c0-1.11.89-2 2-2m9-7l2.78-5H6.14l2.36 5z"
          />
        </svg>
        <span>andramart</span>
      </div>
    </div>
    <div class="container">
      <div class="detail">
        <div class="sect_container">
          <div class="judul">
            <p class="judul_title">Detail Transaksi</p>
          </div>
          <div class="detail_transaksi">
            <div class="jumlah_pembelian detail_segment">
              <p class="detail_title">Jumlah Pembelian</p>
              <span class="detail_number"> Rp. <?= $pembelianFormat ?> </span>
            </div>
            <div class="diskon_pembelian detail_segment">
              <p class="detail_title">Diskon (<?= $diskonTitle; ?>)</p>
              <span class="detail_number"> Rp. <?= $diskonHarga; ?> </span>
            </div>
            <div class="membership_point detail_segment">
              <p class="detail_title <?= $_POST["membership"] ?>">Poin Membership</p>
              <span class="detail_number <?= $_POST["membership"] ?>"> + <?= $poinMemberFormat; ?> </span>
            </div>
            <div class="total_harga detail_segment">
                <p class="detail_title">Total Harga</p>
                <span class="detail_number"> Rp. <?= formatRibuan((diskon($pembelian) + $pembelian)); ?> </span>
            </div>
          </div>
          <div class="done_button">
            <button onclick="showFeedback()" id="submit_button" class="buttonBayar">
              <span> Selesai </span>
            </button>
          </div>
        </div>
      </div>
    </div>
    <script>
        function showFeedback() {
        Swal.fire({
            title: 'Apakah anda puas dengan layanan kami?',
            html: `
            <div class="feedback-container">
                <div class="feedback-option" onclick="handleFeedback('Tidak Puas')">
                <img src="./assets/tidakpuas.png" alt="Tidak Puas">
                <span>Tidak Puas</span>
                </div>
                <div class="feedback-option" onclick="handleFeedback('Puas')">
                <img src="./assets/puas.png" alt="Puas">
                <span>Puas</span>
                </div>
            </div>
            `,
            showConfirmButton: false,
        });
        }

        function handleFeedback(response) {
        Swal.fire({
            icon: 'success',
            title: `Terima kasih atas feedback Anda!`,
            text: `Anda memilih: ${response}`,
        });
        }
    </script>
  </body>
</html>
