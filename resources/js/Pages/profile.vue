<script lang="ts" setup>
import { onMounted, ref, nextTick, type Ref } from "vue";
import { Link } from "@inertiajs/vue3";
import anime from "animejs";
import "particles.js/particles";
import axios from "axios";
import { vars } from "../vars";
import cookie from "js-cookie";

const props = defineProps({
    profile: {
        type: Object,
        required: true,
    },
    links: Array,
});


// console.log(props.profile);

nextTick(function () {
    setTimeout(() => {
        load.value = true;
    }, 200);
});

const load = ref(false);
const show = ref(false);

const image = ref();
const name = ref();
const bg = ref();
const links = ref();

const moveBtn = ref() as Ref<HTMLDivElement>;
const boxLinks = ref() as Ref<HTMLDivElement>;
const spans = ref() as Ref<HTMLDivElement>;
const moved = ref();

onMounted(function () {
    // console.log(particles);
    window.particlesJS("particles-js", {
        particles: {
            number: {
                value: 30,
                density: {
                    enable: true,
                    value_area: 800,
                },
            },
            color: {
                value: "#ffffff",
            },
            shape: {
                type: "circle",
                stroke: {
                    width: 0,
                    color: "#000000",
                },
                polygon: {
                    nb_sides: 5,
                },
                image: {
                    src: "img/github.svg",
                    width: 100,
                    height: 100,
                },
            },
            opacity: {
                value: 0.5,
                random: false,
                anim: {
                    enable: false,
                    speed: 1,
                    opacity_min: 0.1,
                    sync: false,
                },
            },
            size: {
                value: 5,
                random: true,
                anim: {
                    enable: false,
                    speed: 40,
                    size_min: 0.1,
                    sync: false,
                },
            },
            line_linked: {
                enable: true,
                distance: 150,
                color: "#ffffff",
                opacity: 0.4,
                width: 1,
            },
            move: {
                enable: true,
                speed: 6,
                direction: "none",
                random: false,
                straight: false,
                out_mode: "out",
                attract: {
                    enable: false,
                    rotateX: 600,
                    rotateY: 1200,
                },
            },
        },
        interactivity: {
            detect_on: "canvas",
            events: {
                onhover: {
                    enable: true,
                    mode: "repulse",
                },
                onclick: {
                    enable: true,
                    mode: "push",
                },
                resize: true,
            },
            modes: {
                grab: {
                    distance: 400,
                    line_linked: {
                        opacity: 1,
                    },
                },
                bubble: {
                    distance: 400,
                    size: 40,
                    duration: 2,
                    opacity: 8,
                    speed: 3,
                },
                repulse: {
                    distance: 200,
                },
                push: {
                    particles_nb: 4,
                },
                remove: {
                    particles_nb: 2,
                },
            },
        },
        retina_detect: true,
        config_demo: {
            hide_card: false,
            background_color: "#b61924",
            background_image: "",
            background_position: "50% 50%",
            background_repeat: "no-repeat",
            background_size: "cover",
        },
    });
    // window.particlesJs('particles-js', "");

    //     particlesJS.load('particles-js', 'assets/particles.json', function() {
    //   console.log('callback - particles-js config loaded');
    // });
});

let timeline = anime.timeline({
    duration: 1000,
    easing: "easeOutExpo",
    autoplay: false,
});

let size = [] as any;

const colors = [
    ["211951", "836FFF", "15F5BA", "525CEB"],
    ["B6FFFA", "98E4FF", "80B3FF", "687EFF"],
    ["04364A", "176B87", "64CCC5", "DAFFFB"],
    ["FFF5E0", "FF6969", "C70039", "141E46"],
][anime.random(0, 3)];

function Rand() {
    anime({
        targets: moved.value.querySelectorAll("span"),
        width() {
            return `${anime.random(0, 100)}%`;
        },
        height() {
            return `${anime.random(0, 100)}%`;
        },
        top() {
            return `${anime.random(0, 100)}%`;
        },
        left() {
            return `${anime.random(0, 100)}%`;
        },
        duration: 3000,
        backgroundColor(el, i) {
            return `#${colors[anime.random(0, colors.length - 1)]}`;
        },
        easing: "easeInOutSine",
        // loop: true,
    });
}

