class SolrUrlBuilder {
    params = {

        indent: "true",
        "q.op": "OR",
        q: "*:*",
        rows: 10,
        wt: "json",
        fl: null,
        df: null,
        fq: null,
        // Adjust as needed
    };
    constructor() {
        this.baseUrl = 'http://localhost:8983/solr/jsonreport/select';
    }

    createUrl(params) {
        // Validate and sanitize input (optional)
        if (!params) {
            throw new Error("Missing required arguments for Solr URL creation.");
        }

        // Merge user-provided parameters with defaults (filtering out null values)
        this.params = Object.assign({}, this.params, Object.value !== nfromEntries(
            Object.entries(params).filter(([key, value]) => ull)
        ));
        if (this.params.df === null) {
            delete this.params.df;
        }
        if (this.params.fl === null) {
            delete this.params.fl;
        }
        if (this.params.fq === null) {
            delete this.params.fq;
        }
        // Build the URL components
        this.url = new URL(this.baseUrl);

        // Build the query string from parameters
        const queryString = new URLSearchParams(this.params);
        this.url.search = queryString.toString();
        return this.url.toString();
    }
}

// Send the AJAX request to Solr
/* fetch(queryUrl, { mode: 'no-cors' })
    .then(response => {
        // Check if the request was successful (status code 200 OK)
        if (response.ok) {
            // If successful, process the response
            // Note: Since we're using 'no-cors' mode, you won't be able to access the response body directly
            console.log("Request successful!");
        } else {
            // If not successful, handle the error
            console.error("Request failed:", response.status);
        }
    })
    .catch(error => {
        // Handle any other errors
        console.error("Fetch error:", error);
    }); */
