<template>
<div class="mt-3 ml-5 mb-5">

<nav class="breadcrumb" aria-label="breadcrumbs">
    <ul>
        <li 
        v-for="(crumb, index) in crumbs" :key="crumb + '-' + index"
        :class="{ 'is-active': index + 1 == crumbs.length }"
        >
            <RouterLink :to="{name: crumb[0]}">{{ crumb[1] }}</RouterLink>
        </li>
    </ul>
</nav>

</div>
</template>

<script>
export default {
    props: ['crumbs']
}
</script>

<style>

</style>