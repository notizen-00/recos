<script setup>
const props = defineProps({
    label: String,
    type: String, // blue, slate, cyan, emerald, red, orange, gray, dark
})

let colorFrom = '',
    colorTo = '';
switch (props.type){
    case "slate":
        colorFrom = 'from-slate-600';
        colorTo = 'to-slate-300';
        break;
    case "cyan":
        colorFrom = 'from-blue-700';
        colorTo = 'to-cyan-500';
        break;
    case "emerald":
        colorFrom = 'from-emerald-500';
        colorTo = 'to-teal-400';
        break;
    case "red":
        colorFrom = 'from-red-600';
        colorTo = 'to-orange-600';
        break;
    case "orange":
        colorFrom = 'from-orange-500';
        colorTo = 'to-yellow-500';
        break;
    case "gray":
        colorFrom = 'from-gray-400';
        colorTo = 'to-gray-100';
        break;
    case "dark":
        colorFrom = 'from-zinc-800';
        colorTo = 'to-zinc-700';
        break;
    default:
        colorFrom = 'from-blue-500';
        colorTo = 'to-violet-500';
        break;
}

</script>

<template>
    <span v-bind="$attrs" :class="`py-1.4 px-2.5 text-xs rounded-1.8 inline-block whitespace-nowrap text-center bg-gradient-to-tl ${colorFrom} ${colorTo} align-baseline font-bold uppercase leading-none text-white`">{{ props.label }}</span>
</template>

<style scoped>

</style>
