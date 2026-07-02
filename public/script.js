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
            console.log('Initializing Prison Management System...');
            
            const initSteps = [
                { name: 'Theme', fn: () => this.initTheme() },
                { name: 'Sidebar', fn: () => this.initSidebar() },
                { name: 'Navigation', fn: () => this.initNavigation() },
                { name: 'Search', fn: () => this.initSearch() },
                { name: 'Notifications', fn: () => this.initNotifications() },
                { name: 'Logout', fn: () => this.initLogout() },
                { name: 'Home Page', fn: () => this.loadHomePage() },
                { name: 'Charts', fn: () => this.initCharts() },
                { name: 'Critical Stock', fn: () => this.loadCriticalStockTable() },
                { name: 'Event Listeners', fn: () => this.initEventListeners() },
                { name: 'Dashboard Stats', fn: () => this.updateDashboardStats() },
                { name: 'Evaluation Events', fn: () => this.initEvaluationEvents() },
                { name: 'Messages', fn: () => this.loadMessages() },
                { name: 'UOMs', fn: () => this.loadBackendUoms() },
                { name: 'Tooltips', fn: () => this.initTooltips() }
            ];

            initSteps.forEach(step => {
                try {
                    step.fn();
                } catch (error) {
                    console.error(`Error during ${step.name} initialization:`, error);
                }
            });

            console.log('Prison Management System initialization sequence complete');
        });
    }

    initTheme() {
        const themeToggle = document.getElementById('themeToggle');
        if (!themeToggle) return;

        const savedTheme = localStorage.getItem('theme') || 'light';
        document.documentElement.setAttribute('data-bs-theme', savedTheme);
        
        const icon = themeToggle.querySelector('i');
        if (icon) icon.className = savedTheme === 'dark' ? 'fas fa-sun' : 'fas fa-moon';

        themeToggle.addEventListener('click', () => {
            const currentTheme = document.documentElement.getAttribute('data-bs-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';

            document.documentElement.setAttribute('data-bs-theme', newTheme);
            if (icon) icon.className = newTheme === 'dark' ? 'fas fa-sun' : 'fas fa-moon';
            localStorage.setItem('theme', newTheme);
            this.showNotification(`Tema ditukar kepada ${newTheme === 'dark' ? 'gelap' : 'terang'}`, 'info');
        });
    }

    initSidebar() {
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebar');
        if (!sidebarToggle || !sidebar) return;

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
            'laporan-bahan': 'Laporan Stok Bahan',
            'analitik': 'Analitik',
            'pengguna': 'Pengguna',
            'tetapan': 'Tetapan',
            'mesej': 'Mesej',
            'kalendar': 'Kalendar',
            'admin-list': 'Senarai Admin',
            'position-list': 'Senarai Jawatan',
            'supplier-list': 'Senarai Pembekal',
            'category-list': 'Senarai Kategori',
            'uom-list': 'Senarai Unit Ukuran (UOM)',
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
            case 'laporan-prestasi':
                this.loadPerformanceReportsPage();
                break;
            case 'laporan-bahan':
                this.loadRawMaterialReportPage();
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
            case 'uom-list':
                this.loadUomListPage();
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

        // Load critical stock table
        this.loadCriticalStockTable();

        // Load stock forecast widget
        this.loadStockForecast();

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

    async loadCriticalStockTable() {
        const tableBody = document.getElementById('institusi-table-body') || document.getElementById('critical-stock-table-body');
        if (!tableBody) return;

        tableBody.innerHTML = '<tr><td colspan="5" class="text-center text-muted py-4">Memuatkan item stok kritikal...</td></tr>';

        let criticalItems = [];
        let loadedFromBackend = false;

        try {
            const response = await fetch('/dashboard/critical-stock', {
                headers: { 'Accept': 'application/json' }
            });

            if (response.ok) {
                const result = await response.json();
                if (result.success && Array.isArray(result.data)) {
                    criticalItems = result.data;
                    loadedFromBackend = true;
                }
            }
        } catch (error) {
            console.warn('Unable to load critical stock from backend:', error);
        }

        if (!loadedFromBackend) {
            const materials = window.prisonData.rawMaterials.map(m => {
                const percentage = (m.stock / m.minStock) * 100;
                return {
                    ...m,
                    stockPercentage: percentage
                };
            });

            materials.sort((a, b) => a.stockPercentage - b.stockPercentage);
            criticalItems = materials.slice(0, 5);
        }

        tableBody.innerHTML = '';

        if (!criticalItems.length) {
            tableBody.innerHTML = '<tr><td colspan="5" class="text-center text-muted py-4">Tiada item stok kritikal ditemui.</td></tr>';
            return;
        }

        const isDashboardTable = tableBody.id === 'institusi-table-body';

        criticalItems.forEach(item => {
            let statusBadge = '';
            let statusText = '';
            const stockPercentage = Number(item.stockPercentage ?? ((item.stock / item.minStock) * 100));
            const percentageText = Number.isFinite(stockPercentage) ? `${Math.round(stockPercentage)}%` : '-';
            
            if (stockPercentage < 50) {
                statusBadge = 'bg-danger';
                statusText = 'Kritikal';
            } else if (stockPercentage <= 100) {
                statusBadge = 'bg-warning text-dark';
                statusText = 'Rendah';
            } else {
                statusBadge = 'bg-success';
                statusText = 'Mencukupi';
            }

            const row = document.createElement('tr');
            if (isDashboardTable) {
                row.innerHTML = `
                    <td>
                        <div class="fw-medium">${item.name}</div>
                        <div class="small text-muted">${item.category || '-'}</div>
                    </td>
                    <td>${item.stock} ${item.unit || ''}</td>
                    <td class="text-muted">${item.minStock} ${item.unit || ''}</td>
                    <td>${percentageText}</td>
                    <td><span class="badge ${statusBadge}">${statusText}</span></td>
                `;
            } else {
                row.innerHTML = `
                    <td>
                        <div class="fw-medium">${item.name}</div>
                    </td>
                    <td><span class="badge bg-light text-dark">${item.category || '-'}</span></td>
                    <td>
                        <div class="text-center">
                            <div class="fw-bold">${item.stock} ${item.unit || ''}</div>
                        </div>
                    </td>
                    <td class="text-center text-muted">${item.minStock} ${item.unit || ''}</td>
                    <td>
                        <span class="badge ${statusBadge}">${statusText}</span>
                    </td>
                `;
            }
            tableBody.appendChild(row);
        });
    }

    async loadStockForecast() {
        const tableBody = document.getElementById('forecast-table-body');
        if (!tableBody) return;

        tableBody.innerHTML = '<tr><td colspan="5" class="text-center text-muted py-4">Memuatkan ramalan stok...</td></tr>';

        let forecastItems = [];
        let loadedFromBackend = false;

        try {
            const response = await fetch('/dashboard/stock-forecast', {
                headers: { 'Accept': 'application/json' }
            });

            if (response.ok) {
                const result = await response.json();
                if (result.success && Array.isArray(result.data)) {
                    forecastItems = result.data;
                    loadedFromBackend = true;
                }
            }
        } catch (error) {
            console.warn('Unable to load stock forecast from backend:', error);
        }

        if (!loadedFromBackend) {
            const materials = (window.prisonData.rawMaterials || []).filter(mat => mat.minStock > 0);
            if (!materials.length) {
                tableBody.innerHTML = '<tr><td colspan="5" class="text-center text-muted py-4">Tiada data ramalan stok.</td></tr>';
                return;
            }

            forecastItems = materials.map(mat => {
                const stock = Number(mat.stock || 0);
                const monthlyEstimate = Number(mat.minStock || 0);
                const monthsRemaining = monthlyEstimate > 0 ? Number((stock / monthlyEstimate).toFixed(1)) : null;
                const risk = DataHelpers.getForecastRisk ? DataHelpers.getForecastRisk(monthsRemaining) : {
                    text: monthsRemaining === null ? 'Tidak Cukup Data' : monthsRemaining <= 1 ? 'Habis Bulan Ini' : monthsRemaining <= 3 ? 'Habis 3 Bulan' : monthsRemaining <= 6 ? 'Akan Habis 6 Bulan' : 'Cukup >6 Bulan',
                    class: monthsRemaining === null ? 'secondary' : monthsRemaining <= 1 ? 'danger' : monthsRemaining <= 3 ? 'warning' : monthsRemaining <= 6 ? 'warning' : 'success'
                };

                return {
                    name: mat.name || '-',
                    category: mat.category || '-',
                    stock,
                    monthsRemaining,
                    risk,
                    unit: mat.unit || ''
                };
            }).sort((a, b) => {
                if (a.monthsRemaining === null) return 1;
                if (b.monthsRemaining === null) return -1;
                return a.monthsRemaining - b.monthsRemaining;
            }).slice(0, 5);
        }

        tableBody.innerHTML = '';

        if (!forecastItems.length) {
            tableBody.innerHTML = '<tr><td colspan="5" class="text-center text-muted py-4">Tiada item ramalan stok ditemui.</td></tr>';
            return;
        }

        forecastItems.forEach(item => {
            const monthsRemaining = item.monthsRemaining !== null ? `${item.monthsRemaining} bulan` : 'Tidak mencukupi';
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${item.name}</td>
                <td>${item.category}</td>
                <td>${item.stock.toLocaleString()} ${item.unit}</td>
                <td>${monthsRemaining}</td>
                <td><span class="badge bg-${item.risk.class}">${item.risk.text}</span></td>
            `;
            tableBody.appendChild(row);
        });
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

    showCategoryStockDetails(categoryName, categoryItems) {
        const modalElement = document.getElementById('categoryDrilldownModal') || document.getElementById('categoryDetailModal');
        const titleElement = document.getElementById('drilldownCategoryName') || document.getElementById('modalCategoryTitle');
        const tableBody = document.getElementById('drilldown-table-body') || document.getElementById('categoryDetailTableBody');

        if (!modalElement || !titleElement || !tableBody) {
            console.warn('Category stock detail modal markup is missing.');
            this.showNotification('Paparan butiran kategori tidak dijumpai.', 'warning');
            return;
        }

        titleElement.textContent = categoryName || '-';
        tableBody.innerHTML = '';

        if (!categoryItems.length) {
            tableBody.innerHTML = '<tr><td colspan="5" class="text-center text-muted py-4">Tiada item dalam kategori ini.</td></tr>';
        }

        const isDrilldownModal = modalElement.id === 'categoryDrilldownModal';

        categoryItems.forEach(item => {
            const stock = Number(item.stock ?? item.current_quantity ?? 0);
            const minStock = Number(item.minStock ?? item.min_stock ?? item.ceiling_limit ?? item.ceiling_limits ?? 0);
            const unit = item.unit || item.uom || '';
            const stockPercentage = minStock > 0 ? Math.round((stock / minStock) * 100) : 0;

            let statusBadge = '';
            if (stockPercentage < 30) {
                statusBadge = '<span class="badge bg-danger-subtle text-danger">Kritikal</span>';
            } else if (stockPercentage < 70) {
                statusBadge = '<span class="badge bg-warning-subtle text-warning">Rendah</span>';
            } else {
                statusBadge = '<span class="badge bg-success-subtle text-success">Mencukupi</span>';
            }

            const row = document.createElement('tr');
            if (isDrilldownModal) {
                row.innerHTML = `
                    <td>
                        <div class="fw-medium">${item.name || '-'}</div>
                        <div class="small text-muted">${item.description || item.code || '-'}</div>
                    </td>
                    <td>${stock} ${unit}</td>
                    <td>${minStock} ${unit}</td>
                    <td>${stockPercentage}%</td>
                    <td>${statusBadge}</td>
                `;
            } else {
                row.innerHTML = `
                    <td>
                        <div class="fw-medium">${item.name || '-'}</div>
                        <div class="small text-muted">${item.description || '-'}</div>
                    </td>
                    <td>${item.foodType || item.type || item.category || '-'}</td>
                    <td>${stock} ${unit}</td>
                    <td>${minStock} ${unit}</td>
                    <td>${statusBadge}</td>
                `;
            }
            tableBody.appendChild(row);
        });

        bootstrap.Modal.getOrCreateInstance(modalElement).show();
    }

    initCharts() {
        // Raw Material Stock Status Chart
        const materials = window.prisonData.rawMaterials;
        
        // Group materials by category
        const categoryGroups = {};
        materials.forEach(m => {
            if (!categoryGroups[m.category]) {
                categoryGroups[m.category] = { stock: 0, minStock: 0 };
            }
            categoryGroups[m.category].stock += m.stock;
            categoryGroups[m.category].minStock += m.minStock;
        });

        const categoryNames = Object.keys(categoryGroups);
        const stockData = categoryNames.map(cat => {
            const group = categoryGroups[cat];
            const percentage = (group.stock / group.minStock) * 100;
            return Math.round(percentage);
        });

        // Create color array based on stock levels
        const colors = categoryNames.map(cat => {
            const group = categoryGroups[cat];
            const percentage = (group.stock / group.minStock) * 100;
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
                categories: categoryNames,
                labels: {
                    style: {
                        colors: getComputedStyle(document.documentElement).getPropertyValue('--gray-600'),
                        fontSize: '11px'
                    },
                    rotate: -45,
                    rotateAlways: true,
                    hideOverlappingLabels: false,
                    trim: true
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
                        const cat = categoryNames[dataPointIndex];
                        const group = categoryGroups[cat];
                        return `${value}% (Stok: ${group.stock} / Min: ${group.minStock})`;
                    }
                }
            },
            chart: {
                type: 'bar',
                height: 300,
                toolbar: {
                    show: false
                },
                events: {
                    dataPointSelection: (event, chartContext, config) => {
                        const catIndex = config.dataPointIndex;
                        if (catIndex === undefined || catIndex < 0) return;

                        const selectedCategory = categoryNames[catIndex];
                        console.log("Chart clicked! Category:", selectedCategory);
                        const categoryItems = materials.filter(m => m.category === selectedCategory);
                        console.log("Found items:", categoryItems);

                        this.showCategoryStockDetails(selectedCategory, categoryItems);
                    }
                }
            }
        };

        const stockChartEl = document.querySelector("#populationChart");
        if (stockChartEl) {
            if (this.charts.population) this.charts.population.destroy();
            const stockChart = new ApexCharts(stockChartEl, stockStatusOptions);
            stockChart.render();
            this.charts.population = stockChart;
        }

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

        // Destroy existing chart if it exists
        if (this.charts.institution) {
            this.charts.institution.destroy();
        }

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
        // Logic handled by data-bs-toggle="modal" in the blade view
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
        console.log('Loading Reports Page...');
        const reportStatsEl = document.querySelector("#reportStatsChart");
        if (reportStatsEl && !this.charts.reportStats) {
            const options = {
                series: [44, 55, 13, 33],
                chart: {
                    type: 'donut',
                    height: 200
                },
                labels: ['Inden', 'Banduan', 'Bahan', 'Staf'],
                colors: ['#1a5632', '#2e7d57', '#0d3b1f', '#4c956c']
            };
            const chart = new ApexCharts(reportStatsEl, options);
            chart.render();
            this.charts.reportStats = chart;
        }
    }

    loadRawMaterialReportPage() {
        console.log('Loading Raw Material Stock Report Page...');

        const stockChartEl = document.querySelector('#stockStatusReportChart');
        if (stockChartEl && !this.charts.stockStatusReport) {
            const options = {
                series: [{
                    name: 'Stok Semasa',
                    data: [560, 180, 90]
                }, {
                    name: 'Stok Min',
                    data: [120, 150, 100]
                }],
                chart: {
                    type: 'bar',
                    height: 320,
                    toolbar: { show: false }
                },
                plotOptions: {
                    bar: {
                        borderRadius: 6,
                        horizontal: false,
                        columnWidth: '55%'
                    }
                },
                colors: ['#1a5632', '#ffc107'],
                dataLabels: { enabled: false },
                xaxis: {
                    categories: ['Makanan Basah', 'Makanan Kering', 'Rempah Ratus']
                },
                yaxis: {
                    title: {
                        text: 'Unit'
                    }
                },
                legend: {
                    position: 'top'
                }
            };

            const chart = new ApexCharts(stockChartEl, options);
            chart.render();
            this.charts.stockStatusReport = chart;
        }

        const exportBtn = document.getElementById('exportStockReportBtn');
        if (exportBtn && !exportBtn.dataset.bound) {
            exportBtn.dataset.bound = 'true';
            exportBtn.addEventListener('click', () => {
                this.exportStockReport();
            });
        }
    }

    exportStockReport() {
        this.showNotification('Data stok bahan mentah sedang disediakan untuk eksport', 'info');
    }

    async loadPerformanceReportsPage() {
        console.log('Loading Performance Reports (Real-time)...');
        
        const historyBody = document.getElementById('performanceHistoryBody');
        if (historyBody) {
            historyBody.innerHTML = '<tr><td colspan="7" class="text-center py-4 text-muted"><div class="spinner-border spinner-border-sm me-2"></div>Memuatkan data...</td></tr>';
        }

        try {
            // Fetch stats for cards and charts
            const statsRes = await fetch('/evaluations/stats', {
                headers: { 'Accept': 'application/json' }
            });
            
            if (!statsRes.ok) throw new Error(`HTTP error! status: ${statsRes.status}`);
            
            const statsResult = await statsRes.json();
            
            if (statsResult.success) {
                const stats = statsResult.stats;
                if (document.getElementById('statTotalEval')) document.getElementById('statTotalEval').textContent = stats.total;
                if (document.getElementById('statAvgPercentage')) document.getElementById('statAvgPercentage').textContent = `${stats.average}%`;
                if (document.getElementById('statCemerlangCount')) document.getElementById('statCemerlangCount').textContent = stats.ratings['Cemerlang'] || 0;
                if (document.getElementById('statLemahCount')) document.getElementById('statLemahCount').textContent = stats.ratings['Lemah'] || 0;
                
                this.updatePerformanceRatingChart(stats.ratings);
            }
            
            // Fetch history for table
            const histRes = await fetch('/evaluations', {
                headers: { 'Accept': 'application/json' }
            });
            
            if (!histRes.ok) throw new Error(`HTTP error! status: ${histRes.status}`);
            
            const histResult = await histRes.json();
            
            if (histResult.success && historyBody) {
                historyBody.innerHTML = '';
                if (histResult.data.length === 0) {
                    historyBody.innerHTML = '<tr><td colspan="7" class="text-center py-4 text-muted">Tiada rekod penilaian ditemui. Sila tambah penilaian baru.</td></tr>';
                } else {
                    histResult.data.forEach(ev => {
                        const row = document.createElement('tr');
                        const ratingBadge = ev.performance_rating === 'Cemerlang' ? 'bg-success' : 
                                          (ev.performance_rating === 'Sederhana' ? 'bg-warning text-dark' : 'bg-danger');
                        
                        row.innerHTML = `
                            <td>${new Date(ev.evaluation_date).toLocaleDateString('ms-MY')}</td>
                            <td><span class="badge bg-light text-dark border">${ev.order?.order_no || 'N/A'}</span></td>
                            <td><div class="fw-bold">${ev.supplier?.company_name || 'N/A'}</div></td>
                            <td><div class="small">${ev.institution?.name || 'N/A'}</div></td>
                            <td class="text-center"><div class="fw-bold text-primary">${ev.percentage}%</div></td>
                            <td class="text-center"><span class="badge rounded-pill px-3 ${ratingBadge}">${ev.performance_rating}</span></td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-outline-info" onclick="prisonSystem.viewEvaluation(${ev.id})">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </td>
                        `;
                        historyBody.appendChild(row);
                    });
                }
            }
            
            // Re-render Trend Chart
            this.renderPerformanceTrendChart();

        } catch (error) {
            console.error('Error loading performance page:', error);
            if (historyBody) historyBody.innerHTML = `<tr><td colspan="7" class="text-center py-4 text-danger">Ralat memuatkan data: ${error.message}. Sila cuba lagi.</td></tr>`;
        }
    }

    renderPerformanceTrendChart() {
        const trendEl = document.querySelector("#performanceTrendChart");
        if (!trendEl) return;
        
        if (this.charts.performanceTrend) {
            this.charts.performanceTrend.destroy();
        }

        const options = {
            series: [{
                name: 'Purata Prestasi (%)',
                data: [75, 78, 80, 82, 85, 84, 88, 90, 89, 92, 91, 93],
            }],
            chart: {
                type: 'area',
                height: 300,
                toolbar: { show: false },
            },
            colors: ['#1a5632'],
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.45,
                    opacityTo: 0.05,
                    stops: [20, 100],
                },
            },
            stroke: { curve: 'smooth', width: 3 },
            xaxis: {
                categories: ['Jan', 'Feb', 'Mac', 'Apr', 'Mei', 'Jun', 'Jul', 'Ogos', 'Sep', 'Okt', 'Nov', 'Dis'],
            },
            yaxis: { max: 100, min: 0 },
        };

        const chart = new ApexCharts(trendEl, options);
        chart.render();
        this.charts.performanceTrend = chart;
    }

    updatePerformanceRatingChart(ratings) {
        const ratingEl = document.querySelector("#performanceRatingChart");
        if (!ratingEl) return;

        if (this.charts.performanceRating) {
            this.charts.performanceRating.destroy();
        }

        const data = [
            ratings['Cemerlang'] || 0,
            ratings['Sederhana'] || 0,
            ratings['Lemah'] || 0
        ];

        const options = {
            series: data,
            chart: {
                type: 'donut',
                height: 300
            },
            labels: ['Cemerlang', 'Sederhana', 'Lemah'],
            colors: ['#198754', '#ffc107', '#dc3545'],
            legend: { position: 'bottom' },
            plotOptions: {
                pie: {
                    donut: {
                        size: '70%',
                        labels: {
                            show: true,
                            total: {
                                show: true,
                                label: 'Jumlah',
                                formatter: w => w.globals.seriesTotals.reduce((a, b) => a + b, 0)
                            }
                        }
                    }
                }
            }
        };

        const chart = new ApexCharts(ratingEl, options);
        chart.render();
        this.charts.performanceRating = chart;
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
        console.log('Loading Analytics Page...');
        if (document.querySelector("#analyticsChart") && !this.charts.analytics) {
            this.initAnalyticsChart();
        }

        if (document.querySelector("#crimeTrendChart") && !this.charts.crimeTrend) {
            this.initCrimeTrendChart();
        }

        if (document.querySelector("#demographicChart") && !this.charts.demographic) {
            this.initDemographicChart();
        }
    }

    initAnalyticsChart() {
        const chartEl = document.querySelector("#analyticsChart");
        if (!chartEl) return;

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

        const chart = new ApexCharts(chartEl, options);
        chart.render();
        this.charts.analytics = chart;
    }

    initCrimeTrendChart() {
        const chartEl = document.querySelector("#crimeTrendChart");
        if (!chartEl) return;

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

        const chart = new ApexCharts(chartEl, options);
        chart.render();
        this.charts.crimeTrend = chart;
    }

    initDemographicChart() {
        const chartEl = document.querySelector("#demographicChart");
        if (!chartEl) return;

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

        const chart = new ApexCharts(chartEl, options);
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

    getCsrfToken() {
        const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
        return csrfTokenMeta ? csrfTokenMeta.getAttribute('content') : '';
    }

    upsertUser(user) {
        if (!user || !user.id) return;

        const users = window.prisonData.users || [];
        const existing = users.find(u => parseInt(u.id) === parseInt(user.id));

        if (existing) {
            Object.assign(existing, user);
        } else {
            users.push(user);
        }

        window.prisonData.users = users;
    }

    async loadBackendAdmins() {
        try {
            const response = await fetch('/admin/users', {
                headers: {
                    'Accept': 'application/json'
                }
            });

            if (!response.ok) return;

            const result = await response.json();
            if (result.success && Array.isArray(result.data)) {
                result.data.forEach(user => this.upsertUser(user));
            }
        } catch (error) {
            console.warn('Unable to load admins from backend:', error);
        }
    }

    upsertSupplier(supplier) {
        if (!supplier || !supplier.id) return;

        const suppliers = window.prisonData.suppliers || [];
        const existing = suppliers.find(s => parseInt(s.id) === parseInt(supplier.id));

        if (existing) {
            Object.assign(existing, supplier);
        } else {
            suppliers.push(supplier);
        }

        window.prisonData.suppliers = suppliers;
    }

    async loadBackendSuppliers() {
        try {
            const response = await fetch('/suppliers', {
                headers: {
                    'Accept': 'application/json'
                }
            });

            if (!response.ok) return;

            const result = await response.json();
            if (result.success && Array.isArray(result.data)) {
                result.data.forEach(supplier => this.upsertSupplier(supplier));
            }
        } catch (error) {
            console.warn('Unable to load suppliers from backend:', error);
        }
    }

    upsertCategory(category) {
        if (!category || !category.id) return;
        const categories = window.prisonData.categories || [];
        const existing = categories.find(c => parseInt(c.id) === parseInt(category.id));
        if (existing) {
            Object.assign(existing, category);
        } else {
            categories.push(category);
        }
        window.prisonData.categories = categories;
    }

    async loadBackendCategories() {
        try {
            const response = await fetch('/categories', {
                headers: { 'Accept': 'application/json' }
            });
            if (!response.ok) return;
            const result = await response.json();
            if (result.success && Array.isArray(result.data)) {
                window.prisonData.categories = result.data.length ? result.data : window.prisonData.categories;
            }
        } catch (error) {
            console.warn('Unable to load categories from backend:', error);
        }
    }

    async loadBackendUoms() {
        try {
            const response = await fetch('/uoms', {
                headers: { 'Accept': 'application/json' }
            });
            if (!response.ok) return;
            const result = await response.json();
            if (result.success && Array.isArray(result.data)) {
                window.prisonData.uoms = result.data;
                this.populateUomDropdowns();
            }
        } catch (error) {
            console.warn('Unable to load UOMs from backend:', error);
        }
    }

    populateUomDropdowns() {
        const uomSelects = document.querySelectorAll('#item_uom_select');
        uomSelects.forEach(select => {
            const currentValue = select.value;
            select.innerHTML = '<option value="">Pilih Unit</option>';
            if (window.prisonData.uoms) {
                window.prisonData.uoms.forEach(uom => {
                    const option = document.createElement('option');
                    option.value = uom.code;
                    option.textContent = uom.description ? `${uom.description} (${uom.code})` : uom.code;
                    select.appendChild(option);
                });
            }
            if (currentValue) select.value = currentValue;
        });
    }

    async saveUserToBackend(id, formData) {
        formData.append('_method', 'PUT');

        const response = await fetch(`/admin/${id}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': this.getCsrfToken(),
                'Accept': 'application/json'
            },
            body: formData
        });

        const result = await response.json().catch(() => ({}));

        if (!response.ok || !result.success) {
            let errorMsg = result.message || 'Ralat mengemaskini admin.';
            if (result.errors) {
                errorMsg += '<br>' + Object.values(result.errors).map(v => v.join(', ')).join('<br>');
            }
            throw new Error(errorMsg);
        }

        this.upsertUser(result.data);
        this.showNotification(result.message || 'Maklumat admin berjaya dikemaskini.', 'success');
        this.refreshCurrentPage();
        this.updateDashboardStats();
    }

    async saveSupplierToBackend(id, formData) {
        formData.append('_method', 'PUT');

        const response = await fetch(`/suppliers/${id}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': this.getCsrfToken(),
                'Accept': 'application/json'
            },
            body: formData
        });

        const result = await response.json().catch(() => ({}));

        if (!response.ok || !result.success) {
            let errorMsg = result.message || 'Ralat mengemaskini pembekal.';
            if (result.errors) {
                errorMsg += '<br>' + Object.values(result.errors).map(v => v.join(', ')).join('<br>');
            }
            throw new Error(errorMsg);
        }

        this.upsertSupplier(result.data);
        this.showNotification(result.message || 'Maklumat pembekal berjaya dikemaskini.', 'success');
        this.refreshCurrentPage();
        this.updateDashboardStats();
    }

    async loadAdminListPage() {
        const tableBody = document.querySelector('#admin-list-table tbody');
        if (!tableBody) return;

        tableBody.innerHTML = '<tr><td colspan="6" class="text-center text-muted py-4">Memuatkan senarai admin...</td></tr>';
        await this.loadBackendAdmins();
        tableBody.innerHTML = '';
        const filterVal = document.getElementById('role-filter') ? document.getElementById('role-filter').value : '';
        
        let admins = window.prisonData.users;
        if (filterVal) {
            // Note: In data, role might be "Admin" or "User"
            const searchRole = filterVal.toLowerCase() === 'admin' ? 'Admin' : 'User';
            admins = admins.filter(u => (u.role || '').toLowerCase() === searchRole.toLowerCase());
        }

        admins.forEach((admin, index) => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${index + 1}</td>
                <td>
                    <div class="d-flex align-items-center">
                        <img src="https://ui-avatars.com/api/?name=${encodeURIComponent(admin.name)}&background=1a5632&color=fff&size=32" 
                             class="rounded-circle me-2" width="32" height="32">
                        <button class="btn btn-link p-0 text-start fw-medium text-decoration-none admin-name-btn" 
                                data-id="${admin.id}">
                            ${admin.name}
                        </button>
                    </div>
                </td>
                <td>${admin.email}</td>
                <td>${admin.role}</td>
                <td><span class="badge bg-${admin.status === 'active' ? 'success' : 'secondary'}">${admin.status === 'active' ? 'Aktif' : 'Tidak Aktif'}</span></td>
                <td>
                    <div class="btn-group btn-group-sm">
                        <button class="btn btn-sm btn-outline-info admin-view-btn" data-id="${admin.id}" title="Lihat Butiran">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-primary" data-action="edit-user" data-id="${admin.id}" title="Kemaskini">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-danger" data-action="delete-user" data-id="${admin.id}" title="Padam">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            `;
            tableBody.appendChild(row);
        });

        // Add event listeners for view buttons and names
        tableBody.querySelectorAll('.admin-name-btn, .admin-view-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const id = parseInt(btn.getAttribute('data-id'));
                const admin = window.prisonData.users.find(u => u.id === id);
                if (admin) this.showAdminDetailModal(admin);
            });
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
                    <td><span class="badge bg-secondary">${pos.code || 'N/A'}</span></td>
                    <td><div class="fw-medium">${pos.name || pos.title}</div></td>
                    <td>${pos.grade}</td>
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
            const grades = {};
            window.prisonData.positions.forEach(p => {
                grades[p.grade] = (grades[p.grade] || 0) + 1;
            });

            const options = {
                series: Object.values(grades),
                chart: {
                    type: 'pie',
                    height: 250
                },
                labels: Object.keys(grades),
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

    async loadSupplierListPage() {
        const tableBody = document.querySelector('#supplier-list-table tbody');
        if (!tableBody) return;

        tableBody.innerHTML = '<tr><td colspan="8" class="text-center text-muted py-4"><span class="spinner-border spinner-border-sm me-2"></span>Memuatkan senarai pembekal...</td></tr>';
        
        // Sync with database
        await this.loadBackendSuppliers();

        tableBody.innerHTML = '';

        if (window.prisonData.suppliers) {
            window.prisonData.suppliers.forEach((supplier, index) => {
                const row = document.createElement('tr');
                const isActive = supplier.status === 1 || supplier.status === 'active';
                row.innerHTML = `
                    <td>${index + 1}</td>
                    <td>
                        <button class="btn btn-link p-0 text-start fw-semibold text-decoration-underline supplier-name-btn"
                            data-supplier-id="${supplier.id}" style="color:#1a5632;">
                            <i class="fas fa-building me-1 opacity-50"></i>${supplier.company_name}
                        </button>
                        <div><small class="text-muted">${supplier.email || '-'}</small></div>
                    </td>
                    <td>${supplier.contact_person || '-'}</td>
                    <td>${supplier.phone_number || '-'}</td>
                    <td>${supplier.email || '-'}</td>
                    <td>${supplier.state || '-'}</td>
                    <td><span class="badge bg-${isActive ? 'success' : 'secondary'}">${isActive ? 'Aktif' : 'Tidak Aktif'}</span></td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            <button class="btn btn-sm btn-outline-info supplier-view-btn" data-supplier-id="${supplier.id}" title="Lihat Maklumat">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-primary" data-action="edit-supplier" data-id="${supplier.id}" title="Kemaskini">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger" data-action="delete-supplier" data-id="${supplier.id}" title="Padam">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                `;
                tableBody.appendChild(row);
            });
        }

        this.initDataTable('#supplier-list-table');

        // Use event delegation so DataTables row re-renders don't break the listeners
        const tableWrapper = document.querySelector('#supplier-list-table').closest('.table-responsive') 
            || document.querySelector('#supplier-list-content');
        if (tableWrapper) {
            // Remove any existing delegated listener to avoid duplicates
            tableWrapper.removeEventListener('click', tableWrapper._supplierClickHandler);
            tableWrapper._supplierClickHandler = (e) => {
                const btn = e.target.closest('.supplier-name-btn, .supplier-view-btn');
                if (btn) {
                    const id = parseInt(btn.getAttribute('data-supplier-id'));
                    const supplier = window.prisonData.suppliers.find(s => s.id == id);
                    if (supplier) this.showSupplierDetailModal(supplier);
                }
            };
            tableWrapper.addEventListener('click', tableWrapper._supplierClickHandler);
        }
    }

    showSupplierDetailModal(supplier) {
        const isActive = supplier.status === 1 || supplier.status === 'active';

        // Header & title
        document.getElementById('sdm-company-name').textContent = supplier.company_name || '-';
        document.getElementById('sdm-detail-company').textContent = supplier.company_name || '-';

        // Status badge
        const badge = document.getElementById('sdm-status-badge');
        badge.className = `badge fs-6 bg-${isActive ? 'success' : 'secondary'}`;
        badge.textContent = isActive ? 'Aktif' : 'Tidak Aktif';

        // Dates
        document.getElementById('sdm-created-at').textContent =
            supplier.created_at ? DataHelpers.formatDate(supplier.created_at) : '-';

        // Contact info
        document.getElementById('sdm-contact-person').textContent = supplier.contact_person || '-';
        const emailEl = document.getElementById('sdm-email');
        emailEl.textContent = supplier.email || '-';
        emailEl.href = supplier.email ? `mailto:${supplier.email}` : '#';
        document.getElementById('sdm-phone').textContent = supplier.phone_number || '-';

        // Address info
        document.getElementById('sdm-address').textContent = supplier.address || '-';
        document.getElementById('sdm-postcode').textContent = supplier.postcode || '-';
        document.getElementById('sdm-district').textContent = supplier.district || '-';
        document.getElementById('sdm-state').textContent = supplier.state || '-';

        // Edit button
        const editBtn = document.getElementById('sdm-edit-btn');
        if (editBtn) {
            editBtn.onclick = () => {
                bootstrap.Modal.getInstance(document.getElementById('supplierDetailModal'))?.hide();
                this.showEditModal('edit-supplier', supplier.id);
            };
        }

        const modal = new bootstrap.Modal(document.getElementById('supplierDetailModal'));
        modal.show();
    }

    showAdminDetailModal(admin) {
        // Populate modal fields
        document.getElementById('adm-name').textContent = admin.name;
        document.getElementById('adm-email').textContent = admin.email;
        document.getElementById('adm-phone').textContent = admin.phone_number || 'N/A';
        document.getElementById('adm-join-date').textContent = DataHelpers.formatDate(admin.joinDate) || 'N/A';
        document.getElementById('adm-institution').textContent = admin.institution || 'N/A';
        document.getElementById('adm-position').textContent = admin.position || 'N/A';
        document.getElementById('adm-role-badge').textContent = admin.role;

        // Set avatar
        document.getElementById('adm-avatar').src = `https://ui-avatars.com/api/?name=${encodeURIComponent(admin.name)}&background=ffffff&color=1a5632&size=100`;

        // Set status badge
        const statusBadge = document.getElementById('adm-status-badge');
        if (admin.status === 'active') {
            statusBadge.className = 'badge bg-success-subtle text-success';
            statusBadge.textContent = 'Aktif';
        } else {
            statusBadge.className = 'badge bg-secondary-subtle text-secondary';
            statusBadge.textContent = 'Tidak Aktif';
        }

        // Edit button action
        const editBtn = document.getElementById('adm-edit-btn');
        if (editBtn) {
            editBtn.onclick = () => {
                bootstrap.Modal.getInstance(document.getElementById('adminDetailModal'))?.hide();
                // Find and trigger edit button in table
                const editBtnInTable = document.querySelector(`button[data-action="edit-user"][data-id="${admin.id}"]`);
                if (editBtnInTable) editBtnInTable.click();
            };
        }

        const modal = new bootstrap.Modal(document.getElementById('adminDetailModal'));
        modal.show();
    }

    async loadCategoryListPage() {
        const tableBody = document.querySelector('#category-list-table tbody');
        if (!tableBody) return;

        tableBody.innerHTML = '<tr><td colspan="3" class="text-center text-muted py-4"><span class="spinner-border spinner-border-sm me-2"></span>Memuatkan kategori...</td></tr>';
        
        await this.loadBackendCategories();

        tableBody.innerHTML = '';

        if (window.prisonData.categories) {
            // Show all categories from backend
            window.prisonData.categories.forEach((cat, index) => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${index + 1}</td>
                    <td><div class="fw-medium">${cat.name}</div></td>
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

    async loadUomListPage() {
        const tableBody = document.querySelector('#uom-list-table tbody');
        if (!tableBody) return;

        tableBody.innerHTML = '<tr><td colspan="4" class="text-center text-muted py-4"><span class="spinner-border spinner-border-sm me-2"></span>Memuatkan UOM...</td></tr>';

        await this.loadBackendUoms();

        tableBody.innerHTML = '';

        if (window.prisonData.uoms && window.prisonData.uoms.length) {
            window.prisonData.uoms.forEach((uom, index) => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${index + 1}</td>
                    <td><code>${uom.code}</code></td>
                    <td>${uom.description || '-'}</td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            <button class="btn btn-sm btn-outline-primary" data-action="edit-uom" data-id="${uom.id}"><i class="fas fa-edit"></i></button>
                        </div>
                    </td>
                `;
                tableBody.appendChild(row);
            });
        } else {
            tableBody.innerHTML = '<tr><td colspan="4" class="text-center text-muted py-4">Tiada unit ukuran ditemui.</td></tr>';
        }

        this.initDataTable('#uom-list-table');
    }

    loadItemListPage() {
        const tableBody = document.querySelector('#item-list-table tbody');
        if (!tableBody) return;

        tableBody.innerHTML = '';

        // Strip numeric prefix like "2.1 ", "7.23 " from item names
        const cleanName = (name) => name.replace(/^\d+(\.\d+)*\s+/, '');

        // Combine items and rawMaterials for the master list
        const allItems = window.prisonData.items || [];
        const items = allItems.filter(item =>
            item.category.includes('Bahan Mentah') ||
            item.category === 'makanan'
        );

        if (window.prisonData.rawMaterials) {
            window.prisonData.rawMaterials.forEach(material => {
                items.push({
                    name: cleanName(material.name),
                    category: material.category,
                    subcategory: material.subcategory || '-',
                    ceiling_limit: material.ceiling_limit || '-',
                    price: material.price ? 'RM ' + parseFloat(material.price).toFixed(2) : '-',
                    unit: material.unit,
                    status: material.status,
                    id: material.id
                });
            });
        }

        items.forEach((item, index) => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${index + 1}</td>
                <td><div class="fw-medium">${cleanName(item.name)}</div></td>
                <td>${item.category}</td>
                <td>${item.subcategory || '-'}</td>
                <td>${item.ceiling_limit || '-'}</td>
                <td>${item.price || '-'}</td>
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

    initTooltips() {
        // Initialize Bootstrap 5 tooltips for all elements with data-bs-toggle="tooltip"
        document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
            if (!bootstrap.Tooltip.getInstance(el)) {
                new bootstrap.Tooltip(el, { trigger: 'hover' });
            }
        });
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

        logoutBtns.forEach(btn => {
            if (btn) {
                btn.addEventListener('click', (e) => {
                    e.preventDefault();
                    logoutModal.show();
                });
            }
        });
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

            // Export stock report from the stock card action menu
            if (e.target.closest('[data-action="export-stock"]')) {
                e.preventDefault();
                this.exportStockReport();
                return;
            }

            // Table actions
            if (e.target.closest('[data-action]')) {
                const actionElement = e.target.closest('[data-action]');
                const action = actionElement.getAttribute('data-action');
                const id = actionElement.getAttribute('data-id');

                this.handleTableAction(action, id);
            }
        });

        // Role filter change
        const roleFilter = document.getElementById('role-filter');
        if (roleFilter) {
            roleFilter.addEventListener('change', () => {
                // Destroy old datatable first to reinit properly
                if ($.fn.DataTable.isDataTable('#admin-list-table')) {
                    $('#admin-list-table').DataTable().destroy();
                }
                this.loadAdminListPage();
            });
        }

        // Setup Add Admin Modal Population
        const addAdminBtn = document.getElementById('addAdminBtn');
        if (addAdminBtn) {
            addAdminBtn.addEventListener('click', () => {
                // Populate institution select
                const instSelect = document.getElementById('adminInstitution');
                if (instSelect && window.prisonData.institutions) {
                    instSelect.innerHTML = '<option value="">Pilih Institusi</option>';
                    window.prisonData.institutions.forEach(inst => {
                        instSelect.innerHTML += `<option value="${inst.id}">${inst.name}</option>`;
                    });
                }
            });
        }
        
        // Auto-generate email based on Name
        const adminNameInput = document.getElementById('adminName');
        const adminEmailInput = document.getElementById('adminEmail');
        if (adminNameInput && adminEmailInput) {
            adminNameInput.addEventListener('input', (e) => {
                const name = e.target.value.trim().toLowerCase();
                if (name) {
                    const formattedName = name.replace(/\s+/g, '.');
                    adminEmailInput.value = `${formattedName}@gmail.com`;
                } else {
                    adminEmailInput.value = '';
                }
            });
        }

        // File Validation for Admin Image
        const adminImageInput = document.getElementById('adminImage');
        if (adminImageInput) {
            adminImageInput.addEventListener('change', (e) => {
                const file = e.target.files[0];
                let errorEl = e.target.parentNode.querySelector('.text-danger');
                
                // Clear previous error
                if (errorEl) {
                    errorEl.remove();
                }

                if (file) {
                    const maxSize = 2 * 1024 * 1024; // 2MB
                    if (file.size > maxSize) {
                        errorEl = document.createElement('div');
                        errorEl.className = 'text-danger small mt-1';
                        errorEl.textContent = 'Ukuran fail melebihi 2MB. Sila pilih fail yang lebih kecil.';
                        e.target.parentNode.appendChild(errorEl);
                        e.target.value = '';
                        return;
                    }
                    const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                    if (!allowedTypes.includes(file.type)) {
                        errorEl = document.createElement('div');
                        errorEl.className = 'text-danger small mt-1';
                        errorEl.textContent = 'Format fail tidak sah. Sila pilih fail gambar (JPEG, PNG, GIF, WEBP).';
                        e.target.parentNode.appendChild(errorEl);
                        e.target.value = '';
                        return;
                    }
                }
            });
        }

        // Save Admin Btn
        const saveAdminBtn = document.getElementById('saveAdminBtn');
        if (saveAdminBtn) {
            saveAdminBtn.addEventListener('click', async () => {
                const form = document.getElementById('addAdminForm');
                if (form.checkValidity()) {
                    // Update UI to show loading
                    const originalText = saveAdminBtn.innerHTML;
                    saveAdminBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menyimpan...';
                    saveAdminBtn.disabled = true;

                    try {
                        const formData = new FormData(form);
                        const institutionSelect = document.getElementById('adminInstitution');
                        const roleSelect = document.getElementById('adminRole');
                        formData.append('institution_name', institutionSelect?.selectedOptions?.[0]?.textContent || '');
                        formData.append('role_name', roleSelect?.selectedOptions?.[0]?.textContent || '');
                        const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
                        const csrfToken = csrfTokenMeta ? csrfTokenMeta.getAttribute('content') : '';

                        const response = await fetch('/admin/register', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            },
                            body: formData
                        });

                        const result = await response.json();

                        if (response.ok && result.success) {
                            this.showNotification(result.message || 'Pendaftaran Pentadbir Baru Berjaya!', 'success');
                            bootstrap.Modal.getInstance(document.getElementById('addAdminModal')).hide();
                            form.reset();
                            
                            // Reload table if it's the admin list view
                            if (this.currentPage === 'admin-list') {
                                this.upsertUser(result.data);
                                
                                if ($.fn.DataTable.isDataTable('#admin-list-table')) {
                                    $('#admin-list-table').DataTable().destroy();
                                }
                                this.loadAdminListPage();
                            }
                        } else {
                            // Validation error or logic error
                            let errorMsg = result.message || 'Ralat menyimpan pendaftaran admin.';
                            if (result.errors) {
                                const details = Object.values(result.errors).map(v => v.join(', ')).join('<br>');
                                errorMsg += '<br>' + details;
                            }
                            this.showNotification(errorMsg, 'danger');
                        }
                    } catch (error) {
                        console.error('Error registering admin:', error);
                        this.showNotification('Ralat sistem ketika berhubung dengan pelayan.', 'danger');
                    } finally {
                        // Restore button
                        saveAdminBtn.innerHTML = originalText;
                        saveAdminBtn.disabled = false;
                    }
                } else {
                    form.reportValidity();
                }
            });
        }

        // Save Position Btn
        const savePositionBtn = document.getElementById('savePositionBtn');
        if (savePositionBtn) {
            savePositionBtn.addEventListener('click', async () => {
                const form = document.getElementById('addPositionForm');
                if (form.checkValidity()) {
                    // Update UI to show loading
                    const originalText = savePositionBtn.innerHTML;
                    savePositionBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menyimpan...';
                    savePositionBtn.disabled = true;

                    try {
                        const formData = new FormData(form);
                        const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
                        const csrfToken = csrfTokenMeta ? csrfTokenMeta.getAttribute('content') : '';

                        const response = await fetch('/position/store', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            },
                            body: formData
                        });

                        const result = await response.json();

                        if (response.ok && result.success) {
                            this.showNotification(result.message || 'Jawatan Baru Berjaya Disimpan!', 'success');
                            bootstrap.Modal.getInstance(document.getElementById('addPositionModal')).hide();
                            form.reset();
                            
                            // Reload table if it's the position list view
                            if (this.currentPage === 'position-list') {
                                window.prisonData.positions.push({
                                    id: result.data.id || Date.now(),
                                    code: result.data.code,
                                    name: result.data.name,
                                    title: result.data.name, // fallback for legacy
                                    grade: result.data.grade
                                });
                                
                                if ($.fn.DataTable.isDataTable('#position-list-table')) {
                                    $('#position-list-table').DataTable().destroy();
                                }
                                this.loadPositionListPage();
                            }
                        } else {
                            // Validation error
                            let errorMsg = result.message || 'Ralat menyimpan jawatan.';
                            if (result.errors) {
                                const details = Object.values(result.errors).map(v => v.join(', ')).join('<br>');
                                errorMsg += '<br>' + details;
                            }
                            this.showNotification(errorMsg, 'danger');
                        }
                    } catch (error) {
                        console.error('Error saving position:', error);
                        this.showNotification('Ralat sistem ketika berhubung dengan pelayan.', 'danger');
                    } finally {
                        // Restore button
                        savePositionBtn.innerHTML = originalText;
                        savePositionBtn.disabled = false;
                    }
                } else {
                    form.reportValidity();
                }
            });
        }

        // Save Category Btn
        const saveCategoryBtn = document.getElementById('saveCategoryBtn');
        if (saveCategoryBtn) {
            saveCategoryBtn.addEventListener('click', async () => {
                const form = document.getElementById('addCategoryForm');
                if (form.checkValidity()) {
                    const originalText = saveCategoryBtn.innerHTML;
                    saveCategoryBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menyimpan...';
                    saveCategoryBtn.disabled = true;

                    try {
                        const formData = new FormData(form);
                        const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
                        const csrfToken = csrfTokenMeta ? csrfTokenMeta.getAttribute('content') : '';

                        const response = await fetch('/categories', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            },
                            body: formData
                        });

                        const result = await response.json();

                        if (response.ok && result.success) {
                            this.showNotification(result.message || 'Kategori Berjaya Ditambah!', 'success');
                            bootstrap.Modal.getInstance(document.getElementById('addCategoryModal')).hide();
                            form.reset();
                            
                            setTimeout(() => { window.location.reload(); }, 1500);
                        } else {
                            let errorMsg = result.message || 'Ralat menyimpan kategori.';
                            if (result.errors) {
                                const details = Object.values(result.errors).map(v => v.join(', ')).join('<br>');
                                errorMsg += '<br>' + details;
                            }
                            this.showNotification(errorMsg, 'danger');
                        }
                    } catch (error) {
                        console.error('Error saving category:', error);
                        this.showNotification('Ralat sistem ketika berhubung dengan pelayan.', 'danger');
                    } finally {
                        saveCategoryBtn.innerHTML = originalText;
                        saveCategoryBtn.disabled = false;
                    }
                } else {
                    form.reportValidity();
                }
            });
        }

        // Save Item Btn
        const saveItemBtn = document.getElementById('saveItemBtn');
        if (saveItemBtn) {
            saveItemBtn.addEventListener('click', async () => {
                const form = document.getElementById('addItemForm');
                if (form.checkValidity()) {
                    const originalText = saveItemBtn.innerHTML;
                    saveItemBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menyimpan...';
                    saveItemBtn.disabled = true;

                    try {
                        const formData = new FormData(form);
                        const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
                        const csrfToken = csrfTokenMeta ? csrfTokenMeta.getAttribute('content') : '';

                        const response = await fetch('/items', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            },
                            body: formData
                        });

                        const result = await response.json();

                        if (response.ok && result.success) {
                            this.showNotification(result.message || 'Item Berjaya Ditambah!', 'success');
                            bootstrap.Modal.getInstance(document.getElementById('addItemModal')).hide();
                            form.reset();
                            
                            // Optional: If you want to reload the item list logic here:
                            // if (this.currentPage === 'item-list') {
                            //     this.loadItemListPage();
                            // }
                            
                        } else {
                            // Validation error
                            let errorMsg = result.message || 'Ralat menyimpan item.';
                            if (result.errors) {
                                const details = Object.values(result.errors).map(v => v.join(', ')).join('<br>');
                                errorMsg += '<br>' + details;
                            }
                            this.showNotification(errorMsg, 'danger');
                        }
                    } catch (error) {
                        console.error('Error saving item:', error);
                        this.showNotification('Ralat sistem ketika berhubung dengan pelayan.', 'danger');
                    } finally {
                        // Restore button
                        saveItemBtn.innerHTML = originalText;
                        saveItemBtn.disabled = false;
                    }
                } else {
                    form.reportValidity();
                }
            });
        }

        // Save Supplier Btn
        const saveSupplierBtn = document.getElementById('saveSupplierBtn');
        if (saveSupplierBtn) {
            saveSupplierBtn.addEventListener('click', async () => {
                const form = document.getElementById('addSupplierForm');
                if (form.checkValidity()) {
                    const originalText = saveSupplierBtn.innerHTML;
                    saveSupplierBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menyimpan...';
                    saveSupplierBtn.disabled = true;

                    try {
                        const formData = new FormData(form);
                        const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
                        const csrfToken = csrfTokenMeta ? csrfTokenMeta.getAttribute('content') : '';

                        const response = await fetch('/suppliers', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            },
                            body: formData
                        });

                        const result = await response.json();

                        if (response.ok && result.success) {
                            this.showNotification(result.message || 'Pembekal Baru Berjaya Disimpan!', 'success');
                            bootstrap.Modal.getInstance(document.getElementById('addSupplierModal')).hide();
                            form.reset();
                            
                            // Reload table if it's the supplier list view
                            if (this.currentPage === 'supplier-list') {
                                window.prisonData.suppliers.push(result.data);
                                
                                if ($.fn.DataTable.isDataTable('#supplier-list-table')) {
                                    $('#supplier-list-table').DataTable().destroy();
                                }
                                this.loadSupplierListPage();
                            }
                        } else {
                            let errorMsg = result.message || 'Ralat menyimpan pembekal.';
                            if (result.errors) {
                                const details = Object.values(result.errors).map(v => v.join(', ')).join('<br>');
                                errorMsg += '<br>' + details;
                            }
                            this.showNotification(errorMsg, 'danger');
                        }
                    } catch (error) {
                        console.error('Error saving supplier:', error);
                        this.showNotification('Ralat sistem ketika berhubung dengan pelayan.', 'danger');
                    } finally {
                        saveSupplierBtn.innerHTML = originalText;
                        saveSupplierBtn.disabled = false;
                    }
                } else {
                    form.reportValidity();
                }
            });
        }

        // Save UOM Btn
        const saveUomBtn = document.getElementById('saveUomBtn');
        if (saveUomBtn) {
            saveUomBtn.addEventListener('click', async () => {
                const form = document.getElementById('addUomForm');
                if (form.checkValidity()) {
                    const originalText = saveUomBtn.innerHTML;
                    saveUomBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menyimpan...';
                    saveUomBtn.disabled = true;

                    try {
                        const uomId = document.getElementById('uom_id').value;
                        const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
                        const csrfToken = csrfTokenMeta ? csrfTokenMeta.getAttribute('content') : '';

                        const payload = {
                            code: document.getElementById('uom_code').value,
                            description: document.getElementById('uom_description').value
                        };

                        const url = uomId ? `/uoms/${uomId}` : '/uoms';
                        const method = uomId ? 'PUT' : 'POST';

                        const response = await fetch(url, {
                            method: method,
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify(payload)
                        });

                        const result = await response.json();

                        if (response.ok && result.success) {
                            this.showNotification(result.message || 'UOM Berjaya Disimpan!', 'success');
                            bootstrap.Modal.getInstance(document.getElementById('addUomModal')).hide();
                            form.reset();
                            document.getElementById('uom_id').value = '';
                            document.getElementById('uomModalTitle').textContent = 'Tambah UOM Baru';

                            await this.loadBackendUoms();
                            if (this.currentPage === 'uom-list') {
                                this.loadUomListPage();
                            }
                        } else {
                            let errorMsg = result.message || 'Ralat menyimpan UOM.';
                            if (result.errors) {
                                const details = Object.values(result.errors).map(v => v.join(', ')).join('<br>');
                                errorMsg += '<br>' + details;
                            }
                            this.showNotification(errorMsg, 'danger');
                        }
                    } catch (error) {
                        console.error('Error saving UOM:', error);
                        this.showNotification('Ralat sistem ketika berhubung dengan pelayan.', 'danger');
                    } finally {
                        saveUomBtn.innerHTML = originalText;
                        saveUomBtn.disabled = false;
                    }
                } else {
                    form.reportValidity();
                }
            });
        }

        // Reset UOM modal on open for new entry
        const addUomModalEl = document.getElementById('addUomModal');
        if (addUomModalEl) {
            addUomModalEl.addEventListener('hidden.bs.modal', () => {
                document.getElementById('addUomForm').reset();
                document.getElementById('uom_id').value = '';
                document.getElementById('uomModalTitle').textContent = 'Tambah UOM Baru';
            });
        }

        // Initialize Add Supplier Modal Dropdowns
        const addSupplierModalEl = document.getElementById('addSupplierModal');
        if (addSupplierModalEl) {
            addSupplierModalEl.addEventListener('show.bs.modal', () => {
                const stateSelect = document.getElementById('supplierState');
                const districtSelect = document.getElementById('supplierDistrict');
                
                if (stateSelect && window.prisonData.states) {
                    stateSelect.innerHTML = '<option value="">Pilih Negeri</option>';
                    window.prisonData.states.forEach(state => {
                        stateSelect.innerHTML += `<option value="${state.id}">${state.name}</option>`;
                    });
                    
                    stateSelect.onchange = () => {
                        const stateId = parseInt(stateSelect.value);
                        districtSelect.innerHTML = '<option value="">Pilih Daerah</option>';
                        if (stateId && window.prisonData.districts) {
                            window.prisonData.districts.filter(d => d.state_id === stateId).forEach(d => {
                                districtSelect.innerHTML += `<option value="${d.id}">${d.name}</option>`;
                            });
                        }
                    };
                }
            });
        }

        // Initialize add institution modal
        const addInstitutionModal = document.getElementById('addInstitutionModal');
        if (addInstitutionModal) {
            const modal = new bootstrap.Modal(addInstitutionModal);
            const saveBtn = document.getElementById('saveInstitutionBtn');
            const form = document.getElementById('addInstitutionForm');

            if (saveBtn) {
                saveBtn.addEventListener('click', () => {
                    if (form.checkValidity()) {
                        const stateEl = document.getElementById('institutionState');
                        const districtEl = document.getElementById('institutionDistrict');
                        const selectedStateObj = window.prisonData.states.find(s => s.name === stateEl.value);

                        const formData = {
                            name: document.getElementById('institutionName').value,
                            state: stateEl.value,
                            state_id: selectedStateObj ? selectedStateObj.id : null,
                            type: document.getElementById('institutionType').value,
                            capacity: document.getElementById('institutionCapacity').value,
                            status: document.getElementById('institutionStatus').value,
                            address: document.getElementById('institutionAddress').value,
                            phone: document.getElementById('institutionPhone').value,
                            postcode: document.getElementById('institutionPostcode').value,
                            district_id: districtEl ? districtEl.value : ''
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
            const districtSelect = document.getElementById('institutionDistrict');

            if (stateSelect) {
                stateSelect.innerHTML = '<option value="">Pilih Negeri</option>' +
                    window.prisonData.states.map(state =>
                        `<option value="${state.name}" data-id="${state.id}">${state.name}</option>`
                    ).join('');

                // Dynamically load districts when state changes
                stateSelect.addEventListener('change', () => {
                    const selectedOption = stateSelect.options[stateSelect.selectedIndex];
                    const stateId = parseInt(selectedOption.getAttribute('data-id'));

                    if (districtSelect) {
                        districtSelect.innerHTML = '<option value="">Pilih Daerah (pilihan)</option>';
                        if (stateId && window.prisonData.districts) {
                            const filtered = window.prisonData.districts.filter(d => d.state_id === stateId);
                            filtered.forEach(d => {
                                districtSelect.innerHTML += `<option value="${d.id}">${d.name}</option>`;
                            });
                        }
                    }
                });
            }

            // Reset district dropdown when modal is closed
            addInstitutionModal.addEventListener('hidden.bs.modal', () => {
                if (districtSelect) {
                    districtSelect.innerHTML = '<option value="">Pilih Daerah (pilihan)</option>';
                }
            });
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
                saveEditBtn.addEventListener('click', async () => {
                    const id = parseInt(document.getElementById('editEntityId').value);
                    const type = document.getElementById('editEntityType').value;
                    const form = document.getElementById('editForm');

                    if (!form.checkValidity()) {
                        form.reportValidity();
                        return;
                    }

                    const formData = new FormData(form);
                    const originalText = saveEditBtn.innerHTML;
                    saveEditBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menyimpan...';
                    saveEditBtn.disabled = true;

                    try {
                        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
                        let response, result;

                        if (type === 'user') {
                            await this.saveUserToBackend(id, formData);
                            bootstrap.Modal.getInstance(document.getElementById('editModal')).hide();

                        } else if (type === 'supplier') {
                            await this.saveSupplierToBackend(id, formData);
                            bootstrap.Modal.getInstance(document.getElementById('editModal')).hide();

                        } else if (type === 'category') {
                            response = await fetch(`/categories/${id}`, {
                                method: 'PUT',
                                headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json', 'Content-Type': 'application/x-www-form-urlencoded' },
                                body: new URLSearchParams(formData)
                            });
                            result = await response.json();
                            if (result.success) {
                                this.showNotification(result.message || 'Kategori berjaya dikemaskini.', 'success');
                                bootstrap.Modal.getInstance(document.getElementById('editModal')).hide();
                                this.refreshCurrentPage();
                            } else {
                                const msg = result.errors ? Object.values(result.errors).flat().join('\n') : (result.message || 'Ralat mengemaskini kategori.');
                                this.showNotification(msg, 'danger');
                            }

                        } else if (type === 'item') {
                            response = await fetch(`/items/${id}`, {
                                method: 'PUT',
                                headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json', 'Content-Type': 'application/x-www-form-urlencoded' },
                                body: new URLSearchParams(formData)
                            });
                            result = await response.json();
                            if (result.success) {
                                this.showNotification(result.message || 'Item berjaya dikemaskini.', 'success');
                                bootstrap.Modal.getInstance(document.getElementById('editModal')).hide();
                                this.refreshCurrentPage();
                            } else {
                                const msg = result.errors ? Object.values(result.errors).flat().join('\n') : (result.message || 'Ralat mengemaskini item.');
                                this.showNotification(msg, 'danger');
                            }

                        } else if (type === 'position') {
                            response = await fetch(`/position/${id}`, {
                                method: 'PUT',
                                headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json', 'Content-Type': 'application/x-www-form-urlencoded' },
                                body: new URLSearchParams(formData)
                            });
                            result = await response.json();
                            if (result.success) {
                                this.showNotification(result.message || 'Jawatan berjaya dikemaskini.', 'success');
                                bootstrap.Modal.getInstance(document.getElementById('editModal')).hide();
                                this.refreshCurrentPage();
                            } else {
                                const msg = result.errors ? Object.values(result.errors).flat().join('\n') : (result.message || 'Ralat mengemaskini jawatan.');
                                this.showNotification(msg, 'danger');
                            }

                        } else if (type === 'institution') {
                            const updatedData = {};
                            formData.forEach((value, key) => { updatedData[key] = value; });
                            this.saveEntity(type, id, updatedData);
                            bootstrap.Modal.getInstance(document.getElementById('editModal')).hide();

                        } else {
                            const updatedData = {};
                            formData.forEach((value, key) => { updatedData[key] = value; });
                            this.saveEntity(type, id, updatedData);
                            bootstrap.Modal.getInstance(document.getElementById('editModal')).hide();
                        }
                    } catch (error) {
                        console.error('Ralat mengemaskini entiti:', error);
                        this.showNotification(error.message || 'Ralat sistem ketika mengemaskini rekod.', 'danger');
                    } finally {
                        saveEditBtn.innerHTML = originalText;
                        saveEditBtn.disabled = false;
                    }
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
            const entityType = action === 'delete' ? 'institution' : action.replace('delete-', '');
            const confirmMsg = `Adakah anda pasti ingin memadam ${this.getEntityLabel(entityType)} ini?`;
            
            this.showConfirmModal(confirmMsg, () => {
                this.deleteEntity(entityType, entityId);
            }, 'danger', 'delete');
            return;
        }

        // Other Actions
        switch (action) {
            case 'approve-order':
                this.showConfirmModal('Adakah anda pasti ingin meluluskan inden ini?', () => {
                    this.approveOrder(entityId);
                }, 'success', 'approve');
                break;
            case 'reject-order':
                this.showConfirmModal('Adakah anda pasti ingin menolak inden ini?', () => {
                    this.rejectOrder(entityId);
                }, 'danger', 'reject');
                break;
        }
    }

    showConfirmModal(message, callback, type = 'danger', actionType = 'delete') {
        const modalEl = document.getElementById('confirmModal');
        if (!modalEl) {
            if (confirm(message)) callback();
            return;
        }
        
        const modal = new bootstrap.Modal(modalEl);
        const titleEl = document.getElementById('confirmModalTitle');
        const messageEl = document.getElementById('confirmModalMessage');
        const btnEl = document.getElementById('confirmModalBtn');
        const headerEl = modalEl.querySelector('.modal-header');
        const iconEl = document.getElementById('confirmModalIcon');

        messageEl.textContent = message;

        // Reset classes
        headerEl.className = `modal-header text-white bg-${type}`;
        btnEl.className = `btn px-4 btn-${type}`;
        iconEl.className = `fas fa-3x text-${type} `;
        
        if (actionType === 'delete') {
            titleEl.innerHTML = '<i class="fas fa-exclamation-triangle me-2"></i>Pengesahan Padam';
            iconEl.classList.add('fa-trash-alt');
            btnEl.innerHTML = '<i class="fas fa-trash-alt me-2"></i>Padam';
        } else if (actionType === 'approve') {
            titleEl.innerHTML = '<i class="fas fa-check-circle me-2"></i>Pengesahan Kelulusan';
            iconEl.classList.add('fa-check-circle');
            btnEl.innerHTML = '<i class="fas fa-check me-2"></i>Lulus';
        } else if (actionType === 'reject') {
            titleEl.innerHTML = '<i class="fas fa-times-circle me-2"></i>Pengesahan Penolakan';
            iconEl.classList.add('fa-times-circle');
            btnEl.innerHTML = '<i class="fas fa-times me-2"></i>Tolak';
        } else {
            titleEl.innerHTML = '<i class="fas fa-question-circle me-2"></i>Pengesahan Tindakan';
            iconEl.classList.add('fa-question-circle');
            btnEl.innerHTML = 'Teruskan';
        }

        // Remove old event listeners by cloning
        const newBtnEl = btnEl.cloneNode(true);
        btnEl.parentNode.replaceChild(newBtnEl, btnEl);
        
        newBtnEl.addEventListener('click', () => {
            modal.hide();
            callback();
        });

        modal.show();
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
            case 'uom': return window.prisonData.uoms || [];
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

        if (type === 'institution') {
            const address = entity.address || entity.full_address || 'Alamat tidak tersedia';
            const phone = entity.phone_number || entity.phone || entity.phoneNumber || 'Tiada no telefon';

            body.innerHTML = `
                <div class="table-responsive">
                    <table class="table table-sm">
                        <tr>
                            <th class="text-muted" style="width: 35%">Nama</th>
                            <td>${entity.name || 'Tidak dikenali'}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">Alamat</th>
                            <td>${address}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">No telefon</th>
                            <td>${phone}</td>
                        </tr>
                    </table>
                </div>
            `;
            new bootstrap.Modal(document.getElementById('viewModal')).show();
            return;
        }

        const malayLabelMap = {
            'name':             'Nama',
            'email':            'E-mel',
            'phone':            'No. Telefon',
            'phone_number':     'No. Telefon',
            'address':          'Alamat',
            'postcode':         'Poskod',
            'status':           'Status',
            'code':             'Kod',
            'description':      'Penerangan',
            'grade':            'Gred',
            'type':             'Jenis',
            'capacity':         'Kapasiti',
            'current':          'Jumlah Semasa',
            'company_name':     'Nama Syarikat',
            'contact_person':   'PIC',
            'state':            'Negeri',
            'district':         'Daerah',
            'institution':      'Institusi',
            'position':         'Jawatan',
            'role':             'Peranan',
            'category':         'Kategori',
            'uom':              'Unit Ukuran',
            'price_per_unit':   'Harga Seunit',
            'current_quantity': 'Kuantiti Semasa',
            'created_at':       'Tarikh Dicipta',
            'updated_at':       'Tarikh Dikemaskini',
            'stock':            'Jumlah Stok',
            'minStock':         'Stok Minimum',
            'price':            'Harga',
            'unit':             'Unit Ukuran',
            'lastUpdated':      'Kemaskini Terakhir'
        };

        let html = '<div class="table-responsive"><table class="table table-sm">';
        for (const [key, value] of Object.entries(entity)) {
            if (key === 'id' || key === 'avatar') continue;
            const labelText = malayLabelMap[key] || (key.charAt(0).toUpperCase() + key.slice(1).replace(/_/g, ' '));
            html += `
                <tr>
                    <th class="text-muted" style="width: 35%">${labelText}</th>
                    <td>${Array.isArray(value) ? value.join(', ') : (value === '' || value === null ? '-' : value)}</td>
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

        // UOM uses its own modal
        if (type === 'uom') {
            document.getElementById('uom_id').value = entity.id;
            document.getElementById('uom_code').value = entity.code || '';
            document.getElementById('uom_description').value = entity.description || '';
            document.getElementById('uomModalTitle').textContent = 'Kemaskini UOM';
            new bootstrap.Modal(document.getElementById('addUomModal')).show();
            return;
        }

        document.getElementById('editEntityId').value = id;
        document.getElementById('editEntityType').value = type;

        // Set modal title dynamically in Malay
        const modalTitleEl = document.getElementById('editModalTitle');
        if (modalTitleEl) {
            const titleMap = {
                'institution': 'Kemaskini Maklumat Institusi',
                'user':        'Kemaskini Maklumat Pengguna',
                'supplier':    'Kemaskini Maklumat Pembekal',
                'category':    'Kemaskini Maklumat Kategori',
                'item':        'Kemaskini Maklumat Item',
                'position':    'Kemaskini Maklumat Jawatan',
            };
            modalTitleEl.textContent = titleMap[type] || 'Kemaskini Maklumat';
        }

        const fieldsContainer = document.getElementById('editFormFields');
        fieldsContainer.innerHTML = '';

        if (type === 'institution') {
            const states = Array.isArray(window.prisonData.states) ? window.prisonData.states : [];
            const districts = Array.isArray(window.prisonData.districts) ? window.prisonData.districts : [];

            fieldsContainer.innerHTML = `
                <div class="mb-3">
                    <label class="form-label">Nama Institusi</label>
                    <input type="text" class="form-control" name="name" value="${entity.name || ''}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Jenis Institusi</label>
                    <select class="form-select" name="type" required>
                        <option value="Penjara" ${entity.type === 'Penjara' ? 'selected' : ''}>Penjara</option>
                        <option value="Pusat Koreksional" ${entity.type === 'Pusat Koreksional' ? 'selected' : ''}>Pusat Koreksional</option>
                        <option value="Penjara Reman" ${entity.type === 'Penjara Reman' ? 'selected' : ''}>Penjara Reman</option>
                        <option value="Pusat Pemulihan" ${entity.type === 'Pusat Pemulihan' ? 'selected' : ''}>Pusat Pemulihan</option>
                        <option value="Sekolah Henry Gurney" ${entity.type === 'Sekolah Henry Gurney' ? 'selected' : ''}>Sekolah Henry Gurney</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">No telefon</label>
                    <input type="tel" class="form-control" name="phone" value="${entity.phone || ''}" placeholder="Cth: 012-3456789">
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Kapasiti</label>
                        <input type="number" class="form-control" name="capacity" value="${entity.capacity || ''}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Semasa</label>
                        <input type="number" class="form-control" name="current" value="${entity.current || ''}" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-toggle-on me-1 text-success"></i>Status
                    </label>
                    <select class="form-select" name="status" required>
                        <option value="active" ${entity.status === 'active' ? 'selected' : ''}>Aktif</option>
                        <option value="inactive" ${entity.status === 'inactive' ? 'selected' : ''}>Tidak Aktif</option>
                        <option value="maintenance" ${entity.status === 'maintenance' ? 'selected' : ''}>Penyelenggaraan</option>
                    </select>
                </div>
                <div class="mb-2">
                    <label class="form-label">Negeri</label>
                    <select class="form-select" name="state_id" id="editInstitutionStateSelect" required>
                        <option value="">Pilih Negeri</option>
                        ${states.map(state => `
                            <option value="${state.id}" ${state.id == entity.state_id || state.name === entity.state ? 'selected' : ''}>${state.name}</option>
                        `).join('')}
                    </select>
                    <input type="hidden" name="state" id="editInstitutionStateName" value="${entity.state || ''}">
                </div>
                <div class="mb-2">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-map-marker-alt me-1 text-danger"></i>Alamat
                    </label>
                    <textarea class="form-control" name="address" rows="2" placeholder="Alamat penuh institusi (pilihan)">${entity.address || ''}</textarea>
                </div>
                <div class="row mb-2">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Poskod</label>
                        <input type="text" class="form-control" name="postcode" value="${entity.postcode || ''}" maxlength="5" placeholder="Cth: 43000">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Daerah</label>
                        <select class="form-select" name="district_id" id="editInstitutionDistrictSelect">
                            <option value="">Pilih Daerah (pilihan)</option>
                        </select>
                    </div>
                </div>
            `;

            const stateSelect = document.getElementById('editInstitutionStateSelect');
            const stateNameInput = document.getElementById('editInstitutionStateName');
            const districtSelect = document.getElementById('editInstitutionDistrictSelect');

            const populateDistricts = () => {
                const selectedStateId = parseInt(stateSelect.value);
                if (selectedStateId && stateSelect.selectedIndex >= 0) {
                    stateNameInput.value = stateSelect.options[stateSelect.selectedIndex].text;
                } else {
                    stateNameInput.value = '';
                }
                
                districtSelect.innerHTML = '<option value="">Pilih Daerah (pilihan)</option>';
                if (selectedStateId) {
                    districts.filter(d => d.state_id === selectedStateId).forEach(d => {
                        const selected = d.id == entity.district_id ? 'selected' : '';
                        districtSelect.innerHTML += `<option value="${d.id}" ${selected}>${d.name}</option>`;
                    });
                }
            };

            populateDistricts();
            stateSelect.addEventListener('change', populateDistricts);

            new bootstrap.Modal(document.getElementById('editModal')).show();
            return;
        }

        if (type === 'supplier') {
            const isActive = entity.status === 1 || entity.status === 'active' || entity.status === 'Aktif';

            // Build each field individually so we can use textarea for address and select for status
            fieldsContainer.innerHTML = `
                <div class="mb-3">
                    <label class="form-label">Nama Syarikat</label>
                    <input type="text" class="form-control" name="company_name" value="${entity.company_name || ''}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">PIC</label>
                    <input type="text" class="form-control" name="contact_person" value="${entity.contact_person || ''}">
                    <div class="form-text text-muted small">Orang untuk dihubungi</div>
                </div>
                <div class="mb-3">
                    <label class="form-label">E-mel</label>
                    <input type="email" class="form-control" name="email" value="${entity.email || ''}">
                </div>
                <div class="mb-3">
                    <label class="form-label">No. Telefon</label>
                    <input type="text" class="form-control" name="phone_number" value="${entity.phone_number || ''}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea class="form-control" name="address" rows="3">${entity.address || ''}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Poskod</label>
                    <input type="text" class="form-control" name="postcode" value="${entity.postcode || ''}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select class="form-select" name="status" required>
                        <option value="active" ${isActive ? 'selected' : ''}>Aktif</option>
                        <option value="inactive" ${!isActive ? 'selected' : ''}>Tidak Aktif</option>
                    </select>
                </div>
            `;


            const states = Array.isArray(window.prisonData.states) ? window.prisonData.states : [];
            const districts = Array.isArray(window.prisonData.districts) ? window.prisonData.districts : [];

            const stateField = document.createElement('div');
            stateField.className = 'mb-3';
            stateField.innerHTML = `
                <label class="form-label">Negeri</label>
                <select class="form-select" name="state_id" id="editSupplierStateSelect">
                    <option value="">Pilih Negeri</option>
                    ${states.map(state => `
                        <option value="${state.id}" ${state.id === entity.state_id ? 'selected' : ''}>${state.name}</option>
                    `).join('')}
                </select>
            `;
            fieldsContainer.appendChild(stateField);

            const districtField = document.createElement('div');
            districtField.className = 'mb-3';
            districtField.innerHTML = `
                <label class="form-label">Daerah</label>
                <select class="form-select" name="district_id" id="editSupplierDistrictSelect">
                    <option value="">Pilih Daerah</option>
                </select>
            `;
            fieldsContainer.appendChild(districtField);

            const stateSelect = document.getElementById('editSupplierStateSelect');
            const districtSelect = document.getElementById('editSupplierDistrictSelect');

            const populateDistricts = () => {
                const selectedStateId = parseInt(stateSelect.value);
                districtSelect.innerHTML = '<option value="">Pilih Daerah</option>';
                if (selectedStateId) {
                    districts.filter(d => d.state_id === selectedStateId).forEach(d => {
                        const selected = d.id === entity.district_id ? 'selected' : '';
                        districtSelect.innerHTML += `<option value="${d.id}" ${selected}>${d.name}</option>`;
                    });
                }
            };

            populateDistricts();
            stateSelect.addEventListener('change', populateDistricts);
            new bootstrap.Modal(document.getElementById('editModal')).show();
            return;
        }

        if (type === 'user') {
            const institutions = Array.isArray(window.prisonData.institutions) ? window.prisonData.institutions : [];
            const positions = Array.isArray(window.prisonData.positions) ? window.prisonData.positions : [];

            fieldsContainer.innerHTML = `
                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" class="form-control" name="name" id="editAdminName" value="${entity.name || ''}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Emel</label>
                    <input type="email" class="form-control" name="email" id="editAdminEmail" value="${entity.email || ''}" required readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">No. Telefon</label>
                    <input type="text" class="form-control" name="phone_number" value="${entity.phone_number || ''}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Peranan</label>
                    <select class="form-select" name="role_id" required>
                        <option value="">Pilih Peranan</option>
                        <option value="1" ${entity.role_id == 1 || entity.role === 'Admin' ? 'selected' : ''}>Admin</option>
                        <option value="2" ${entity.role_id == 2 || entity.role === 'User' ? 'selected' : ''}>User</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Institusi</label>
                    <select class="form-select" name="institution_id" required>
                        <option value="">Pilih Institusi</option>
                        ${institutions.map(inst => `
                            <option value="${inst.id}" ${inst.id == entity.institution_id || inst.name === entity.institution ? 'selected' : ''}>${inst.name}</option>
                        `).join('')}
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Jawatan</label>
                    <select class="form-select" name="position_id" required>
                        <option value="">Pilih Jawatan</option>
                        ${positions.map(pos => `
                            <option value="${pos.id}" ${pos.id == entity.position_id || pos.name === entity.position ? 'selected' : ''}>${pos.name}</option>
                        `).join('')}
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select class="form-select" name="status" required>
                        <option value="active" ${entity.status === 'active' || entity.status === 'Aktif' ? 'selected' : ''}>Aktif</option>
                        <option value="inactive" ${entity.status === 'inactive' || entity.status === 'Tidak Aktif' ? 'selected' : ''}>Tidak Aktif</option>
                    </select>
                </div>
            `;

            new bootstrap.Modal(document.getElementById('editModal')).show();
            return;
        }

        if (type === 'position') {
            fieldsContainer.innerHTML = `
                <div class="mb-3">
                    <label class="form-label">Kod Jawatan</label>
                    <input type="text" class="form-control" name="code" value="${entity.code || ''}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nama Jawatan</label>
                    <input type="text" class="form-control" name="name" value="${entity.name || ''}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Gred</label>
                    <input type="text" class="form-control" name="grade" value="${entity.grade || ''}" required>
                </div>
            `;
            new bootstrap.Modal(document.getElementById('editModal')).show();
            return;
        }

        if (type === 'category') {
            fieldsContainer.innerHTML = `
                <div class="mb-3">
                    <label class="form-label">Kod Kategori</label>
                    <input type="text" class="form-control" name="code" value="${entity.code || ''}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nama Kategori</label>
                    <input type="text" class="form-control" name="name" value="${entity.name || ''}" required>
                </div>
            `;
            new bootstrap.Modal(document.getElementById('editModal')).show();
            return;
        }

        if (type === 'item') {
            const categories = Array.isArray(window.prisonData.categories) ? window.prisonData.categories : [];
            const uoms = Array.isArray(window.prisonData.uoms) ? window.prisonData.uoms : [];

            fieldsContainer.innerHTML = `
                <div class="mb-3">
                    <label class="form-label">Nama Item</label>
                    <input type="text" class="form-control" name="name" value="${entity.name || ''}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Kategori</label>
                    <select class="form-select" name="category_id" required>
                        <option value="">Pilih Kategori</option>
                        ${categories.map(cat => `
                            <option value="${cat.id}" ${cat.id == entity.category_id || cat.name === entity.category ? 'selected' : ''}>${cat.code} - ${cat.name}</option>
                        `).join('')}
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Unit Ukuran (UOM)</label>
                    <select class="form-select" name="uom_id" required>
                        <option value="">Pilih UOM</option>
                        ${uoms.map(uom => `
                            <option value="${uom.id}" ${uom.id == entity.uom_id || uom.code === entity.uom ? 'selected' : ''}>${uom.code}</option>
                        `).join('')}
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select class="form-select" name="status" required>
                        <option value="1" ${entity.status == 1 || entity.status === 'Aktif' || entity.status === 'active' ? 'selected' : ''}>Aktif</option>
                        <option value="0" ${entity.status == 0 || entity.status === 'Tidak Aktif' || entity.status === 'inactive' ? 'selected' : ''}>Tidak Aktif</option>
                    </select>
                </div>
            `;

            new bootstrap.Modal(document.getElementById('editModal')).show();
            return;
        }

        if (type === 'material') {
            const categories = Array.isArray(window.prisonData.categories) ? window.prisonData.categories : [];
            const uoms = Array.isArray(window.prisonData.uoms) ? window.prisonData.uoms : [];

            const catOptions = categories.length > 0 
                ? categories.map(c => `<option value="${c.name}" ${c.name === entity.category ? 'selected' : ''}>${c.name}</option>`).join('')
                : ['SAYUR', 'IKAN', 'AYAM', 'DAGING', 'BUAH', 'PERENCAH', 'LAIN-LAIN'].map(c => `<option value="${c}" ${c === entity.category ? 'selected' : ''}>${c}</option>`).join('');

            const unitOptions = uoms.length > 0
                ? uoms.map(u => `<option value="${u.code}" ${u.code === entity.unit ? 'selected' : ''}>${u.code}</option>`).join('')
                : ['kg', 'g', 'biji', 'ikat', 'bungkus', 'botol', 'tin', 'peket', 'liter'].map(u => `<option value="${u}" ${u === entity.unit ? 'selected' : ''}>${u}</option>`).join('');

            fieldsContainer.innerHTML = `
                <div class="mb-3">
                    <label class="form-label">Nama Bahan</label>
                    <input type="text" class="form-control" name="name" value="${entity.name || ''}" required>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Kategori</label>
                        <select class="form-select" name="category" required>
                            <option value="">Pilih Kategori</option>
                            ${catOptions}
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Unit</label>
                        <select class="form-select" name="unit" required>
                            <option value="">Pilih Unit</option>
                            ${unitOptions}
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Jumlah Stok</label>
                        <input type="number" step="0.01" class="form-control" name="stock" value="${entity.stock !== undefined ? entity.stock : ''}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Stok Minimum</label>
                        <input type="number" step="0.01" class="form-control" name="minStock" value="${entity.minStock !== undefined ? entity.minStock : ''}" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Harga Seunit (RM)</label>
                    <input type="number" step="0.01" class="form-control" name="price" value="${entity.price !== undefined ? entity.price : ''}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Penerangan</label>
                    <textarea class="form-control" name="description" rows="2">${entity.description || ''}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select class="form-select" name="status" required>
                        <option value="aktif" ${entity.status === 'aktif' || entity.status === 'active' ? 'selected' : ''}>Aktif</option>
                        <option value="tidak aktif" ${entity.status === 'tidak aktif' || entity.status === 'inactive' ? 'selected' : ''}>Tidak Aktif</option>
                    </select>
                </div>
            `;

            new bootstrap.Modal(document.getElementById('editModal')).show();
            return;
        }

        // Malay label map for generic fallback
        const malayLabelMap = {
            'name':             'Nama',
            'email':            'E-mel',
            'phone':            'No. Telefon',
            'phone_number':     'No. Telefon',
            'address':          'Alamat',
            'postcode':         'Poskod',
            'status':           'Status',
            'code':             'Kod',
            'description':      'Penerangan',
            'grade':            'Gred',
            'type':             'Jenis',
            'capacity':         'Kapasiti',
            'current':          'Jumlah Semasa',
            'company_name':     'Nama Syarikat',
            'contact_person':   'PIC',
            'state':            'Negeri',
            'district':         'Daerah',
            'institution':      'Institusi',
            'position':         'Jawatan',
            'role':             'Peranan',
            'category':         'Kategori',
            'uom':              'Unit Ukuran',
            'price_per_unit':   'Harga Seunit',
            'current_quantity': 'Kuantiti Semasa',
            'created_at':       'Tarikh Dicipta',
            'updated_at':       'Tarikh Dikemaskini',
        };

        for (const [key, value] of Object.entries(entity)) {
            if (key === 'id' || key === 'avatar' || key === 'lastUpdated' || key === 'joinDate' || key === 'lastLogin') continue;
            if (type === 'user' && ['institution_id', 'role_id', 'position_id', 'image'].includes(key)) continue;

            const fieldDiv = document.createElement('div');
            fieldDiv.className = 'mb-3';
            const safeValue = String(value ?? '')
                .replace(/&/g, '&amp;')
                .replace(/"/g, '&quot;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;');
            const labelText = malayLabelMap[key] || (key.charAt(0).toUpperCase() + key.slice(1).replace(/_/g, ' '));
            fieldDiv.innerHTML = `
                <label class="form-label">${labelText}</label>
                <input type="text" class="form-control" name="${key}" value="${safeValue}">
            `;
            fieldsContainer.appendChild(fieldDiv);
        }

        new bootstrap.Modal(document.getElementById('editModal')).show();
    }

    async deleteEntity(type, id) {
        let endpoint = '';
        let csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

        switch (type) {
            case 'user': endpoint = `/admin/${id}`; break;
            case 'supplier': endpoint = `/suppliers/${id}`; break;
            case 'category': endpoint = `/categories/${id}`; break;
            case 'item': endpoint = `/items/${id}`; break;
            case 'uom': endpoint = `/uoms/${id}`; break;
            case 'position': endpoint = `/position/${id}`; break;
            default:
                // Handle unsupported types with the legacy mock delete
                const entities = this.getEntities(type);
                const index = entities.findIndex(e => e.id === id);
                if (index !== -1) {
                    entities.splice(index, 1);
                    this.showNotification(`Berjaya dipadam (Data Contoh)`, 'success');
                    this.refreshCurrentPage();
                    this.updateDashboardStats();
                }
                return;
        }

        try {
            const response = await fetch(endpoint, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            });

            const result = await response.json();

            if (response.ok && result.success) {
                this.showNotification(result.message || 'Berjaya mendapat maklum balas padam', 'success');
                this.refreshCurrentPage();
                this.updateDashboardStats();
            } else {
                this.showNotification(result.message || 'Ralat memadam entiti. Mungkin masih digunakan', 'danger');
            }
        } catch (error) {
            console.error('Error in deletion request:', error);
            this.showNotification('Ralat sambungan: Gagal memadam rekod.', 'danger');
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
                // Determine if value should be parsed as number
                // Ignore empty strings, or strings that look like phone numbers/postcodes (start with 0 unless it's just '0')
                if (value !== '' && !isNaN(value) && (!value.toString().startsWith('0') || value.toString() === '0')) {
                    entity[key] = value.includes('.') ? parseFloat(value) : parseInt(value);
                } else {
                    entity[key] = value;
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
                const saveBtn = document.getElementById('btnSaveProfile');

                // Show loading state
                if (saveBtn) {
                    saveBtn.disabled = true;
                    saveBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status"></span>Menyimpan...';
                }

                try {
                    const response = await fetch(formUpdate.getAttribute('action') || 'api_update_profile.php', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    });

                    const result = await response.json();

                    if (response.ok) {
                        const newName  = formData.get('name')  || '';
                        const newEmail = formData.get('email') || '';
                        const newPhone = formData.get('phone_number') || '';

                        // Update displayed name everywhere on the page
                        const nameDisplay = document.getElementById('profileNameDisplay');
                        if (nameDisplay) nameDisplay.textContent = newName;
                        document.querySelectorAll('.user-name').forEach(el => el.textContent = newName);
                        document.querySelectorAll('.user-info h6').forEach(el => el.textContent = newName);

                        // Update the "Maklumat Peribadi" card's static spans
                        const emailSpan = document.querySelector('#profil-content .list-group-item:nth-child(1) .fw-medium');
                        if (emailSpan) emailSpan.textContent = newEmail;

                        this.showNotification(result.success || 'Profil berjaya dikemaskini!', 'success');

                        // Return to view mode
                        cardUpdate.style.display = 'none';
                        if (btnEdit) btnEdit.closest('.card-body').style.display = 'block';

                    } else {
                        const errors = result.errors
                            ? Object.values(result.errors).flat().join('\n')
                            : (result.error || 'Ralat semasa mengemaskini profil');
                        this.showNotification(errors, 'danger');
                    }
                } catch (error) {
                    console.error('Profile update error:', error);
                    this.showNotification('Ralat sambungan pelayan. Pastikan pelayan PHP berjalan.', 'danger');
                } finally {
                    // Restore button
                    if (saveBtn) {
                        saveBtn.disabled = false;
                        saveBtn.innerHTML = '<i class="fas fa-save me-2"></i>Simpan Perubahan';
                    }
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

    initEvaluationEvents() {
        const modalEl = document.getElementById('addEvaluationModal');
        if (!modalEl) return;

        // Sliders interaction
        const sliders = modalEl.querySelectorAll('.slider-score');
        sliders.forEach(slider => {
            slider.addEventListener('input', () => {
                const display = slider.nextElementSibling;
                display.textContent = slider.value;
                
                // Color scaling for the small score display
                if (slider.value >= 6) display.className = 'fw-bold score-display text-success fs-5';
                else if (slider.value >= 4) display.className = 'fw-bold score-display text-warning fs-5';
                else display.className = 'fw-bold score-display text-danger fs-5';
                
                this.calculateEvaluationScore();
            });
        });

        // Order Selection logic
        const orderSelect = document.getElementById('evalOrderId');
        if (orderSelect) {
            orderSelect.addEventListener('change', () => {
                const orderId = orderSelect.value;
                const orders = window.prisonData.inden || [];
                const order = orders.find(o => o.id == orderId);
                const infoBox = document.getElementById('evalSupplierInfo');
                
                if (order) {
                    document.getElementById('evalSupplierName').textContent = order.supplier?.company_name || 'N/A';
                    document.getElementById('evalSupplierId').value = order.supplier_id;
                    document.getElementById('evalInstitutionName').textContent = order.institution?.name || 'N/A';
                    document.getElementById('evalInstitutionId').value = order.institution_id;
                    infoBox.classList.remove('d-none');
                } else {
                    infoBox.classList.add('d-none');
                }
            });
        }

        // Save Button logic
        const saveBtn = document.getElementById('saveEvaluationBtn');
        if (saveBtn) {
            saveBtn.addEventListener('click', async () => {
                const form = document.getElementById('evaluationForm');
                if (!form.checkValidity()) {
                    form.reportValidity();
                    return;
                }

                const formData = new FormData(form);
                const originalContent = saveBtn.innerHTML;
                saveBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...';
                saveBtn.disabled = true;

                try {
                    const response = await fetch('/evaluations', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                            'Accept': 'application/json'
                        },
                        body: formData
                    });

                    const result = await response.json();
                    if (result.success) {
                        this.showNotification(result.message, 'success');
                        bootstrap.Modal.getInstance(modalEl).hide();
                        form.reset();
                        this.loadPerformanceReportsPage();
                    } else {
                        const errorMsg = result.errors ? Object.values(result.errors).flat().join('\n') : (result.message || 'Ralat menyimpan.');
                        this.showNotification(errorMsg, 'danger');
                    }
                } catch (error) {
                    console.error('Error saving eval:', error);
                    this.showNotification('Ralat sistem ketika menyimpan penilaian.', 'danger');
                } finally {
                    saveBtn.innerHTML = originalContent;
                    saveBtn.disabled = false;
                }
            });
        }

        // Add Button Trigger
        const addBtn = document.getElementById('addNewEvaluationBtn');
        if (addBtn) {
            addBtn.addEventListener('click', () => {
                this.populateOrdersForEvaluation();
                new bootstrap.Modal(modalEl).show();
            });
        }
    }

    calculateEvaluationScore() {
        const sliders = document.querySelectorAll('.slider-score');
        let total = 0;
        sliders.forEach(s => total += parseInt(s.value));
        
        const percentage = ((total / 35) * 100).toFixed(1);
        document.getElementById('evalTotalScore').textContent = `${total} / 35`;
        document.getElementById('evalPercentage').textContent = `${percentage}%`;
        
        const badge = document.getElementById('evalRatingBadge');
        if (percentage >= 81) {
            badge.textContent = 'CEMERLANG';
            badge.style.backgroundColor = '#198754';
            badge.style.color = '#fff';
        } else if (percentage >= 51) {
            badge.textContent = 'SEDERHANA';
            badge.style.backgroundColor = '#ffc107';
            badge.style.color = '#000';
        } else {
            badge.textContent = 'LEMAH';
            badge.style.backgroundColor = '#dc3545';
            badge.style.color = '#fff';
        }
    }

    async populateOrdersForEvaluation() {
        const select = document.getElementById('evalOrderId');
        if (!select) return;
        
        select.innerHTML = '<option value="">Memuatkan pesanan...</option>';
        
        try {
            // Fetch real orders from the database
            const response = await fetch('/inden/all-data'); // Assuming an endpoint exists or we use existing ones
            // Wait, let's check if there's a better endpoint.
            // Actually, we can use the existing window.prisonData.inden if we update it.
            // But let's just use a direct fetch to be sure we have real IDs.
            
            const res = await fetch('/evaluations/orders'); // I will create this endpoint
            const result = await res.json();
            
            if (result.success) {
                select.innerHTML = '<option value="">Pilih Pesanan</option>';
                result.data.forEach(order => {
                    const supplierName = order.supplier?.company_name || 'N/A';
                    const option = document.createElement('option');
                    option.value = order.id;
                    option.textContent = `${order.order_no || 'INDEN'} - ${supplierName}`;
                    
                    // Attach data for easy retrieval on change
                    option.dataset.supplierId = order.supplier_id;
                    option.dataset.supplierName = supplierName;
                    option.dataset.instId = order.institution_id;
                    option.dataset.instName = order.institution?.name || 'N/A';
                    
                    select.appendChild(option);
                });

                // Update info box on change by reading dataset
                select.onchange = () => {
                    const selected = select.options[select.selectedIndex];
                    const infoBox = document.getElementById('evalSupplierInfo');
                    if (selected.value) {
                        document.getElementById('evalSupplierName').textContent = selected.dataset.supplierName;
                        document.getElementById('evalSupplierId').value = selected.dataset.supplierId;
                        document.getElementById('evalInstitutionName').textContent = selected.dataset.instName;
                        document.getElementById('evalInstitutionId').value = selected.dataset.instId;
                        infoBox.classList.remove('d-none');
                    } else {
                        infoBox.classList.add('d-none');
                    }
                };
            } else {
                select.innerHTML = '<option value="">Gagal memuatkan pesanan</option>';
            }
        } catch (error) {
            console.error('Error fetching orders for eval:', error);
            select.innerHTML = '<option value="">Ralat memuatkan pesanan</option>';
        }
    }

    async viewEvaluation(id) {
        try {
            const response = await fetch(`/evaluations/${id}`);
            const result = await response.json();
            
            if (result.success) {
                const ev = result.data;
                const content = `
                    <div class="card border-0 shadow-sm mb-3">
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-6">
                                    <div class="text-muted small">Pembekal</div>
                                    <div class="fw-bold">${ev.supplier?.company_name || 'N/A'}</div>
                                </div>
                                <div class="col-6">
                                    <div class="text-muted small">Tarikh Penilaian</div>
                                    <div class="fw-bold">${new Date(ev.evaluation_date).toLocaleDateString('ms-MY')}</div>
                                </div>
                            </div>
                            <hr class="my-2 opacity-10">
                            <ul class="list-unstyled mb-0">
                                <li class="d-flex justify-content-between mb-1">
                                    <span>Kuantiti Bekalan:</span>
                                    <span class="fw-bold text-success">${ev.criteria_quantity} / 7</span>
                                </li>
                                <li class="d-flex justify-content-between mb-1">
                                    <span>Masa Penghantaran:</span>
                                    <span class="fw-bold text-success">${ev.criteria_delivery} / 7</span>
                                </li>
                                <li class="d-flex justify-content-between mb-1">
                                    <span>Harga Bekalan:</span>
                                    <span class="fw-bold text-success">${ev.criteria_price} / 7</span>
                                </li>
                                <li class="d-flex justify-content-between mb-1">
                                    <span>Kualiti Bekalan:</span>
                                    <span class="fw-bold text-success">${ev.criteria_quality} / 7</span>
                                </li>
                                <li class="d-flex justify-content-between mb-1">
                                    <span>Kerjasama:</span>
                                    <span class="fw-bold text-success">${ev.criteria_cooperation} / 7</span>
                                </li>
                            </ul>
                            <div class="mt-3 p-2 rounded bg-light text-center">
                                <div class="fw-bold text-primary fs-5">${ev.percentage}% - ${ev.performance_rating}</div>
                            </div>
                            ${ev.remarks ? `<div class="mt-3 small text-muted"><strong>Ulasan:</strong> ${ev.remarks}</div>` : ''}
                        </div>
                    </div>
                `;
                
                const viewBody = document.getElementById('viewModalBody');
                const viewTitle = document.getElementById('viewModalTitle');
                if (viewBody && viewTitle) {
                    viewTitle.textContent = 'Butiran Penilaian Prestasi';
                    viewBody.innerHTML = content;
                    new bootstrap.Modal(document.getElementById('viewModal')).show();
                }
            }
        } catch (error) {
            console.error('Error viewing eval:', error);
            this.showNotification('Ralat memuatkan butiran.', 'danger');
        }
    }
}

// Initialize the system
const prisonSystem = new PrisonSystem();

// Make available globally for debugging
window.prisonSystem = prisonSystem;
