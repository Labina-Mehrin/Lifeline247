<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Report a Sighting</title>
  <link href="https://fonts.googleapis.com/css?family=Montserrat:700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    .sighting-success-message {
      background: #28A745;
      color: #fff;
      border-radius: 14px;
      padding: 2rem 2rem 1.5rem 2rem;
      margin-top: 2rem;
      text-align: center;
      box-shadow: 0 4px 24px rgba(16,24,40,.10);
    }
    .sighting-success-title {
      font-family: 'Montserrat', Arial, sans-serif;
      font-size: 24px;
      font-weight: bold;
      margin-bottom: 1rem;
    }
    .sighting-success-body {
      font-family: 'Roboto', Arial, sans-serif;
      font-size: 18px;
      font-weight: 400;
      margin-bottom: 2rem;
    }
    .sighting-success-btn {
      font-family: 'Roboto', Arial, sans-serif;
      font-size: 16px;
      font-weight: 500;
      background: #004DFF;
      color: #fff;
      border: none;
      border-radius: 6px;
      padding: 12px 28px;
      cursor: pointer;
      transition: background .2s;
      box-shadow: 0 2px 8px rgba(0,77,255,.08);
    }
    .sighting-success-btn:hover {
      background: #0035CC;
    }
    body {
      background: #F7F7F7;
      font-family: 'Roboto', Arial, sans-serif;
      color: #333333;
    }
    .sighting-header {
      font-family: 'Montserrat', Arial, sans-serif;
      font-size: 2.2rem;
      font-weight: 700;
      color: #004DFF;
      margin-bottom: 0.5rem;
    }
    .sighting-subheader {
      font-size: 1.15rem;
      color: #4A4A4A;
      margin-bottom: 2.2rem;
    }
    .sighting-form {
      background: #fff;
      border-radius: 18px;
      box-shadow: 0 4px 24px rgba(16,24,40,.10);
      padding: 2.2rem 2rem;
      max-width: 540px;
      margin: 0 auto 2rem auto;
    }
    .form-label { font-weight: 500; color: #333333; }
    .form-control, .form-select {
      border-radius: 10px;
      background: #f4f4f4;
      border: 1.5px solid #e3e8f0;
      font-size: 1rem;
      padding-left: 2.2rem;
    }
    .input-icon {
      position: absolute;
      left: 14px;
      top: 50%;
      transform: translateY(-50%);
      color: #004DFF;
      font-size: 1.2rem;
    }
    .input-group { position: relative; }
    .btn-sighting {
      background: #004DFF;
      color: #fff;
      border-radius: 10px;
      padding: 15px 25px;
      font-weight: 500;
      font-size: 1.08rem;
      border: none;
      transition: background .2s;
      box-shadow: 0 2px 8px rgba(0,77,255,.08);
      margin-top: 1.2rem;
    }
    .btn-sighting:hover {
      background: #0035CC;
    }
    .progress-indicator {
      display: flex;
      gap: 8px;
      justify-content: center;
      margin-bottom: 1.5rem;
    }
    .progress-dot {
      width: 12px;
      height: 12px;
      border-radius: 50%;
      background: #E3F0FF;
      border: 2px solid #004DFF;
    }
    .progress-dot.active {
      background: #004DFF;
    }
    .map-container {
      margin: 2rem auto 0 auto;
      max-width: 540px;
      border-radius: 18px;
      overflow: hidden;
      box-shadow: 0 4px 24px rgba(16,24,40,.10);
      background: #fff;
    }
    @media (max-width: 600px) {
      .sighting-header { font-size: 1.5rem; }
      .sighting-form { padding: 1.2rem 0.5rem; }
      .map-container { width: 98vw; }
    }
  </style>
</head>
<body>
  <div class="container py-5">
    <div class="text-center mb-4">
      <div class="sighting-header">Report a Sighting</div>
      <div class="sighting-subheader">Help us reunite missing persons with their families. Provide details below to assist in the search.</div>
    </div>
  <!-- Progress indicator removed as requested -->
    <form class="sighting-form" method="post" enctype="multipart/form-data">
      <div class="mb-3 input-group">
        <span class="input-icon bi bi-geo-alt-fill"></span>
        <input type="text" class="form-control" name="location" placeholder="Enter the location where the person was sighted." required>
      </div>
      <div class="row mb-3">
        <div class="col-md-6 input-group">
          <span class="input-icon bi bi-calendar-event"></span>
          <input type="date" class="form-control" name="date" required>
        </div>
        <div class="col-md-6 input-group">
          <span class="input-icon bi bi-clock"></span>
          <input type="time" class="form-control" name="time" required>
        </div>
      </div>
      <div class="mb-3">
        <label class="form-label">Person's Description</label>
        <textarea class="form-control" name="description" rows="3" placeholder="Describe the person you saw. Include any identifying features (clothing, height, age, etc.)" required></textarea>
      </div>
      <div class="mb-3">
        <label class="form-label">Upload Image/Video</label>
        <div class="input-group">
          <span class="input-icon bi bi-camera"></span>
          <input type="file" class="form-control" name="media" accept="image/*,video/*">
        </div>
      </div>
      <div class="mb-3">
        <label class="form-label">Contact Information (optional)</label>
        <input type="text" class="form-control mb-2" name="contact_name" placeholder="Enter your name">
        <input type="email" class="form-control mb-2" name="contact_email" placeholder="Enter your email">
        <input type="text" class="form-control" name="contact_phone" placeholder="Enter your phone number">
      </div>
      <div class="mb-3">
        <label class="form-label">Additional Notes (optional)</label>
        <textarea class="form-control" name="notes" rows="2" placeholder="Any additional details that could help in identifying the person."></textarea>
      </div>
      <button class="btn-sighting w-100" type="submit">Submit Sighting</button>
      <div id="form-message" class="mt-3"></div>
    </form>
    <div class="map-container mt-4">
      <div id="sightingMap" style="width:100%;height:300px;"></div>
      <input type="hidden" id="mapLat" name="mapLat">
      <input type="hidden" id="mapLng" name="mapLng">
    </div>
  </div>
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
  <script>
    // Initialize Leaflet map
    var map = L.map('sightingMap').setView([23.7509, 90.3911], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 19,
      attribution: '© OpenStreetMap'
    }).addTo(map);
    var marker;
    map.on('click', function(e) {
      if (marker) map.removeLayer(marker);
      marker = L.marker(e.latlng).addTo(map);
      document.getElementById('mapLat').value = e.latlng.lat;
      document.getElementById('mapLng').value = e.latlng.lng;
    });

    // Simple client-side validation and feedback
    document.querySelector('.sighting-form').addEventListener('submit', function(e) {
      var form = e.target;
      var msg = document.getElementById('form-message');
      msg.innerHTML = '';
      var location = form.location.value.trim();
      var date = form.date.value;
      var time = form.time.value;
      var description = form.description.value.trim();
      var lat = document.getElementById('mapLat').value;
      var lng = document.getElementById('mapLng').value;
      if (!location || !date || !time || !description) {
        e.preventDefault();
        msg.innerHTML = '<div class="alert alert-danger">Please fill out all required fields.</div>';
        return false;
      }
      if (!lat || !lng) {
        e.preventDefault();
        msg.innerHTML = '<div class="alert alert-danger">Please pin the sighting location on the map.</div>';
        return false;
      }
      e.preventDefault();
      msg.innerHTML = `
        <div class="sighting-success-message">
          <div class="sighting-success-title">Your sighting report has been successfully submitted.</div>
          <div class="sighting-success-body">Thank you for helping us in the search for the person. Your information is vital in bringing them home.</div>
          <button class="sighting-success-btn" onclick="window.location.reload()">Report Another Sighting</button>
        </div>
      `;
      form.reset();
    });
  </script>
</body>
</html>
