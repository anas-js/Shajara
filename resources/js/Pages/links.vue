<script setup lang="ts">
import Layout from "../Layouts/dash.vue";
import { Link, router } from "@inertiajs/vue3";
import { onMounted, ref } from "vue";
import { useConfirm } from "primevue/useconfirm";
import axios from "axios";
import { vars } from "../vars";

const props = defineProps({
    links: {
        type: Array,
        required: true,
    },
    total_links: {
        type: Number,
    },
    per: {
        type: String,
    },
    page: {
        type: String,
    },
});

const links = ref(
    props.links.map((link, i) => {
        link.index = (Number(props.page) - 1) * Number(props.per) + i + 1;
        return link;
    })
);

defineOptions({
    layout: Layout,
});

const confirm = useConfirm();

const linksPerPage = ref(Number(props.per));

onMounted(() => {
    console.log(links.value);
    // pagin.value.currentState.page = 3;

    // console.log( pagin.value);
});

const loading = ref(false);

const updateStatus = (e, id, index) => {
    loading.value = true;

    axios
        .post(`${vars.backend}/link/${id}/edit`, {
            status: e,
        })
        .then((_) => {
            loading.value = false;
        })
        .catch((_) => {
            links.value[index].status = !e;
            loading.value = false;
        });
};

const deleteLink = (id) => {
    loading.value = true;
    confirm.require({
        message: `هل انت متأكد من حذف هذا الرابط؟`,
        header: "تأكيد الحذف",
        icon: "pi pi-exclamation-triangle",
        rejectProps: {
            label: "الغاء",
            severity: "secondary",
            outlined: true,
        },
        acceptProps: {
            label: "حذف",
            severity: "danger",
        },
        accept: () => {
            axios
                .post(`${vars.backend}/link/${id}/remove`)
                .then((_) => {
                    // links.value = links.value.filter((e) => e.id !== id);
                    router.get(
                        "/dashboard/links",
                        {
                            page: Number(props.page),
                            per: Number(props.per),
                        },
                        {
                            onSuccess() {
                                loading.value = false;
                            },
                        }
                    );
                })
                .catch((_) => {
                    loading.value = false;
                });
        },
        reject: () => {
            loading.value = false;
        },
        onHide() {
            loading.value = false;
        },
    });
};

const updatePage = (page) => {
    loading.value = true;

    router.get(
        "/dashboard/links",
        {
            page: page.page + 1,
            per: page.rows,
        },
        {
            // preserveScroll : true,
            // preserveState: true,
            // onSuccess() {
            //     loading.value = false;
            // },
        }
    );

    // axios
    //     .get(`${vars.backend}/links/paginate`, {
    //         params: {
    //             page: page.page + 1,
    //             pre: page.rows,
    //         },
    //     })
    //     .then((res) => {
    //         // console.log(res.data);
    //         links.value = res.data.data.map((link, i) => {
    //             link.index = res.data.from + i;
    //             return link;
    //         });

    //         loading.value = false;
    //     })
    //     .catch((_) => {
    //         loading.value = false;
    //     });
};
</script>

