
// import './bootstrap';
import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'

import PrimeVue from 'primevue/config';
import Aura from '@primevue/themes/aura';
import 'primeicons/primeicons.css'
import '../css/app.scss';
import 'remixicon/fonts/remixicon.css'
import ConfirmationService from 'primevue/confirmationservice';



// import '../css/styles.scss';
// import '../css/tailwind.css';

createInertiaApp({
  resolve: name  => {
    const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
    return pages[`./Pages/${name}.vue`] as any;
  },
  setup({ el, App, props, plugin }) {

    createApp({ render: () => h(App, props) })
      .use(plugin).use(PrimeVue, {
        theme: {
            preset: Aura,
            options: {
                // prefix: 'p',
                darkModeSelector: '.darker',
                // cssLayer: false
            }
        }
    }).use(ConfirmationService)
      .mount(el)
  },
})
