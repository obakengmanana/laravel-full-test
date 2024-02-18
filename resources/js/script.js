$(document).ready(function(){
    // Initialize Typeahead.js
    $('#searchInput').typeahead({
        source: function(query, process) {
            return $.get('/autocomplete', { query: query }, function(data) {
                process(data);
            });
        },
        displayText: function(item) {
            // Generate HTML markup for suggestion display
            var releaseYear = item.release_date.split('-')[0];
            return '<div style="display: flex; align-items: center;"><div><img src="' + item.poster_image + '" alt="' + item.title + '" style="width: 40px; height: 50px; margin-right: 10px;"></div><div><big style="font-weight: bold;">' + item.title + '</big><div style="margin-top: 5px;"><small style="font-weight: bold;">' + releaseYear + ' - </small><small>' + item.director_name + '</small></div></div></div>';
        },
        highlighter: function(item) {
            return item;
        },
        matcher: function(item) {
            return true;
        },
        updater: function(item) {
            return item;
        },
        sorter: function(items) {
            return items;
        }
    });

    // Customize Typeahead.js behavior to display suggestions as a dropdown
    $('#searchInput').on('input', function() {
        // Trigger Typeahead.js to show suggestions as the user types
        $(this).typeahead('open');
    });

    // Add event listener for selecting a suggestion from the dropdown
    $('#searchInput').on('typeahead:select', function(event, suggestion) {
        // Populate search input field with the selected suggestion
        $(this).typeahead('val', suggestion.title); // You can change 'title' to any other property you want to display
    });

    // Add event listener for input changes
    $('#searchInput').on('input', function() {
        let query = $(this).val();
        axios.get('/search', { params: { query: query } })
             .then(function(response) {
                 // Handle search results if needed
             })
             .catch(function(error) {
                 console.error(error);
             });
    });
});