<template>
    <div>
        <h1>الروابط</h1>
        <Link href="links/create/">
            <Button
                label="إنشاء رابط جديد"
                icon="pi pi-plus"
                style="margin-top: 10px"
            />
        </Link>
        <div class="table">
            <DataTable :value="links" :loading="loading">
                <Column header="#" bodyStyle="text-align:right">
                    <template #body="slotProps">
                        {{ slotProps.data.index }}
                    </template>
                </Column>

                <Column
                    field="url"
                    header="الرابط"
                    bodyStyle="text-align:right"
                    bodyClass="link"
                ></Column>
                <Column
                    field="clicks"
                    header="النقرات"
                    bodyStyle="text-align:right"
                    bodyClass="clicks"
                ></Column>
                <Column
                    field="icon"
                    header="الأيقونة"
                    bodyStyle="text-align:right"
                >
                    <template #body="slotProps">
                        <i class="icon" :class="slotProps.data.icon"></i>
                    </template>
                </Column>
                <Column
                    field="color"
                    header="اللون"
                    bodyStyle="text-align:right"
                >
                    <template #body="slotProps">
                        <ColorPicker v-model="slotProps.data.color" disabled />
                    </template>
                </Column>
                <Column
                    field="bg_color"
                    header="لون الخلفية"
                    bodyStyle="text-align:right"
                >
                    <template #body="slotProps">
                        <!-- {{ }} -->
                        <ColorPicker
                            v-model="slotProps.data.bg_color"
                            disabled
                        />
                    </template>
                </Column>

                <Column
                    bodyClass="status"
                    header="الحالة"
                    bodyStyle="text-align:center"
                >
                    <template #body="slotProps">
                        <div class="box-status">
                            <Tag
                                v-if="slotProps.data.status"
                                :value="slotProps.data.status ? 'علني' : 'مخفي'"
                                severity="success"
                                icon="pi pi-check"
                            />
                            <Tag
                                v-else
                                :value="slotProps.data.status ? 'علني' : 'مخفي'"
                                severity="danger"
                                icon="pi pi-times"
                            />

                            <ToggleSwitch
                                class="toogleStatus"
                                v-model="slotProps.data.status"
                                @update:modelValue="
                                    updateStatus(
                                        $event,
                                        slotProps.data.id,
                                        slotProps.index
                                    )
                                "
                            />
                        </div>

                        <!--   :severity="getSeverity(slotProps.data)" -->
                    </template>
                </Column>

                <Column
                    header="الإجراءات"
                    bodyStyle="text-align:center"
                    bodyClass="action"
                >
                    <template #body="slotProps">
                        <Link :href="`links/${slotProps.data.id}/edit`">
                            <Button icon="pi pi-pencil" severity="warn" text />
                        </Link>
                        <Button
                            icon="pi pi-trash"
                            severity="danger"
                            text
                            @click="deleteLink(slotProps.data.id)"
                        />
                    </template>
                </Column>

                <template #empty>
                    <p class="empty">لا يوجد اي روابط</p>
                </template>
                <template #footer v-if="total_links">
                    لديك
                    {{ total_links }} رابط
                </template>
                <!-- <template #paginatorfirstpagelinkicon>
                    <i class="pi pi-angle-double-right"></i>
                </template>
                <template #paginatorlastpagelinkicon>
                    <i class="pi pi-angle-double-left"></i>
                </template>
                <template #paginatornextpagelinkicon>
                    <i class="pi pi-angle-left"></i>
                </template>
                <template #paginatorprevpagelinkicon>
                    <i class="pi pi-angle-right"></i>
                 </template> -->
            </DataTable>
            <Paginator
                :rows="linksPerPage"
                :totalRecords="total_links"
                :rowsPerPageOptions="[10, 20, 30]"
                :first="(Number(props.page) - 1) * Number(props.per)"
                @page="updatePage"
                v-show="!loading"
            >
                <template #firsticon>
                    <i class="pi pi-angle-double-right"></i>
                </template>
                <template #lasticon>
                    <i class="pi pi-angle-double-left"></i>
                </template>
                <template #nexticon>
                    <i class="pi pi-angle-left"></i>
                </template>
                <template #previcon>
                    <i class="pi pi-angle-right"></i>
                </template>
            </Paginator>
        </div>
        <ConfirmDialog></ConfirmDialog>
    </div>
</template>

<style lang="scss">
@import "resources/css/colors.scss";
.table {
    border-radius: 25px;
    overflow: hidden;
    color: $color_c;

    .p-datatable-header-cell {
        background: $background;
    }

    .p-datatable-tbody > tr {
        background: $background;
    }

    .empty {
        text-align: center;
        padding: 20px 0;
    }
    .p-disabled,
    .p-component:disabled {
        opacity: 1;
    }
    .icon {
        font-size: 20px;
        color: $color_black_a;
    }

    .link {
        // overflow-wrap: anywhere;
        // max-width:200px
        width: 50%;
    }
    .action {
        width: 200px;
        button {
            margin: 6px;
        }
    }

    .status {
        .box-status {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
        }
        .toogleStatus {
            margin: 5px;
        }
    }
}
</style>
