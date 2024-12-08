function searchClientWithType(route, csrf) {
    let currentPage = 1;  // Track the current page for pagination
    let loading = false; 
    var searchEngine = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: {
            url: route, // Route to handle POST request
            prepare: function (query, settings) {
                // Prepare the POST request with CSRF token and query
                settings.type = 'POST';
                settings.contentType = 'application/json';
                settings.data = JSON.stringify({ inputText: query });  
                settings.headers = {
                    'X-CSRF-TOKEN': csrf 
                };
                return settings;
            },
            wildcard: '%QUERY'
        }
    });

    $('#search-box').typeahead(
        {
            highlight: true,
            minLength: 1,
        },
        {
            name: 'search-results',
            display: 'id', 
            source: searchEngine,
            limit: 40,
            templates: {
                suggestion: function (data) {
                    return `
                        <div class="custom-suggestion">
                            <strong>${data.file_name}</strong><br>
                            <small>Application No: ${data.application_no}</small>
                        </div>`;
                },
                empty: '<div class="no-results">No records found for this search.</div>'
            }
        }
    );
    $('#search-box').on('typeahead:opened', function() {
        var menu = $('.tt-menu');
        menu.on('scroll', function() {
            if (menu.scrollTop() + menu.innerHeight() >= menu[0].scrollHeight && !loading) {
                loading = true;  // Prevent multiple simultaneous requests
                currentPage++;   // Increment the page number
                $('#search-box').typeahead('val', $('#search-box').val()); // Trigger a new search to load more data
            }
        });
    });

    // Show the spinner when a request starts
    $('#search-box')
    .on('typeahead:asyncrequest', function() {
        $('#spinner-loader').show();  // Show spinner
    })
    .on('typeahead:asyncreceive', function() {
        $('#spinner-loader').hide();  // Hide spinner
        loading = false;      // Allow new requests
    })
    .on('typeahead:asynccancel', function() {
        $('#spinner-loader').hide();  // Hide spinner if the request is canceled
        loading = false;
    });
}
