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
    title: tourI18n.intro_title,
    text: tourI18n.intro_text
});

tour_intro.addStep('intro_1', {
    title: tourI18n.intro_1_title,
    text: tourI18n.intro_1_text,
    attachTo: '.panel-account left'
});
tour_intro.addStep('intro_2', {
    title: tourI18n.intro_2_title,
    text: tourI18n.intro_2_text,
    attachTo: '.panel-limit left'
});
tour_intro.addStep('intro_3', {
    title: tourI18n.intro_3_title,
    text: tourI18n.intro_3_text,
    attachTo: '.panel-leads top'
});
tour_intro.addStep('intro_4', {
    title: tourI18n.intro_4_title,
    text: tourI18n.intro_4_text,
    attachTo: '.panel-contact left',
    buttons: {
        text: tourI18n.intro_4_btn_label,
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
    title: tourI18n.search_1_title,
    text: tourI18n.search_1_text
});
tour_search.addStep('search_2', {
    title: tourI18n.search_2_title,
    text: tourI18n.search_2_text,
    attachTo: '.panel-search top'
});
tour_search.addStep('search_3', {
    title: tourI18n.search_3_title,
    text: tourI18n.search_3_text,
    attachTo: '.panel-search-params top'
});
tour_search.addStep('search_4', {
    title: tourI18n.search_4_title,
    text: tourI18n.search_4_text,
    attachTo: '.panel-map top'
});
tour_search.addStep('search_5', {
    title: tourI18n.search_5_title,
    text: tourI18n.search_5_text,
    attachTo: '.panel-place-details left',
    buttons: {
        text: tourI18n.search_5_btn_label,
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