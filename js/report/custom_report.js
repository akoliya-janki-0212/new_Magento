class MyGrid {
    constructor(gridElement, gridOptions) {
        this.injectStyles();
        this.data = gridOptions.rowData;
        this.originalData = [...this.data];
        this.columnDefs = gridOptions.columnDefs;
        this.container = gridElement;
        this.rowHeight = 30;
        this.totalRows = this.data.length;
        this.containerHeight = 400;
        this.heightRows = this.containerHeight / this.rowHeight;
        this.totalHeight = this.totalRows * this.rowHeight;
        this.table = document.createElement("table");
        this.thead = document.createElement("thead");
        this.tbody = document.createElement("tbody");
        this.setupTable();
        this.currentSort = { column: null, direction: "" };
        this.filters = {};
        this.createHeaders();
        this.initVirtualScroll();
        this.addCheckboxListeners();
        this.setVisibility();
    }

    setupTable() {
        this.table.style.cssText = "width: 100%; border-collapse: collapse;";
        this.table.appendChild(this.thead);
        this.table.appendChild(this.tbody);
        this.container.appendChild(this.table);
        this.container.style.height = `${this.containerHeight}px`;
        this.container.style.overflowY = "scroll";
        this.container.style.position = "relative";
        this.table.style.height = `${this.totalRows * this.rowHeight}px`;
    }

    createHeaders() {
        const filterRow = document.createElement("tr");
        const headerRow = document.createElement("tr");
        this.columnDefs.forEach((colDef, index) => {
            const th = document.createElement("th");
            th.innerHTML = `${colDef.headerName} <span class='sort-icon'>&#x25B2;</span>`; // Down arrow as default
            th.style.minWidth = `${colDef.minWidth || 100}px`; // Default min-width
            th.setAttribute("draggable", true);
            th.addEventListener("dragstart", this.handleDragStart.bind(this, index));
            th.addEventListener("dragover", this.handleDragOver.bind(this, index));
            th.addEventListener("drop", this.handleDrop.bind(this, index));
            th.addEventListener("click", () => this.handleSort(colDef.field));
            //filter
            const input = document.createElement("input");
            input.type = "text";
            input.placeholder = "Filter...";
            input.oninput = (event) =>
                this.handleFilter(colDef.field, event.target.value);
            input.style.width = "100%";
            filterRow.appendChild(document.createElement("th")).appendChild(input);
            headerRow.appendChild(th);
        });
        this.thead.appendChild(headerRow);
        this.thead.appendChild(filterRow);
    }

    initVirtualScroll() {
        this.visibleRows = Math.ceil(this.heightRows);
        this.attachEvents();
        this.renderGrid(0);
    }

    attachEvents() {
        let lastKnownScrollPosition = 0;
        let ticking = false;
        this.container.addEventListener("scroll", () => {
            lastKnownScrollPosition = this.container.scrollTop;
            if (!ticking) {
                window.requestAnimationFrame(() => {
                    const startIndex = Math.floor(
                        lastKnownScrollPosition / this.rowHeight
                    );
                    if (startIndex + this.visibleRows <= this.totalRows) {
                        this.renderGrid(startIndex);
                    }
                    ticking = false;
                });
                ticking = true;
            }
        });
    }

    renderGrid(startIndex) {
        const endIndex = Math.min(startIndex + this.visibleRows, this.data.length);
        this.tbody.innerHTML = "";
        for (let i = startIndex; i < endIndex; i++) {
            const rowElement = this.createRowElement(this.data[i], i);
            this.tbody.appendChild(rowElement);
        }
    }

    createRowElement(rowData, index) {
        const tr = document.createElement("tr");
        tr.id = `row-${index}`;
        tr.style.height = `${this.rowHeight}px`;
        this.columnDefs.forEach((colDef) => {
            if (colDef.visible !== false) {
                const td = document.createElement("td");
                td.textContent = rowData[colDef.field];
                tr.appendChild(td);
            }
        });
        return tr;
    }

    handleDragStart(originalIndex, event) {
        event.dataTransfer.setData("text/plain", originalIndex);
    }

    handleDragOver(targetIndex, event) {
        event.preventDefault();
    }

    handleDrop(targetIndex, event) {
        event.preventDefault();
        const originalIndex = parseInt(
            event.dataTransfer.getData("text/plain"),
            10
        );
        if (originalIndex === targetIndex) return;
        const movedColumn = this.columnDefs.splice(originalIndex, 1)[0];
        this.columnDefs.splice(targetIndex, 0, movedColumn);
        this.thead.innerHTML = "";
        this.createHeaders();
        this.renderGrid(0);
        this.addCheckboxListeners();
        this.setVisibility();
    }

    handleSort(field) {
        const direction =
            this.currentSort.column === field && this.currentSort.direction === "asc"
                ? "desc"
                : "asc";
        this.originalData.sort((a, b) => {
            if (a[field] < b[field]) return direction === "asc" ? -1 : 1;
            if (a[field] > b[field]) return direction === "asc" ? 1 : -1;
            return 0;
        });
        this.currentSort = { column: field, direction };
        this.applyFilters();
        this.updateSortIndicator();
    }

    updateSortIndicator() {
        Array.from(this.thead.querySelectorAll(".sort-icon")).forEach((icon) => {
            icon.innerHTML = "&#x25B2;";
        });
        const index = this.columnDefs.findIndex(
            (colDef) => colDef.field === this.currentSort.column
        );
        if (index !== -1) {
            const header = this.thead.children[0].children[index];
            if (header) {
                const icon = header.querySelector(".sort-icon");
                if (icon) {
                    icon.innerHTML =
                        this.currentSort.direction === "asc" ? "&#x25BC;" : "&#x25B2;";
                }
            }
        }
    }

    handleFilter(field, value) {
        this.filters[field] = value.toLowerCase();
        this.applyFilters();
    }

    applyFilters() {
        this.data = this.originalData.filter((item) => {
            return Object.keys(this.filters).every((field) => {
                if (item[field] == null) return this.filters[field] === "";
                return (
                    this.filters[field] === "" ||
                    item[field].toString().toLowerCase().includes(this.filters[field])
                );
            });
        });
        this.table.style.height = `${this.data.length * this.rowHeight}px`;
        this.renderGrid(0);
    }

    addCheckboxListeners() {
        const applyColumnBtn = document.getElementById("applyFilterBtn"); 
        applyColumnBtn.addEventListener("click", () => {
            this.setVisibility();
        });
    }
    setVisibility() {
        const checkboxes = document.querySelectorAll(
            'input[type="checkbox"][data-column]'
        );
        checkboxes.forEach((checkbox) => {
            const column = checkbox.getAttribute("data-column");
            const isChecked = checkbox.checked;
            this.setColumnVisibility(column, isChecked);
        });
    }
    setColumnVisibility(columnName, isVisible) {
        const columnIndex = this.columnDefs.findIndex(
            (colDef) => colDef.field === columnName
        );
        if (columnIndex === -1) return;
        this.columnDefs[columnIndex].visible = isVisible;
        const selector = `th:nth-child(${columnIndex + 1}), td:nth-child(${columnIndex + 1
            })`;
        const cells = this.table.querySelectorAll(selector);
        cells.forEach((cell) => {
            cell.style.display = isVisible ? "" : "none";
        });
        this.renderGrid(0);
    }

    injectStyles() {
        const style = document.createElement("style");
        style.type = "text/css";
        style.innerHTML = `
            table {
      width: 100%;
      border-collapse: collapse;
      border-spacing: 0;
      font-family: Arial, sans-serif;
  }
  
  th, td {
      border: 1px solid #ddd;
      padding: 10px;
      text-align: left;
  }
  
  th {
      background-color: #f2f2f2;
      cursor: grab;
      position: sticky;
      top: 0;
      z-index: 2;
  }
  
  th:active {
      cursor: grabbing;
  }
  
  th:hover {
      background-color: #e0e0e0;
  }
  
  th .sort-icon {
      visibility: visible;
  }
  
  .sort-icon {
      margin-left: 5px;
      visibility: hidden;
  }
  
  td:hover {
      background-color: #f9f9f9;
  }
  
  input[type="text"] {
      box-sizing: border-box;
      padding: 8px;
      margin: 2px 0;
      border: 1px solid #ccc;
      width: 100%;
      transition: border-color 0.3s;
  }
  
  input[type="text"]:focus {
      outline: none;
      border-color: #4CAF50;
  }
  thead{
      position: sticky;
      top: 0;
      background-color: #f2f2f2;
      z-index: 1;
    }
        `;
        document.head.appendChild(style);
    }

    setRowData(newData) {
        this.data = newData;
        this.originalData = [...this.data];
        this.renderGrid(0);
    }

    getRowData() {
        return this.data;
    }
}
