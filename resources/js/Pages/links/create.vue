<script setup lang="ts">
import Layout from "../../Layouts/dash.vue";
import { router } from "@inertiajs/vue3";
import { ref } from "vue";
import axios from "axios";
import { vars } from "../../vars";
import iconsFile from '../../icons.json';



defineOptions({
    layout: Layout,
});

const props = defineProps({
    erros: Object,
});

const loading = ref(false);
const erros = ref({
    url: "",
    icon: "",
    color: "",
    bg_color: "",
    status: "",
});

// get link from backend
const link = ref({
    url: "",
    color: "ffffff",
    bg_color: "000000",
    icon: "",
    status: true
});

const createLink = async () => {
    Object.keys(erros.value).forEach((k) => {
        erros.value[k] = "";
    });

    loading.value = true;
    router.post(vars.backend + "/link/create", link.value, {
        onError(error) {

            Object.keys(error).forEach((k) => {
                erros.value[k] = error[k];
            });
            loading.value = false;
        },
    });

    // axios.post(vars.backend + "/link/create", link.value).then((e) => {
    //     console.log(e);
    // });

    // axios(vars.backend + "/link", link.value);
};

// import ico from 'remixicon/fonts/remixicon.css';

// console.log(ico)
 const icons = ref(iconsFile.icons);
// const icons = ref([ "ri-arrow-right-up-line","ri-arrow-right-up-line","ri-arrow-right-up-line","ri-arrow-right-up-line","ri-arrow-right-up-line","ri-arrow-right-up-line","ri-arrow-right-up-line","ri-arrow-right-up-line",]);
</script>

<template>
    <div class="small-panel">
        <h1>إنشاء رابط جديد</h1>
        <div class="inputs">
            <div>
                <label>الرابط</label>
                <InputText v-model="link.url" />
                <small>على سبيل المثال : https://juzr.sa</small>
                <Message severity="error" v-if="erros.url">{{
                    erros.url
                }}</Message>
            </div>
            <div>
                <label>الأيقونة</label>
                <Select
                    v-model="link.icon"
                    :options="icons"
             :virtualScrollerOptions="{ itemSize: 38 }"
                >
                    <template #option="{ option }">
                        <i :class="option"></i>
                    </template>
                    <template #value="{ value }">
                        <i v-if="value" :class="value"></i>
                        <p v-else>إختر ايقونة</p>
                    </template>
                </Select>
                <p>اذا كنت تظن ان هناك ايقونة يفضل حذفها من الموقع, فلا تتردد بإخبارنا <a target="_blank" href="https://www.instagram.com/juzr.official">من هنا</a></p>
                <Message severity="error" v-if="erros.icon">{{
                    erros.icon
                }}</Message>
            </div>
            <div>
                <label>اللون</label>
                <ColorPicker v-model="link.color" />
                <InputText v-model="link.color" />
                <small>بدون علامة الهاشتاق (#)</small>
                <Message severity="error" v-if="erros.color">{{
                    erros.color
                }}</Message>
            </div>
            <div>
                <label>لون الخلفية</label>
                <ColorPicker v-model="link.bg_color" />
                <InputText v-model="link.bg_color" />
                <small>بدون علامة الهاشتاق (#)</small>
                <Message severity="error" v-if="erros.bg_color">{{
                    erros.bg_color
                }}</Message>
            </div>
            <div>
                <label>الحالة</label>
                <ToggleButton
                    offLabel="مخفي"
                    onLabel="علني"
                    v-model="link.status"
                    onIcon="pi pi-check"
                    offIcon="pi pi-times"
                    :invalid="!link.status"
                />
                <Message severity="error" v-if="erros.status">{{
                    erros.status
                }}</Message>
            </div>
            <div>
                <label>المعاينة</label>
                <a
                    class="link-rev"
                    href="#"
                    :style="`color:#${link.color};background:#${link.bg_color};`"
                >
                    <i v-if="link.icon" :class="link.icon"></i>
                    <i v-else class="ri-arrow-right-up-line"></i>
                </a>
            </div>
            <Button
                :loading="loading"
                class="save-btn"
                label="إنشاء الرابط"
                icon="pi pi-plus"
                severity="success"
                @click="createLink"
            />
        </div>
    </div>
</template>

<style lang="scss">
@import "resources/css/colors.scss";

.inputs {
    > div {
        margin-top: 10px;

        > *:not(.p-select, .link-rev) {
            margin-top: 3px;
            display: block;
        }

        > *:not(.link-rev) {
            width: 100%;
        }

        label {
            font-weight: bold;
        }
    }

    .save-btn {
        margin-top: 10px;
        width: 100%;
    }

    // .tag {
    //     margin-top: 5px;
    //     width: fit-content;
    //     .p-tag-icon {
    //         margin-left: 3px;
    //     }
    // }
}
</style>
