// Prison Management System - Main JavaScript
class PrisonSystem {
    constructor() {
        this.currentPage = 'home';
        this.charts = {};
        this.dataTables = {};
        this.initialize();
    }

    initialize() {
        document.addEventListener('DOMContentLoaded', () => {
            this.initTheme();
            this.initSidebar();
            this.initNavigation();
            this.initSearch();
            this.initNotifications();
            this.initLogout();
            this.loadHomePage();
            this.initCharts();
            this.loadInstitutionsTable();
            this.initEventListeners();
            this.updateDashboardStats();
            this.loadMessages();

            console.log('Prison Management System initialized');
        });
    }

    initTheme() {
        const themeToggle = document.getElementById('themeToggle');
        const savedTheme = localStorage.getItem('theme') || 'light';

        // Set initial theme
        document.documentElement.setAttribute('data-bs-theme', savedTheme);
        themeToggle.querySelector('i').className = savedTheme === 'dark' ? 'fas fa-sun' : 'fas fa-moon';

        // Toggle theme
        themeToggle.addEventListener('click', () => {
            const currentTheme = document.documentElement.getAttribute('data-bs-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';

            document.documentElement.setAttribute('data-bs-theme', newTheme);
            themeToggle.querySelector('i').className = newTheme === 'dark' ? 'fas fa-sun' : 'fas fa-moon';
            localStorage.setItem('theme', newTheme);

            this.showNotification(`Tema ditukar kepada ${newTheme === 'dark' ? 'gelap' : 'terang'}`, 'info');
        });
    }

    initSidebar() {
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebar');

        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('show');
            sidebarToggle.querySelector('i').classList.toggle('fa-bars');
            sidebarToggle.querySelector('i').classList.toggle('fa-times');
        });

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', (e) => {
            if (window.innerWidth < 992 &&
                !sidebar.contains(e.target) &&
                !sidebarToggle.contains(e.target) &&
                sidebar.classList.contains('show')) {
                sidebar.classList.remove('show');
                sidebarToggle.querySelector('i').classList.remove('fa-times');
                sidebarToggle.querySelector('i').classList.add('fa-bars');
            }
        });
    }

    initNavigation() {
        const navLinks = document.querySelectorAll('[data-page]');
        const sidebarLinks = document.querySelectorAll('.sidebar-menu .nav-link');

        navLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                const page = link.getAttribute('data-page');

                // Update active state in sidebar if applicable
                sidebarLinks.forEach(l => l.classList.remove('active'));
                const correspondingSidebarLink = document.querySelector(`.sidebar-menu .nav-link[data-page="${page}"]`);
                if (correspondingSidebarLink) {
                    correspondingSidebarLink.classList.add('active');
                } else if (link.classList.contains('nav-link')) {
                    link.classList.add('active');
                }

                // Navigate to page
                this.navigateTo(page);
            });
        });
    }

    navigateTo(page) {
        this.currentPage = page;

        // Update page title
        this.updatePageTitle(page);

        // Show page content
        this.showPageContent(page);

        // Close sidebar on mobile
        if (window.innerWidth < 992) {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.remove('show');
            document.getElementById('sidebarToggle').querySelector('i').classList.remove('fa-times');
            document.getElementById('sidebarToggle').querySelector('i').classList.add('fa-bars');
        }

        // Load page-specific content
        this.loadPageContent(page);
    }

    updatePageTitle(page) {
        const titles = {
            'home': 'Dashboard',
            'dashboard': 'Dashboard',
            'institusi': 'Institusi',
            'bahan-mentah': 'Bahan Mentah',
            'banduan': 'Banduan',
            'negeri': 'Negeri & Daerah',
            'inden': 'Inden',
            'pengesahan': 'Pengesahan',
            'laporan-prestasi': 'Laporan Prestasi',
            'analitik': 'Analitik',
            'pengguna': 'Pengguna',
            'tetapan': 'Tetapan',
            'mesej': 'Mesej',
            'kalendar': 'Kalendar',
            'admin-list': 'Senarai Admin',
            'position-list': 'Senarai Jawatan',
            'supplier-list': 'Senarai Pembekal',
            'category-list': 'Senarai Kategori',
            'item-list': 'Senarai Item',
            'profil': 'Profil Saya',
            'tukar-kata-laluan': 'Tukar Kata Laluan',
            'quick-guide': 'Panduan Pantas',
            'kalendar': 'Kalendar Aktiviti',
            'mesej': 'Mesej',
            'tetapan': 'Tetapan Sistem',
            'analitik': 'Analitik Lanjutan',
            'laporan': 'Laporan Sistem'
        };

        const pageTitle = document.getElementById('pageTitle');
        const breadcrumb = document.getElementById('breadcrumbCurrent');

        if (pageTitle) pageTitle.textContent = titles[page] || 'Dashboard';
        if (breadcrumb) breadcrumb.textContent = titles[page] || 'Dashboard';

        // Update document title
        document.title = `${titles[page] || 'Dashboard'} - Sistem Pengurusan Penjara`;
    }

    showPageContent(page) {
        // Hide all page contents
        document.querySelectorAll('.page-content').forEach(content => {
            content.classList.remove('active');
        });

        // Show current page
        const currentContent = document.getElementById(`${page}-content`);
        if (currentContent) {
            currentContent.classList.add('active');
        }
    }

    loadPageContent(page) {
        switch (page) {
            case 'home':
                this.loadHomePage();
                break;
            case 'institusi':
                this.loadInstitutionsPage();
                break;
            case 'bahan-mentah':
                this.loadMaterialsPage();
                break;
            case 'banduan':
                this.loadInmatesPage();
                break;
            case 'negeri':
                this.loadStatesPage();
                break;
            case 'inden':
                this.loadOrdersPage();
                break;
            case 'pengesahan':
                this.loadVerificationPage();
                break;
            case 'laporan':
                this.loadReportsPage();
                break;
            case 'analitik':
                this.loadAnalyticsPage();
                break;
            case 'pengguna':
                this.loadUsersPage();
                break;
            case 'admin-list':
                this.loadAdminListPage();
                break;
            case 'position-list':
                this.loadPositionListPage();
                break;
            case 'supplier-list':
                this.loadSupplierListPage();
                break;
            case 'category-list':
                this.loadCategoryListPage();
                break;
            case 'item-list':
                this.loadItemListPage();
                break;
            case 'tetapan':
                this.loadSettingsPage();
                break;
            case 'mesej':
                this.loadMessagesPage();
                break;
            case 'kalendar':
                this.loadCalendarPage();
                break;
            case 'profil':
                this.loadProfilePage();
                break;
            case 'tukar-kata-laluan':
                this.loadChangePasswordPage();
                break;
            case 'quick-guide':
                this.loadQuickGuidePage();
                break;
            default:
                console.log(`Loading ${page} page...`);
        }
    }

    loadHomePage() {
        // Update stats cards with animation
        this.animateStats();

        // Load institutions table
        this.loadInstitutionsTable();

        // Load activities
        this.loadActivities();

        // Initialize charts if not already initialized
        if (!this.charts.population) {
            this.initCharts();
        }

        // Load messages
        this.loadMessages();

        // Initialize calendar
        this.initDashboardCalendar();

        // Update dashboard stats
        this.updateDashboardStats();
    }

    updateDashboardStats() {
        const stats = DataHelpers.updateStats();

        // Update sidebar badges
        document.getElementById('institution-count').textContent = stats.totalInstitutions;
        document.getElementById('material-count').textContent = stats.totalMaterials;
        document.getElementById('inmate-count').textContent = stats.totalInmates.toLocaleString();
        document.getElementById('order-count').textContent = stats.totalOrders;
        document.getElementById('approval-count').textContent = stats.pendingApprovals;

        // Update main stats
        document.getElementById('total-inmates').textContent = stats.totalInmates.toLocaleString();
        document.getElementById('total-institutions').textContent = stats.totalInstitutions;
        document.getElementById('total-materials').textContent = stats.totalMaterials;
        document.getElementById('pending-orders').textContent = stats.pendingApprovals;
    }

    animateStats() {
        const statValues = document.querySelectorAll('.stat-card h2');
        statValues.forEach(stat => {
            const value = parseInt(stat.textContent.replace(/,/g, ''));
            if (!isNaN(value)) {
                this.animateValue(stat, 0, value, 1500);
            }
        });
    }

    animateValue(element, start, end, duration) {
        let startTimestamp = null;
        const step = (timestamp) => {
            if (!startTimestamp) startTimestamp = timestamp;
            const progress = Math.min((timestamp - startTimestamp) / duration, 1);
            const value = Math.floor(progress * (end - start) + start);
            element.textContent = value.toLocaleString();
            if (progress < 1) {
                window.requestAnimationFrame(step);
            }
        };
        window.requestAnimationFrame(step);
    }

    initDashboardCalendar() {
        const calendarEl = document.getElementById('calendar');
        if (!calendarEl) return;

        // Check if calendar is already initialized to avoid duplication
        if (this.charts.dashboardCalendar) {
            this.charts.dashboardCalendar.destroy();
        }

        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'listWeek',
            headerToolbar: {
                left: 'title',
                center: '',
                right: 'today'
            },
            height: 350,
            events: window.prisonData.calendarEvents,
            locale: 'ms',
            buttonText: {
                today: 'Hari Ini'
            },
            eventClick: (info) => {
                this.showNotification(`Acara: ${info.event.title}`, 'info');
            }
        });

        calendar.render();
        this.charts.dashboardCalendar = calendar;
    }

    loadInstitutionsTable() {
        const tableBody = document.getElementById('institusi-table-body');
        if (!tableBody) return;

        tableBody.innerHTML = '';

        // Get first 5 institutions
        const institutions = window.prisonData.institutions.slice(0, 5);

        institutions.forEach(institution => {
            const usage = DataHelpers.getInstitutionUsage(institution);
            const status = DataHelpers.getInstitutionStatus(institution);

            const row = document.createElement('tr');
            row.innerHTML = `
                <td>
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm bg-light-primary rounded me-3">
                            <i class="fas fa-building text-primary"></i>
                        </div>
                        <div>
                            <div class="fw-medium">${institution.name}</div>
                            <div class="text-muted small">${DataHelpers.getInstitutionTypeLabel(institution.type)}</div>
                        </div>
                    </div>
                </td>
                <td>${institution.state}</td>
                <td>
                    <div class="text-center">
                        <div class="fw-bold">${institution.current}</div>
                        <div class="text-muted small">/${institution.capacity}</div>
                    </div>
                </td>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 me-3">
                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar bg-${status.class}" style="width: ${usage}%"></div>
                            </div>
                        </div>
                        <div class="text-${status.class} fw-medium">${usage}%</div>
                    </div>
                </td>
                <td>
                    <span class="badge bg-${status.class}">${status.text}</span>
                </td>
                <td>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-light" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#" data-action="view" data-id="${institution.id}"><i class="fas fa-eye me-2"></i>Lihat</a></li>
                            <li><a class="dropdown-item" href="#" data-action="edit" data-id="${institution.id}"><i class="fas fa-edit me-2"></i>Edit</a></li>
                            <li><a class="dropdown-item text-danger" href="#" data-action="delete" data-id="${institution.id}"><i class="fas fa-trash me-2"></i>Padam</a></li>
                        </ul>
                    </div>
                </td>
            `;
            tableBody.appendChild(row);
        });

        // Add event listeners for actions
        this.initTableActions();
    }

    loadActivities() {
        const activityContainer = document.getElementById('activity-timeline');
        if (!activityContainer) return;

        activityContainer.innerHTML = '';

        // Get first 4 activities
        const activities = window.prisonData.activities.slice(0, 4);

        activities.forEach(activity => {
            const activityItem = document.createElement('div');
            activityItem.className = 'activity-item';

            const colorMap = {
                'primary': 'primary',
                'success': 'success',
                'warning': 'warning',
                'info': 'info',
                'danger': 'danger'
            };

            activityItem.innerHTML = `
                <div class="activity-icon bg-${colorMap[activity.color] || 'primary'}">
                    <i class="fas fa-${activity.icon}"></i>
                </div>
                <div class="activity-content">
                    <h6>${activity.title}</h6>
                    <p>${activity.description}</p>
                    <small class="text-muted">${activity.time}</small>
                </div>
            `;

            activityContainer.appendChild(activityItem);
        });
    }

    initCharts() {
        // Raw Material Stock Status Chart
        const materials = window.prisonData.rawMaterials;
        const materialNames = materials.map(m => m.name);
        const stockData = materials.map(m => {
            const percentage = (m.stock / m.minStock) * 100;
            return Math.round(percentage);
        });

        // Create color array based on stock levels
        const colors = materials.map(m => {
            const percentage = (m.stock / m.minStock) * 100;
            if (percentage < 30) return '#dc3545'; // danger - red
            if (percentage < 70) return '#ffc107'; // warning - yellow
            return '#198754'; // success - green
        });

        const stockStatusOptions = {
            series: [{
                name: 'Status Stok (%)',
                data: stockData
            }],
            chart: {
                type: 'bar',
                height: 300,
                toolbar: {
                    show: false
                }
            },
            plotOptions: {
                bar: {
                    distributed: true,
                    borderRadius: 6,
                    columnWidth: '60%'
                }
            },
            colors: colors,
            dataLabels: {
                enabled: true,
                formatter: function (val) {
                    return val + '%';
                },
                style: {
                    fontSize: '12px',
                    colors: ['#fff']
                }
            },
            xaxis: {
                categories: materialNames,
                labels: {
                    style: {
                        colors: getComputedStyle(document.documentElement).getPropertyValue('--gray-600'),
                        fontSize: '11px'
                    },
                    rotate: -45,
                    rotateAlways: true
                }
            },
            yaxis: {
                title: {
                    text: 'Status Stok (%)',
                    style: {
                        color: getComputedStyle(document.documentElement).getPropertyValue('--gray-600')
                    }
                },
                labels: {
                    style: {
                        colors: getComputedStyle(document.documentElement).getPropertyValue('--gray-600')
                    },
                    formatter: function (val) {
                        return val + '%';
                    }
                }
            },
            grid: {
                borderColor: getComputedStyle(document.documentElement).getPropertyValue('--gray-200')
            },
            legend: {
                show: false
            },
            tooltip: {
                theme: document.documentElement.getAttribute('data-bs-theme'),
                y: {
                    formatter: function (value, { dataPointIndex }) {
                        const material = materials[dataPointIndex];
                        return `${value}% (${material.stock} ${material.unit} / Min: ${material.minStock})`;
                    }
                }
            }
        };

        const stockChart = new ApexCharts(document.querySelector("#populationChart"), stockStatusOptions);
        stockChart.render();
        this.charts.population = stockChart;

        // Institution Distribution Chart
        const institutionOptions = {
            series: window.prisonData.charts.institutionTypes.data,
            chart: {
                type: 'donut',
                height: 300
            },
            colors: window.prisonData.charts.institutionTypes.colors,
            labels: window.prisonData.charts.institutionTypes.labels,
            plotOptions: {
                pie: {
                    donut: {
                        size: '65%',
                        labels: {
                            show: true,
                            total: {
                                show: true,
                                label: 'Jumlah Institusi',
                                color: getComputedStyle(document.documentElement).getPropertyValue('--gray-700'),
                                formatter: function (w) {
                                    return w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                }
                            }
                        }
                    }
                }
            },
            dataLabels: {
                enabled: false
            },
            legend: {
                position: 'bottom',
                horizontalAlign: 'center',
                labels: {
                    colors: getComputedStyle(document.documentElement).getPropertyValue('--gray-600')
                }
            },
            tooltip: {
                theme: document.documentElement.getAttribute('data-bs-theme'),
                y: {
                    formatter: function (value) {
                        return value + ' institusi';
                    }
                }
            }
        };

        const institutionChart = new ApexCharts(document.querySelector("#institutionChart"), institutionOptions);
        institutionChart.render();
        this.charts.institution = institutionChart;
    }

    loadInstitutionsPage() {
        const tableBody = document.getElementById('full-institutions-table');
        if (!tableBody) return;

        tableBody.innerHTML = '';

        window.prisonData.institutions.forEach((institution, index) => {
            const status = DataHelpers.getInstitutionStatus(institution);
            const usage = DataHelpers.getInstitutionUsage(institution);

            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${index + 1}</td>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm bg-light-primary rounded me-3">
                            <i class="fas fa-building text-primary"></i>
                        </div>
                        <div>
                            <div class="fw-medium">${institution.name}</div>
                            <div class="text-muted small">${DataHelpers.getInstitutionTypeLabel(institution.type)}</div>
                        </div>
                    </div>
                </td>
                <td>${institution.state}</td>
                <td>${DataHelpers.getInstitutionTypeLabel(institution.type)}</td>
                <td>
                    <div class="text-center">
                        <div class="fw-bold">${institution.current}</div>
                        <div class="text-muted small">/${institution.capacity}</div>
                    </div>
                </td>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 me-3">
                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar bg-${status.class}" style="width: ${usage}%"></div>
                            </div>
                        </div>
                        <div class="text-${status.class} fw-medium">${usage}%</div>
                    </div>
                </td>
                <td>
                    <span class="badge bg-${status.class}">${status.text}</span>
                </td>
                <td>
                    <div class="btn-group btn-group-sm">
                        <button class="btn btn-outline-primary" data-action="view" data-id="${institution.id}">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="btn btn-outline-warning" data-action="edit" data-id="${institution.id}">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-outline-danger" data-action="delete" data-id="${institution.id}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            `;
            tableBody.appendChild(row);
        });

        this.initTableActions();

        // Initialize DataTable
        this.initDataTable('#institutions-table');

        // Initialize add institution button
        const addBtn = document.getElementById('addInstitutionBtn');
        if (addBtn) {
            addBtn.addEventListener('click', () => {
                this.showAddInstitutionModal();
            });
        }
    }

    loadMaterialsPage() {
        const tableBody = document.querySelector('#materials-table tbody');
        if (!tableBody) return;

        tableBody.innerHTML = '';

        window.prisonData.rawMaterials.forEach(material => {
            const stockStatus = DataHelpers.getStockStatus(material.stock, material.minStock);

            const row = document.createElement('tr');
            row.innerHTML = `
                <td>
                    <div class="fw-medium">${material.name}</div>
                    <small class="text-muted">${material.description}</small>
                </td>
                <td>
                    <span class="badge bg-light text-dark">${material.category}</span>
                </td>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 me-2">
                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar bg-${stockStatus.class}" style="width: ${stockStatus.percentage > 100 ? 100 : stockStatus.percentage}%"></div>
                            </div>
                        </div>
                        <div class="fw-medium ${stockStatus.class === 'danger' ? 'text-danger' : stockStatus.class === 'warning' ? 'text-warning' : 'text-success'}">
                            ${material.stock}
                        </div>
                    </div>
                </td>
                <td>${material.unit}</td>
                <td>${DataHelpers.formatCurrency(material.price)}</td>
                <td>
                    <span class="badge bg-${stockStatus.class}">${stockStatus.status} (${stockStatus.percentage}%)</span>
                </td>
                <td>
                    <div class="btn-group btn-group-sm">
                        <button class="btn btn-outline-primary" data-action="view-material" data-id="${material.id}">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="btn btn-outline-warning" data-action="edit-material" data-id="${material.id}">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-outline-danger" data-action="delete-material" data-id="${material.id}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            `;
            tableBody.appendChild(row);
        });

        // Initialize DataTable
        this.initDataTable('#materials-table');

        // Initialize add material button
        const addBtn = document.getElementById('addMaterialBtn');
        if (addBtn) {
            addBtn.addEventListener('click', () => {
                this.showAddMaterialModal();
            });
        }
    }

    loadInmatesPage() {
        const tableBody = document.querySelector('#inmates-table tbody');
        if (!tableBody) return;

        tableBody.innerHTML = '';

        window.prisonData.inmates.forEach(inmate => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>INM-${String(inmate.id).padStart(4, '0')}</td>
                <td>
                    <div class="fw-medium">${inmate.name}</div>
                    <small class="text-muted">ID: ${inmate.id}</small>
                </td>
                <td>${inmate.institution}</td>
                <td>
                    <span class="badge bg-${DataHelpers.getStatusBadgeClass(inmate.status)}">
                        ${DataHelpers.getStatusLabel(inmate.status)}
                    </span>
                </td>
                <td>
                    <div>
                        <div class="small">${DataHelpers.formatDate(inmate.admission)}</div>
                        <div class="small text-muted">hingga ${DataHelpers.formatDate(inmate.release)}</div>
                    </div>
                </td>
                <td>${inmate.age} tahun</td>
                <td>
                    <span class="badge bg-light text-dark">${inmate.offense}</span>
                </td>
                <td>
                    <div class="btn-group btn-group-sm">
                        <button class="btn btn-outline-primary" data-action="view-inmate" data-id="${inmate.id}">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="btn btn-outline-warning" data-action="edit-inmate" data-id="${inmate.id}">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-outline-danger" data-action="delete-inmate" data-id="${inmate.id}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            `;
            tableBody.appendChild(row);
        });

        // Initialize DataTable
        this.initDataTable('#inmates-table');

        // Initialize add inmate button
        const addBtn = document.getElementById('addInmateBtn');
        if (addBtn) {
            addBtn.addEventListener('click', () => {
                this.showAddInmateModal();
            });
        }
    }

    loadStatesPage() {
        const statesList = document.getElementById('states-list');
        const districtsContainer = document.getElementById('districts-container');

        if (!statesList || !districtsContainer) return;

        // Load states
        statesList.innerHTML = '';
        window.prisonData.states.forEach(state => {
            const stateItem = document.createElement('a');
            stateItem.href = '#';
            stateItem.className = 'list-group-item list-group-item-action d-flex justify-content-between align-items-center';
            stateItem.innerHTML = `
                ${state.name}
                <span class="badge bg-primary rounded-pill">
                    ${window.prisonData.institutions.filter(inst => inst.state === state.name).length}
                </span>
            `;

            stateItem.addEventListener('click', (e) => {
                e.preventDefault();
                this.loadDistrictsForState(state.id);

                // Update active state
                document.querySelectorAll('#states-list .list-group-item').forEach(item => {
                    item.classList.remove('active');
                });
                stateItem.classList.add('active');
            });

            statesList.appendChild(stateItem);
        });

        // Load all districts initially
        this.loadAllDistricts();

        // Initialize search
        const searchInput = document.getElementById('search-district');
        if (searchInput) {
            searchInput.addEventListener('input', (e) => {
                this.searchDistricts(e.target.value);
            });
        }
    }

    loadAllDistricts() {
        const districtsContainer = document.getElementById('districts-container');
        if (!districtsContainer) return;

        districtsContainer.innerHTML = '<h6 class="mb-3">Semua Daerah di Malaysia</h6>';

        // Group districts by state
        const districtsByState = {};
        window.prisonData.districts.forEach(district => {
            const state = window.prisonData.states.find(s => s.id === district.state_id);
            if (state) {
                if (!districtsByState[state.name]) {
                    districtsByState[state.name] = [];
                }
                districtsByState[state.name].push(district);
            }
        });

        // Display districts by state
        Object.keys(districtsByState).sort().forEach(stateName => {
            const stateDiv = document.createElement('div');
            stateDiv.className = 'mb-4';

            const stateHeader = document.createElement('h6');
            stateHeader.className = 'text-primary mb-2';
            stateHeader.textContent = stateName;

            const districtsGrid = document.createElement('div');
            districtsGrid.className = 'row row-cols-2 row-cols-md-3 g-2';

            districtsByState[stateName].forEach(district => {
                const districtCol = document.createElement('div');
                districtCol.className = 'col';

                const districtCard = document.createElement('div');
                districtCard.className = 'card h-100 border';
                districtCard.innerHTML = `
                    <div class="card-body p-2">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-map-marker-alt text-muted me-2"></i>
                            <span class="small">${district.name}</span>
                        </div>
                    </div>
                `;

                districtCol.appendChild(districtCard);
                districtsGrid.appendChild(districtCol);
            });

            stateDiv.appendChild(stateHeader);
            stateDiv.appendChild(districtsGrid);
            districtsContainer.appendChild(stateDiv);
        });
    }

    loadDistrictsForState(stateId) {
        const districtsContainer = document.getElementById('districts-container');
        if (!districtsContainer) return;

        const districts = DataHelpers.getDistrictsByState(stateId);
        const state = window.prisonData.states.find(s => s.id === stateId);

        districtsContainer.innerHTML = `
            <h6 class="mb-3">Daerah di ${state.name}</h6>
            <p class="text-muted small mb-3">${districts.length} daerah ditemui</p>
            <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3" id="state-districts-grid"></div>
        `;

        const grid = document.getElementById('state-districts-grid');
        districts.forEach(district => {
            const districtCol = document.createElement('div');
            districtCol.className = 'col';

            const districtCard = document.createElement('div');
            districtCard.className = 'card h-100 border hover-shadow';
            districtCard.innerHTML = `
                <div class="card-body p-3 text-center">
                    <i class="fas fa-map-marker-alt fa-2x text-primary mb-2"></i>
                    <h6 class="card-title mb-0">${district.name}</h6>
                    <small class="text-muted">ID: ${district.id}</small>
                </div>
            `;

            districtCol.appendChild(districtCard);
            grid.appendChild(districtCol);
        });
    }

    searchDistricts(query) {
        const districtsContainer = document.getElementById('districts-container');
        if (!districtsContainer) return;

        if (!query.trim()) {
            this.loadAllDistricts();
            return;
        }

        const searchTerm = query.toLowerCase();
        const filteredDistricts = window.prisonData.districts.filter(district =>
            district.name.toLowerCase().includes(searchTerm)
        );

        districtsContainer.innerHTML = `
            <h6 class="mb-3">Hasil Carian: "${query}"</h6>
            <p class="text-muted small mb-3">${filteredDistricts.length} daerah ditemui</p>
            <div class="row row-cols-2 row-cols-md-3 g-3">
                ${filteredDistricts.map(district => {
            const state = window.prisonData.states.find(s => s.id === district.state_id);
            return `
                        <div class="col">
                            <div class="card h-100 border">
                                <div class="card-body p-3">
                                    <h6 class="card-title">${district.name}</h6>
                                    <small class="text-muted">${state ? state.name : 'Unknown'}</small>
                                </div>
                            </div>
                        </div>
                    `;
        }).join('')}
            </div>
        `;
    }

    loadOrdersPage() {
        const tableBody = document.querySelector('#orders-table tbody');
        if (!tableBody) return;

        tableBody.innerHTML = '';

        window.prisonData.inden.forEach(order => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>
                    <div class="fw-medium">${order.number}</div>
                    <small class="text-muted">ID: ${order.id}</small>
                </td>
                <td>${order.institution}</td>
                <td>
                    <div class="small">
                        ${order.items.map(item => `<div>• ${item}</div>`).join('')}
                    </div>
                </td>
                <td>${DataHelpers.formatCurrency(order.amount)}</td>
                <td>${DataHelpers.formatDate(order.date)}</td>
                <td>
                    <span class="badge bg-${DataHelpers.getStatusBadgeClass(order.status)}">
                        ${DataHelpers.getStatusLabel(order.status)}
                    </span>
                </td>
                <td>
                    <div class="btn-group btn-group-sm">
                        <button class="btn btn-outline-primary" data-action="view-order" data-id="${order.id}">
                            <i class="fas fa-eye"></i>
                        </button>
                        ${order.status === 'pending' ? `
                            <button class="btn btn-outline-success" data-action="approve-order" data-id="${order.id}">
                                <i class="fas fa-check"></i>
                            </button>
                            <button class="btn btn-outline-danger" data-action="reject-order" data-id="${order.id}">
                                <i class="fas fa-times"></i>
                            </button>
                        ` : ''}
                    </div>
                </td>
            `;
            tableBody.appendChild(row);
        });

        // Initialize DataTable
        this.initDataTable('#orders-table');

        // Initialize add order button
        const addBtn = document.getElementById('addOrderBtn');
        if (addBtn) {
            addBtn.addEventListener('click', () => {
                this.showAddOrderModal();
            });
        }
    }

    loadVerificationPage() {
        const tableBody = document.querySelector('#verification-table tbody');
        if (!tableBody) return;

        tableBody.innerHTML = '';

        window.prisonData.inden.forEach(order => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>
                    <div class="fw-medium">${order.number}</div>
                    <small class="text-muted">ID: ${order.id}</small>
                </td>
                <td>${order.institution}</td>
                <td>${DataHelpers.formatCurrency(order.amount)}</td>
                <td>${DataHelpers.formatDate(order.date)}</td>
                <td>
                    <span class="badge bg-${DataHelpers.getStatusBadgeClass(order.status)}">
                        ${DataHelpers.getStatusLabel(order.status)}
                    </span>
                </td>
                <td>
                    <div class="btn-group btn-group-sm">
                        <button class="btn btn-outline-primary" data-action="view-order" data-id="${order.id}">
                            <i class="fas fa-eye"></i>
                        </button>
                        ${order.status === 'pending' ? `
                            <button class="btn btn-outline-success" data-action="approve-order" data-id="${order.id}">
                                <i class="fas fa-check"></i> Sahkan
                            </button>
                            <button class="btn btn-outline-danger" data-action="reject-order" data-id="${order.id}">
                                <i class="fas fa-times"></i> Tolak
                            </button>
                        ` : ''}
                    </div>
                </td>
            `;
            tableBody.appendChild(row);
        });

        // Initialize DataTable
        this.initDataTable('#verification-table');

        // Update approval count
        const pendingOrders = window.prisonData.inden.filter(order => order.status === 'pending');
        const approvalCount = pendingOrders.length;
        document.getElementById('approval-count').textContent = approvalCount;

        // Initialize verification chart
        this.initVerificationChart();
    }

    initVerificationChart() {
        const pending = window.prisonData.inden.filter(o => o.status === 'pending').length;
        const approved = window.prisonData.inden.filter(o => o.status === 'approved').length;
        const rejected = window.prisonData.inden.filter(o => o.status === 'rejected').length;

        const options = {
            series: [pending, approved, rejected],
            chart: {
                type: 'donut',
                height: 200
            },
            colors: ['#ffc107', '#198754', '#dc3545'],
            labels: ['Menunggu', 'Disahkan', 'Ditolak'],
            plotOptions: {
                pie: {
                    donut: {
                        size: '70%'
                    }
                }
            },
            dataLabels: {
                enabled: false
            },
            legend: {
                show: false
            }
        };

        const chart = new ApexCharts(document.querySelector("#verificationChart"), options);
        chart.render();
        this.charts.verification = chart;
    }

    loadReportsPage() {
        // Initialize report stats chart
        this.initReportStatsChart();
    }

    initReportStatsChart() {
        const options = {
            series: [{
                name: 'Muat Turun',
                data: [45, 32, 28, 21, 15, 12, 8]
            }],
            chart: {
                type: 'bar',
                height: 200,
                toolbar: {
                    show: false
                }
            },
            colors: ['#1a5632'],
            plotOptions: {
                bar: {
                    borderRadius: 4,
                    horizontal: false,
                    columnWidth: '60%'
                }
            },
            dataLabels: {
                enabled: false
            },
            xaxis: {
                categories: ['Okt', 'Sep', 'Ogos', 'Jul', 'Jun', 'Mei', 'Apr']
            },
            yaxis: {
                title: {
                    text: 'Muat Turun'
                }
            },
            grid: {
                borderColor: getComputedStyle(document.documentElement).getPropertyValue('--gray-200')
            }
        };

        const chart = new ApexCharts(document.querySelector("#reportStatsChart"), options);
        chart.render();
        this.charts.reportStats = chart;
    }

    loadAnalyticsPage() {
        // Initialize analytics charts
        this.initAnalyticsChart();
        this.initCrimeTrendChart();
        this.initDemographicChart();
    }

    initAnalyticsChart() {
        const options = {
            series: [
                {
                    name: 'Banduan Baru',
                    data: [120, 135, 110, 145, 130, 125, 140, 155, 130, 145, 120, 135]
                },
                {
                    name: 'Banduan Dibebaskan',
                    data: [95, 110, 105, 120, 115, 100, 125, 115, 120, 110, 105, 115]
                }
            ],
            chart: {
                type: 'area',
                height: 400,
                stacked: false,
                toolbar: {
                    show: false
                }
            },
            colors: ['#1a5632', '#0dcaf0'],
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 2
            },
            fill: {
                type: 'gradient',
                gradient: {
                    opacityFrom: 0.6,
                    opacityTo: 0.8,
                }
            },
            xaxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ogos', 'Sep', 'Okt', 'Nov', 'Dis']
            },
            yaxis: {
                title: {
                    text: 'Bilangan Banduan'
                }
            },
            grid: {
                borderColor: getComputedStyle(document.documentElement).getPropertyValue('--gray-200')
            },
            legend: {
                position: 'top',
                horizontalAlign: 'left'
            }
        };

        const chart = new ApexCharts(document.querySelector("#analyticsChart"), options);
        chart.render();
        this.charts.analytics = chart;
    }

    initCrimeTrendChart() {
        const options = {
            series: [{
                name: 'Kesalahan',
                data: [45, 52, 38, 24, 33, 26, 21, 20, 6, 8, 15, 10]
            }],
            chart: {
                height: 300,
                type: 'line',
                toolbar: {
                    show: false
                }
            },
            colors: ['#dc3545'],
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 3
            },
            xaxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ogos', 'Sep', 'Okt', 'Nov', 'Dis']
            },
            yaxis: {
                title: {
                    text: 'Bilangan Kes'
                }
            },
            grid: {
                borderColor: getComputedStyle(document.documentElement).getPropertyValue('--gray-200')
            }
        };

        const chart = new ApexCharts(document.querySelector("#crimeTrendChart"), options);
        chart.render();
        this.charts.crimeTrend = chart;
    }

    initDemographicChart() {
        const options = {
            series: [44, 55, 41, 17, 15],
            chart: {
                type: 'donut',
                height: 300
            },
            colors: ['#1a5632', '#198754', '#0dcaf0', '#ffc107', '#dc3545'],
            labels: ['18-25 tahun', '26-35 tahun', '36-45 tahun', '46-55 tahun', '55+ tahun'],
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 200
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }]
        };

        const chart = new ApexCharts(document.querySelector("#demographicChart"), options);
        chart.render();
        this.charts.demographic = chart;
    }

    loadSettingsPage() {
        // Initialize settings page
        const settingsForm = document.getElementById('systemSettingsForm');
        if (settingsForm) {
            settingsForm.addEventListener('submit', (e) => {
                e.preventDefault();
                this.showNotification('Tetapan sistem berjaya dikemaskini', 'success');
            });
        }
    }

    loadUsersPage() {
        const tableBody = document.querySelector('#users-table tbody');
        if (!tableBody) return;

        tableBody.innerHTML = '';

        window.prisonData.users.forEach(user => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>
                    <div class="d-flex align-items-center">
                        <img src="https://ui-avatars.com/api/?name=${encodeURIComponent(user.name)}&background=1a5632&color=fff&size=32" 
                             class="rounded-circle me-2" width="32" height="32">
                        <div>
                            <div class="fw-medium">${user.name}</div>
                            <small class="text-muted">${user.role.toLowerCase()}</small>
                        </div>
                    </div>
                </td>
                <td>${user.email}</td>
                <td><span class="badge bg-${user.role === 'Administrator' ? 'primary' : user.role === 'Penyelia' ? 'success' : user.role === 'Operator' ? 'warning' : 'info'}">${user.role}</span></td>
                <td>${user.institution}</td>
                <td><span class="badge bg-${user.status === 'active' ? 'success' : 'secondary'}">${user.status === 'active' ? 'Aktif' : 'Tidak Aktif'}</span></td>
                <td>${DataHelpers.formatDate(user.joinDate)}</td>
                <td>
                    <div class="btn-group btn-group-sm">
                        <button class="btn btn-outline-primary" data-action="view-user" data-id="${user.id}">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="btn btn-outline-warning" data-action="edit-user" data-id="${user.id}">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-outline-danger" data-action="delete-user" data-id="${user.id}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            `;
            tableBody.appendChild(row);
        });

        // Initialize DataTable
        this.initDataTable('#users-table');

        // Initialize add user button
        const addBtn = document.getElementById('addUserBtn');
        if (addBtn) {
            addBtn.addEventListener('click', () => {
                this.showAddUserModal();
            });
        }
    }

    loadMessagesPage() {
        // Load messages for messages page
        this.loadMessagesList();

        // Initialize message sending
        const messageInput = document.querySelector('#message-container + .message-input input');
        const sendBtn = document.querySelector('#message-container + .message-input button');

        if (sendBtn && messageInput) {
            sendBtn.addEventListener('click', () => {
                if (messageInput.value.trim()) {
                    const newMessage = DataHelpers.addMessage({
                        sender: 'Admin',
                        senderId: 'admin',
                        message: messageInput.value.trim(),
                        avatar: 'AP'
                    });

                    const messageContainer = document.getElementById('message-container');
                    if (messageContainer) {
                        const messageDiv = document.createElement('div');
                        messageDiv.className = 'message sent';
                        messageDiv.innerHTML = `
                            <div class="message-content">
                                <p>${newMessage.message}</p>
                                <small class="text-muted">${newMessage.time}</small>
                            </div>
                        `;
                        messageContainer.appendChild(messageDiv);
                        messageContainer.scrollTop = messageContainer.scrollHeight;
                    }

                    messageInput.value = '';
                    this.showNotification('Mesej berjaya dihantar', 'success');
                }
            });

            messageInput.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') {
                    sendBtn.click();
                }
            });
        }
    }

    loadMessagesList() {
        const messageList = document.getElementById('message-list');
        if (!messageList) return;

        // Get last 5 messages
        const messages = window.prisonData.messages.slice(0, 5);

        messageList.innerHTML = messages.map(msg => `
            <div class="message ${msg.senderId === 'admin' ? 'sent' : 'received'}">
                <div class="message-content">
                    <div class="d-flex align-items-center mb-1">
                        <div class="fw-medium me-2">${msg.sender}</div>
                        <small class="text-muted ms-auto">${msg.time}</small>
                    </div>
                    <p class="mb-1">${msg.message}</p>
                </div>
            </div>
        `).join('');

        // Update message count
        const unreadCount = DataHelpers.getUnreadMessagesCount();
        document.getElementById('message-count').textContent = unreadCount;
    }

    loadMessages() {
        const messageList = document.getElementById('message-list');
        if (!messageList) return;

        // Get last 3 messages for dashboard
        const messages = window.prisonData.messages.slice(0, 3);

        messageList.innerHTML = messages.map(msg => `
            <div class="message ${msg.senderId === 'admin' ? 'sent' : 'received'}">
                <div class="message-content">
                    <div class="d-flex align-items-center mb-1">
                        <div class="fw-medium me-2">${msg.sender}</div>
                        <small class="text-muted ms-auto">${msg.time}</small>
                    </div>
                    <p class="mb-1">${msg.message}</p>
                </div>
            </div>
        `).join('');

        // Initialize message sending for dashboard
        const messageInput = document.getElementById('message-input');
        const sendBtn = document.getElementById('send-message');

        if (sendBtn && messageInput) {
            sendBtn.addEventListener('click', () => {
                if (messageInput.value.trim()) {
                    const newMessage = DataHelpers.addMessage({
                        sender: 'Admin',
                        senderId: 'admin',
                        message: messageInput.value.trim(),
                        avatar: 'AP'
                    });

                    // Add message to dashboard list
                    const messageDiv = document.createElement('div');
                    messageDiv.className = 'message sent';
                    messageDiv.innerHTML = `
                        <div class="message-content">
                            <div class="d-flex align-items-center mb-1">
                                <div class="fw-medium me-2">Admin</div>
                                <small class="text-muted ms-auto">${newMessage.time}</small>
                            </div>
                            <p class="mb-1">${newMessage.message}</p>
                        </div>
                    `;
                    messageList.appendChild(messageDiv);
                    messageList.scrollTop = messageList.scrollHeight;

                    messageInput.value = '';
                    this.showNotification('Mesej berjaya dihantar', 'success');
                }
            });

            messageInput.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') {
                    sendBtn.click();
                }
            });
        }
    }

    loadCalendarPage() {
        // Initialize FullCalendar
        this.initCalendar();

        // Initialize event listeners for calendar buttons
        const addEventBtn = document.getElementById('addEventBtn');
        if (addEventBtn) {
            addEventBtn.addEventListener('click', () => {
                this.showAddEventModal();
            });
        }

        const todayBtn = document.getElementById('todayBtn');
        if (todayBtn && this.calendar) {
            todayBtn.addEventListener('click', () => {
                this.calendar.today();
            });
        }

        const prevMonthBtn = document.getElementById('prevMonth');
        if (prevMonthBtn && this.calendar) {
            prevMonthBtn.addEventListener('click', () => {
                this.calendar.prev();
            });
        }

        const nextMonthBtn = document.getElementById('nextMonth');
        if (nextMonthBtn && this.calendar) {
            nextMonthBtn.addEventListener('click', () => {
                this.calendar.next();
            });
        }
    }

    // --- Master Data Page Loaders ---

    loadAdminListPage() {
        const tableBody = document.querySelector('#admin-list-table tbody');
        if (!tableBody) return;

        tableBody.innerHTML = '';
        const admins = window.prisonData.users.filter(u => u.role === 'Administrator');

        admins.forEach((admin, index) => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${index + 1}</td>
                <td>
                    <div class="d-flex align-items-center">
                        <img src="https://ui-avatars.com/api/?name=${encodeURIComponent(admin.name)}&background=1a5632&color=fff&size=32" 
                             class="rounded-circle me-2" width="32" height="32">
                        <div class="fw-medium">${admin.name}</div>
                    </div>
                </td>
                <td>${admin.email}</td>
                <td>${admin.role}</td>
                <td><span class="badge bg-${admin.status === 'active' ? 'success' : 'secondary'}">${admin.status === 'active' ? 'Aktif' : 'Tidak Aktif'}</span></td>
                <td>
                    <button class="btn btn-sm btn-outline-primary" data-action="edit-user" data-id="${admin.id}"><i class="fas fa-edit"></i></button>
                    <button class="btn btn-sm btn-outline-danger" data-action="delete-user" data-id="${admin.id}"><i class="fas fa-trash"></i></button>
                </td>
            `;
            tableBody.appendChild(row);
        });

        this.initDataTable('#admin-list-table');
    }

    loadPositionListPage() {
        const tableBody = document.querySelector('#position-list-table tbody');
        if (!tableBody) return;

        tableBody.innerHTML = '';

        if (window.prisonData.positions) {
            window.prisonData.positions.forEach((pos, index) => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${index + 1}</td>
                    <td><div class="fw-medium">${pos.title}</div></td>
                    <td>${pos.grade}</td>
                    <td>${pos.department}</td>
                    <td><span class="badge bg-${pos.status === 'active' ? 'success' : 'secondary'}">${pos.status === 'active' ? 'Aktif' : 'Tidak Aktif'}</span></td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            <button class="btn btn-sm btn-outline-primary" data-action="edit-position" data-id="${pos.id}"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-sm btn-outline-danger" data-action="delete-position" data-id="${pos.id}"><i class="fas fa-trash"></i></button>
                        </div>
                    </td>
                `;
                tableBody.appendChild(row);
            });
        }

        this.initDataTable('#position-list-table');

        // Initialize Position Chart
        if (document.querySelector("#positionChart")) {
            const departments = {};
            window.prisonData.positions.forEach(p => {
                departments[p.department] = (departments[p.department] || 0) + 1;
            });

            const options = {
                series: Object.values(departments),
                chart: {
                    type: 'pie',
                    height: 250
                },
                labels: Object.keys(departments),
                colors: ['#1a5632', '#2e7d57', '#0d3b1f', '#4c956c', '#6aab8c'],
                legend: {
                    position: 'bottom'
                }
            };

            if (this.charts.position) this.charts.position.destroy();
            this.charts.position = new ApexCharts(document.querySelector("#positionChart"), options);
            this.charts.position.render();
        }
    }

    loadSupplierListPage() {
        const tableBody = document.querySelector('#supplier-list-table tbody');
        if (!tableBody) return;

        tableBody.innerHTML = '';

        if (window.prisonData.suppliers) {
            window.prisonData.suppliers.forEach((supplier, index) => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${index + 1}</td>
                    <td>
                        <div class="fw-medium">${supplier.name}</div>
                        <small class="text-muted">${supplier.email}</small>
                    </td>
                    <td>${supplier.category}</td>
                    <td>${supplier.contact}</td>
                    <td><i class="fas fa-star text-warning"></i> ${supplier.rating}</td>
                    <td><span class="badge bg-${supplier.status === 'active' ? 'success' : 'secondary'}">${supplier.status === 'active' ? 'Aktif' : 'Tidak Aktif'}</span></td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            <button class="btn btn-sm btn-outline-primary" data-action="edit-supplier" data-id="${supplier.id}"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-sm btn-outline-danger" data-action="delete-supplier" data-id="${supplier.id}"><i class="fas fa-trash"></i></button>
                        </div>
                    </td>
                `;
                tableBody.appendChild(row);
            });
        }

        this.initDataTable('#supplier-list-table');
    }

    loadCategoryListPage() {
        const tableBody = document.querySelector('#category-list-table tbody');
        if (!tableBody) return;

        tableBody.innerHTML = '';

        if (window.prisonData.categories) {
            // Only show food-related categories
            const foodCategories = window.prisonData.categories.filter(cat =>
                cat.name.includes('Bahan Mentah') ||
                cat.code === 'CAT-001' ||
                cat.code === 'CAT-002'
            );

            foodCategories.forEach((cat, index) => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${index + 1}</td>
                    <td><code>${cat.code}</code></td>
                    <td><div class="fw-medium">${cat.name}</div></td>
                    <td>${cat.description}</td>
                    <td>${cat.totalItems}</td>
                    <td><span class="badge bg-${cat.status === 'active' ? 'success' : 'secondary'}">${cat.status === 'active' ? 'Aktif' : 'Tidak Aktif'}</span></td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            <button class="btn btn-sm btn-outline-primary" data-action="edit-category" data-id="${cat.id}"><i class="fas fa-edit"></i></button>
                        </div>
                    </td>
                `;
                tableBody.appendChild(row);
            });
        }

        this.initDataTable('#category-list-table');
    }

    loadItemListPage() {
        const tableBody = document.querySelector('#item-list-table tbody');
        if (!tableBody) return;

        tableBody.innerHTML = '';

        // Combine items and rawMaterials for the master list
        const allItems = window.prisonData.items || [];
        const items = allItems.filter(item =>
            item.category.includes('Bahan Mentah') ||
            item.category === 'makanan'
        );

        if (window.prisonData.rawMaterials) {
            window.prisonData.rawMaterials.forEach(material => {
                items.push({
                    code: `MAT-${material.id.toString().padStart(3, '0')}`, // Generate a code for materials
                    name: material.name,
                    category: material.category, // 'makanan'
                    stock: material.stock,
                    unit: material.unit,
                    status: material.status
                });
            });
        }

        items.forEach((item, index) => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${index + 1}</td>
                <td><code>${item.code}</code></td>
                <td><div class="fw-medium">${item.name}</div></td>
                <td>${item.category}</td>
                <td>${item.stock}</td>
                <td>${item.unit}</td>
                <td><span class="badge bg-${item.status === 'active' ? 'success' : 'secondary'}">${item.status === 'active' ? 'Aktif' : 'Tidak Aktif'}</span></td>
                <td>
                    <div class="btn-group btn-group-sm">
                        <button class="btn btn-sm btn-outline-primary" data-action="edit-item" data-id="${item.id || index}"><i class="fas fa-edit"></i></button>
                    </div>
                </td>
            `;
            tableBody.appendChild(row);
        });

        this.initDataTable('#item-list-table');
    }

    initCalendar() {
        // Initialize FullCalendar
        const calendarEl = document.getElementById('fullCalendar');
        if (!calendarEl) return;

        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            events: window.prisonData.calendarEvents,
            eventClick: (info) => {
                this.showNotification(`Acara: ${info.event.title}\nMasa: ${info.event.start.toLocaleString()}`, 'info');
            },
            eventColor: '#1a5632',
            eventTextColor: '#ffffff',
            height: 'auto',
            locale: 'ms',
            buttonText: {
                today: 'Hari Ini',
                month: 'Bulan',
                week: 'Minggu',
                day: 'Hari'
            }
        });

        calendar.render();
        this.calendar = calendar;

        // Initialize mini calendar
        this.initMiniCalendar();

        // Initialize calendar stats chart
        this.initCalendarStatsChart();
    }

    initMiniCalendar() {
        const miniCalendarEl = document.getElementById('mini-calendar');
        if (!miniCalendarEl) return;

        const today = new Date();
        const month = today.toLocaleDateString('ms-MY', { month: 'long' });
        const year = today.getFullYear();

        miniCalendarEl.innerHTML = `
            <div class="text-center mb-2">
                <h5 class="mb-1">${month} ${year}</h5>
                <h3 class="mb-3">${today.getDate()}</h3>
            </div>
            <div class="row g-1 text-center">
                ${['M', 'T', 'W', 'T', 'F', 'S', 'S'].map(day =>
            `<div class="col"><small class="text-muted">${day}</small></div>`
        ).join('')}
            </div>
        `;
    }

    initCalendarStatsChart() {
        const options = {
            series: [{
                name: 'Acara',
                data: [5, 3, 7, 2, 4, 6, 3]
            }],
            chart: {
                type: 'line',
                height: 200,
                toolbar: {
                    show: false
                }
            },
            colors: ['#1a5632'],
            stroke: {
                curve: 'smooth',
                width: 3
            },
            xaxis: {
                categories: ['Isn', 'Sel', 'Rab', 'Kha', 'Jum', 'Sab', 'Ahd']
            },
            yaxis: {
                title: {
                    text: 'Bilangan Acara'
                }
            },
            grid: {
                borderColor: getComputedStyle(document.documentElement).getPropertyValue('--gray-200')
            }
        };

        const chart = new ApexCharts(document.querySelector("#calendarStatsChart"), options);
        chart.render();
        this.charts.calendarStats = chart;
    }

    initSearch() {
        const searchInput = document.querySelector('.search-box input');
        const searchIcon = document.querySelector('.search-box i');

        const performSearch = () => {
            const query = searchInput.value.trim();
            if (query) {
                this.showNotification(`Mencari: "${query}"`, 'info');
                this.searchAcrossData(query);
            }
        };

        if (searchInput) {
            searchInput.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') performSearch();
            });
        }

        if (searchIcon) {
            searchIcon.addEventListener('click', performSearch);
        }
    }

    searchAcrossData(query) {
        const searchTerm = query.toLowerCase();

        // Search in institutions
        const institutions = window.prisonData.institutions.filter(inst =>
            inst.name.toLowerCase().includes(searchTerm) ||
            inst.state.toLowerCase().includes(searchTerm) ||
            inst.type.toLowerCase().includes(searchTerm)
        );

        // Search in materials
        const materials = window.prisonData.rawMaterials.filter(mat =>
            mat.name.toLowerCase().includes(searchTerm) ||
            mat.description.toLowerCase().includes(searchTerm)
        );

        // Search in inmates
        const inmates = window.prisonData.inmates.filter(inmate =>
            inmate.name.toLowerCase().includes(searchTerm) ||
            inmate.institution.toLowerCase().includes(searchTerm)
        );

        if (institutions.length === 0 && materials.length === 0 && inmates.length === 0) {
            this.showNotification(`Tiada hasil ditemui untuk "${query}"`, 'warning');
        } else {
            let message = `Hasil carian untuk "${query}": `;
            if (institutions.length > 0) message += `${institutions.length} institusi, `;
            if (materials.length > 0) message += `${materials.length} bahan, `;
            if (inmates.length > 0) message += `${inmates.length} banduan`;

            this.showNotification(message, 'info');
        }
    }

    initNotifications() {
        // Mark all as read functionality
        const markAllRead = document.querySelector('.notifications .dropdown-header a');
        if (markAllRead) {
            markAllRead.addEventListener('click', (e) => {
                e.preventDefault();
                const badge = document.querySelector('.badge-notification');
                if (badge) badge.style.display = 'none';
                this.showNotification('Semua pemberitahuan ditanda sebagai dibaca', 'success');
            });
        }
    }

    initLogout() {
        const logoutBtns = [document.getElementById('logoutBtn'), document.getElementById('logoutBtn2')];
        const logoutModal = new bootstrap.Modal(document.getElementById('logoutModal'));
        const confirmLogout = document.getElementById('confirmLogout');

        logoutBtns.forEach(btn => {
            if (btn) {
                btn.addEventListener('click', (e) => {
                    e.preventDefault();
                    logoutModal.show();
                });
            }
        });

        if (confirmLogout) {
            confirmLogout.addEventListener('click', () => {
                this.showNotification('Anda telah berjaya log keluar', 'success');
                logoutModal.hide();

                // Simulate logout delay
                setTimeout(() => {
                    window.location.href = 'http://mysipma_2.test'; // Redirect to login page
                }, 1500);
            });
        }
    }

    initEventListeners() {
        // Card action buttons
        document.addEventListener('click', (e) => {
            // Quick guide button handled via data-page if added, but keeping handler for compatibility
            if (e.target.closest('.btn-light') && e.target.closest('.banner-actions')) {
                const page = e.target.closest('.btn-light').getAttribute('data-page');
                if (page) {
                    this.navigateTo(page);
                    return;
                }
                this.showNotification('Panduan pantas dibuka', 'info');
            }

            // View report button handled via data-page
            if (e.target.closest('.btn-primary') && e.target.closest('.banner-actions')) {
                const page = e.target.closest('.btn-primary').getAttribute('data-page');
                if (page) {
                    this.navigateTo(page);
                    return;
                }
                this.navigateTo('laporan');
            }

            // View all institutions button
            if (e.target.closest('.btn-primary') && e.target.textContent === 'Lihat Semua') {
                this.navigateTo('institusi');
            }

            // Table actions
            if (e.target.closest('[data-action]')) {
                const actionElement = e.target.closest('[data-action]');
                const action = actionElement.getAttribute('data-action');
                const id = actionElement.getAttribute('data-id');

                this.handleTableAction(action, id);
            }
        });

        // Initialize add institution modal
        const addInstitutionModal = document.getElementById('addInstitutionModal');
        if (addInstitutionModal) {
            const modal = new bootstrap.Modal(addInstitutionModal);
            const saveBtn = document.getElementById('saveInstitutionBtn');
            const form = document.getElementById('addInstitutionForm');

            if (saveBtn) {
                saveBtn.addEventListener('click', () => {
                    if (form.checkValidity()) {
                        const formData = {
                            name: document.getElementById('institutionName').value,
                            state: document.getElementById('institutionState').value,
                            type: document.getElementById('institutionType').value,
                            capacity: document.getElementById('institutionCapacity').value
                        };

                        const newInstitution = DataHelpers.addInstitution(formData);
                        this.showNotification(`Institusi "${newInstitution.name}" berjaya ditambah`, 'success');
                        modal.hide();
                        form.reset();

                        // Refresh the institutions page if we're on it
                        if (this.currentPage === 'institusi') {
                            this.loadInstitutionsPage();
                        }

                        // Update dashboard stats
                        this.updateDashboardStats();
                    } else {
                        form.reportValidity();
                    }
                });
            }

            // Populate state dropdown
            const stateSelect = document.getElementById('institutionState');
            if (stateSelect) {
                stateSelect.innerHTML = '<option value="">Pilih Negeri</option>' +
                    window.prisonData.states.map(state =>
                        `<option value="${state.name}">${state.name}</option>`
                    ).join('');
            }
        }

        // Initialize add event modal
        const addEventModal = document.getElementById('addEventModal');
        if (addEventModal) {
            const modal = new bootstrap.Modal(addEventModal);
            const saveBtn = document.getElementById('saveEventBtn');
            const form = document.getElementById('addEventForm');

            if (saveBtn) {
                saveBtn.addEventListener('click', () => {
                    if (form.checkValidity()) {
                        const formData = {
                            title: document.getElementById('eventTitle').value,
                            start: `${document.getElementById('eventDate').value}T${document.getElementById('eventStart').value}:00`,
                            end: `${document.getElementById('eventDate').value}T${document.getElementById('eventEnd').value}:00`,
                            description: document.getElementById('eventDescription').value,
                            location: 'Penjara Kajang',
                            color: '#1a5632'
                        };

                        const newEvent = DataHelpers.addCalendarEvent(formData);
                        this.showNotification(`Acara "${newEvent.title}" berjaya ditambah`, 'success');
                        modal.hide();
                        form.reset();

                        // Refresh calendar if it's initialized
                        if (this.calendar) {
                            this.calendar.refetchEvents();
                        }
                    } else {
                        form.reportValidity();
                    }
                });
            }

            // Initialize Edit Modal Save Button
            const saveEditBtn = document.getElementById('saveEditBtn');
            if (saveEditBtn) {
                saveEditBtn.addEventListener('click', () => {
                    const id = parseInt(document.getElementById('editEntityId').value);
                    const type = document.getElementById('editEntityType').value;
                    const form = document.getElementById('editForm');
                    const formData = new FormData(form);
                    const updatedData = {};

                    formData.forEach((value, key) => {
                        updatedData[key] = value;
                    });

                    this.saveEntity(type, id, updatedData);
                    bootstrap.Modal.getInstance(document.getElementById('editModal')).hide();
                });
            }
        }
    }

    initTableActions() {
        // Add event listeners for table action buttons
        document.querySelectorAll('[data-action]').forEach(button => {
            button.addEventListener('click', (e) => {
                e.stopPropagation();
                const action = button.getAttribute('data-action');
                const id = button.getAttribute('data-id');
                this.handleTableAction(action, id);
            });
        });
    }

    handleTableAction(action, id) {
        const entityId = parseInt(id);

        // View Actions
        if (action.startsWith('view')) {
            this.showViewModal(action, entityId);
            return;
        }

        // Edit Actions
        if (action.startsWith('edit')) {
            this.showEditModal(action, entityId);
            return;
        }

        // Delete Actions
        if (action.startsWith('delete')) {
            const entityType = action.replace('delete-', '') || 'institution';
            const confirmMsg = `Adakah anda pasti ingin memadam ${this.getEntityLabel(entityType)} ini?`;
            if (confirm(confirmMsg)) {
                this.deleteEntity(entityType, entityId);
            }
            return;
        }

        // Other Actions
        switch (action) {
            case 'approve-order':
                if (confirm('Adakah anda pasti ingin meluluskan inden ini?')) {
                    this.approveOrder(entityId);
                }
                break;
            case 'reject-order':
                if (confirm('Adakah anda pasti ingin menolak inden ini?')) {
                    this.rejectOrder(entityId);
                }
                break;
        }
    }

    getEntityLabel(type) {
        const labels = {
            'institution': 'institusi',
            'material': 'bahan',
            'inmate': 'banduan',
            'user': 'pengguna',
            'position': 'jawatan',
            'supplier': 'pembekal',
            'category': 'kategori',
            'item': 'item',
            'order': 'inden'
        };
        return labels[type] || type;
    }

    getEntities(type) {
        switch (type) {
            case 'institution': return window.prisonData.institutions;
            case 'material': return window.prisonData.rawMaterials;
            case 'inmate': return window.prisonData.inmates;
            case 'user': return window.prisonData.users;
            case 'position': return window.prisonData.positions;
            case 'supplier': return window.prisonData.suppliers;
            case 'category': return window.prisonData.categories;
            case 'item': return window.prisonData.items;
            case 'order': return window.prisonData.inden;
            default: return [];
        }
    }

    showViewModal(action, id) {
        const type = action === 'view' ? 'institution' : action.replace('view-', '');
        const entities = this.getEntities(type);
        const entity = entities.find(e => e.id === id);

        if (!entity) return;

        const title = document.getElementById('viewModalTitle');
        const body = document.getElementById('viewModalBody');

        title.textContent = `Butiran ${this.getEntityLabel(type).toUpperCase()}`;

        let html = '<div class="table-responsive"><table class="table table-sm">';
        for (const [key, value] of Object.entries(entity)) {
            if (key === 'id' || key === 'avatar') continue;
            html += `
                <tr>
                    <th class="text-muted" style="width: 35%">${key.charAt(0).toUpperCase() + key.slice(1)}</th>
                    <td>${Array.isArray(value) ? value.join(', ') : value}</td>
                </tr>
            `;
        }
        html += '</table></div>';

        body.innerHTML = html;
        new bootstrap.Modal(document.getElementById('viewModal')).show();
    }

    showEditModal(action, id) {
        const type = action === 'edit' ? 'institution' : action.replace('edit-', '');
        const entities = this.getEntities(type);
        const entity = entities.find(e => e.id === id);

        if (!entity) return;

        document.getElementById('editEntityId').value = id;
        document.getElementById('editEntityType').value = type;

        const fieldsContainer = document.getElementById('editFormFields');
        fieldsContainer.innerHTML = '';

        for (const [key, value] of Object.entries(entity)) {
            if (key === 'id' || key === 'avatar' || key === 'lastUpdated' || key === 'joinDate' || key === 'lastLogin') continue;

            const fieldDiv = document.createElement('div');
            fieldDiv.className = 'mb-3';
            fieldDiv.innerHTML = `
                <label class="form-label">${key.charAt(0).toUpperCase() + key.slice(1)}</label>
                <input type="text" class="form-control" name="${key}" value="${value}">
            `;
            fieldsContainer.appendChild(fieldDiv);
        }

        new bootstrap.Modal(document.getElementById('editModal')).show();
    }

    deleteEntity(type, id) {
        const entities = this.getEntities(type);
        const index = entities.findIndex(e => e.id === id);

        if (index !== -1) {
            entities.splice(index, 1);
            this.showNotification(`Berjaya dipadam`, 'success');
            this.refreshCurrentPage();
            this.updateDashboardStats();
        }
    }

    refreshCurrentPage() {
        this.loadPageContent(this.currentPage);
    }

    saveEntity(type, id, data) {
        const entities = this.getEntities(type);
        const entity = entities.find(e => e.id === id);

        if (entity) {
            // Update entity fields
            for (const [key, value] of Object.entries(data)) {
                if (key in entity) {
                    entity[key] = isNaN(value) ? value : (value.includes('.') ? parseFloat(value) : parseInt(value));
                }
            }

            this.showNotification(`Maklumat ${this.getEntityLabel(type)} berjaya dikemaskini`, 'success');
            this.refreshCurrentPage();
            this.updateDashboardStats();
        }
    }
    // The following code block was misplaced and has been removed as per the instruction's implied fix.
    // if (this.currentPage === 'pengguna') {
    //     this.loadUsersPage();
    // }
    //         }
    //     }

    approveOrder(id) {
        const order = window.prisonData.inden.find(o => o.id === id);
        if (order) {
            order.status = 'approved';
            this.showNotification(`Inden ${order.number} berjaya diluluskan`, 'success');

            // Refresh the page if we're on orders page
            if (this.currentPage === 'inden' || this.currentPage === 'pengesahan') {
                this.loadOrdersPage();
                this.loadVerificationPage();
            }

            // Update dashboard stats
            this.updateDashboardStats();
        }
    }

    rejectOrder(id) {
        const order = window.prisonData.inden.find(o => o.id === id);
        if (order) {
            order.status = 'rejected';
            this.showNotification(`Inden ${order.number} telah ditolak`, 'danger');

            // Refresh the page if we're on orders page
            if (this.currentPage === 'inden' || this.currentPage === 'pengesahan') {
                this.loadOrdersPage();
                this.loadVerificationPage();
            }

            // Update dashboard stats
            this.updateDashboardStats();
        }
    }

    showAddInstitutionModal() {
        const modal = new bootstrap.Modal(document.getElementById('addInstitutionModal'));
        modal.show();
    }

    showAddMaterialModal() {
        const materialName = prompt('Masukkan nama bahan baru:');
        if (materialName) {
            const category = prompt('Masukkan kategori (makanan/lain):', 'makanan');
            const foodType = prompt('Masukkan jenis makanan (bijirin/protein/sayur/tenusu/perasa/lain):', 'lain');
            const unit = prompt('Masukkan unit (kg/liter/unit/kotak):', 'kg');
            const price = prompt('Masukkan harga (RM):', '10.00');
            const minStock = prompt('Masukkan stok minimum:', '20');

            const newMaterial = DataHelpers.addMaterial({
                name: materialName,
                category: category,
                foodType: foodType,
                stock: 100,
                unit: unit,
                minStock: parseInt(minStock),
                price: parseFloat(price),
                description: `Bahan ${materialName} untuk kegunaan harian`
            });

            this.showNotification(`Bahan "${newMaterial.name}" berjaya ditambah`, 'success');

            if (this.currentPage === 'bahan-mentah') {
                this.loadMaterialsPage();
            }

            this.updateDashboardStats();
        }
    }

    showAddInmateModal() {
        const inmateName = prompt('Masukkan nama banduan baru:');
        if (inmateName) {
            const institution = prompt('Masukkan nama institusi:') || 'Penjara Kajang';
            const offense = prompt('Masukkan kesalahan:', 'Kesalahan Dadah');
            const age = prompt('Masukkan umur:', '30');
            const admissionDate = prompt('Masukkan tarikh masuk (YYYY-MM-DD):', new Date().toISOString().split('T')[0]);
            const releaseDate = prompt('Masukkan tarikh keluar (YYYY-MM-DD):',
                new Date(Date.now() + 365 * 24 * 60 * 60 * 1000).toISOString().split('T')[0]);

            const newInmate = DataHelpers.addInmate({
                name: inmateName,
                institution: institution,
                admission: admissionDate,
                release: releaseDate,
                age: parseInt(age),
                offense: offense
            });

            this.showNotification(`Banduan "${newInmate.name}" berjaya didaftarkan`, 'success');

            if (this.currentPage === 'banduan') {
                this.loadInmatesPage();
            }

            this.updateDashboardStats();
        }
    }

    showAddUserModal() {
        const userName = prompt('Masukkan nama pengguna baru:');
        if (userName) {
            const email = prompt('Masukkan email:', `${userName.toLowerCase().replace(/\s+/g, '.')}@prison.gov.my`);
            const role = prompt('Masukkan jawatan (Administrator/Penyelia/Operator/Pengurus):', 'Operator');
            const institution = prompt('Masukkan institusi:', 'Penjara Kajang');

            const newUser = {
                id: window.prisonData.users.length + 1,
                name: userName,
                email: email,
                role: role,
                institution: institution,
                status: 'active',
                joinDate: new Date().toISOString().split('T')[0],
                lastLogin: new Date().toISOString().replace('T', ' ').substring(0, 19),
                avatar: userName.substring(0, 2).toUpperCase()
            };

            window.prisonData.users.push(newUser);
            this.showNotification(`Pengguna "${newUser.name}" berjaya ditambah`, 'success');

            if (this.currentPage === 'pengguna') {
                this.loadUsersPage();
            }
        }
    }

    showAddOrderModal() {
        const institution = prompt('Masukkan nama institusi:') || 'Penjara Kajang';
        const items = prompt('Masukkan item (pisahkan dengan koma):') || 'Beras - 100kg, Minyak - 20 liter';
        const amount = prompt('Masukkan jumlah (RM):') || '5000';

        if (institution && items && amount) {
            const newOrder = DataHelpers.addOrder({
                institution: institution,
                items: items.split(',').map(item => item.trim()),
                amount: amount
            });

            this.showNotification(`Inden ${newOrder.number} berjaya dibuat`, 'success');

            if (this.currentPage === 'inden' || this.currentPage === 'pengesahan') {
                this.loadOrdersPage();
                this.loadVerificationPage();
            }

            this.updateDashboardStats();
        }
    }

    showAddEventModal() {
        const modal = new bootstrap.Modal(document.getElementById('addEventModal'));
        modal.show();
    }

    showNotification(message, type = 'info') {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `notification alert alert-${type} alert-dismissible fade show`;
        notification.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;

        // Style notification
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1100;
            min-width: 300px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            border-radius: 8px;
            border: none;
        `;

        // Add to page
        document.body.appendChild(notification);

        // Auto remove after 5 seconds
        setTimeout(() => {
            if (notification.parentNode) {
                notification.remove();
            }
        }, 5000);
    }

    loadProfilePage() {
        // Data is now populated by Blade from the authenticated user
        // We only need to initialize events for this page
        this.initProfileEvents();
    }

    initProfileEvents() {
        const btnEdit = document.getElementById('btnEditProfile');
        const btnCancel = document.getElementById('btnCancelEdit');
        const cardUpdate = document.getElementById('cardUpdateProfile');
        const formUpdate = document.getElementById('formUpdateProfile');

        // Avatar upload elements
        const btnChangeAvatar = document.getElementById('btnChangeAvatar');
        const avatarInput = document.getElementById('avatarInput');

        // Handle Change Avatar button
        if (btnChangeAvatar && avatarInput) {
            btnChangeAvatar.addEventListener('click', () => {
                avatarInput.click();
            });
        }

        // Handle Avatar Input change
        if (avatarInput) {
            avatarInput.addEventListener('change', async () => {
                if (avatarInput.files && avatarInput.files[0]) {
                    const formData = new FormData();
                    formData.append('avatar', avatarInput.files[0]);

                    try {
                        const response = await fetch('/profile/avatar', {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                            }
                        });

                        const result = await response.json();

                        if (response.ok) {
                            // Update all avatar images
                            document.querySelectorAll('.user-img, .user-avatar, #profileAvatar').forEach(img => {
                                img.src = result.avatar_url;
                            });
                            this.showNotification(result.success, 'success');
                        } else {
                            const errorMsg = result.errors ? Object.values(result.errors).flat().join('\n') : (result.message || 'Ralat semasa memuat naik gambar');
                            this.showNotification(errorMsg, 'danger');
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        this.showNotification('Ralat sambungan pelayan', 'danger');
                    }
                }
            });
        }

        if (btnEdit && cardUpdate) {
            btnEdit.addEventListener('click', () => {
                cardUpdate.style.display = 'block';
                btnEdit.closest('.card-body').style.display = 'none';
                cardUpdate.scrollIntoView({ behavior: 'smooth' });
            });
        }

        if (btnCancel && cardUpdate && btnEdit) {
            btnCancel.addEventListener('click', () => {
                cardUpdate.style.display = 'none';
                btnEdit.closest('.card-body').style.display = 'block';
            });
        }

        if (formUpdate) {
            formUpdate.addEventListener('submit', async (e) => {
                e.preventDefault();
                const formData = new FormData(formUpdate);

                try {
                    const response = await fetch(formUpdate.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    });

                    const result = await response.json();

                    if (response.ok) {
                        const newName = formData.get('name');

                        // Update UI elements
                        document.getElementById('profileNameDisplay').textContent = newName;
                        document.querySelectorAll('.user-name').forEach(el => el.textContent = newName);
                        document.querySelectorAll('.user-info h6').forEach(el => el.textContent = newName);

                        this.showNotification(result.success || 'Profil berjaya dikemaskini', 'success');

                        // Return to view mode
                        cardUpdate.style.display = 'none';
                        btnEdit.closest('.card-body').style.display = 'block';

                        // Refresh page content to show updated info in the profile card
                        this.navigateTo('profil');
                    } else {
                        const errors = Object.values(result.errors || {}).flat().join('\n');
                        this.showNotification(errors || 'Ralat semasa mengemaskini profil', 'danger');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    this.showNotification('Ralat sambungan pelayan', 'danger');
                }
            });
        }

        // Toggle password visibility
        document.querySelectorAll('.toggle-password').forEach(btn => {
            btn.addEventListener('click', () => {
                const input = btn.previousElementSibling;
                const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                input.setAttribute('type', type);

                const icon = btn.querySelector('i');
                icon.classList.toggle('fa-eye');
                icon.classList.toggle('fa-eye-slash');
            });
        });
    }

    loadChangePasswordPage() {
        const formPass = document.getElementById('formChangePasswordStandalone');
        if (formPass) {
            formPass.addEventListener('submit', async (e) => {
                e.preventDefault();
                const formData = new FormData(formPass);

                try {
                    const response = await fetch(formPass.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    });

                    const result = await response.json();

                    if (response.ok) {
                        this.showNotification(result.success || 'Kata laluan berjaya dikemaskini. Sila log masuk semula dengan kata laluan baru.', 'success');
                        formPass.reset();

                        // Redirect back to profile after success
                        setTimeout(() => {
                            this.navigateTo('profil');
                        }, 2000);
                    } else {
                        const errors = Object.values(result.errors || {}).flat().join('\n');
                        this.showNotification(errors || 'Ralat semasa menukar kata laluan', 'danger');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    this.showNotification('Ralat sambungan pelayan', 'danger');
                }
            });
        }

        // Initialize password toggles for this page as well
        document.querySelectorAll('#tukar-kata-laluan-content .toggle-password').forEach(btn => {
            btn.addEventListener('click', () => {
                const input = btn.previousElementSibling;
                const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                input.setAttribute('type', type);

                const icon = btn.querySelector('i');
                icon.classList.toggle('fa-eye');
                icon.classList.toggle('fa-eye-slash');
            });
        });
    }

    loadReportsPage() {
        console.log('Loading Reports Page...');
        if (!this.charts.reportStats) {
            const options = {
                series: [44, 55, 13, 33],
                chart: {
                    type: 'donut',
                    height: 200
                },
                labels: ['Inden', 'Banduan', 'Bahan', 'Staf'],
                colors: ['#1a5632', '#2e7d57', '#0d3b1f', '#4c956c']
            };
            const chart = new ApexCharts(document.querySelector("#reportStatsChart"), options);
            chart.render();
            this.charts.reportStats = chart;
        }
    }

    loadAnalyticsPage() {
        console.log('Loading Analytics Page...');
        // Initialize charts if target exists
        if (document.querySelector("#analyticsChart") && !this.charts.analytics) {
            const options = {
                series: [{
                    name: 'Kapasiti',
                    data: [31, 40, 28, 51, 42, 109, 100]
                }],
                chart: {
                    type: 'area',
                    height: 400
                },
                colors: ['#1a5632']
            };
            const chart = new ApexCharts(document.querySelector("#analyticsChart"), options);
            chart.render();
            this.charts.analytics = chart;
        }
    }

    loadSettingsPage() {
        console.log('Loading Settings Page...');
    }

    loadMessagesPage() {
        console.log('Loading Messages Page...');
        const container = document.getElementById('message-container');
        if (container) {
            container.scrollTop = container.scrollHeight;
        }
    }

    loadCalendarPage() {
        console.log('Loading Calendar Page...');
        if (!this.calendar) {
            this.initCalendar();
        } else {
            setTimeout(() => {
                this.calendar.render(); // Re-render to fix sizing in hidden container
            }, 100);
        }
    }

    loadStatesPage() {
        console.log('Loading States Page...');
    }

    loadQuickGuidePage() {
        console.log('Loading Quick Guide Page...');
    }

    initDataTable(selector) {
        const table = document.querySelector(selector);
        if (!table) return;

        // Check if DataTable is already initialized
        if ($.fn.DataTable.isDataTable(table)) {
            $(table).DataTable().destroy();
        }

        // Initialize DataTable
        $(table).DataTable({
            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/ms.json'
            },
            pageLength: 10,
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Semua"]],
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
                '<"row"<"col-sm-12"tr>>' +
                '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
            initComplete: function () {
                // Add custom class to DataTable elements
                $('.dataTables_length select').addClass('form-select form-select-sm');
                $('.dataTables_filter input').addClass('form-control form-control-sm');
            }
        });
    }

    // Utility methods
    formatNumber(num) {
        return new Intl.NumberFormat('ms-MY').format(num);
    }

    formatDate(date) {
        return new Date(date).toLocaleDateString('ms-MY', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric'
        });
    }
}

// Initialize the system
const prisonSystem = new PrisonSystem();

// Make available globally for debugging
window.prisonSystem = prisonSystem;