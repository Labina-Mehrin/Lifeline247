<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Donate to LifeLine for the Missing</title>
  <link href="https://fonts.googleapis.com/css?family=Montserrat:700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #E3F0FF 0%, #fff 100%);
      font-family: 'Roboto', Arial, sans-serif;
      color: #4A4A4A;
    }
    .donate-header {
      font-family: 'Montserrat', Arial, sans-serif;
      font-size: 2.2rem;
      font-weight: 700;
      color: #004DFF;
      margin-bottom: 0.5rem;
    }
    .donate-subheader {
      font-size: 1.15rem;
      color: #2E2E2E;
      margin-bottom: 2.2rem;
    }
    .donation-cards {
      display: flex;
      flex-wrap: wrap;
      gap: 2rem;
      justify-content: center;
      margin-bottom: 2.5rem;
    }
    .donation-card {
      background: #fff;
      border-radius: 18px;
      box-shadow: 0 4px 24px rgba(16,24,40,.10);
      display: flex;
      align-items: center;
      padding: 1.5rem 2rem;
      min-width: 320px;
      max-width: 420px;
      transition: box-shadow .2s, transform .2s;
      cursor: pointer;
      border: 2px solid transparent;
    }
    .donation-card:hover {
      box-shadow: 0 8px 32px rgba(16,24,40,.16);
      border-color: #004DFF;
      transform: translateY(-2px) scale(1.02);
    }
    .donation-icon {
      width: 48px;
      height: 48px;
      margin-right: 1.5rem;
      color: #004DFF;
    }
    .donation-title {
      font-family: 'Roboto', Arial, sans-serif;
      font-size: 1.25rem;
      font-weight: 700;
      color: #004DFF;
      margin-bottom: 0.3rem;
    }
    .donation-description {
      font-size: 1rem;
      color: #4A4A4A;
      margin-bottom: 0.7rem;
    }
    .donate-btn {
      background: #004DFF;
      color: #fff;
      border-radius: 10px;
      padding: 10px 20px;
      font-weight: 500;
      font-size: 1.08rem;
      border: none;
      transition: background .2s;
      box-shadow: 0 2px 8px rgba(0,77,255,.08);
    }
    .donate-btn:hover {
      background: #2B65E2;
    }
    .donation-form {
      background: #fff;
      border-radius: 18px;
      box-shadow: 0 4px 24px rgba(16,24,40,.10);
      padding: 2rem 2.2rem;
      max-width: 480px;
      margin: 0 auto 2rem auto;
      display: none;
    }
    .donation-form.active {
      display: block;
      animation: fadeIn .4s;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .form-label { font-weight: 500; }
    .form-check-input { border-radius: 50%; }
    .form-control, .form-select {
      border-radius: 10px;
      background: #f4f4f4;
      border: 1.5px solid #e3e8f0;
      font-size: 1rem;
    }
    @media (max-width: 900px) {
      .donation-cards { flex-direction: column; align-items: center; }
      .donation-card { max-width: 98vw; }
    }
  </style>
</head>
<body>
  <div class="container py-5">
    <div id="donation-success-message" class="alert alert-success text-center" style="display:none; font-size:1.1rem; font-weight:500; margin-bottom:2rem;">
      Your donation has been successfully processed. Thank you for your support in making a difference! Every contribution helps bring us one step closer to our goal.
    </div>
    <div class="text-center mb-4">
      <div class="donate-header">Donate to LifeLine for the Missing</div>
      <div class="donate-subheader">Your contribution can make a difference. Choose an option below to help those in need.</div>
    </div>
    <div class="donation-cards">
      <div class="donation-card" onclick="showForm('relief')">
        <span class="donation-icon"><i class="fas fa-hand-holding-usd"></i></span>
        <div class="donation-info">
          <h3 class="donation-title">Funds for Relief</h3>
          <p class="donation-description">Help support rescue operations, food, water, and shelter for displaced individuals.</p>
          <button class="donate-btn" type="button">Donate Now</button>
        </div>
      </div>
      <div class="donation-card" onclick="showForm('emergency')">
  <span class="donation-icon"><i class="fas fa-ambulance"></i></span>
        <div class="donation-info">
          <h3 class="donation-title">Emergency Fund</h3>
          <p class="donation-description">Provide immediate financial assistance for urgent needs and emergencies.</p>
          <button class="donate-btn" type="button">Donate Now</button>
        </div>
      </div>
      <div class="donation-card" onclick="showForm('clothing')">
  <span class="donation-icon"><i class="fas fa-tshirt"></i></span>
        <div class="donation-info">
          <h3 class="donation-title">Clothing & Essentials</h3>
          <p class="donation-description">Donate new clothes, hygiene kits, and other essentials for those in need.</p>
          <button class="donate-btn" type="button">Donate Now</button>
        </div>
      </div>
      <div class="donation-card" onclick="showForm('medical')">
  <span class="donation-icon"><i class="fas fa-medkit"></i></span>
        <div class="donation-info">
          <h3 class="donation-title">Medical Supplies</h3>
          <p class="donation-description">Support with first aid kits, medicines, and medical equipment.</p>
          <button class="donate-btn" type="button">Donate Now</button>
        </div>
      </div>
      <div class="donation-card" onclick="showForm('food')">
  <span class="donation-icon"><i class="fas fa-utensils"></i></span>
        <div class="donation-info">
          <h3 class="donation-title">Food and Water</h3>
          <p class="donation-description">Help provide nutritious food and clean water to affected families.</p>
          <button class="donate-btn" type="button">Donate Now</button>
        </div>
      </div>
    </div>
    <!-- Donation Forms -->
    <form id="form-relief" class="donation-form" method="post">
      <h4 class="mb-3">Funds for Relief</h4>
      <div class="mb-3">
        <label class="form-label">Donation Amount</label><br>
        <div class="d-flex gap-2 mb-2">
          <button type="button" class="btn btn-outline-primary" onclick="setAmount(10)">$10</button>
          <button type="button" class="btn btn-outline-primary" onclick="setAmount(25)">$25</button>
          <button type="button" class="btn btn-outline-primary" onclick="setAmount(50)">$50</button>
          <button type="button" class="btn btn-outline-primary" onclick="setAmount(100)">$100</button>
        </div>
        <input type="number" name="amount" id="amount-relief" class="form-control" placeholder="Custom Amount">
      </div>
      <div class="mb-3">
        <label class="form-label">Payment Method</label>
        <select class="form-select" name="payment_method">
          <option>Credit/Debit Card</option>
          <option>PayPal</option>
          <option>Bank Transfer</option>
        </select>
      </div>
      <div class="mb-3">
        <label class="form-label">Name (optional for anonymous)</label>
        <input type="text" name="donor_name" class="form-control" placeholder="Enter your name">
      </div>
      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="donor_email" class="form-control" placeholder="Enter your email">
      </div>
      <div class="mb-3">
        <label class="form-label">Phone</label>
        <input type="text" name="donor_phone" class="form-control" placeholder="Enter your phone">
      </div>
      <button class="donate-btn w-100" type="submit">Complete Donation</button>
    </form>
    <form id="form-emergency" class="donation-form" method="post">
      <h4 class="mb-3">Emergency Fund</h4>
      <div class="mb-3">
        <label class="form-label">Donation Amount</label><br>
        <div class="d-flex gap-2 mb-2">
          <button type="button" class="btn btn-outline-primary" onclick="setAmount(10, 'emergency')">$10</button>
          <button type="button" class="btn btn-outline-primary" onclick="setAmount(25, 'emergency')">$25</button>
          <button type="button" class="btn btn-outline-primary" onclick="setAmount(50, 'emergency')">$50</button>
          <button type="button" class="btn btn-outline-primary" onclick="setAmount(100, 'emergency')">$100</button>
        </div>
        <input type="number" name="amount" id="amount-emergency" class="form-control" placeholder="Custom Amount">
      </div>
      <div class="mb-3">
        <label class="form-label">Payment Method</label>
        <select class="form-select" name="payment_method">
          <option>Credit/Debit Card</option>
          <option>PayPal</option>
          <option>Bank Transfer</option>
        </select>
      </div>
      <div class="mb-3">
        <label class="form-label">Name (optional for anonymous)</label>
        <input type="text" name="donor_name" class="form-control" placeholder="Enter your name">
      </div>
      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="donor_email" class="form-control" placeholder="Enter your email">
      </div>
      <div class="mb-3">
        <label class="form-label">Phone</label>
        <input type="text" name="donor_phone" class="form-control" placeholder="Enter your phone">
      </div>
      <button class="donate-btn w-100" type="submit">Complete Donation</button>
    </form>
    <form id="form-clothing" class="donation-form" method="post">
      <h4 class="mb-3">Clothing & Essentials</h4>
      <div class="mb-3">
        <label class="form-label">Select Items</label><br>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" name="items[]" value="New Clothes" id="clothes">
          <label class="form-check-label" for="clothes">New Clothes</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" name="items[]" value="Hygiene Kits" id="hygiene">
          <label class="form-check-label" for="hygiene">Hygiene Kits</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" name="items[]" value="Blankets" id="blankets">
          <label class="form-check-label" for="blankets">Blankets</label>
        </div>
      </div>
      <div class="mb-3">
        <label class="form-label">Quantity</label>
        <input type="number" name="quantity" class="form-control" min="1" placeholder="Enter quantity">
      </div>
      <div class="mb-3">
        <label class="form-label">Pickup Location</label>
        <input type="text" name="pickup_location" class="form-control" placeholder="Enter pickup address">
      </div>
      <div class="mb-3">
        <label class="form-label">Name</label>
        <input type="text" name="donor_name" class="form-control" placeholder="Enter your name">
      </div>
      <button class="donate-btn w-100" type="submit">Submit Your Donation</button>
    </form>
    <form id="form-medical" class="donation-form" method="post">
      <h4 class="mb-3">Medical Supplies</h4>
      <div class="mb-3">
        <label class="form-label">Select Items</label><br>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" name="items[]" value="First Aid Kits" id="firstaid">
          <label class="form-check-label" for="firstaid">First Aid Kits</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" name="items[]" value="Medicines" id="medicines">
          <label class="form-check-label" for="medicines">Medicines</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" name="items[]" value="Medical Equipment" id="equipment">
          <label class="form-check-label" for="equipment">Medical Equipment</label>
        </div>
      </div>
      <div class="mb-3">
        <label class="form-label">Quantity</label>
        <input type="number" name="quantity" class="form-control" min="1" placeholder="Enter quantity">
      </div>
      <div class="mb-3">
        <label class="form-label">Pickup Location</label>
        <input type="text" name="pickup_location" class="form-control" placeholder="Enter pickup address">
      </div>
      <div class="mb-3">
        <label class="form-label">Name</label>
        <input type="text" name="donor_name" class="form-control" placeholder="Enter your name">
      </div>
      <button class="donate-btn w-100" type="submit">Submit Your Donation</button>
    </form>
    <form id="form-food" class="donation-form" method="post">
      <h4 class="mb-3">Food and Water</h4>
      <div class="mb-3">
        <label class="form-label">Select Items</label><br>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" name="items[]" value="Food Packets" id="foodpackets">
          <label class="form-check-label" for="foodpackets">Food Packets</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" name="items[]" value="Water Bottles" id="waterbottles">
          <label class="form-check-label" for="waterbottles">Water Bottles</label>
        </div>
      </div>
      <div class="mb-3">
        <label class="form-label">Quantity</label>
        <input type="number" name="quantity" class="form-control" min="1" placeholder="Enter quantity">
      </div>
      <div class="mb-3">
        <label class="form-label">Pickup Location</label>
        <input type="text" name="pickup_location" class="form-control" placeholder="Enter pickup address">
      </div>
      <div class="mb-3">
        <label class="form-label">Name</label>
        <input type="text" name="donor_name" class="form-control" placeholder="Enter your name">
      </div>
      <button class="donate-btn w-100" type="submit">Submit Your Donation</button>
    </form>
  </div>
  <script>
    function showForm(type) {
      document.querySelectorAll('.donation-form').forEach(f => f.classList.remove('active'));
      document.getElementById('form-' + type).classList.add('active');
      window.scrollTo({ top: document.getElementById('form-' + type).offsetTop - 40, behavior: 'smooth' });
    }
    function setAmount(val, type = 'relief') {
      document.getElementById('amount-' + type).value = val;
    }

    // Show success message after any donation form is submitted
    document.querySelectorAll('.donation-form').forEach(function(form) {
      form.addEventListener('submit', function(e) {
        e.preventDefault();
        document.getElementById('donation-success-message').style.display = 'block';
        form.reset();
        form.classList.remove('active');
        window.scrollTo({ top: 0, behavior: 'smooth' });
      });
    });
  </script>
</body>
</html>
  </div>
  <!-- <div class="form-check mb-3">
    <input class="form-check-input" type="checkbox" id="consent" name="consent" required> -->
    <!-- <label class="form-check-label" for="consent">
      I confirm the items or funds are genuine and suitable for relief use.
    </label> -->
  <!-- </div> -->
  <!-- <button class="btn btn-success w-100" type="submit">Submit Donation</button> -->
</form>