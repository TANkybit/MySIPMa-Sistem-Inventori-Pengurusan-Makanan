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

    function csvCell(value) {
        return `"${cleanText(value).replace(/"/g, '""')}"`;
    }

    function slug(value) {
        return cleanText(value)
            .toLowerCase()
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/^-+|-+$/g, '') || 'jadual';
    }

    function tableTitle(table) {
        const scope = table.closest('.card, .card-box, .section-card, main, .page-content') || document;
        const title = scope.querySelector('h1, h2, h3, h4, h5, .card-title');
        return title ? cleanText(title.textContent) : table.id || 'Jadual';
    }

    function headerInfo(table) {
        const headerCells = Array.from(table.querySelectorAll('thead th'));

        return headerCells
            .map((cell, index) => ({
                index,
                text: cleanText(cell.textContent),
            }))
            .filter(col => col.text && !SKIP_HEADERS.includes(col.text.toLowerCase()));
    }

    function rowsFromDataTable(table, columns) {
        if (typeof window.jQuery === 'undefined' || !window.jQuery.fn || !window.jQuery.fn.DataTable) {
            return null;
        }

        const $ = window.jQuery;
        if (!$.fn.DataTable.isDataTable(table)) {
            return null;
        }

        const api = $(table).DataTable();
        const rows = [];

        api.rows({ search: 'applied' }).indexes().each(function (rowIndex) {
            const row = columns.map(col => api.cell(rowIndex, col.index).data());
            if (row.some(value => cleanText(value))) {
                rows.push(row);
            }
        });

        return rows;
    }

    function rowsFromDom(table, columns) {
        return Array.from(table.querySelectorAll('tbody tr'))
            .filter(row => !row.classList.contains('child'))
            .map(row => {
                const cells = Array.from(row.children);
                if (cells.some(cell => Number(cell.getAttribute('colspan') || 1) > 1)) {
                    return null;
                }

                return columns.map(col => cells[col.index] ? cells[col.index].innerHTML : '');
            })
            .filter(row => row && row.some(value => cleanText(value)));
    }

    function exportTable(table) {
        const columns = headerInfo(table);
        if (!columns.length) return;

        const rows = rowsFromDataTable(table, columns) || rowsFromDom(table, columns);
        const csv = [
            columns.map(col => csvCell(col.text)).join(','),
            ...rows.map(row => row.map(csvCell).join(',')),
        ].join('\r\n');

        const blob = new Blob(['\ufeff' + csv], { type: 'text/csv;charset=utf-8;' });
        const url = URL.createObjectURL(blob);
        const link = document.createElement('a');
        const date = new Date().toISOString().slice(0, 10);

        link.href = url;
        link.download = `${slug(tableTitle(table))}-${date}.csv`;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        URL.revokeObjectURL(url);
    }

    function ensureTableId(table, index) {
        if (!table.id) {
            table.id = `download-table-${index + 1}`;
        }
    }

    function iconClass() {
        const hasFontAwesome = Boolean(document.querySelector('link[href*="font-awesome"], link[href*="fontawesome"]'));
        return hasFontAwesome ? 'fas fa-download' : 'bi bi-download';
    }

    function addButton(table, index) {
        if (table.dataset.downloadAttached === 'true' || table.dataset.downloadable === 'false') {
            return;
        }

        if (!table.querySelector('thead th') || !table.querySelector('tbody')) {
            return;
        }

        if (table.classList.contains('table-borderless')) {
            return;
        }

        ensureTableId(table, index);

        const toolbar = document.createElement('div');
        toolbar.className = 'mysipma-table-download-toolbar d-flex justify-content-end mb-2';
        toolbar.dataset.downloadFor = table.id;

        const button = document.createElement('button');
        const darkTable = table.classList.contains('table-dark-custom') || Boolean(table.closest('.card-table'));
        button.type = 'button';
        button.className = `btn btn-sm ${darkTable ? 'btn-outline-light' : 'btn-outline-secondary'}`;
        button.innerHTML = `<i class="${iconClass()} me-1"></i>Muat Turun`;
        button.addEventListener('click', function () {
            exportTable(table);
        });

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

    window.MySIPMaTableDownload = {
        enhanceTables,
        exportTable,
    };
})();
