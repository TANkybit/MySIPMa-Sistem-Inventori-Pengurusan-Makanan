(function () {
    'use strict';

    const SKIP_HEADERS = ['tindakan', 'aksi', 'action', 'actions'];

    function cleanText(value) {
        if (value === null || value === undefined) return '';
        const holder = document.createElement('div');
        holder.innerHTML = String(value);
        holder.querySelectorAll('script, style, button, .btn, .dropdown-menu').forEach(el => el.remove());
        return (holder.textContent || holder.innerText || String(value))
            .replace(/\s+/g, ' ')
            .trim();
    }

    function tableTitle(table) {
        const scope = table.closest('.card, .card-box, .section-card, main, .page-content') || document;
        const title = scope.querySelector('h1, h2, h3, h4, h5, .card-title');
        return title ? cleanText(title.textContent) : table.id || 'Jadual';
    }

    function headerInfo(table) {
        const headerCells = Array.from(table.querySelectorAll('thead th'));
        return headerCells
            .map((cell, index) => ({ index, text: cleanText(cell.textContent) }))
            .filter(col => col.text && !SKIP_HEADERS.includes(col.text.toLowerCase()));
    }

    function rowsFromDataTable(table, columns) {
        if (typeof window.jQuery === 'undefined' || !window.jQuery.fn || !window.jQuery.fn.DataTable) return null;
        const $ = window.jQuery;
        if (!$.fn.DataTable.isDataTable(table)) return null;
        const api = $(table).DataTable();
        const rows = [];
        api.rows({ search: 'applied' }).indexes().each(function (rowIndex) {
            const row = columns.map(col => api.cell(rowIndex, col.index).data());
            if (row.some(value => cleanText(value))) rows.push(row);
        });
        return rows;
    }

    function rowsFromDom(table, columns) {
        return Array.from(table.querySelectorAll('tbody tr'))
            .filter(row => !row.classList.contains('child'))
            .map(row => {
                const cells = Array.from(row.children);
                if (cells.some(cell => Number(cell.getAttribute('colspan') || 1) > 1)) return null;
                return columns.map(col => cells[col.index] ? cleanText(cells[col.index].innerHTML) : '');
            })
            .filter(row => row && row.some(value => value));
    }

    function exportPDF(table) {
        const columns = headerInfo(table);
        if (!columns.length) return;

        const rows = rowsFromDataTable(table, columns) || rowsFromDom(table, columns);
        const title = cleanText(tableTitle(table));

        const win = window.open('', '_blank');
        if (!win) return;

        const now = new Date();
        const dateStr = now.toLocaleDateString('ms-MY', { day: 'numeric', month: 'long', year: 'numeric' });

        let html = `<!DOCTYPE html><html><head><meta charset="utf-8"><title>${title}</title>`;
        html += `<style>
            @page { margin: 20mm 15mm; }
            body { font-family: Arial, sans-serif; font-size: 10pt; color: #111; }
            h2 { text-align: center; margin-bottom: 5px; font-size: 14pt; }
            .date { text-align: center; color: #666; font-size: 9pt; margin-bottom: 20px; }
            table { width: 100%; border-collapse: collapse; font-size: 9pt; }
            th { background: #f3f4f6; text-align: left; padding: 6px 8px; border: 1px solid #d1d5db; font-weight: 700; }
            td { padding: 5px 8px; border: 1px solid #d1d5db; }
            tr:nth-child(even) td { background: #f9fafb; }
            .footer { text-align: center; font-size: 8pt; color: #999; margin-top: 20px; }
        </style></head><body>`;
        html += `<h2>${title}</h2>`;
        html += `<div class="date">Dijana pada: ${dateStr}</div>`;
        html += '<table><thead><tr>';
        columns.forEach(col => { html += `<th>${col.text}</th>`; });
        html += '</tr></thead><tbody>';
        rows.forEach(row => {
            html += '<tr>';
            row.forEach(cell => { html += `<td>${cell}</td>`; });
            html += '</tr>';
        });
        html += '</tbody></table>';
        html += `<div class="footer">MySIPMa - Sistem Inventori Pengurusan Makanan</div>`;
        html += '</body></html>';

        win.document.write(html);
        win.document.close();

        win.setTimeout(function () {
            win.focus();
            win.print();
        }, 500);
    }

    function ensureTableId(table, index) {
        if (!table.id) table.id = `download-table-${index + 1}`;
    }

    function iconClass() {
        const hasFA = Boolean(document.querySelector('link[href*="font-awesome"], link[href*="fontawesome"]'));
        return hasFA ? 'fas fa-file-pdf' : 'bi bi-filetype-pdf';
    }

    function addButton(table, index) {
        if (table.dataset.downloadAttached === 'true' || table.dataset.downloadable === 'false') return;
        if (!table.querySelector('thead th') || !table.querySelector('tbody')) return;
        if (table.classList.contains('table-borderless')) return;

        ensureTableId(table, index);

        const toolbar = document.createElement('div');
        toolbar.className = 'mysipma-table-download-toolbar d-flex justify-content-end mb-2';
        toolbar.dataset.downloadFor = table.id;

        const button = document.createElement('button');
        const darkTable = table.classList.contains('table-dark-custom') || Boolean(table.closest('.card-table'));
        const isLight = document.documentElement.getAttribute('data-bs-theme') === 'light';
        button.type = 'button';
        const btnClass = darkTable ? (isLight ? 'btn-outline-dark' : 'btn-outline-light') : 'btn-outline-secondary';
        button.className = `btn btn-sm ${btnClass}`;
        if (isLight) button.style.cssText = 'color:#000!important;border-color:#000!important;';
        button.innerHTML = `<i class="${iconClass()} me-1"></i>Muat Turun PDF`;
        button.addEventListener('click', function () { exportPDF(table); });

        toolbar.appendChild(button);
        const responsiveWrapper = table.closest('.table-responsive');
        if (responsiveWrapper && responsiveWrapper.parentNode) {
            responsiveWrapper.parentNode.insertBefore(toolbar, responsiveWrapper);
        } else {
            table.parentNode.insertBefore(toolbar, table);
        }
        table.dataset.downloadAttached = 'true';
    }

    function enhanceTables() {
        document.querySelectorAll('table').forEach(addButton);
    }

    document.addEventListener('DOMContentLoaded', function () {
        enhanceTables();
        window.setTimeout(enhanceTables, 500);
        window.setTimeout(enhanceTables, 1500);
    });

    window.MySIPMaTableDownload = { enhanceTables, exportPDF };
})();
