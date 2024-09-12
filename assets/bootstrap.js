import { startStimulusApp } from '@symfony/stimulus-bundle';

const app = startStimulusApp();
console.log(app.debug);
// register any custom, 3rd party controllers here
// app.register('some_controller_name', SomeImportedController);
