<script setup lang="ts">
import Layout from "../Layouts/dash.vue";
// import { Head } from '@inertiajs/vue3'
import { ref } from "vue";

defineProps({
    views: {
        type: Number,
    },
    clicks: {
        type: Number,
    },
});

defineOptions({
    layout: Layout,
});
</script>

<template>
    <div>
        <h1>مرحباً</h1>
        <div class="statics">
            <h2>إحصائيات صفحتك</h2>

            <div class="boxs">
                <div class="box">
                    <div class="box-content">
                        <p>المشاهدات</p>
                        <span>{{ views }}</span>
                        <i class="icon pi pi-eye"></i>
                    </div>
                    <span class="wall"></span>
                </div>

                <div class="box">
                    <div class="box-content">
                        <p>النقرات</p>
                        <span>{{ clicks }}</span>
                        <i class="icon pi pi-arrow-up-right"></i>
                    </div>
                    <span class="wall"></span>
                </div>
            </div>
        </div>
    </div>
</template>

<style lang="scss">
@import "resources/css/colors.scss";
.statics {
    margin-top: 10px;
}

.boxs {
    display: flex;
    margin-top: 10px;
    flex-wrap: wrap;
    .box {
        // display: inline-block;
        min-width: 300px;
        position: relative;

        margin-top: 10px;
        // &:not(:first-of-type) {

        // }

        font-size: 20px;
        background-color: $color_a_lite;
        margin-left: 10px;
        border-radius: 34px;
        color: $color_a;
        overflow: hidden;
        z-index: 0;

        p,
        span {
            font-size: 17px;
            font-weight: 500;
        }

        > .box-content {
            padding: 30px;
            // backdrop-filter: blur(50px);
        }

        span {
            font-size: 57px;
            color: $color_a;
        }

        .icon {
            position: absolute;
            bottom: -15px;
            left: 3px;
            font-size: 69px;
            color: rgba($color: $color_d, $alpha: 0.8);
            // z-index: 1;
        }

        .wall {
            position: absolute;
            bottom: -55px;
            left: -33px;

            font-size: 69px;
            width: 137px;
            height: 137px;
            border-radius: 50%;
            background-color: $color_a;
            z-index: -1;
        }
    }
}

@media (max-width: 550px) {
    .boxs .box {
        width: 100%;
        min-width: 100%;
    }
}
</style>
