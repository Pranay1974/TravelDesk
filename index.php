<?php
$submitted = false;
$booking_id = "";
$search_result = null;
$search_error = "";
$is_expired = false;

$url = "https://script.google.com/macros/s/AKfycbw2zsKSyjEH-WU6SV8pAaEWngwI8_9Skkcn_CHWtSnrXMykqJWeGEIvWRLG83slIsGZ/exec";

/* ===== BOOKING ===== */
if ($_SERVER["REQUEST_METHOD"] == "POST" && ($_POST['action'] ?? '') == 'book') {

    $booking_id = "TRAVEL_" . time();

    $name = $_POST['name'] ?? '';
    $destination = $_POST['destination'] ?? '';
    $date = $_POST['date'] ?? '';
    $people = $_POST['people'] ?? '';
    $mode = $_POST['mode'] ?? '';

    if (strtotime($date) < strtotime(date("Y-m-d"))) {
        $search_error = "❌ You cannot book a past date!";
    } else {

        $data = [
            "id" => $booking_id,
            "name" => $name,
            "destination" => $destination,
            "date" => $date,
            "people" => $people,
            "mode" => $mode
        ];

        $options = [
            "http" => [
                "header" => "Content-type: application/x-www-form-urlencoded\r\n",
                "method" => "POST",
                "content" => http_build_query($data)
            ]
        ];

        @file_get_contents($url, false, stream_context_create($options));
        $submitted = true;
    }
}

/* ===== SEARCH ===== */
if (isset($_GET['search_id'])) {

    $search_id = trim($_GET['search_id']);

    if (!empty($search_id)) {

        $response = @file_get_contents($url . "?action=search&id=" . urlencode($search_id));

        if ($response !== false) {
            $data = json_decode($response, true);

            if ($data['status'] === 'success') {
                $search_result = $data['data'];

                if (strtotime($search_result['date']) < strtotime(date("Y-m-d"))) {
                    $is_expired = true;
                }

            } else {
                $search_error = "❌ No booking found!";
            }

        } else {
            $search_error = "❌ Server error!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Travel Booking</title>
<link rel="stylesheet" href="style.css">

<!-- PDF -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<!-- QR -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

</head>
<body>

<div class="overlay"></div>

<div class="card">
<h1>🌍 Travel Booking</h1>
<p class="subtitle">Plan your next adventure or check your ticket</p>

<?php if ($search_error): ?>
<p class="error-msg"><?php echo $search_error; ?></p>
<?php endif; ?>

<!-- SEARCH RESULT -->
<?php if ($search_result): ?>
<div class="ticket" id="ticketArea">

<h2>🎫 Your Travel Ticket</h2>

<?php if ($is_expired): ?>
<p class="expired">⚠️ Ticket Expired</p>
<?php endif; ?>

<div class="ticket-details">
<p><span>Booking ID:</span> <?php echo $search_result['id']; ?></p>
<p><span>Passenger:</span> <?php echo $search_result['name']; ?></p>
<p><span>Destination:</span> <?php echo $search_result['destination']; ?></p>
<p><span>Date:</span> <?php echo $search_result['date']; ?></p>
<p><span>Travelers:</span> <?php echo $search_result['people']; ?></p>
<p><span>Mode:</span> <?php echo $search_result['mode']; ?></p>
</div>

<!-- QR -->
<div id="qrcode"></div>

<div class="ticket-buttons">
<a href="index.php" class="home-btn">⬅️ Back</a>
<button onclick="downloadPDF()" class="pdf-btn">📄 PDF</button>
</div>

</div>

<script>
new QRCode(document.getElementById("qrcode"), {
    text: "<?php echo $search_result['id']; ?>",
    width: 100,
    height: 100
});
</script>

<?php endif; ?>

<!-- BOOKING SUCCESS -->
<?php if ($submitted && !$search_result): ?>
<div class="success">

<h2>🎉 Booking Confirmed!</h2>

<p><b>Booking ID:</b> 
<span class="highlight"><?php echo $booking_id; ?></span>
</p>

<div class="ticket-details">
<p><span>Name:</span> <?php echo $name; ?></p>
<p><span>Destination:</span> <?php echo $destination; ?></p>
<p><span>Date:</span> <?php echo $date; ?></p>
<p><span>Travelers:</span> <?php echo $people; ?></p>
<p><span>Mode:</span> <?php echo $mode; ?></p>
</div>

<!-- QR -->
<div id="qrcode2"></div>

<a href="index.php" class="home-btn">🔁 Book Again</a>

</div>

<script>
new QRCode(document.getElementById("qrcode2"), {
    text: "<?php echo $booking_id; ?>",
    width: 100,
    height: 100
});
</script>

<?php endif; ?>

<!-- HOME -->
<?php if (!$submitted && !$search_result): ?>

<div class="search-section">
<h3>🔍 Find My Ticket</h3>

<form method="GET" class="search-form" id="searchForm">
<input type="text" name="search_id" placeholder="Enter Booking ID (e.g., TRAVEL_12345)" required>
<button type="submit" id="searchBtn">🔍 Search</button>
</form>

</div>

<hr class="divider">

<h3>📝 New Booking</h3>

<form method="POST" id="bookingForm">
<input type="hidden" name="action" value="book">

<div class="input-group">
<input type="text" name="name" required>
<label>Your Name</label>
</div>

<div class="input-group">
<input type="text" name="destination" required>
<label>Destination</label>
</div>

<div class="input-group">
<input type="date" name="date" id="dateInput" required>
</div>

<div class="input-group">
<input type="number" name="people" required>
<label>Travelers</label>
</div>

<div class="input-group">
<select name="mode" required>
<option value="">Select Mode</option>
<option>By Road</option>
<option>By Air</option>
<option>By Water</option>
</select>
</div>

<button type="submit" id="bookingBtn">✈️ Confirm Booking</button>

</form>

<?php endif; ?>

</div>

<script>
const today = new Date().toISOString().split('T')[0];
document.getElementById("dateInput")?.setAttribute("min", today);

document.getElementById("searchForm")?.addEventListener("submit", function() {
    const btn = document.getElementById("searchBtn");
    btn.innerHTML = 'Searching <span class="spinner dark"></span>';
    btn.disabled = true;
});

document.getElementById("bookingForm")?.addEventListener("submit", function() {
    const btn = document.getElementById("bookingBtn");
    btn.innerHTML = 'Booking <span class="spinner"></span>';
    btn.disabled = true;
});

function downloadPDF(){
    html2pdf().from(document.getElementById("ticketArea")).save();
}
</script>

</body>
</html>