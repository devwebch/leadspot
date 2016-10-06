jQuery(document).ready(function ($) {
   console.log('ready');
});


let tour = new Shepherd.Tour({
    defaults: {
        classes: 'shepherd-theme-arrows',
        showCancelLink: true
    }
});

tour.addStep('intro', {
    title: 'Welcome to LeadSpot',
    text: 'Hello, this is your dashboard, here you will find informations related to your account and operations.'
});

tour.addStep('intro_1', {
    title: 'My account',
    text: 'Quicklink to your account, manage your informations and subscriptions.',
    attachTo: '.panel-account left'
});
tour.addStep('intro_2', {
    title: 'Daily limit',
    text: "Depending on your account type (free or paid), your daily limit may vary.<br>The limit is reset every day at midnight.",
    attachTo: '.panel-limit left'
});
tour.addStep('intro_3', {
    title: 'Contact us',
    text: 'If you have a question or run into any issue, please let us know.',
    attachTo: '.panel-contact left',
    buttons: {
        text: 'Next',
        action: function () {
            tour.next;
            window.location = '/leads/search?tour=yes';
        }
    }
});

tour.start();