onMounted(function () {
    anime({
        targets: spans.value.querySelectorAll("span"),

        backgroundColor(el, i) {
            return `#${colors[i]}`;
        },
        easing: "easeInOutSine",
    });

    // setInterval(() => {
    //     Rand();
    // }, 3000);

    timeline.add({
        targets: image.value,
        scale: 10,
        delay: anime.stagger(100),
        opacity: 0,
        easing: "easeOutInExpo",
        duration: 500
    });

    timeline.add(
        {
            targets: name.value,
            translateY: [
                {
                    value: -170,
                    delay: 200,
                },
            ],

            // letterSpacing: [
            //     { value: "50px", duration: 600, delay: 1000 },
            //     { value: "0px" },
            // ],
            filter: [
                { value: "blur(0px)" ,duration: 100},
                { value: "blur(2px)", duration: 1000},
                { value: "blur(0px)" },
            ],
            // opacity: [
            //     {
            //         value: 1,
            //     },
            //     {
            //         value: 0.2,
            //         // duration: 200
            //     },
            //     {
            //         value: 1,
            //     },
            // ],
            color: [
                {
                    value: "#000000",
                    delay: 800,
                },
            ],
            easing: "easeInOutCubic",
        },
        "-=800"
    );

    timeline.add(
        {
            targets: bg.value,
            clipPath: "circle(100%)",
            duration: 500,
            easing: "easeOutInExpo",
        },
        "-=1100"
    );

    timeline.add(
        {
            targets: links.value,
            opacity: 1,
            duration: 1000,
            delay: anime.stagger(100),
            top: 0,
            easing: "easeOutExpo",
            // begin() {
            //

            // },
            // loopBegin() {
            //     console.log("run");
            // },
            update({ progress }) {
                if (progress > 1) {
                    boxLinks.value.classList.add("active");
                } else {
                    boxLinks.value.classList.remove("active");
                }
                // console.log(progress);
            },
            // changeBegin() {
            //     console.log("run");
            //     boxLinks.value.classList.toggle("active");
            //     // console.log("chcange")
            // }
        },
        1200
    );

    timeline.add(
        {
            targets: moveBtn.value,
            translateY: -300,
            // delay : 2000,
            easing: "easeInOutElastic(1, .6)",

        },
        "-=2000"
    );
});

function toggleLinks() {
    if (show.value || timeline.reversed) {
        timeline.reverse();
    }
    timeline.play();

    show.value = !show.value;
}

async function goToLink(link: any) {
    // console.log(link);

    await axios.post(`${vars.backend}/link/${link.id}/click`,null,{
        // headers : {
        //     "X-XSRF-TOKEN" : cookie.get('XSRF-TOKEN')
        // },
        withCredentials  :true,
        withXSRFToken : true
    }).catch((e) => {});
    window.location.href = link.url;
}
</script>

<template>
    <div class="profile-page">
        <div>
            <div class="loading" :class="{ load: load }">
                <div>
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </div>

        <div class="backg-main">
            <div id="particles-js"></div>
            <div class="backg-elemenets">
                <div class="panel"></div>
                <div ref="spans" class="spans">
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    <!-- <span></span> -->
                </div>
                <!-- <div ref="moved" class="moved">
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                </div> -->
            </div>
        </div>
        <div class="main">
            <div>
                <div class="main-img">
                    <img
                        ref="image"
                        :src="profile.image_src"
                        alt="profile img"
                    />
                    <span class="anmite-img"></span>
                </div>

                <h1 ref="name">{{ props.profile.name }}</h1>

                <div @click="toggleLinks" class="tolinks">
                    <i
                        ref="moveBtn"
                        class="ri-arrow-down-line"
                        :class="{ 'ri-close-line': show }"
                    ></i>
                    <span ref="bg" class="click-anime"></span>
                </div>
            </div>

            <div class="link" ref="boxLinks">
                <a
                    ref="links"
                    v-for="link in profile.links"
                    :href="link.url"
                    target="_blank"
                    @click.prevent="goToLink(link)"
                    :style="`color:#${link.color};background-color:#${link.bg_color}`"
                >
                    <i :class="link.icon"></i>
                </a>
            </div>
        </div>

        <div class="from-app">
        <div class="group">
        <p class="by">بــــــــــــــــواسطة</p>
            <Link href="/"
                ><img class="logo" :src="`/images/logo.svg`" alt="logo"
            /></Link>

        </div>
        </div>
    </div>
</template>

<style lang="scss" scoped>
@import "resources/css/profile.scss";
@import "resources/css/res.scss";
</style>
