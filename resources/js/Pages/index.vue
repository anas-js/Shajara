<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import { vars } from "../vars";
import Typed from "typed.js";
import { onMounted, ref } from "vue";

const user = ref();
onMounted(() => {
    const typed = new Typed(user.value, {
        strings: ["ameer", "asma", "ahmed", "aseel", "anas"],
        typeSpeed: 100,
        backSpeed: 50,
        startDelay: 500,
        loop: true,
        // smartBackspace : false,
        backDelay: 1500,
    });
});
</script>

<template>
    <div class="index-page">
        <div class="sha-container">
            <div class="rigth">
                <img class="logo" :src="`/images/logo.svg`" />
                <div class="text">
                    <p class="ex">
                        <!-- <strong ref="user">anas</strong
                        ><span>.shajara.juzr.sa</span> -->
                        shajara.juzr.sa/@<strong ref="user">anas</strong>
                    </p>
                    <h1>روابطك تحتاج تكون في مكان مميز!</h1>
                    <a href="/dashboard"
                        >مشينا <i class="ri-arrow-left-line"></i
                    ></a>
                </div>
                <div class="from-juzr">
                    <p>إحدى منصات</p>
                    <a :href="vars.juzr" target="_blank">
                        <img :src="`${vars.juzr}/images/juzr-black.png`"
                    /></a>
                </div>
            </div>
            <div class="left">
                <a
                    href="https://shajara.juzr.sa/@anas"
                    target="_blank"
                    class="green-layout"
                >
                    <div>
                        <i class="ri-arrow-left-line"></i>
                        <p>شف مثال</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</template>

<style lang="scss" scoped>
@import "resources/css/colors.scss";

.index-page {
    a {
        text-decoration: none;
    }
    background-color: rgba($color: $color_b, $alpha: 0.3);
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;

    .sha-container {
        // padding: 30px 0px;
        width: 960px;
        display: flex;
        // margin: 0 auto;
        > * {
            width: 100%;
            // height: 100%
        }
        .rigth {
            .logo {
                width: 150px;
                margin-bottom: 5px;
            }
            .text {
                .ex {
                    direction: ltr;
                    text-align: right;
                    margin-bottom: -15px;
                    font-size: 20px;
                    color: $color_a;
                    font-weight: bold;
                    font-family: "Outfit" !important;
                    span {
                        color: $color_c;
                    }

                    strong {
                        display: inline-block;
                        font-size: 30px;
                    }

                    * {
                        font-family: "Outfit" !important;
                    }
                }
                h1 {
                    font-size: 60px;
                    font-weight: bold;
                    color: $color_c;
                }

                a {
                    display: inline-block;
                    background-color: $color_a;
                    color: $color_b;
                    border: none;
                    padding: 10px 15px;
                    // border: 5px solid $color_a;
                    margin-top: 24px;
                    font-size: 20px;
                    border-radius: 19px;
                    cursor: pointer;
                    position: relative;

                    &::before {
                        content: "";
                        visibility: hidden;
                        opacity: 0;
                        position: absolute;
                        width: 90%;
                        border-radius: 25px;
                        height: 80%;
                        border: 5px solid rgba($color: $color_a, $alpha: 0.5);
                        left: 50%;
                        transform: translate(-50%, -50%);
                        top: 50%;
                        transition: 0.2s;

                        // border: 5px solid $color_b;
                    }

                    &:hover::before {
                        visibility: visible;
                        opacity: 1;
                        width: 100%;
                        height: 100%;
                    }
                    i {
                        margin-right: 10px;
                    }
                }
            }

            .from-juzr {
                margin-top: 28px;

                p {
                    font-weight: 200;
                    font-size: 17px;
                }
                img {
                    width: 60px;
                    display: block;
                    margin-top: 5px;
                }
            }
        }

        .left {
            display: flex;
            justify-content: end;

            .green-layout {
                cursor: pointer;
                position: relative;
                width: 250px;
                height: 100%;
                border-radius: 200px;
                display: flex;
                justify-self: center;
                align-items: center;
                background-color: $color_a;
                text-align: center;
                color: $color_b;

                // .ex {
                //     top: 0;
                //     left: 50%;
                //     transform: translateX(-50%);
                //     position: absolute;
                //     font-size: 20px;
                //     color: $color_a;
                // }

                > div {
                    width: 100%;

                    i {
                        display: block;
                        font-size: 100px;
                    }
                }
            }
        }
    }
}

@media (max-width: 1000px) {
    .index-page {
        .sha-container {
            width: 90%;
        }
    }
}

@media (max-width: 730px) {
    .index-page {
        .sha-container {
            // height: 95%;
            // align-items: center;
            flex-wrap: wrap;
            > * {
                // width: 100%;
                // flex: 1;
            }

            .left {
                margin-top: 50px;
                .green-layout {
                    width: 100%;
                    height: 250px;
                }
            }
        }
    }
}

@media (max-height: 810px) and (max-width: 730px), (max-height: 425px) {
    .index-page {
        align-items: start;
        width: 100%;
        height: 100%;
        left: 0;
        top: 0;
        position: fixed;
        overflow: auto;
        padding: 20px 0;
    }
}

// @media (max-height: 425px) {
//     .index-page {
//         align-items: start;
//         width: 100%;
//         height: 100%;
//         left: 0;
//         top: 0;
//         position: fixed;
//         overflow: auto;
//         padding: 20px 0;
//     }
// }
</style>
