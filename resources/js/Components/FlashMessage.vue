<script setup>
</script>

<template>
    <div v-if="$page.props.flash.status" :class="`${$page.props.flash.status == 'success' ? 'bg-blue-500' : 'bg-red-500'} text-white pl-2 text-lg`">
    {{ $page.props.flash.message }}
    </div>
</template>