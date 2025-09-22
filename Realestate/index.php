<?php 
ini_set('session.cookie_lifetime', 0);
session_start(); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="google-site-verification" content="Q4jG5aowQQUyyX2_PgN3kL7HDmkBZNRsgiFLBXoUIVk" />
  <title>RealEstate Portal</title>
  <!-- Lightbox2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/lightbox2@2.11.4/dist/css/lightbox.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
  <!-- Lightbox2 CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/@n8n/chat/dist/style.css" rel="stylesheet" />
 
 <meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<meta name="google-site-verification" content="Q4jG5aowQQUyyX2_PgN3kL7HDmkBZNRsgiFLBXoUIVk" />

<title>RealEstate Portal | DTCP Approved Plots, Bookings & Investments</title>

 <title>All is Well Properties | Real Estate & DTCP Approved Plots in Vijayawada</title>

<meta name="description" content="All is Well Properties in Vijayawada offers DTCP approved plots, real estate consulting, and construction services. Explore properties in Auto Nagar and surrounding areas with secure investments and easy booking." />

<meta name="keywords" content="All is Well Properties Vijayawada, All is Well Real Estate, DTCP plots Vijayawada, Auto Nagar plots, Vijayawada construction services, real estate consultants Vijayawada, land for sale Vijayawada, property investment Andhra Pradesh" />

<meta name="author" content="All is Well Properties, Vijayawada" />

<!-- Open Graph -->
<meta property="og:title" content="All is Well Properties | DTCP Approved Plots in Vijayawada" />
<meta property="og:description" content="Trusted real estate and construction services in Vijayawada. Book DTCP approved plots in Auto Nagar and nearby locations with All is Well Properties." />
<meta property="og:type" content="website" />
<meta property="og:url" content="https://yourdomain.com" />
<meta property="og:image" content="https://yourdomain.com/images/vijayawada-realestate.jpg" />

<!-- Twitter Card -->
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:title" content="All is Well Properties Vijayawada | DTCP Plots & Real Estate" />
<meta name="twitter:description" content="Buy DTCP approved plots in Vijayawada with All is Well Properties. Offering real estate consulting and construction services in Auto Nagar & nearby." />
<meta name="twitter:image" content="https://yourdomain.com/images/vijayawada-realestate.jpg" />


<!-- Bootstrap CSS (if not already included) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

  <style>
 .footer-glass {
  background: rgba(255, 255, 255, 0.08);
  backdrop-filter: blur(10px);
  border-top: 2px solid rgba(255, 255, 255, 0.2);
  box-shadow: 0 -5px 30px rgba(0, 0, 0, 0.4);
  padding: 3rem 1rem;
  margin-top: 4rem;
  border-radius: 20px 20px 0 0;
  color: #ffffff;
}

