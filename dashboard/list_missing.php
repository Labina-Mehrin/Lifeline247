<?php
require_once '../db_connect.php';
$result = $conn->query("SELECT * FROM missing_persons WHERE status='APPROVED' ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Find Someone</title>
	<link href="https://fonts.googleapis.com/css?family=Montserrat:700&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&display=swap" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
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
		.filter-select, .filter-checkbox {
			font-family: 'Roboto', Arial, sans-serif;
			font-size: 1rem;
			border-radius: 10px;
			border: 1.5px solid #e3e8f0;
			background: #fff;
			color: #333333;
			padding: 8px 16px;
			min-width: 160px;
		}
		.missing-list {
			max-width: 900px;
			margin: 0 auto 2rem auto;
			display: flex;
			flex-wrap: wrap;
			gap: 1.5rem;
			justify-content: center;
		}
		.missing-person-card {
			background: #fff;
			border-radius: 8px;
			box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
			padding: 1.2rem 1.5rem;
			display: flex;
			align-items: center;
			gap: 1.2rem;
			min-width: 320px;
			max-width: 420px;
			margin-bottom: 1rem;
		}
		.person-photo {
			width: 80px;
			height: 80px;
			object-fit: cover;
			border-radius: 10px;
			border: 2px solid #004DFF;
		}
		.person-info {
			flex: 1;
		}
		.person-name {
			font-family: 'Roboto', Arial, sans-serif;
			font-weight: 700;
			font-size: 1.15rem;
			color: #004DFF;
			margin-bottom: 0.2rem;
		}
		.person-status {
			font-family: 'Roboto', Arial, sans-serif;
			font-weight: 500;
			font-size: 0.95rem;
			margin-bottom: 0.2rem;
			display: inline-block;
			padding: 2px 10px;
			border-radius: 8px;
		}
		.status-missing { background: #FFE5E0; color: #FF5733; }
		.status-located { background: #E8F8F0; color: #28A745; }
		.status-investigation { background: #FFF4E0; color: #FF9900; }
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
			.missing-list { max-width: 98vw; }
		}
		@media (max-width: 600px) {
			.page-header { font-size: 1.3rem; }
			.page-subheader { font-size: 1rem; }
			.search-bar { max-width: 98vw; }
			.missing-person-card { min-width: 98vw; max-width: 98vw; flex-direction: column; align-items: flex-start; }
			.person-photo { margin-bottom: 0.5rem; }
		}
	</style>
</head>
<body>
	<div class="container py-5">
		<div class="text-center mb-4">
			<div class="page-header">Find Someone</div>
			<div class="page-subheader">Search for missing persons by name, location, or other identifying details.</div>
		</div>
		<div class="search-bar mb-3">
			<span class="search-icon bi bi-search"></span>
			<input type="text" class="search-input" id="searchInput" placeholder="Search by name, location, or unique identifiers (e.g., clothing, features)" aria-label="Search missing persons">
		</div>
		<div class="filters mb-3">
			<select class="filter-select" id="locationFilter" aria-label="Filter by location">
				<option value="all">All Locations</option>
				<option value="Dhaka">Dhaka</option>
				<option value="Banani">Banani</option>
				<option value="Uttara">Uttara</option>
				<option value="Serakh">Serakh</option>
			</select>
			<select class="filter-select" id="dateFilter" aria-label="Filter by last seen date">
				<option value="all">Any Date</option>
				<option value="week">Within a week</option>
				<option value="month">Within a month</option>
			</select>
			<select class="filter-select" id="statusFilter" aria-label="Filter by status">
				<option value="all">All Statuses</option>
				<option value="missing">Missing</option>
				<option value="located">Located</option>
				<option value="investigation">Under Investigation</option>
			</select>
			<select class="filter-select" id="ageFilter" aria-label="Filter by age range">
				<option value="all">All Ages</option>
				<option value="child">Child</option>
				<option value="teen">Teen</option>
				<option value="adult">Adult</option>
			</select>
		</div>
		<div class="missing-list" id="missingList">
			<?php while($row = $result->fetch_assoc()): 
        $photo = '';
        $photos = json_decode($row['photos'], true);
        if (!empty($photos) && isset($photos[0])) {
            $photo = htmlspecialchars($photos[0]);
        }
    ?>
        <div class="missing-person-card mb-3">
            <div class="d-flex align-items-center">
                <img src="<?= htmlspecialchars($photo) ?>" class="person-photo me-3" alt="Photo">
                <div class="person-info">
                    <div class="person-name"><?= htmlspecialchars($row['full_name']) ?></div>
                    <div class="person-status status-missing">Status: Missing</div>
                    <div class="small text-muted">Location: <?= htmlspecialchars($row['last_seen_location']) ?> | Last Seen: <?= htmlspecialchars($row['last_seen_datetime']) ?></div>
                    <a href="profile.php?id=<?= $row['id'] ?>" class="btn btn-primary mt-2">View Details</a>
                </div>
            </div>
        </div>
    <?php endwhile; ?>
		</div>
		<button class="load-more-btn" id="loadMoreBtn" style="display:none;">Load More</button>
	</div>
	<!-- <div class="footer">
		<a href="#">Contact Us</a> |
		<a href="#">Terms & Conditions</a> |
		<a href="#">Privacy Policy</a>
	</div> -->
	<script>
		// Example data (replace with dynamic data from backend)
		const missingPersons = [
			{
				name: "Michael Johnson",
				photo: "uploads/photo3.jpg",
				location: "Dhaka",
				lastSeen: "Apr 10, 2024",
				status: "missing",
				age: "adult"
			},
			{
				name: "Jahin",
				photo: "uploads/jahin_photo.png",
				location: "Banani",
				lastSeen: "May 2, 2024",
				status: "missing",
				age: "teen"
			},
			{
				name: "Gina",
				photo: "uploads/photo6.jpg",
				location: "Uttara",
				lastSeen: "May 5, 2024",
				status: "investigation",
				age: "adult"
			},
			{
				name: "Emily Chen",
				photo: "uploads/photo4.jpg",
				location: "Serakh",
				lastSeen: "Last Seen, Dua",
				status: "located",
				age: "adult"
			}
		];
		let filteredPersons = missingPersons;
		let personsPerPage = 4;
		let currentPage = 1;
		// List rendering
			function renderMissingList(persons, page = 1) {
				const list = document.getElementById('missingList');
				list.innerHTML = '';
				const start = (page - 1) * personsPerPage;
				const end = start + personsPerPage;
				persons.slice(start, end).forEach((person, idx) => {
					const card = document.createElement('div');
					card.className = 'missing-person-card';
					card.innerHTML = `
						<img src="${person.photo}" alt="Photo of ${person.name}" class="person-photo">
						<div class="person-info">
							<h3 class="person-name">${person.name}</h3>
							<p class="person-status status-${person.status}">Status: ${person.status.charAt(0).toUpperCase() + person.status.slice(1)}</p>
							<p class="person-meta">Location: ${person.location} | Last Seen: ${person.lastSeen}</p>
							<button class="view-details-btn" tabindex="0" aria-label="View details for ${person.name}" data-idx="${start+idx}">View Details</button>
						</div>
					`;
					list.appendChild(card);
				});
				// Pagination
				const loadMoreBtn = document.getElementById('loadMoreBtn');
				if (persons.length > end) {
					loadMoreBtn.style.display = 'block';
				} else {
					loadMoreBtn.style.display = 'none';
				}
				// Attach modal logic
				document.querySelectorAll('.view-details-btn').forEach(btn => {
					btn.onclick = function() {
						const idx = parseInt(btn.getAttribute('data-idx'));
						showDetailsModal(filteredPersons[idx]);
					};
				});
			}

			// Modal HTML
			if (!document.getElementById('detailsModal')) {
				const modal = document.createElement('div');
				modal.id = 'detailsModal';
				modal.style.display = 'none';
				modal.innerHTML = `
					<div class="modal-backdrop" style="position:fixed;top:0;left:0;width:100vw;height:100vh;background:rgba(0,0,0,0.4);z-index:1040;display:none;"></div>
				<div class="modal-content" style="position:fixed;top:50%;left:50%;transform:translate(-50%,-50%);background:#fff;border-radius:18px;box-shadow:0 8px 32px rgba(16,24,40,.18);padding:2.5rem 1rem;max-width:90vw;width:100vw;z-index:1050;display:none;overflow-y:auto;max-height:90vh;">
						<button type="button" class="btn-close" aria-label="Close" style="position:absolute;top:18px;right:18px;font-size:1.5rem;"></button>
						<div id="modalBody"></div>
					</div>
				`;
				document.body.appendChild(modal);
				modal.querySelector('.modal-backdrop').onclick = closeDetailsModal;
				modal.querySelector('.btn-close').onclick = closeDetailsModal;
			}

			function showDetailsModal(person) {
				const modal = document.getElementById('detailsModal');
				const backdrop = modal.querySelector('.modal-backdrop');
				const content = modal.querySelector('.modal-content');
				const body = modal.querySelector('#modalBody');
				// Example timeline data
				const timeline = [
					{ date: 'Apr 10, 2024', desc: `Last seen in ${person.location}`, type: '' },
					{ date: 'Apr 12, 2024', desc: 'Reported by witness', type: 'urgent' },
					{ date: 'Apr 15, 2024', desc: 'Located in hospital', type: 'success' }
				];
				body.innerHTML = `
					<div class="text-center mb-4">
						<img src="${person.photo}" alt="Photo of ${person.name}" style="width:120px;height:120px;object-fit:cover;border-radius:50%;border:3px solid #004DFF;">
						<h1 style="font-family:Montserrat;font-size:2rem;font-weight:700;color:#004DFF;margin:0.7rem 0 0.2rem 0;">${person.name}</h1>
						<span class="badge" style="font-size:1rem;padding:6px 18px;border-radius:8px;background:${person.status==='missing'?'#FF5733':person.status==='located'?'#28A745':'#FF9900'};color:#fff;">${person.status.charAt(0).toUpperCase() + person.status.slice(1)}</span>
					</div>
					<div class="mb-3">
						<div class="person-info-card" style="background:#F7F7F7;border-radius:12px;padding:1.2rem 1rem;margin-bottom:1rem;">
							<p class="info-item"><strong>Age:</strong> 30 years</p>
							<p class="info-item"><strong>Height:</strong> 5'9"</p>
							<p class="info-item"><strong>Last Seen Location:</strong> ${person.location}</p>
							<p class="info-item"><strong>Contact:</strong> <span style="color:#28A745;font-weight:500;">(123) 456-7890</span></p>
							<p class="info-item"><strong>Clothing:</strong> Blue jacket, jeans</p>
						</div>
					</div>
					<div class="mb-3">
						<h5 style="font-family:Montserrat;font-size:1.1rem;color:#004DFF;margin-bottom:0.7rem;">Timeline & Updates</h5>
						<div class="timeline">
							${timeline.map(item => `
								<div class="timeline-item ${item.type}" style="background:#fff;border-radius:8px;padding:0.7rem 1rem;margin-bottom:0.6rem;box-shadow:0 2px 8px rgba(16,24,40,.08);border-left:5px solid ${item.type==='urgent'?'#FF5733':item.type==='success'?'#28A745':'#004DFF'};">
									<p class="timeline-date" style="font-size:0.98rem;color:#6C757D;margin-bottom:0.2rem;">${item.date}</p>
									<p class="timeline-description" style="font-size:1rem;color:${item.type==='urgent'?'#FF5733':item.type==='success'?'#28A745':'#333'};margin-bottom:0;">${item.desc}</p>
								</div>
							`).join('')}
						</div>
					</div>
					<div class="cta-buttons mb-2 text-center">
						  <button class="report-sighting-btn" style="background:#004DFF;color:#fff;font-family:Roboto;font-size:1.1rem;font-weight:500;border:none;border-radius:10px;padding:12px 25px;margin-bottom:0.7rem;transition:background .2s;">Report a Sighting</button>
						  <!-- Social sharing buttons removed -->
					</div>
				<!-- Footer links removed -->
				`;
						modal.style.display = '';
						backdrop.style.display = 'block';
						content.style.display = 'block';
						document.body.style.overflow = 'hidden';
						// Add redirect for Report a Sighting button
						setTimeout(function() {
							const reportBtn = modal.querySelector('.report-sighting-btn');
							if (reportBtn) {
								reportBtn.onclick = function() {
									window.location.href = 'report_sighting.php';
								};
							}
						}, 100);
			}
			function closeDetailsModal() {
				const modal = document.getElementById('detailsModal');
				const backdrop = modal.querySelector('.modal-backdrop');
				const content = modal.querySelector('.modal-content');
				modal.style.display = 'none';
				backdrop.style.display = 'none';
				content.style.display = 'none';
				document.body.style.overflow = '';
			}
		// Filter logic
		function applyFilters() {
			const searchVal = document.getElementById('searchInput').value.toLowerCase();
			const location = document.getElementById('locationFilter').value;
			const date = document.getElementById('dateFilter').value;
			const status = document.getElementById('statusFilter').value;
			const age = document.getElementById('ageFilter').value;
			filteredPersons = missingPersons.filter(person => {
				let match = true;
				if (searchVal) {
					match = person.name.toLowerCase().includes(searchVal) ||
									person.location.toLowerCase().includes(searchVal);
				}
				if (location !== 'all') {
					match = match && person.location === location;
				}
				if (status !== 'all') {
					match = match && person.status === status;
				}
				if (age !== 'all') {
					match = match && person.age === age;
				}
				// Date filter logic can be added here
				return match;
			});
			currentPage = 1;
			renderMissingList(filteredPersons, currentPage);
		}
		document.getElementById('searchInput').addEventListener('input', applyFilters);
		document.getElementById('locationFilter').addEventListener('change', applyFilters);
		document.getElementById('dateFilter').addEventListener('change', applyFilters);
		document.getElementById('statusFilter').addEventListener('change', applyFilters);
		document.getElementById('ageFilter').addEventListener('change', applyFilters);
		document.getElementById('loadMoreBtn').addEventListener('click', function() {
			currentPage++;
			renderMissingList(filteredPersons, currentPage);
		});
		// Initial render
		renderMissingList(missingPersons, currentPage);
		// Accessibility: Keyboard navigation for filter controls
		document.querySelectorAll('.filter-select, .search-input').forEach(el => {
			el.setAttribute('tabindex', '0');
		});
	</script>
</body>
</html>

