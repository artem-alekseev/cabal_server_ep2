require('./bootstrap');

import {createApp} from 'vue';
import ItemEditor from './components/ItemEditor.vue';
import UserNumSelect from "./components/UserNumSelect.vue";
import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css';

createApp({
    components: {
        ItemEditor,
        UserNumSelect,
        vSelect,
    }
})
.mount('#app');
