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
var answers = $('.answer');
var $actions = $('.action');
var loader = $("#loader");
var map = $('map');
var sceneDialogue = $('#sceneDialogue');
var sceneImage = $('#sceneImage');
var sentences = $('.sentence');
var sentencesDocker = $('#answers');
/**
 *
 */
$(document).ready(function() {

    //action responsive
    $('img[usemap]').rwdImageMaps();

    /**
     * When player click on a location button,
     * AJAX GOTO is called and analyze.
     *
     */
    answers.click(function()
    {
        provideAnswer($(this).data('answer'));
    });

    //Hide Loader layer and show content layer
    loader.fadeOut(hideDelay);
});

/******************/
/* Dynamic action */
/******************/
function provideAnswer(answerId) {
    loader.fadeIn(showDelay);
    $.getJSON(
        this.rootPath + 'answer/'+ answerId,
        function (data) {
            console.log(JSON.stringify(data));
            if (data['messages'] && data['messages']['error'] ) {
                console.log('Error handled from do call !');
                return;
            }
            //change dialogue
            sceneDialogue.text(data['scene']['dialogue']);
            sceneImage.attr('src', data['base_dir'] + data['scene']['image']);
            //create areas
            map.empty();
            $.each(data['actions'], function (key, val) {
                createArea(val);
            });
            //create sentences
            sentencesDocker.empty();
            $.each(data['sentences'], function (key, val) {
                createSentence(val);
            });
            //influence scores
            $.each( data['influences'], function( key, val ) {
                console.log('characteristics '+key+':'+val);
                $("#"+key)
                    .text(val)
                    .animateCss('flash');

            });
            loader.fadeOut(showDelay);
            console.log('end function getJSON(provideAnswer)')
        }
    ).done(function() {
        console.log( "Good provideAnswer received" );
    }).fail(function() {
        console.log( "error provideAnswer received" );
    }).always(function() {
        //action responsive
        $('img[usemap]').rwdImageMaps();
        //loader hide
        loader.fadeOut(showDelay);
        console.log( "complete provideAnswer received" );
    });
}

/******************************/
/* Dynamic creations function */
/******************************/
function createArea(data){
    var area = $('<area>')
        .addClass('action answer')
        .click(function(){
            provideAnswer(data['id'])
        })
        .attr('shape', data['shape'])
        .attr('coords', data['coords'])
        .attr('alt', data['tooltip'])
        .attr('href', '#')
        .attr('data-answer', data['id'])
        .data('answer', data['id']);
    map.append(area);
}

function createSentence(data){
    var link = $('<a>')
        .addClass('action answer')
        .click(function(){
            provideAnswer(data['id'])
        })
        .attr('title', '')
        .attr('href', '#')
        .attr('data-answer', data['id'])
        .data('answer', data['id'])
        .html(data['sentence']);
    var paragraphe = $('<p class="text-center">')
        .append(link);
    var div = $('<div class="col-sm-12 col-md-6">')
        .append(paragraphe);

    sentencesDocker.append(div);
}

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