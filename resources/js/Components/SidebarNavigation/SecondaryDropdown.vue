<script setup>
import { ref, watch } from "vue";

const props = defineProps({
    title: {
        type: String,
        required: true,
    },
    iconClass: {
        type: String,
        default: "",
    },
    links: {
        type: Array,
        default: () => [],
    },
    isActive: {
        type: Boolean,
        default: false,
    },
    parentIsExpanded: {
        type: Boolean,
        default: true,
    },
});

const isExpanded = ref(props.isActive);
const subMenuHeight = ref(0);
const subMenu = ref(null);

const toggleMenu = () => {
    if (!subMenu.value) return;
    isExpanded.value = !isExpanded.value;
    subMenuHeight.value = isExpanded.value ? subMenu.value.scrollHeight : 0;
};

watch(
    () => props.parentIsExpanded,
    (newValue) => {
        if (!newValue) {
            isExpanded.value = true;
            subMenuHeight.value = isExpanded.value
                ? subMenu.value.scrollHeight
                : subMenu.value.scrollHeight;
        }
    }
);
</script>

<template>
    <div>
        <a
            href="javascript:;"
            @click.prevent="toggleMenu"
            :class="[
                'py-2.5 px-4 pl-6 ml-5 mt-0.75 rounded-2  flex items-center text-sm transition-all',
                isExpanded
                    ? 'text-slate-800 dark:text-white font-semibold bg-blue-500/30'
                    : 'text-slate-600 dark:text-white/50',
            ]"
        >
            {{ title }}
            <i
                class="ml-auto fas text-sm transition-transform duration-200 ease-in-out"
                :class="[isExpanded ? 'fa-arrow-up' : 'fa-arrow-down']"
            ></i>
        </a>

        <div
            ref="subMenu"
            :style="{ maxHeight: isExpanded ? `${subMenuHeight}px` : '0px' }"
            class="overflow-hidden pl-20 transition-all duration-300 ease-in-out"
        >
            <ul class="list-none">
                <li v-for="(link, index) in links" :key="index">
                    <a
                        :href="link.href"
                        :class="[
                            'py-2.7 text-sm transition-all ',
                            link.isActive
                                ? 'text-slate-800 dark:text-white font-semibold'
                                : 'text-slate-700 dark:text-white/50',
                        ]"
                    >
                        {{ link.title }}
                    </a>
                </li>
            </ul>
        </div>
    </div>
</template>
