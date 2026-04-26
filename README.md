# 🌍 Travel Booking System (PHP + Google Sheets)

![PHP](https://img.shields.io/badge/Backend-PHP-blue)
![Google Sheets](https://img.shields.io/badge/Database-Google%20Sheets-green)
![QR Code](https://img.shields.io/badge/Feature-QR%20Code-yellow)
![PDF](https://img.shields.io/badge/Export-PDF-red)
![UI](https://img.shields.io/badge/UI-Glassmorphism-purple)
![Automation](https://img.shields.io/badge/Type-Web%20App-orange)
![Status](https://img.shields.io/badge/Status-Working-brightgreen)
![License](https://img.shields.io/badge/License-MIT-lightgrey)

A modern **travel booking web app** built using **PHP** and **Google Sheets as a backend**. Users can book trips, search tickets via Booking ID, generate QR codes, and download tickets as PDF — all in a clean glass UI.

---

## 🚀 Features

- 📝 Book travel tickets easily  
- 🔍 Search booking using unique ID  
- 📄 Download ticket as PDF  
- 🔳 Auto-generated QR code for tickets  
- 📅 Prevent past date bookings  
- ⚠️ Expired ticket detection  
- 🎨 Modern glassmorphism UI  

---

## 🧰 Tech Stack

- **PHP** – Backend logic  
- **Google Apps Script + Sheets** – Database  
- **HTML/CSS/JS** – Frontend  
- **html2pdf.js** – PDF generation  
- **QRCode.js** – QR code generation  

---

## 🏗️ Architecture

👤 User → 🌐 PHP App → 📡 Google Apps Script → 📊 Google Sheets  
                      ↓  
                🎫 Ticket + QR + PDF  

---

## 🧠 How It Works

1. User fills booking form  
2. PHP sends data to Google Apps Script  
3. Data is stored in Google Sheets  
4. Booking ID is generated  
5. User can search ticket using ID  
6. Ticket is displayed with QR + PDF option  

---

## ⚙️ Setup Instructions

### 1️⃣ Clone Repository

```bash
git clone https://github.com/your-username/travel-booking-system.git
cd travel-booking-system
```

### 2️⃣ Setup Google Sheets API

- Create a **Google Sheet**  
- Open **Extensions → Apps Script**  
- Paste your script (handle POST + search)  
- Deploy as **Web App**  
- Copy the **Web App URL**  

---

## 3️⃣ Connect with PHP

Update this in your PHP file:

```php
$url = "YOUR_GOOGLE_SCRIPT_WEB_APP_URL";
```

## 4️⃣ Run Project

- Place files in **htdocs** (XAMPP)  
- Start Apache  
- Open in browser:  

```bash
http://localhost/project-folder


```

---

## 🔐 Notes

- Do NOT expose your Apps Script URL publicly  
- Add validation if deploying to production  
- Use HTTPS for security  

---

## 🧪 Example

**Booking ID:** `TRAVEL_1712345678`

- Search using ID  
- View ticket  
- Scan QR  
- Download PDF  

---

## 📈 Improvements (Next Steps)

- 🔐 User authentication (login/signup)  
- 🧑‍💼 Admin dashboard  
- 📧 Email ticket delivery  
- 📱 Mobile responsive improvements  
- ☁️ Deploy on VPS / hosting  

---

## 🖼️ Demo

<img width="1917" height="897" alt="image" src="https://github.com/user-attachments/assets/17fe49a9-b0ca-4132-8a1e-ed08c213d0d5" />

---

## 🙌 Author

**Pranay Gurjar**

---

## ⭐ Support

If you like this project:

- ⭐ Star the repo  
- 🔁 Share it  
- 💬 Give feedback  
```
