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
    text: 'Hello, this is your dashboard, here you will find informations<br>related to your account and operations.'
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
    title: 'Leads',
    text: "Your latest leads will be shown here.",
    attachTo: '.panel-leads top'
});
tour_intro.addStep('intro_4', {
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
    title: 'Search for leads',
    text: "Start searching for new client! Use this view to analyze local businesses and save leads."
});
tour_search.addStep('search_2', {
    title: 'Set a search location',
    text: 'You may search for a location by <em>address</em> or by using <em>geolocation</em>.',
    attachTo: '.panel-search top'
});
tour_search.addStep('search_3', {
    title: 'Define parameters',
    text: 'Places may be found by <em>name</em>, <em>category</em> and <em>radius</em>.',
    attachTo: '.panel-search-params top'
});
tour_search.addStep('search_4', {
    title: 'Results',
    text: 'Your results will be displayed on the map.',
    attachTo: '.panel-map top'
});
tour_search.addStep('search_5', {
    title: 'Business details',
    text: 'Click the <em>analyze</em> button and relevant results will be display here.',
    attachTo: '.panel-place-details left',
    buttons: {
        text: "I'm ready!",
        action: function () {
            tour_search.cancel();
            window.location = '/leads/search';
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
        //tour_list.start();
        break;
    default:
}