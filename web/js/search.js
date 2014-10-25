// search modifer attribute identifier
SMID = 'data-searchmod';

// stored search modifier cookie name
SMCOOKIE = 'search-modifier-cookie';

// get faceted/slug data if the user is on a special page or explicitly
// using search facets
function getFacets() {
    console.log('getFacets: begin');
    var facets = [];
    var rawslug = $('#slugdata').text();
    var lmark = "(u'selected_facets', ";

    // parse slug into pieces -- convert python to JSON
    if (rawslug && rawslug.indexOf(lmark) > -1) {
	var left = rawslug.indexOf(lmark) + lmark.length;
	var trimmed = rawslug.slice(left);
	var right = trimmed.indexOf("])") + 1;
	var trimmed = trimmed.slice(0, right);
	trimmed = trimmed.split("[u'").join("['");
	trimmed = trimmed.split(", u'").join(", '");
	trimmed = trimmed.split("'").join('"');
	var facets = JSON.parse(trimmed);
    }

    return facets;
}

function checkSearch() {
    console.log('checkSearch: begin');
    var node_query = $('#bq_query');
    var node_location = $('#bq_location');
    var searchTerm = node_query.val();
    var locationTerm = node_location.val();

    var facets = getFacets();

    if (
        (searchTerm.trim() == "" && locationTerm.trim() == "") &&
        !facets.length
        ) {
        node_query.focus();
        node_query.css("border-color", "#ff0039");
        $('#term-required').show();

        // stop form submission
        //return false;
    }
    else {

        try {
            //console.log('checkSearch: before GA');
            //_gaq.push(['_trackEvent', 'homepage' , 'search']);
            //console.log('checkSearch: after GA');
        }
        catch (err) {

        }

        var modifiers = getSearchModifiers();
        var ordering = getSortModifier();

        // store modifiers only if non-empty; this avoids e.g. empty search
        // results resetting checkboxes
        // BUT -- store empty modifiers if search terms changed (reset)
        if (!$.isEmptyObject(modifiers) || searchchanged) {
            if (searchchanged) {
            modifiers = {};
            ordering = '';
            }
            storeSearchModifiers(SMCOOKIE, modifiers);

            var exclusions = [];

            for (var key in modifiers) {
            var value = modifiers[key];
            if (!value) {
                exclusions.push(key);
            }
            }

            // put exclusion modifiers into query string for back-end use
            // encode modifiers with base64 to avoid bugs in qs updates
            var ex = window.btoa(JSON.stringify(exclusions));
            ex = ex.replace(/\+/g, '-').replace(/\//g, '_').replace(/\=+$/, '');
            var newuri = updateQueryStringParameter({'ex': ex, 'bq[query]' : searchTerm, 'bq[location]' : locationTerm, 'page' : '1', 'order_by' : ordering});

            window.location.href = newuri;
            return false;
        }

        return true;
    }
}

/* Get checkbox states for each on-page checkbox with data-searchmod attribute.
   These values are used to maintain checkbox state between page loads
   and to modify search results, e.g. allow a user to find courses
   that are either free or that have a free trial.
*/
function getSearchModifiers() {
    console.log('getSearchModifiers: begin');
    var modifiers = {};
    $('.searchmod').each(function (k, e) {
	var modifier = e.getAttribute(SMID);
	modifiers[modifier] =  e.checked ? 1 : 0;
    });

    return modifiers;
}

/* Get currently selected search ordering.
   This value is used to maintain sort dropdown state between page loads
   and to modify search results, e.g. allow a user to find courses that are less
   expensive.
*/
function getSortModifier() {
    console.log('getSortModifier: begin');
    var sortorder = $('#searchorder').val();
    return sortorder;
}

/* Retrieve search modifiers from cookie storage */
function retrieveSearchModifiers(cookieName) {
    console.log('retrieveSearchModifiers: begin');
    /* Disabling cookied search preferences until they can be remembered
       per-topic and put in something more appropriate like Local Storage

    var stored = $.cookie(cookieName);
    */
    var stored = null;

    if (!stored) {
	stored = {};
    }

    else {
	stored = JSON.parse(stored);
    }

    return stored;
}

/* Store search modifiers in a session cookie, so that checked boxes retain
   state on page reload/navigation. */
function storeSearchModifiers(cookieName, values) {
    console.log('storeSearchModifiers: begin');
    var serialized = JSON.stringify(values);
    $.cookie(cookieName, serialized);
}


/* Update query string, assigning a new value to each parameter
 * given in kvpairs */
function updateQueryStringParameter(kvpairs) {
    console.log('updateQueryStringParameter: begin');
    var uri = URI(window.location.href);

    for (var key in kvpairs) {
	var value = kvpairs[key];
	uri.removeSearch(key);
	uri.addSearch(key, value);
    }

    return uri.href();
}

/* Get a query string parameter by name */
function getParameterByName(name) {
    console.log('getParameterByName: begin' + name);
    var match = RegExp('[?&]' + name + '=([^&]*)').exec(window.location.search);
    return match && decodeURIComponent(match[1].replace(/\+/g, ' '));
}

$(document).ready(function () {
    // Set up checkbox state on page load, if page has search checkboxes
    var boxes = $('.searchmod');
    if (boxes.length) {

	/* 2 possibly conflicting sources for search modifiers: session cookie
	   and query string 'ex' parameter. For example, user may have session
	   cookie with modifiers even though they have initiated a brand new
	   search. User may have no cookie but has ex parameter in
	   query string. The query string overrides session cookie settings.
	*/
	var stored = {};

	var ex = getParameterByName('ex');

	if (ex) {
	    try {
		var exclusions = JSON.parse(window.atob(ex));
		for (var k=0; k < exclusions.length; k += 1) {
		    stored[exclusions[k]] = false;
		}
	    }

	    catch (err) {
	    }
	}

	// get cookie-stored modifiers only if query string absent/failed
	if ($.isEmptyObject(stored)) {
	    stored = retrieveSearchModifiers(SMCOOKIE);
	}


	for (var k=0; k < boxes.length; k += 1) {
	    var box = boxes[k];

	    // only handle search modifier checkboxes
	    var searchmod = box.getAttribute(SMID);
	    var stored_checkvalue = stored[searchmod];

	    // no stored value found -- set checked by default
	    if (stored_checkvalue == null) {
		$(box).prop('checked', true);
	    }

	    // set box to prior stored value
	    else {
		$(box).prop('checked', stored_checkvalue);
	    }

	}
    }

    // Set up filter-reset click handler to clear search modifier checkboxes
    $("#resetfilters").click(function(event) {
	    $.removeCookie(SMCOOKIE);
	    $('input.searchmod').prop('checked', true);
	    event.preventDefault();
	    $('#bq_searchbutton').click();
    });

    // Checkbox click handler to refresh page when search modifiers change
    $(".searchmod").click(function(event) {
        console.log('searchmod click event: before searchbutton click');
        $('#bq_searchbutton').click();
    });

    // if user changes search terms, reset search filters
    searchval = $("#bq_query").val().trim();
    locationval = $("#bq_location").val().trim();
    searchchanged = false;

    $("#bq_query").change(function(event) {
        if (
            (($("#bq_query").val().trim() != searchval) && searchval != '')
        ) {
            searchchanged = true;
        }
        else {
            searchchanged = false;
        }
    });

    $("#bq_location").change(function(event) {
        if (($("#bq_location").val().trim() != searchval) && searchval != '') {
            searchchanged = true;
        }
        else {
            searchchanged = false;
        }
    });


    // Facet mouseover UI and 'only' selection controls
    $(".facetrow").hover(
	function () {
	    $(this).css("background", "aliceblue");
	    $(this).find("a").show();
	},
	function () {
	    $(this).css("background","");
	    $(this).find("a").hide();
	}
    );

    $(".filteronly").click(function(event) {
	    // uncheck all filters in group, then check only clicked-row filter
	    $(this).closest("div.facet").find("input").prop("checked", false);
	    $(this).closest("div").find("input").prop("checked", true);
	    event.preventDefault();
	    $("#bq_searchbutton").click();
    });
});
