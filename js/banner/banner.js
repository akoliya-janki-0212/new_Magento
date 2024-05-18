varienGrid.prototype.doFilter = function () {
    var filters = $$('#' + this.containerId + ' .filter input', '#' + this.containerId + ' .filter select');
    var elements = [];
    filters.push(customtextbox);
    for (var i in filters) {
        if (filters[i].value && filters[i].value.length) elements.push(filters[i]);
    }
    if (!this.doFilterCallback || (this.doFilterCallback && this.doFilterCallback())) {
        this.reload(this.addVarToUrl(this.filterVar, encode_base64(Form.serializeElements(elements))));
    }
},
varienGrid.prototype.demo = function(url,formkey){
        new Ajax.Request(url,{
            method:'post',
            parameters:{form_key:formkey,name:'Janki'},
            onSuccess :function(response){
                alert(response.responseText.evalJSON());
            },
            onFailure : function(){
                alert('you are fail so sad 😢');
            }
        })
};    