require('./bootstrap');


import { App, plugin } from '@inertiajs/inertia-vue'
import Vue from 'vue'
import { InertiaForm } from 'laravel-jetstream';
import PortalVue from 'portal-vue';
import vSelect from 'vue-select';

Vue.mixin({ methods: { route } });
Vue.use(plugin)
Vue.use(InertiaForm);
Vue.use(PortalVue);
Vue.component('v-select', vSelect);

const el = document.getElementById('app')

new Vue({
      render: h => h(App, {
              props: {
                        initialPage: JSON.parse(el.dataset.page),
                        resolveComponent: name => require(`./Pages/${name}`).default,
                      },
            }),
}).$mount(el)
