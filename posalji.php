<?php

// Dozvoli samo POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("Neispravan zahtjev.");
}

// Anti-spam (honeypot)
if (!empty($_POST['website'])) {
    die();
}

// Uzimanje podataka
$ime = isset($_POST['Ime']) ? trim($_POST['Ime']) : '';
$email = isset($_POST['Email']) ? trim($_POST['Email']) : '';
$poruka = isset($_POST['Poruka']) ? trim($_POST['Poruka']) : '';

// Validacija
if (empty($ime) || empty($email) || empty($poruka)) {
    die("Sva polja su obavezna.");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Neispravan email.");
}

// Sanitizacija
$ime = htmlspecialchars($ime, ENT_QUOTES, 'UTF-8');
$email = filter_var($email, FILTER_SANITIZE_EMAIL);
$poruka = htmlspecialchars($poruka, ENT_QUOTES, 'UTF-8');

// Email postavke
$to = "vedad@velagic.net";
$cc = "tamer@velagic.net";
$subject = "Novi klijent za Wellas!";

// Sadržaj poruke
$body = "Novi upit sa Wellas stranice:\n\n";
$body .= "Ime: $ime\n";
$body .= "Email: $email\n\n";
$body .= "Poruka:\n$poruka\n";

// Headeri
$headers = "From: Wellas <no-reply@velagic.net>\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "Cc: $cc\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

// Pokušaj slanja (nije kritično za redirect)
@mail($to, $subject, $body, $headers);

// 🔥 NAJBITNIJE — redirect
header("Location: hvala.html");
exit();

?>