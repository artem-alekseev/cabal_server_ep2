<template>
    <div>
        <div class="mb-3">
            <label for="id" class="form-label">ID</label>
            <v-select :options="itemsData" v-model="itemData.dec_id" :reduce="option => option.code"></v-select>
            <input id="id" name="id" type="hidden" class="form-control" :value="dec2Hex(itemData.dec_id)">
        </div>

        <div class="mb-3">
            <label for="lvl" class="form-label">Level</label>
            <v-select :options="levels" v-model="itemData.lvl" :reduce="option => option.code"></v-select>
            <input id="lvl" name="lvl" type="hidden" class="form-control" :value="itemData.lvl">
        </div>

        <div class="mb-3">
            <label for="count_slots" class="form-label">Slots</label>
            <v-select :options="slots" v-model="itemData.count_slots" :reduce="option => option.code"></v-select>
            <input id="count_slots" name="count_slots" class="form-control" type="hidden" :value="itemData.count_slots">
        </div>

        <div class="mb-3">
            <label for="first_craft_slot" class="form-label">1 Craft Slot</label>
            <v-select :options="slotOptions" v-model="itemData.first_craft_slot"
                      :reduce="option => option.code"></v-select>
            <input id="first_craft_slot" name="first_craft_slot" type="hidden" class="form-control"
                   :value="itemData.first_craft_slot">
        </div>

        <div class="mb-3">
            <label for="first_craft_option" class="form-label">1 Craft Option</label>
            <v-select :options="craftOptions" v-model="itemData.first_craft_option"
                      :reduce="option => option.code"></v-select>
            <input id="first_craft_option" name="first_craft_option" type="hidden" class="form-control"
                   :value="itemData.first_craft_option">
        </div>

        <div class="mb-3" v-if="itemData.count_slots > 0">
            <label for="two_craft_option" class="form-label">2 Craft Option</label>
            <v-select :options="craftOptions" v-model="itemData.two_craft_option"
                      :reduce="option => option.code"></v-select>
            <input id="two_craft_slot" name="two_craft_slot" type="hidden" class="form-control" value="1">
            <input id="two_craft_option" name="two_craft_option" type="hidden" class="form-control"
                   :value="itemData.two_craft_option">
        </div>


        <div class="mb-3" v-if="itemData.count_slots > 1">
            <label for="thrid_craft_option" class="form-label">3 Craft Option</label>
            <v-select :options="craftOptions" v-model="itemData.thrid_craft_option"
                      :reduce="option => option.code"></v-select>
            <input id="thrid_craft_slot" name="thrid_craft_slot" type="hidden" class="form-control" value="1">
            <input id="thrid_craft_option" name="thrid_craft_option" type="hidden" class="form-control"
                   :value="itemData.thrid_craft_option">
        </div>

        <div class="mb-3" v-if="itemData.count_slots > 2">
            <label for="four_craft_option" class="form-label">4 Craft Option</label>
            <v-select :options="craftOptions" v-model="itemData.four_craft_option"
                      :reduce="option => option.code"></v-select>
            <input id="four_craft_slot" name="four_craft_slot" type="hidden" class="form-control" value="1">
            <input id="four_craft_option" name="four_craft_option" type="hidden" class="form-control"
                   :value="itemData.four_craft_option">
        </div>
    </div>
</template>
<script>
import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css';

export default {
    props: ['item', 'items'],
    components: {
        vSelect
    },
    data() {
        return {
            craftOptions: [
                {label: 'None', code: '0'},
                {label: '1', code: '1'},
                {label: '2', code: '2'},
                {label: '3', code: '3'},
                {label: '4', code: '4'},
                {label: '5', code: '5'},
                {label: '6', code: '6'},
                {label: '7', code: '7'},
                {label: '8', code: '8'},
                {label: '9', code: '9'},
                {label: 'A', code: 'a'},
                {label: 'B', code: 'b'},
                {label: 'C', code: 'c'},
                {label: 'D', code: 'd'},
                {label: 'E', code: 'e'},
                {label: 'F', code: 'f'},
            ],
            slotOptions: [
                {label: 'None', code: '0'},
                {label: 'Craft lvl 1', code: '9'},
                {label: 'Craft lvl 2', code: 'a'},
                {label: 'Craft lvl 3', code: 'b'},
                {label: 'Craft lvl 4', code: 'c'},
                {label: 'Craft lvl 5', code: 'd'},
                {label: 'Craft lvl 6', code: 'e'},
                {label: 'Craft lvl 7', code: 'f'},
            ],
            levels: [
                {label: '0', code: '0'},
                {label: '+1', code: '2'},
                {label: '+2', code: '4'},
                {label: '+3', code: '6'},
                {label: '+4', code: '8'},
                {label: '+5', code: 'a'},
                {label: '+6', code: 'c'},
                {label: '+7', code: 'e'},
            ],
            slots: [
                {label: 'None', code: '0'},
                {label: 'One', code: '1'},
                {label: 'Two', code: '2'},
                {label: 'Three', code: '3'},
                {label: 'Four', code: '4'},
            ],
            itemData: this.item,
            itemsData: Object.keys(this.items).map((key) => {
                return {label: this.items[key], code: parseInt(key)};
            }),
        }
    },
    methods: {
        dec2Hex(dec) {
            let hex = dec.toString(16).padStart(4, '0');
            hex = hex[2] + hex[3] + hex[0] + hex[1];
            return hex;
        }
    }
}
</script>
