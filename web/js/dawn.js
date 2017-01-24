/**
 * Created by alexandre.tranchant on 24/01/2017.
 */

//Log non-existant selectors
$ = Object.assign(function (jQuery) {
    return function(pars) {
        var result = jQuery(pars);
        if (result.length==0) console.log('selector has no results',pars);
        return result;
    }
}($),$);

/**
 * Delay to hide Layer.
 *
 * @type {number}
 */
var hideDelay = 200;

/**
 * Delay to show layer.
 *
 * @type {number}
 */
var showDelay = 1000;

/**
 * Character in meet popup.
 *
 * @type {string}
 */
var character = '';

/**
 * Btn class dynmically created created.
 *
 * @type {string}
 */
var btnCss = 'btn btn-secondary btn-sm';

/**
 * Background Layer.
 *
 * @type {*}
 */
var backgroundLayer = $('div#background');

/**
 *
 */
$(document).ready(function() {

    //Hide Loader layer and show content layer
    $("#loader").fadeOut(hideDelay);
});
/**
 * Do an animation only one time
 */
jQuery.fn.extend({
    animateCss: function (animationName) {
        var animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
        this.addClass('animated ' + animationName).one(animationEnd, function() {
            $(this).removeClass('animated ' + animationName);
        });
    }
});
/**
 * Disable function
 */
jQuery.fn.extend({
    disable: function(state) {
        return this.each(function() {
            this.disabled = state;
        });
    }
});
/**
 * Enable function
 *
 */
jQuery.fn.extend({
    enable: function(state) {
        return this.each(function() {
            this.disabled = !state;
        });
    }
});

/******************************/
/* Dynamic creations function */
/******************************/
