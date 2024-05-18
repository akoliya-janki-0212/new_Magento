<?php
class Ccc_Banner_Block_Adminhtml_Banner_Grid_Renderer_Editablecolumn extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $value = $row->getData($this->getColumn()->getIndex());
        $html = '<div class="editable" data-id="' . $row->getId() . '">' . $value . '</div>';
        $url = $this->getUrl('*/*/editable');
        // Add JavaScript to trigger on click
        $html .= '<script type="text/javascript">
            document.addEventListener("DOMContentLoaded", function() {
                var deliveryNoteColumns = document.querySelectorAll(".editable");
                

                deliveryNoteColumns.forEach(function(element) {
                    element.addEventListener("click", function() {
                        var currentValue ="";
                        var orderId = this.getAttribute("data-id");
                        var textarea = document.createElement("textarea");
                        textarea.value = currentValue;
                        this.innerText = "";
                        this.appendChild(textarea);
                        textarea.focus();

                        var saveButton = document.createElement("button");
                        saveButton.innerText = "✔";
                        saveButton.addEventListener("click", function() {
                            var newValue = textarea.value;
                            // Assuming you have a function named saveDeliveryNoteData to send data to another URL
                            handleDeliveryNoteClick(orderId, newValue, "' . $url . '");
                        });
                        this.appendChild(saveButton);

                        var closeButton = document.createElement("button");
                        closeButton.innerText = "✖";
                        closeButton.addEventListener("click", function() {
                            // Refresh the page
                            location.reload();
                        });
                        this.appendChild(closeButton);
                    });
                });
            });

            function handleDeliveryNoteClick(orderId, newValue, url) {
                var redirectUrl = url + "?banner_id=" + encodeURIComponent(orderId) + "&newValue=" + encodeURIComponent(newValue);
                window.location.href = redirectUrl;
            }
        </script>';
        return $html;
    }
}