document.observe('dom:loaded', function () {
    new PartManager();
});

var PartManager = Class.create({
    initialize: function() {
        this.attachEventListeners();
    },
    attachEventListeners: function() {
        var loadDetailsButton = $('loadDetails');
        if (loadDetailsButton) {
            loadDetailsButton.observe('click', this.loadDetails.bind(this));
        }

        var saveDataButton = $('saveData');
        if (saveDataButton) {
            saveDataButton.observe('click', this.saveData.bind(this));
        }
    },

    loadDetails: function() {
        var productId = $('productSelect').value;
        var url = "http://127.0.0.1/Magento/index.php/admin/partmanager/getDetails/key/" + FORM_KEY;

        new Ajax.Request(url, {
            method: 'post',
            parameters: {
                productId: productId,
            },
            onSuccess: function(response) {
                var data = response.responseText.evalJSON(true);
                this.fillData(data);
            }.bind(this),
            onFailure: function() {
                alert('Failed to load data. Please try again.');
            }
        });
    },

    fillData: function(data) {
        $('productName').update(data.productDetails.name);
        $('productSKU').update(data.productDetails.sku);

        var partNumbers = data.productDetails.part_number.split(';');
        var partNumbersHTML = '';
        partNumbers.each(function(partNumber) {
            partNumbersHTML += '<li>' + partNumber + '</li>';
        });
        $('partNumbersList').update(partNumbersHTML);

        var manufacturerPartsHTML = '';
        Object.keys(data.manufacturerDetails).forEach(function(manufacturer) {
            var parts = data.manufacturerDetails[manufacturer].split(';');
            parts.each(function(part, index) {
                manufacturerPartsHTML += '<tr>' +
                    '<td>' + manufacturer + '</td>' +
                    '<td>' + part + '</td>' +
                    '<td><input type="text" name="' + manufacturer + '_' + part + '_qty" class="quantity-input" data-manufacturer="' + manufacturer + '"/></td>';
                if (index === 0) {
                    manufacturerPartsHTML += '<td rowspan="' + parts.length + '" class="min-quantity" id="min-' + manufacturer + '"></td>';
                }
                manufacturerPartsHTML += '</tr>';
            });
        });
        $('manufacturerPartsBody').update(manufacturerPartsHTML);

        // Add event listener for quantity input changes
        $$('.quantity-input').each(function(input) {
            input.observe('change', this.calculateMinQuantities.bind(this));
        }.bind(this));
    },

    calculateMinQuantities: function() {
        var manufacturerQuantities = {};

        $$('.quantity-input').each(function(input) {
            var manufacturer = input.getAttribute('data-manufacturer');
            var quantity = parseInt(input.value, 10);
            if (!manufacturerQuantities[manufacturer]) {
                manufacturerQuantities[manufacturer] = [];
            }
            if (!isNaN(quantity)) {
                manufacturerQuantities[manufacturer].push(quantity);
            }
        });

        Object.keys(manufacturerQuantities).forEach(function(manufacturer) {
            var minQuantity = Math.min.apply(0, manufacturerQuantities[manufacturer]);
            if (!(minQuantity == 'Infinity')) {
                $('min-' + manufacturer).update(minQuantity);
            }
        });
    },

    saveData: function() {
        var manufacturerPartQuantities = {};
        var productId = $('productSelect').value;

        $$('#manufacturerPartsBody tr').each(function(row) {
            var manufacturer = row.down('td:first-child').textContent.trim();
            var part = row.down('td:nth-child(2)').textContent.trim();
            var quantity = row.down('input').value.trim();
            var min_qty = $("min-" + manufacturer).innerText;
            if (!manufacturerPartQuantities[manufacturer]) {
                manufacturerPartQuantities[manufacturer] = [];
            }
            manufacturerPartQuantities[manufacturer].push({
                part: part,
                quantity: quantity,
                min_qty: min_qty,
            });
        });

        var data = {
            productId: productId,
            manufacturerPartQuantities: Object.toJSON(manufacturerPartQuantities),
        };

        this.saveManufacturerPartQuantities(data);
    },

    saveManufacturerPartQuantities: function(data) {
        var url = "http://127.0.0.1/Magento/index.php/admin/partmanager/saveMfrParts/key/" + FORM_KEY;

        new Ajax.Request(url, {
            method: 'post',
            parameters: data,
            onSuccess: function(response) {
               responseData=JSON.parse(response.responseText);
               console.log(responseData.message);
            },
            onFailure: function() {
                alert('Failed to save manufacturer part quantities. Please try again.');
            }
        });
    }
});
