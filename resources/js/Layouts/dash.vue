<script setup lang="ts">
import { ref, watch } from "vue";
import { Link } from "@inertiajs/vue3";
import { usePage } from "@inertiajs/vue3";
import { vars } from "../vars";
import cookie from "js-cookie";
import anime from "animejs";
import type { Ref } from "vue";
// const home = ref({
//     icon: "pi pi-home",
// });

// { , paths: [{ label: "الروابط" }] }
const pathTabel = {
    dashboard: {
        label: "لوحة التحكم",
        route: "/dashboard",
        icon: "pi pi-home",
        paths: {
            links: {
                label: "الروابط",
                icon: "pi pi-link",
                route: "/dashboard/links",
                paths: {
                    edit: {
                        label: "تعديل",
                        icon: "pi pi-pencil",
                    },
                    create: {
                        label: "جديد",
                        icon: "pi pi-plus",
                    },
                },
            },
        },
    },
};

const page = usePage();

 console.log(page.props.auth);

function getPaths() {
    const paths = [];
    const url = page.url.split("/");
    url.splice(0, 1);

    let cruuPath = { paths: pathTabel };
    let deep = 0;
    let path = null;

    while (deep < url.length) {
        path = url[deep];

        // console.log(cruuPath?.paths, path);
        let isFind = cruuPath?.paths ? cruuPath?.paths[path] : false;

        cruuPath = isFind ? cruuPath?.paths[path] : cruuPath;

        if (cruuPath && isFind) {
            const push = JSON.parse(JSON.stringify(cruuPath));
            delete push.paths;
            paths.push(push);
        }
        deep++;
    }

    return paths;
}

const paths = ref(getPaths());

watch(
    () => page.url,
    function (newv) {
        paths.value = getPaths();
    }
);

const userMenuRef = ref();

const toggle = (event) => {
    userMenuRef.value.toggle(event);
};

const userMenu = ref([
    {
        label: "سريع",
        items: [
            {
                label: "صفحتي",
                url: `${vars.shajara}/${page.props.auth.user.username}`,
                target: "_blank",
                icon: "pi pi-external-link",
                // url :
            },
            {
                label: "حسابي",
                url: vars.juzr + "/account",
                icon: "pi pi-user",
            },
        ],
    },
    {
        label: "حسابي",
        items: [
            {
                label: "تسجيل الخروج",
                icon: "pi pi-sign-out",
                click: () => {
                    cookie.set("logout", JSON.stringify([]), {
                        domain: vars.domain.juzr,
                        expires: 7,
                    });
                    window.location.href = vars.juzr + "/logout";
                },
            },
        ],
    },

    // { label: "Computer", icon: "pi pi-home" },
]);
// cookie.set("logout", JSON.stringify(logoutCookie), {
//       domain: $app().domain.juzr,
//       expires: 7
//     });
const dashboardList = ref([
    {
        label: "لوحة التحكم",
        route: "/dashboard",
        icon: "pi pi-user",
    },
    {
        label: "الروابط",
        route: "/dashboard/links",
        icon: "pi pi-external-link",
        start: true,
    },
]);

const showListMobile = ref(false);
const listMobile = ref() as Ref<HTMLDivElement>;

let listMobileAnime: null | anime.AnimeInstance = null;

function toogleListMobile() {
    if(window.innerWidth > 750) {
        return;
    }
    if (!listMobileAnime) {
        listMobileAnime = anime({
            targets: listMobile.value,
            // right: ['100%',"0%"],
            duration : 800,
            translateX : ['100%',"0%"],
            autoplay: false,
        });
    }

    if (showListMobile.value || listMobileAnime.reversed) {
        listMobileAnime.reverse();
    }
    listMobileAnime.play();

    showListMobile.value = !showListMobile.value;

}
</script>

