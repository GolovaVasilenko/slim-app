var slugify = require('slugify');
//import $ from 'jquery';

$(document).ready(function($) {

    $('.slug-title').on('change', function() {

        $('.slug-res').val(slugify($(this).val(), {
            replacement: '-',    // replace spaces with replacement
            remove: null,        // regex to remove characters
            lower: true          // result in lower case
        }));
    });

});