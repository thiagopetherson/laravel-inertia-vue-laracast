<template>
    <nav class="pagination flex justify-end">
        <Component
            :is="link.url ? 'Link' : 'span'"
            v-for="link in links"
            v-html="link.label"
            :href="link.url"
            :key="link.label"
            class="px-1"
            :class="{ 'text-gray-500': !link.url, 'font-bold': link.active }"
            preserve-scroll
        >
        </Component>
    </nav>
</template>

<script>
export default {
    props: {
        links: Array
    }
};
</script>