.footer-glass h4 {
  font-weight: bold;
  font-size: 1.5rem;
  background: linear-gradient(90deg, #ff416c, #ff4b2b);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}

.glass-button {
  background: linear-gradient(to right, #ff416c, #ff4b2b);
  color: #fff;
  border: none;
  padding: 12px 28px;
  font-size: 1rem;
  border-radius: 50px;
  box-shadow: 0 0 15px rgba(255, 75, 43, 0.5);
  transition: all 0.3s ease;
  text-decoration: none;
  display: inline-block;
}

.glass-button:hover {
  transform: scale(1.05);
  box-shadow: 0 0 25px rgba(255, 75, 43, 0.7);
  color: white;
}
    body {
      font-family: 'Segoe UI', sans-serif;
    }

    .hero {
      background: url('https://www.ikonmarket.com/assets/images/marketing-articles/luxury-home.jpg') center/cover no-repeat;
      height: 400px;
      color: white;
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
    }

    .hero .content {
      background: rgba(0, 0, 0, 0.6);
      padding: 30px;
      border-radius: 10px;
      text-align: center;
    }

    .explore-cards img {
      width: 100%;
      height: 180px;
      object-fit: cover;
      border-radius: 8px;
    }

    @media (min-width: 992px) {
      .dropdown:hover .dropdown-menu {
        display: block;
        margin-top: 0.5rem;
      }
    }
    html {
  scroll-behavior: smooth;
}
.card-title {
  font-weight: bold;
  margin-bottom: 10px;
}

  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg sticky-top bg-white shadow-sm">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center" href="#">
      <img src="https://content.jdmagicbox.com/comp/vijayawada/u2/0866px866.x866.230315042914.s4u2/catalogue/all-is-well-eco-ventures-office-srinivasa-nagar-bank-colony-vijayawada-gmn6zjvz6m.jpg" alt="Company Logo" style="height: 50px; margin-right: 10px;">
      <span class="fw-bold text-black animate__animated animate__fadeInDown">All Is Well Eco Ventures</span>
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <?php if (isset($_SESSION['username'])): ?>
  <ul class="navbar-nav me-auto mb-2 mb-lg-0">
    <li class="nav-item"><a class="nav-link" href="book.php">Booking Form</a></li>
    <li class="nav-item"><a class="nav-link" href="User-data.php">User Submissions</a></li>
    <li class="nav-item"><a class="nav-link" href="Edit.php">Edit Status</a></li>
    <li class="nav-item"><a class="nav-link" href="add_referral.php">Add Referral</a></li>
    <li class="nav-item"><a class="nav-link " href="referral_tree.php">View Referral</a></li>
    <li class="nav-item"><a class="nav-link   " href="manage_referrals.php">Manage Referral</a></li> 
  </ul>
<?php endif; ?>

 <div class="d-flex justify-content-end align-items-center gap-2" style="margin-left: auto;">
  <a href="https://www.youtube.com/@ALLISWELLECOVENTURES/featured" target="_blank" class="me-3">
    <button class="btn btn-success">🔔 Visit <span class="badge bg-light text-dark"> & Subscribe</span></button>
  </a>

  <!-- User Icon Dropdown -->
  <div class="dropdown">
    <a href="#" class="position-relative" role="button" data-bs-toggle="dropdown" aria-expanded="false">
      <i class="bi bi-person-circle text-black fs-4 me-2"></i>
      <?php if (isset($_SESSION['username'])): ?>
        <span class="position-absolute top-0 start-100 translate-middle p-1 bg-success border border-light rounded-circle">
          <span class="visually-hidden">Online</span>
        </span>
      <?php endif; ?>
    </a>
    <ul class="dropdown-menu dropdown-menu-end">
      <?php if (isset($_SESSION['username'])): ?>
        <li><span class="dropdown-item-text">👋 Hi, <?php echo htmlspecialchars($_SESSION['username']); ?></span></li>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item" href="logout.php">Logout</a></li>
      <?php else: ?>
        <li><a class="dropdown-item" href="login.html">Login</a></li>
      <?php endif; ?>
    </ul>
  </div>
</div>


    
    </div>
  </div>
</nav>

<!-- Hero Section -->
<div class="hero">
  <div class="content">
    <h1>"మీ భవిష్యత్తు భూమిలో రాశిచింత – ‘ఆల్ ఇజ్ వెల్’ తో ప్రారంభించండి!"</h1>
   <b> "Don’t worry about your future land investment – Start it with ‘All Is Well’!"</b>
    <h3>📍పట్టణానికి చేరువలో DTCP ఆమోదిత స్థలాలు</h3>
    <h4><b>"మీ నమ్మకానికి సరైన చిరునామా – ‘ఆల్ ఇజ్ వెల్ వెంచర్స్’"</b></h4>
    <a href="#move" class="btn btn-primary">Explore Now →</a>
  </div>
</div>

 
<div class="container mt-5" id="move">
  <h4 class="text-center mb-4">📸 Our Gallery (Photos & Videos)</h4>
  <div class="row g-3">

   
    <div class="col-md-4">
      <a href="https://lh3.googleusercontent.com/p/AF1QipNWRZfrGvUsVEskpoIIyJ-_pJqi_hSVB0RpkqPe=s1360-w1360-h1020-rw" data-lightbox="realestate-gallery" data-title="Open Plots - East Facing">
        <img src="https://lh3.googleusercontent.com/p/AF1QipNWRZfrGvUsVEskpoIIyJ-_pJqi_hSVB0RpkqPe=s1360-w1360-h1020-rw" class="img-fluid rounded" alt="Plot">
      </a>
    </div>
     
    <div class="col-md-4">
      <a href="https://lh3.googleusercontent.com/gps-cs-s/AC9h4nqwIzVWl4RHakrV14XQ0RruKt5UqZVEsTx9tqTVQV4qhpO4ftnkPZnr3gRzZba1XkFuUP-vTi0ZocBzBW1EAM-_1Y9MSJL2Tev6-6KOY8j-XsapTgigjNKiKD658PuScu1CkCZePXgj9lBF=s1360-w1360-h1020-rw" data-lightbox="realestate-gallery" data-title="Open Plots - East Facing">
        <img src="https://lh3.googleusercontent.com/gps-cs-s/AC9h4nqwIzVWl4RHakrV14XQ0RruKt5UqZVEsTx9tqTVQV4qhpO4ftnkPZnr3gRzZba1XkFuUP-vTi0ZocBzBW1EAM-_1Y9MSJL2Tev6-6KOY8j-XsapTgigjNKiKD658PuScu1CkCZePXgj9lBF=s1360-w1360-h1020-rw" class="img-fluid rounded" alt="Plot">
      </a>
    </div>

     
    <div class="col-md-4">
      <a href="https://lh3.googleusercontent.com/gps-cs-s/AC9h4nqT0zvUq65o1220SFNKp7geKoxuJSo_PrhG2gB3LinbngTQCG5fWVJZAsyRpRfhB6QBJTG6wYlO56kqDZ_mzymCfKhrRU1h8JMOVCi7x5FF28ziZxCy1iDlJqFQ1Rk9KA2TRHJzoF63hfqR=s1360-w1360-h1020-rw" data-lightbox="realestate-gallery" data-title="Plot-Markings">
        <img src="https://lh3.googleusercontent.com/gps-cs-s/AC9h4nqT0zvUq65o1220SFNKp7geKoxuJSo_PrhG2gB3LinbngTQCG5fWVJZAsyRpRfhB6QBJTG6wYlO56kqDZ_mzymCfKhrRU1h8JMOVCi7x5FF28ziZxCy1iDlJqFQ1Rk9KA2TRHJzoF63hfqR=s1360-w1360-h1020-rw" class="img-fluid rounded" alt="Villa">
      </a>
    </div>
  </div>
</div>

 <!-- Video Modal -->
 <!-- PDF Documents Section -->
<div class="container mt-5">
  <h4 class="text-center mb-4">📄 Legal & Technical Documents</h4>   
  <div class="row justify-content-center"> 
    <div class="col-md-5 mb-3">
      <div class="card shadow-sm">
        <div class="card-body text-center">
          <h5 class="card-title">Legal & Approvals</h5>
          <a href="Legal&approvlas.pdf" target="_blank" class="btn btn-outline-success">
            📥 View / Download PDF
          </a>
        </div>
      </div>
    </div>

      <div class="col-md-5 mb-3">
      <div class="card shadow-sm">
        <div class="card-body text-center">
          <h5 class="card-title">Soil Testing</h5>
          <a href="Soil_Testing.pdf" target="_blank" class="btn btn-outline-success">
            📥 View / Download PDF
          </a>
        </div>
      </div>
    </div>

  </div>
</div>

 
<div class="container mt-5">
  <h2 class="mb-1 text-center">Intro Video</h2>
  
  <div class="ratio ratio-16x9">
    <iframe src="https://www.youtube.com/embed/N8ktYQ8rgeo" title="YouTube video" allowfullscreen></iframe>
  </div>

</div>

<div class="container mt-5">
  <h2 class="mb-1 text-center">About The venture</h2>
  
  <div class="ratio ratio-16x9">
    <iframe src="https://www.youtube.com/embed/FUwbqaqUh_Q?si=4RwtntcmKCPndAXJ" title="YouTube video" allowfullscreen></iframe>
  </div>

</div>
 


<!-- Footer Section -->
<footer class="container text-center footer-glass">
  <h4 class="animate__animated animate__fadeInDown">📺 Follow Our YouTube Channel for Regular Updates!</h4>
  <a href="https://www.youtube.com/@ALLISWELLECOVENTURES/featured" 
     target="_blank" 
     class="glass-button mt-3">
    🔔 Visit & Subscribe
  </a>
</footer>


 

  <!-- Location Section -->
<div class="container mt-5">
  <h4 class="mb-3 text-center">📍 Visit Our Office Location</h4>
  <p class="text-center text-muted">We welcome you to explore our ventures at our Ongole office.</p>
  
  <!-- Responsive Map -->
  <div class="ratio ratio-16x9 mb-3">
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d984183.2119121673!2d78.81316467812502!3d15.513147400000006!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3a4b016b75f5ba3b%3A0x1cb43823bb004c08!2sAll%20is%20well%20eco%20ventures%20office%20Ongole!5e0!3m2!1sen!2sin!4v1752240670759!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
  </div>

  <!-- Get Directions Button -->
  <div class="text-center">
    <a href="https://www.google.com/maps/dir/?api=1&destination=All+is+well+eco+ventures+office+Ongole" 
       class="btn btn-outline-primary" 
       target="_blank" 
       rel="noopener noreferrer">
      🚗 Get Directions on Google Maps
    </a>
  </div>
</div>


<!-- Footer -->
<footer class="text-center p-4 mt-5 bg-dark text-white">
  © 2025 RealEstate Portal. All rights reserved.
</footer>
<!-- Lightbox2 JS -->
<script src="https://cdn.jsdelivr.net/npm/lightbox2@2.11.4/dist/js/lightbox-plus-jquery.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script type="module">
	import { createChat } from 'https://cdn.jsdelivr.net/npm/@n8n/chat/dist/chat.bundle.es.js';

	createChat({
		webhookUrl: 'https://devaraju.app.n8n.cloud/webhook/81beeb70-486c-4d87-9cc9-c4bdd6da3a65/chat'
	});
</script>
</body>
</html>
