<script setup lang="ts">
import Layout from "../../Layouts/dash.vue";
// import { Head } from '@inertiajs/vue3'
import { router } from "@inertiajs/vue3";
import { ref } from "vue";
import { vars } from "../../vars";
import iconsFile from '../../icons.json';
defineOptions({
    layout: Layout,
});

const props = defineProps({
    link: Object,
});

const erros = ref({
    url: "",
    icon: "",
    color: "",
    bg_color: "",
    status: "",
});

// console.log(props.link);
const loading = ref(false);

// get link from backend
const linkEdit = ref(props.link!);

const updateLink = () => {
    Object.keys(erros.value).forEach((k) => {
        erros.value[k] = "";
    });

    loading.value = true;
    router.post(`${vars.backend}/link/${props.link!.id}/edit`, linkEdit.value, {
        onError(error) {
            Object.keys(error).forEach((k) => {
                erros.value[k] = error[k];
            });
            loading.value = false;
        },
    });
};

const icons = ref(iconsFile.icons);
</script>

<template>
    <div class="small-panel">
        <h1>تعديل الرابط</h1>
        <div class="inputs">
            <div>
                <label>الرابط</label>
                <InputText v-model="linkEdit.url" />
                <small>على سبيل المثال : https://juzr.sa</small>
                <Message severity="error" v-if="erros.url">{{
                    erros.url
                }}</Message>
            </div>
            <div>
                <label>الأيقونة</label>
                <Select
                    v-model="linkEdit.icon"
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
                <ColorPicker v-model="linkEdit.color" />
                <InputText v-model="linkEdit.color" />
                <small>بدون علامة الهاشتاق (#)</small>
                <Message severity="error" v-if="erros.color">{{
                    erros.color
                }}</Message>
            </div>
            <div>
                <label>لون الخلفية</label>
                <ColorPicker v-model="linkEdit.bg_color" />
                <InputText v-model="linkEdit.bg_color" />
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
                    v-model="linkEdit.status"
                    onIcon="pi pi-check"
                    offIcon="pi pi-times"
                    :invalid="!linkEdit.status"
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
                    :style="`color:#${linkEdit.color};background:#${linkEdit.bg_color};`"
                >
                    <i v-if="linkEdit.icon" :class="linkEdit.icon"></i>
                    <i v-else class="ri-arrow-right-up-line"></i>
                </a>
            </div>
            <Button
                :loading="loading"
                class="save-btn"
                label="حفظ"
                icon="pi pi-check"
                severity="success"
                @click="updateLink"
            />
        </div>
    </div>
</template>

<style lang="scss">
@import "resources/css/colors.scss";

// .inputs {
//     > div {
//         margin-top: 10px;

//         > *:not(.p-select,.link-rev) {
//             margin-top: 3px;
//             display: block;
//         }

//         > *:not(.link-rev) {
//             width: 100%;
//         }

//         label {
//             font-weight: bold;
//         }
//     }

//     .save-btn {
//         margin-top: 10px;
//         width: 100%;
//     }

// .tag {
//     margin-top: 5px;
//     width: fit-content;
//     .p-tag-icon {
//         margin-left: 3px;
//     }
// }

.link-rev {
    display: inline-block;
    text-align: center;
    background-color: #000;
    color: #fff;
    border-radius: 20px;
    padding: 15px;
    text-decoration: none;
    margin: 15px 0;
    margin-top: 20px;
    position: relative;
    transform: scale(1.5);

    transition: 0.5s ease;
    overflow: hidden;
    font-size: 20px;

    i {
        display: block;
    }

    // Circular background White animation
    // .click-anime {
    //     position: fixed;
    //     width: 100%;
    //     height: 100%;
    //     background-color: #fff;
    //     z-index: -1;
    //     left: 0;
    //     top: 0;
    //     border-radius: 20px;
    //     box-sizing: border-box;
    //     transition: 1s;
    //     clip-path: circle(0%);
    // }
    // }
}
</style>
