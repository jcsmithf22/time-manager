import {startStimulusApp, registerControllers} from "vite-plugin-symfony/stimulus/helpers";

// Registers Stimulus controllers from controllers.json and in the controllers/ directory
const app = startStimulusApp();
registerControllers(
  app,
  import.meta.glob('./controllers/*_controller.js', {
    query: "?stimulus",
    /**
     * always true, the `lazy` behavior is managed internally with
     * import.meta.stimulusFetch (see reference)
     */
    eager: true,
  })
)
