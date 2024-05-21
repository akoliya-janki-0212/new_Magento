// var $j = jQuery.noConflict();
var SalesConfig = Class.create();

SalesConfig.prototype = {
  initialize: function(configURL) {
    this.configURL = configURL;
    this.formVisible = false;
  },

  toggleForm: function() {
    var formContainer = $$(".configuration_form")[0];
    if (!formContainer) {
      console.error("No form container found.");
      return;
    }

    if (this.formVisible) {
      formContainer.update(''); // Hide the form
      this.formVisible = false;
    } else {
      this.createForm(formContainer); // Show the form
      this.formVisible = true;
    }
  },

  createForm: function(formContainer) {
    var form = new Element("form", {
      id: "configuration_form",
      method: "POST",
      action: this.configURL,
    });

    var formKey = new Element("input", {
      type: "hidden",
      id: "form_key",
      name: "form_key",
      value: "<?php echo Mage::getSingleton('core/session')->getFormKey(); ?>"
    });
    form.insert(formKey);

    // Text input 1
    var label1 = new Element("label", { for: "text_input_1" }).update("Text Input 1: ");
    var textInput1 = new Element("input", {
      type: "text",
      id: "text_input_1",
      name: "text_input_1"
    });
    form.insert(label1);
    form.insert(textInput1);
    form.insert(new Element("br"));

    // Text input 2
    var label2 = new Element("label", { for: "text_input_2" }).update("Text Input 2: ");
    var textInput2 = new Element("input", {
      type: "text",
      id: "text_input_2",
      name: "text_input_2"
    });
    form.insert(label2);
    form.insert(textInput2);
    form.insert(new Element("br"));

    // Date input
    var label3 = new Element("label", { for: "date_input" }).update("Date Input: ");
    var dateInput = new Element("input", {
      type: "date",
      id: "date_input",
      name: "date_input"
    });
    form.insert(label3);
    form.insert(dateInput);
    form.insert(new Element("br"));

    // Submit button
    var submitButton = new Element("input", {
      type: "submit",
      value: "Submit",
      id: "submit",
      name: "submit"
    });
    form.insert(submitButton);

    formContainer.update(form);
  }
};

document.observe("dom:loaded", function() {
  var salesConfig = new SalesConfig("abc/sss/jjj");
  
  $("showFormButton").observe("click", function() {
    salesConfig.toggleForm();
  });
});
