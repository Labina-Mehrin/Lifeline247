<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Hospitals and Shelters</title>
  <link href="https://fonts.googleapis.com/css?family=Montserrat:700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
  <style>
    body {
      background: #F7F7F7;
      font-family: 'Roboto', Arial, sans-serif;
      color: #333333;
    }
    .page-header {
      font-family: 'Montserrat', Arial, sans-serif;
      font-size: 2rem;
      font-weight: 700;
      color: #004DFF;
      margin-bottom: 0.5rem;
    }
    .page-subheader {
      font-size: 1.15rem;
      color: #4A4A4A;
      margin-bottom: 2rem;
    }
    .search-bar {
      position: relative;
      max-width: 540px;
      margin: 0 auto 1.5rem auto;
    }
    .search-input {
      font-family: 'Roboto', Arial, sans-serif;
      font-size: 1rem;
      background: #f4f4f4;
      border-radius: 10px;
      border: 1.5px solid #e3e8f0;
      padding: 12px 16px 12px 40px;
      width: 100%;
      color: #333333;
    }
    .search-icon {
      position: absolute;
      left: 14px;
      top: 50%;
      transform: translateY(-50%);
      color: #004DFF;
      font-size: 1.2rem;
    }
    .filters {
      display: flex;
      gap: 1rem;
      justify-content: center;
      margin-bottom: 1.5rem;
      flex-wrap: wrap;
    }
    .filter-select, .filter-slider {
      font-family: 'Roboto', Arial, sans-serif;
      font-size: 1rem;
      border-radius: 10px;
      border: 1.5px solid #e3e8f0;
      background: #fff;
      color: #333333;
      padding: 8px 16px;
      min-width: 160px;
    }
    .filter-slider::-webkit-slider-thumb {
      background: #004DFF;
    }
    .map-section {
      width: 100%;
      max-width: 900px;
      margin: 0 auto 2rem auto;
      border-radius: 18px;
      overflow: hidden;
      box-shadow: 0 4px 24px rgba(16,24,40,.10);
      background: #fff;
      min-height: 350px;
    }
    #facilityMap {
      width: 100%;
      height: 350px;
    }
    .list-section {
      max-width: 900px;
      margin: 0 auto 2rem auto;
    }
    .facility-card {
      background: #fff;
      border-radius: 14px;
      box-shadow: 0 2px 12px rgba(16,24,40,.08);
      padding: 1.2rem 1.5rem;
      margin-bottom: 1.2rem;
      display: flex;
      flex-direction: column;
      gap: 0.5rem;
    }
    .facility-name {
      font-family: 'Roboto', Arial, sans-serif;
      font-weight: 700;
      font-size: 1.15rem;
      color: #004DFF;
      margin-bottom: 0.2rem;
    }
    .facility-type {
      font-family: 'Roboto', Arial, sans-serif;
      font-weight: 500;
      font-size: 0.95rem;
      margin-bottom: 0.2rem;
      display: inline-block;
      padding: 2px 10px;
      border-radius: 8px;
    }
    .facility-type.hospital { background: #E3F0FF; color: #004DFF; }
    .facility-type.shelter { background: #E8F8F0; color: #28A745; }
    .facility-type.relief { background: #FFF4E0; color: #FF9900; }
    .facility-address, .facility-phone, .facility-email, .facility-distance {
      font-family: 'Roboto', Arial, sans-serif;
      font-size: 1rem;
      color: #333333;
      margin-bottom: 0.1rem;
    }
    .view-details-btn {
      background: #004DFF;
      color: #fff;
      border-radius: 10px;
      padding: 8px 18px;
      font-weight: 500;
      font-size: 1rem;
      border: none;
      transition: background .2s;
      margin-top: 0.5rem;
    }
    .view-details-btn:hover {
      background: #0035CC;
    }
    .load-more-btn {
      background: #004DFF;
      color: #fff;
      border-radius: 10px;
      padding: 10px 28px;
      font-weight: 500;
      font-size: 1rem;
      border: none;
      transition: background .2s;
      margin: 1.5rem auto 0 auto;
      display: block;
    }
    .load-more-btn:hover {
      background: #0035CC;
    }
    .footer {
      background: #F7F7F7;
      color: #6C757D;
      font-family: 'Roboto', Arial, sans-serif;
      font-size: 0.95rem;
      padding: 2rem 0 1rem 0;
      text-align: center;
    }
    .footer a {
      color: #004DFF;
      text-decoration: none;
      margin: 0 10px;
    }
    .footer a:hover {
      text-decoration: underline;
    }
    @media (max-width: 900px) {
      .map-section, .list-section { max-width: 98vw; }
    }
    @media (max-width: 600px) {
      .page-header { font-size: 1.3rem; }
      .page-subheader { font-size: 1rem; }
      .search-bar { max-width: 98vw; }
      .map-section { min-height: 220px; }
      #facilityMap { height: 220px; }
      .facility-card { padding: 1rem 0.5rem; }
    }
  </style>
</head>
<body>
  <div class="container py-5">
    <div class="text-center mb-4">
      <div class="page-header">Hospitals and Shelters</div>
      <div class="page-subheader">Find nearby hospitals, shelters, and relief centers to assist with the search and recovery.</div>
    </div>
    <div class="search-bar mb-3">
      <span class="search-icon bi bi-search"></span>
      <input type="text" class="search-input" id="searchInput" placeholder="Search by name, location, or type of facility" aria-label="Search hospitals and shelters">
    </div>
    <div class="filters mb-3">
      <select class="filter-select" id="categoryFilter" aria-label="Filter by category">
        <option value="all">All</option>
        <option value="hospital">Hospital</option>
        <option value="shelter">Shelter</option>
        <option value="relief">Relief Center</option>
      </select>
      <select class="filter-select" id="distanceFilter" aria-label="Filter by distance">
        <option value="any">Any distance</option>
        <option value="5">Within 5 km</option>
        <option value="10">Within 10 km</option>
        <option value="20">Within 20 km</option>
      </select>
    </div>
    <div class="map-section mb-4">
      <div id="facilityMap"></div>
    </div>
    <div class="list-section" id="facilityList">
      <!-- Facility cards will be rendered here -->
    </div>

    <!-- Facility Details Modal -->
    <div class="modal fade" id="facilityDetailsModal" tabindex="-1" aria-labelledby="facilityDetailsLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="border-radius:16px; background:#F7F7F7;">
          <div class="modal-header" style="border-bottom:none;">
            <div class="facility-header w-100 d-flex flex-column flex-md-row align-items-md-center justify-content-between">
              <span id="modalFacilityName" class="facility-name" style="font-family:Montserrat,Arial,sans-serif;font-size:32px;font-weight:bold;"></span>
              <span id="modalFacilityType" class="facility-type" style="font-family:Roboto,Arial,sans-serif;font-size:18px;font-weight:500;"></span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="facility-details mb-3" style="font-size:16px;color:#333;">
              <p id="modalFacilityLocation" class="facility-location mb-1"></p>
              <p id="modalFacilityPhone" class="contact-info mb-1"></p>
              <p id="modalFacilityEmail" class="contact-info mb-1"></p>
              <p id="modalFacilityHours" class="hours-info mb-1"></p>
              <p id="modalFacilityEmergency" class="contact-info mb-1"></p>
            </div>
            <div class="services-section mb-3" style="background:#fff;border-radius:8px;padding:1rem;">
              <h4 class="services-heading mb-2" style="font-family:Roboto,Arial,sans-serif;font-size:18px;font-weight:500;color:#333;">Services Offered</h4>
              <ul id="modalServicesList" class="services-list" style="font-size:16px;color:#333;margin-left:20px;"></ul>
            </div>
            <div class="mb-3">
              <p id="modalFacilityDirections"></p>
              <p id="modalFacilitySpecialized"></p>
              <p id="modalFacilityAmenities"></p>
            </div>
            <div id="modalFacilityNotice" class="alert alert-warning d-none"></div>
            <div class="d-flex gap-2 mt-3 flex-wrap">
              <button id="modalDonateBtn" class="donate-btn" style="background-color:#004DFF;color:white;border:none;padding:12px 20px;border-radius:5px;cursor:pointer;">Donate Now</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>
    <button class="load-more-btn" id="loadMoreBtn" style="display:none;">Load More</button>
  </div>
  <!-- Footer removed as requested -->
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Example data (replace with dynamic data from backend)
    const facilities = [
      {
        name: "St. Mary's General Hospital",
        type: "hospital",
        address: "123 Health St., Central City",
        phone: "(555) 100-0001",
        email: "stmarys@hospital.com",
        lat: 23.7510,
        lng: 90.3910,
        distance: 2,
        website: "#"
      },
      {
        name: "Green Valley Shelter",
        type: "shelter",
        address: "456 Oak Rd., West Side",
        phone: "(555) 100-0002",
        email: "greenvalley@shelter.com",
        lat: 23.7495,
        lng: 90.3865,
        distance: 4,
        website: "#"
      },
      {
        name: "Central City Emergency Center",
        type: "hospital",
        address: "789 Main St., Central City",
        phone: "(555) 100-0003",
        email: "emergency@centralcity.com",
        lat: 23.7542,
        lng: 90.3898,
        distance: 3,
        website: "#"
      },
      {
        name: "Hope Haven Shelter",
        type: "shelter",
        address: "321 Elm St., Downtown",
        phone: "(555) 100-0004",
        email: "hopehaven@shelter.com",
        lat: 23.7478,
        lng: 90.3952,
        distance: 5,
        website: "#"
      },
      {
        name: "CityCare Hospital",
        type: "hospital",
        address: "654 Maple Ave., East Town",
        phone: "(555) 100-0005",
        email: "citycare@hospital.com",
        lat: 23.7591,
        lng: 90.3847,
        distance: 6,
        website: "#"
      },
      {
        name: "Silver Lining Relief Center",
        type: "relief",
        address: "1023 Pine Blvd., North District",
        phone: "(555) 100-0006",
        email: "silverlining@relief.com",
        lat: 23.7623,
        lng: 90.3999,
        distance: 7,
        website: "#"
      },
      {
        name: "Sunrise Hospital",
        type: "hospital",
        address: "100 Sun St., Central City",
        phone: "(555) 100-0007",
        email: "sunrise@hospital.com",
        lat: 23.7444,
        lng: 90.3888,
        distance: 2,
        website: "#"
      },
      {
        name: "Safe Harbor Shelter",
        type: "shelter",
        address: "207 River Rd., Lakeside",
        phone: "(555) 100-0008",
        email: "safeharbor@shelter.com",
        lat: 23.7555,
        lng: 90.4032,
        distance: 8,
        website: "#"
      },
      {
        name: "St. Paul’s Community Hospital",
        type: "hospital",
        address: "805 Church St., Old Town",
        phone: "(555) 100-0009",
        email: "stpauls@hospital.com",
        lat: 23.7489,
        lng: 90.4011,
        distance: 4,
        website: "#"
      },
      {
        name: "The Bridge Shelter",
        type: "shelter",
        address: "1122 Bay St., Riverside",
        phone: "(555) 100-0010",
        email: "bridge@shelter.com",
        lat: 23.7607,
        lng: 90.3876,
        distance: 6,
        website: "#"
      },
      {
        name: "Mercy Health Center",
        type: "hospital",
        address: "349 Oakwood Dr., Greenfield",
        phone: "(555) 100-0011",
        email: "mercy@healthcenter.com",
        lat: 23.7432,
        lng: 90.4023,
        distance: 7,
        website: "#"
      },
      {
        name: "New Horizons Shelter",
        type: "shelter",
        address: "254 High St., Midtown",
        phone: "(555) 100-0012",
        email: "newhorizons@shelter.com",
        lat: 23.7588,
        lng: 90.3977,
        distance: 5,
        website: "#"
      },
      {
        name: "East Side Medical Center",
        type: "hospital",
        address: "403 Birchwood Ave., East City",
        phone: "(555) 100-0013",
        email: "eastside@medical.com",
        lat: 23.7466,
        lng: 90.3902,
        distance: 6,
        website: "#"
      },
      {
        name: "Healing Hands Relief Center",
        type: "relief",
        address: "900 Cedar Blvd., South Bay",
        phone: "(555) 100-0014",
        email: "healinghands@relief.com",
        lat: 23.7612,
        lng: 90.3933,
        distance: 9,
        website: "#"
      },
      {
        name: "Community Health Hospital",
        type: "hospital",
        address: "768 Hillcrest Rd., Downtown",
        phone: "(555) 100-0015",
        email: "communityhealth@hospital.com",
        lat: 23.7502,
        lng: 90.4055,
        distance: 3,
        website: "#"
      }
    ];
    let filteredFacilities = facilities;
    let facilitiesPerPage = 5;
    let currentPage = 1;
    // Map setup
    var map = L.map('facilityMap').setView([23.7509, 90.3911], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 19,
      attribution: '© OpenStreetMap'
    }).addTo(map);
    // Pin colors
    function getPinColor(type) {
      if (type === 'hospital') return '#004DFF';
      if (type === 'shelter') return '#28A745';
      if (type === 'relief') return '#FF9900';
      return '#004DFF';
    }
    let markers = [];
    function renderMapMarkers(facilities) {
      markers.forEach(m => map.removeLayer(m));
      markers = facilities.map(facility => {
        let marker = L.marker([facility.lat, facility.lng], {
          icon: L.divIcon({
            className: 'custom-pin',
            html: `<span style="font-size:2rem;color:${getPinColor(facility.type)};">●</span>`
          })
        }).addTo(map);
        marker.bindPopup(`<strong>${facility.name}</strong><br>${facility.type.charAt(0).toUpperCase() + facility.type.slice(1)}<br>${facility.address}<br>Phone: ${facility.phone}<br><a href='${facility.website}' target='_blank'>More info</a>`);
        return marker;
      });
    }
    // List rendering
    function renderFacilityList(facilities, page = 1) {
      const list = document.getElementById('facilityList');
      list.innerHTML = '';
      const start = (page - 1) * facilitiesPerPage;
      const end = start + facilitiesPerPage;
      facilities.slice(start, end).forEach((facility, idx) => {
        const card = document.createElement('div');
        card.className = 'facility-card';
        card.innerHTML = `
          <h3 class="facility-name">${facility.name}</h3>
          <span class="facility-type ${facility.type}">${facility.type.charAt(0).toUpperCase() + facility.type.slice(1)}</span>
          <p class="facility-address">${facility.address}</p>
          <p class="facility-phone">Phone: ${facility.phone}</p>
          <p class="facility-email">Email: ${facility.email}</p>
          <p class="facility-distance">Distance: ${facility.distance} km</p>
          <button class="view-details-btn" tabindex="0" aria-label="View details for ${facility.name}" data-idx="${start+idx}">View Details</button>
        `;
        list.appendChild(card);
      });
      // Pagination
      const loadMoreBtn = document.getElementById('loadMoreBtn');
      if (facilities.length > end) {
        loadMoreBtn.style.display = 'block';
      } else {
        loadMoreBtn.style.display = 'none';
      }
    }
    // Filter logic
    function applyFilters() {
      const searchVal = document.getElementById('searchInput').value.toLowerCase();
      const category = document.getElementById('categoryFilter').value;
      const distance = document.getElementById('distanceFilter').value;
      filteredFacilities = facilities.filter(facility => {
        let match = true;
        if (searchVal) {
          match = facility.name.toLowerCase().includes(searchVal) ||
                  facility.address.toLowerCase().includes(searchVal) ||
                  facility.type.toLowerCase().includes(searchVal);
        }
        if (category !== 'all') {
          match = match && facility.type === category;
        }
        if (distance !== 'any') {
          match = match && facility.distance <= parseInt(distance);
        }
        return match;
      });
      currentPage = 1;
      renderFacilityList(filteredFacilities, currentPage);
      renderMapMarkers(filteredFacilities);
    }
    document.getElementById('searchInput').addEventListener('input', applyFilters);
    document.getElementById('categoryFilter').addEventListener('change', applyFilters);
    document.getElementById('distanceFilter').addEventListener('change', applyFilters);
    document.getElementById('loadMoreBtn').addEventListener('click', function() {
      currentPage++;
      renderFacilityList(filteredFacilities, currentPage);
    });
    // Initial render
    renderFacilityList(facilities, currentPage);
    renderMapMarkers(facilities);

    // View Details Modal logic
    document.querySelectorAll('.view-details-btn').forEach(btn => {
      btn.addEventListener('click', function() {
        const idx = parseInt(btn.getAttribute('data-idx'));
        const facility = filteredFacilities[idx] || facilities[idx];
        // Header
        document.getElementById('modalFacilityName').textContent = facility.name;
        let typeColor = '#004DFF';
        if (facility.type === 'shelter') typeColor = '#28A745';
        if (facility.type === 'relief') typeColor = '#FF9900';
        document.getElementById('modalFacilityType').textContent = facility.type.charAt(0).toUpperCase() + facility.type.slice(1);
        document.getElementById('modalFacilityType').style.color = typeColor;
        // Basic Info
        document.getElementById('modalFacilityLocation').innerHTML = `<strong>Location:</strong> ${facility.address}`;
        document.getElementById('modalFacilityPhone').innerHTML = `<strong>Phone:</strong> ${facility.phone}`;
        document.getElementById('modalFacilityEmail').innerHTML = `<strong>Email:</strong> ${facility.email}`;
  document.getElementById('modalFacilityHours').innerHTML = `<strong>Operating Hours:</strong> 24/7`;
  document.getElementById('modalFacilityEmergency').innerHTML = facility.emergency ? `<strong>Emergency Contact:</strong> ${facility.emergency}` : '';
        // Services
        const servicesList = document.getElementById('modalServicesList');
        servicesList.innerHTML = '';
        (facility.services || [facility.type==='hospital'?"Emergency Care":"",facility.type==='hospital'?"Surgery":"",facility.type==='hospital'?"Maternity":"",facility.type==='hospital'?"Outpatient":"",facility.type==='hospital'?"Pediatrics":"",facility.type==='hospital'?"Intensive Care":"",facility.type==='shelter'?"Emergency Shelter":"",facility.type==='shelter'?"Long-term Stay":"",facility.type==='shelter'?"Food & Clothing Distribution":"",facility.type==='shelter'?"Counseling Services":"",facility.type==='relief'?"Disaster Relief":"",facility.type==='relief'?"First Aid":"",facility.type==='relief'?"Distribution of Supplies":""].filter(Boolean)).forEach(s => {
          const li = document.createElement('li');
          li.textContent = s;
          servicesList.appendChild(li);
        });
        // Directions
        document.getElementById('modalFacilityDirections').innerHTML = `<strong>Directions:</strong> <a href="https://www.google.com/maps?q=${encodeURIComponent(facility.address)}" target="_blank">View on Google Maps</a>`;
        // Specialized Services
        document.getElementById('modalFacilitySpecialized').innerHTML = facility.specialized ? `<strong>Specialized Services:</strong> ${facility.specialized}` : '';
        // Amenities
        document.getElementById('modalFacilityAmenities').innerHTML = facility.amenities ? `<strong>Nearby Amenities:</strong> ${facility.amenities}` : '';
        // Notice
        const noticeDiv = document.getElementById('modalFacilityNotice');
        if (facility.notice) {
          noticeDiv.textContent = facility.notice;
          noticeDiv.classList.remove('d-none');
        } else {
          noticeDiv.classList.add('d-none');
        }
        // CTA buttons
        document.getElementById('modalDonateBtn').style.display = (facility.type==='shelter'||facility.type==='relief') ? 'inline-block' : 'none';
        document.getElementById('modalDonateBtn').onclick = function() {
          window.location.href = '../donate.php';
        };
        // Show modal
        var modal = new bootstrap.Modal(document.getElementById('facilityDetailsModal'));
        modal.show();
      });
    });
    // Accessibility: Keyboard navigation for filter controls
    document.querySelectorAll('.filter-select, .search-input').forEach(el => {
      el.setAttribute('tabindex', '0');
    });
  </script>
</body>
</html>
