<template>
    <div>
        <v-select :options="usersData" v-model="userNum" :reduce="option => option.code"></v-select>
        <input type="hidden" class="form-control" name="UserNum" :value="userNum">
    </div>
</template>

<script>
import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css';

export default {
    props: ['users', 'value'],
    components: {
        vSelect
    },
    data() {
        return {
            userNum: null,
            usersData: Object.keys(this.users).map((key) => {
                return {label: this.users[key], code: parseInt(key)};
            }),
        }
    }
}

</script>