<template>
    <div class="dash-layout">
        <div class="list" ref="listMobile">
            <!-- <h1>شجرة</h1> -->
            <button class="list-btn-toggle" @click="toogleListMobile">
                <i v-if="!showListMobile" class="ri-menu-3-line"></i>
                <i v-else class="ri-close-large-line"></i>
            </button>
            <Link href="/"
                ><img class="logo" :src="`/images/logo-lite.svg`" alt="logo"
            /></Link>
            <div class="content">
                <Menu :model="dashboardList" class="dashboard-menu">
                    <template #item="{ item, props }">
                        <Link
                         @click="toogleListMobile"
                            v-if="item.route"
                            :href="item.route"
                            v-bind="props.action"
                            :class="{
                                active: item.start
                                    ? $page.url.startsWith(item.route)
                                    : $page.url === item.route,
                            }"
                            custom
                        >
                            <!-- <a
                                v-ripple
                                :href="href"


                            > -->
                            <span :class="item.icon" />
                            <span class="ml-2">{{ item.label }}</span>
                        </Link>
                        <a
                         @click="toogleListMobile"
                            v-else
                            v-ripple
                            :href="item.url"
                            v-bind="props.action"
                            :class="{ active: $page.url.startsWith('/users') }"
                        >
                            <span :class="item.icon" />
                            <span class="ml-2">{{ item.label }}</span>
                        </a>
                    </template>
                </Menu>
            </div>
        </div>
        <div class="content" scroll-region>
            <div class="top">

                <Breadcrumb :model="paths">
                    <template v-slot:separator>
                        <i class="pi pi-angle-left"></i>
                    </template>
                    <template #item="{ item, props }">
                        <Link
                            v-if="item.route"
                            :href="item.route"
                            v-bind="props.action"
                            custom
                        >
                            <span :class="[item.icon, 'text-color']" />
                            <span class="text-primary font-semibold">{{
                                item.label
                            }}</span>
                        </Link>
                        <a
                            v-else
                            :href="item.url"
                            :target="item.target"
                            v-bind="props.action"
                        >
                            <span :class="[item.icon, 'text-color']" />
                            <span
                                class="text-surface-700 dark:text-surface-0"
                                >{{ item.label }}</span
                            >
                        </a>
                    </template>
                </Breadcrumb>

                <div class="listUser">
                    <Avatar
                        :image="page.props.auth.user.image_src"
                        shape="circle"
                        size="large"
                        @click="toggle"
                    />
                    <Menu
                        class="munuUser"
                        ref="userMenuRef"
                        :model="userMenu"
                        :popup="true"
                    >
                        <template #item="{ item, props }">
                            <a
                                v-ripple
                                class="flex items-center"
                                v-bind="props.action"
                                :href="item.url"
                                :target="item.target"
                                v-if="item.click"
                                @click="item.click"
                            >
                                <span :class="item.icon" />
                                <span>{{ item.label }}</span>
                                <Badge
                                    v-if="item.badge"
                                    class="ml-auto"
                                    :value="item.badge"
                                />
                                <span
                                    v-if="item.shortcut"
                                    class="ml-auto border border-surface rounded bg-emphasis text-muted-color text-xs p-1"
                                    >{{ item.shortcut }}</span
                                >
                            </a>
                            <Link
                                v-else-if="item.route"
                                :href="item.route"
                                :target="item.target"
                                v-bind="props.action"
                                custom
                            >
                                <!-- <a
                                v-ripple
                                :href="href"


                            > -->
                                <span :class="item.icon" />
                                <span class="ml-2">{{ item.label }}</span>
                            </Link>
                            <a
                                v-ripple
                                class="flex items-center"
                                v-bind="props.action"
                                :href="item.url"
                                :target="item.target"
                                v-else
                            >
                                <span :class="item.icon" />
                                <span>{{ item.label }}</span>
                                <Badge
                                    v-if="item.badge"
                                    class="ml-auto"
                                    :value="item.badge"
                                />
                                <span
                                    v-if="item.shortcut"
                                    class="ml-auto border border-surface rounded bg-emphasis text-muted-color text-xs p-1"
                                    >{{ item.shortcut }}</span
                                >
                            </a>
                        </template>
                    </Menu>
                </div>
            </div>

            <button class="list-btn-toggle" @click="toogleListMobile">
                <i v-if="!showListMobile" class="ri-menu-3-line"></i>
                <i v-else class="ri-close-large-line"></i>
            </button>


            <Message severity="warn" v-if="page.props.auth.user.isBlocked">تم حضر حسابك لوجود مخالفات, يرجى التواصل معنا <a target="_blank" href="https://www.instagram.com/juzr.official">من هنا</a></Message>
            <slot></slot>
        </div>
    </div>
</template>
