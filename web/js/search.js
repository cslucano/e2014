// search modifer attribute identifier
SMID = 'data-searchmod';

// stored search modifier cookie name
SMCOOKIE = 'search-modifier-cookie';

// get faceted/slug data if the user is on a special page or explicitly 
// using search facets
function getFacets() {
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
    var node = $('#id_q');
    var searchTerm = node.val();

    var facets = getFacets();

    if ((searchTerm.trim() == "") && !facets.length) {
        node.focus();
        node.css("border-color", "#ff0039");
        $('#term-required').show();
        
        // stop form submission
        return false;
    }
    else {

        try {
            //console.log('checkSearch: before GA');
            _gaq.push(['_trackEvent', 'homepage' , 'search']);
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
	    var newuri = updateQueryStringParameter({'ex': ex, 'q' : searchTerm, 'page' : '1', 'order_by' : ordering});

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
    var sortorder = $('#searchorder').val();
    return sortorder;
}

/* Retrieve search modifiers from cookie storage */
function retrieveSearchModifiers(cookieName) {
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
    var serialized = JSON.stringify(values);
    $.cookie(cookieName, serialized);
}


/* Update query string, assigning a new value to each parameter
 * given in kvpairs */
function updateQueryStringParameter(kvpairs) {
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
	$('#searchbutton').click();
    });

    // Checkbox click handler to refresh page when search modifiers change
    $(".searchmod").click(function(event) {
	$('#searchbutton').click();
    });

    // if user changes search terms, reset search filters
    searchval = $("#id_q").val().trim();
    searchchanged = false;

    $("#id_q").change(function(event) {
	if (($("#id_q").val().trim() != searchval) && searchval != '') {
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
	// have we made check box group read-only? then prevent changes
	var disabled = $(event.target).parents('dl').children().first().prop('disabled');

	if (disabled != 'disabled') {
	    // uncheck all filters in group, then check only clicked-row filter
	    $(this).closest("div").find("input").prop("checked", false);
	    $(this).closest("dd").find("input").prop("checked", true);
	    event.preventDefault();
	    $("#searchbutton").click();
	}
    });

    // Hide excess rows under Category and Provider groups, with "more" link
    // to reveal them when clicked
    var initialRows = 3;
    var hideTargets = ['#group_category dd', '#group_provider dd'];
    var moreLink = '<dd><a class="moreLink" href="#">more &raquo;</a></dd>';

    for (var k=0; k < hideTargets.length; k += 1) {
	var categories = $(hideTargets[k]);
	if (categories.length > initialRows) {
	    // add a 'more' link at the end of category
	    var inserted = $(moreLink).insertAfter(categories.last());

	    inserted.click(function(event) {
		// reveal previously-hidden category rows on 'more' link click
		$(event.target).parent().parent().find('dd').show();
		// hide 'more' link after revealing extras
		$(event.target).hide();
		event.preventDefault();
	    });

	    // hide the excess rows on initial page view
	    categories.slice(initialRows, 1000).hide();
	}
    }

    // Make search box read-only if user is on a pre-filtered content page or faceting
    // Also hide search area if user is on a pre-filtered content page
    var slugs = getFacets();
    if (slugs.length) {
	$('.input-group').hide();
	
	var restrictions = {'category_exact' : 'dl :contains(Category)',
			    'school_exact' : 'dl :contains(Provider)',
			    'price_bucket_exact' : 'dl :contains(Pricing)',
			    'certificate_exact' : 'dl :contains(Certificate)'};

	for (var j = 0; j < slugs.length; j += 1) {
	    slug = slugs[j];

	    // find which slugtype (if any) matches current slug, restrict its search group
	    for (var slugtype in restrictions) {
		if (slug.indexOf(slugtype) > -1) {
		    var boxes = $(restrictions[slugtype]).parent().find('input');
		    boxes.prop('checked', false);
		    for (var k=0; k < boxes.length; k += 1) {
			var box = $(boxes[k]);
			var bdata = box.data()['searchmod'];
			if (bdata == slug) {
			    box.prop('checked', true);
			}
		    }
		    boxes.prop('disabled', 'disabled');
		    boxes.first().parents('dl').children().first().prop('disabled', 'disabled');
		}
	    }
	}
    }

    // set up search ordering controls
    var default_order = 'relevance';
    var orderings = Array(Array("Sort: Relevance", "relevance"),
              Array("Sort: Price low to high", "price_low"),
              Array("Sort: Price high to low", "price_high"),
			  Array("Sort: Popularity", "popularity"));

    // don't provide price sorting when price filter is stuck on Free

    var price_rejects = Array(Array('price_bucket_exact:Free'),
			      Array('price_bucket_exact:Free Trial'),
			      Array('price_bucket_exact:Free', 
				    'price_bucket_exact:Free Trial')
			     );
    var prices = $("dl dt:contains(Pricing)").parent().find('input:checked');
    var hide_price_sort = false;
    if (prices.length == 1 && prices.first().data('searchmod') == 'price_bucket_exact:Free') {
	hide_price_sort = true;
    }

    if (hide_price_sort) {
	var newOrderings = Array();
	for (j=0; j < orderings.length; j += 1) {
	    if (orderings[j][0].indexOf("Price") == -1) {
		newOrderings.push(orderings[j]);
	    }
	}

	orderings = newOrderings;
    }

    // don't provide Relevance sorting if there is no explicit search term
    var query = getParameterByName('q');
    if (!query || !query.trim()) {
	var default_order = 'popularity';
	var newOrderings = Array();
	for (j=0; j < orderings.length; j += 1) {
	    if (orderings[j][0].indexOf("Relevance") == -1) {
		newOrderings.push(orderings[j]);
	    }
	}

	orderings = newOrderings;
    }
    

    for(j=0; j < orderings.length; j += 1)
    {
	var key = orderings[j][0];
	var value = orderings[j][1];
	var rhtml = ['<option value="', value, '">', key, '</option>'].join('');
	var opt = $(rhtml);
	opt.appendTo("#searchorder");
    }

    // set stored search order
    var stored_order = getParameterByName('order_by');
    if (stored_order) {
	$("#searchorder").val(stored_order);
    }
    else {
	$("#searchorder").val(default_order);
    }

    // hide search options if there is only one search option
    if (orderings.length == 1) {
	$("#searchblock").hide();
    }

    // Search order change handler to refresh page when search modifiers change
    $("#searchorder").change(function(event) {
	$('#searchbutton').click();
    });

});
