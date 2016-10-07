window.Shepherd = require('tether-shepherd');

var default_config = {
    classes: 'shepherd-theme-arrows',
    showCancelLink: true
};

/**
 * Tour intro
 */
var tour_intro = new Shepherd.Tour({
    defaults: default_config
});

tour_intro.addStep('intro', {
    title: 'Welcome to LeadSpot',
    text: 'Hello, this is your dashboard, here you will find informations related to your account and operations.'
});

tour_intro.addStep('intro_1', {
    title: 'My account',
    text: 'Quicklink to your account, manage your informations and subscriptions.',
    attachTo: '.panel-account left'
});
tour_intro.addStep('intro_2', {
    title: 'Daily limit',
    text: "Depending on your account type (free or paid), your daily limit may vary.<br>The limit is reset every day at midnight.",
    attachTo: '.panel-limit left'
});
tour_intro.addStep('intro_3', {
    title: 'Contact us',
    text: 'If you have a question or run into any issue, please let us know.',
    attachTo: '.panel-contact left',
    buttons: {
        text: 'Continue',
        action: function () {
            tour_intro.next;
            window.location = '/leads/search?tour=1';
        }
    }
});

/**
 * Tour search leads
 */
var tour_search = new Shepherd.Tour({
    defaults: default_config
});

tour_search.addStep('search_1', {
    title: 'Set a search location',
    text: 'You may search for a location by <em>address</em> or by using <em>geolocation</em>.',
    attachTo: '.panel-search top'
});
tour_search.addStep('search_2', {
    title: 'Define parameters',
    text: 'Places may be found by <em>name</em>, <em>category</em> and <em>radius</em>.',
    attachTo: '.panel-search-params top'
});
tour_search.addStep('search_3', {
    title: 'Results',
    text: 'Your results will be displayed on the map.',
    attachTo: '.map-container top'
});
tour_search.addStep('search_4', {
    title: 'Business details',
    text: 'Click the <em>analyze</em> button and relevant results will be display here.',
    attachTo: '.panel-place-details left',
    buttons: {
        text: 'Continue',
        action: function () {
            tour_intro.next;
            window.location = '/leads/list?tour=1';
        }
    }
});

/**
 * Tour list leads
 */
var tour_list = new Shepherd.Tour({
    defaults: default_config
});

tour_list.addStep('list_1', {
    title: 'Set a search location',
    text: 'You may search for a location by <em>address</em> or by using <em>geolocation</em>.',
    attachTo: '.panel-search top'
});
tour_list.addStep('list_2', {
    title: 'Define parameters',
    text: 'Places may be found by <em>name</em>, <em>category</em> and <em>radius</em>.',
    attachTo: '.panel-search-params top'
});
tour_list.addStep('list_3', {
    title: 'Results',
    text: 'Your results will be displayed on the map.',
    attachTo: '.map-container top'
});
tour_list.addStep('list_4', {
    title: 'Business details',
    text: 'Click the <em>analyze</em> button and relevant results will be display here.',
    attachTo: '.panel-place-details left',
    buttons: {
        text: 'Continue',
        action: function () {
            tour_intro.next;
            window.location = '/leads/list?tour=1';
        }
    }
});



// start tour
switch (tourConfig.tour) {
    case 'intro':
        tour_intro.start();
        break;
    case 'search':
        tour_search.start();
        break;
    case 'list':
        tour_list.start();
        break;
    default:
}