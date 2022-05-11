require('./bootstrap');

import {createApp} from 'vue';
import ItemEditor from './components/ItemEditor.vue';

createApp({
    components: {
        ItemEditor,
    }
})
.mount('#app');
