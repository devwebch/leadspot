let tour = new Shepherd.Tour({
    defaults: {
        classes: 'shepherd-theme-arrows'
    }
});

tour.addStep('example', {
    title: 'Example',
    text: 'Hello world, you can do this',
    attachTo: '.panel-welcome top'
});

tour.start();