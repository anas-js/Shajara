<script setup lang="ts">
// import Layout from "../Layouts/dash.vue";
// // import { Head } from '@inertiajs/vue3'
import { ref } from "vue";
import axios from "axios";

import { router } from "@inertiajs/vue3";
// defineOptions({
//     layout: Layout,
// });

const accsept = ref({
    islam: false,
});

const loading = ref(false);

const register = () => {
    loading.value = true;
    axios.post("/api/registration").then(() => {
        router.get("/dashboard");
    });
    // router.post("/api/test",undefined,{

    // });
    // router.get('/registration');
};
</script>

<template>
    <div class="registration-page">
        <div class="box">
            <div class="inner">
                <Card style="width: 25rem; overflow: hidden">
                    <template #header>
                        <!-- <img src="https://primefaces.org/cdn/primevue/images/card-vue.jpg" /> -->
                    </template>
                    <template #title>الدخول الى النظام</template>
                    <template #subtitle>شجرة</template>
                    <template #content>
                        <div class="accsept">
                            <Checkbox
                                :disabled="loading"
                                v-model="accsept.islam"
                                binary
                            />
                            <label
                                >اوافق بأنني لن اقوم بوضع روابط تحيل الى اشياء
                                مخالفة للشريعة الاسلامية, بدون تحديد سواء كان
                                (حساب, موقع , برنامج, الخ)</label
                            >
                        </div>
                    </template>
                    <template #footer>
                        <div class="btns">
                            <!-- <Button
                                label="Cancel"
                                severity="secondary"
                                outlined
                                class="w-full"
                            /> -->
                            <Button
                                @click="register"
                                :loading="loading"
                                :disabled="!accsept.islam || loading"
                                label="الدخول"
                                class="w-full"
                            />
                        </div>
                    </template>
                </Card>
            </div>
        </div>
    </div>
</template>

<style lang="scss">
@import "resources/css/colors.scss";

.registration-page {
    .box {
        width: 100%;
        height: 100%;
        position: fixed;
        left: 0;
        right: 0;
        display: flex;
        justify-content: center;
        align-items: center;

        .inner {
            max-height: 50vh;

            .accsept {
                label {
                    margin-right: 5px;
                }
            }
            .btns {
                display: flex;
                // justify-content: space-between;
                > * {
                    width: 100%;
                    // margin: 0 5px;
                }
            }
        }
    }
}
</style>
