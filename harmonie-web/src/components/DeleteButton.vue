<template>
    <div class="column is-2">      
        <transition name="slide-fade" mode="out-in">
        
        <div v-if="!deleteConfirm" class="columns">
            <div class="column p-1">
            <button class="button is-fullwidth" @click="$emit('edit')">
            <span class="icon">
                <i class="fa-solid fa-pen"></i>
            </span>
            </button>
        </div>
        <div class="column p-1">
            <button v-if="!deleteConfirm" class="button is-danger is-light is-fullwidth" @click="deleteConfirm = !deleteConfirm">
            <span class="icon">
                <i class="fa-solid fa-trash"></i>
            </span>
            </button>
        </div>
        </div>

        <div v-else class="columns">
            <div class="column p-1">
            <button class="button is-danger is-fullwidth is-light" @click="$emit('delete')">
                <span class="icon">
                <i class="fa-solid fa-trash"></i>
                </span>
            </button>
            </div>
            <div class="column p-1">
            <button class="button is-fullwidth" @click="deleteConfirm = !deleteConfirm">
                <span class="icon">
                <i class="fa-solid fa-ban"></i>
                </span>
            </button>
            </div>
        </div>

        </transition>
    </div>
</template>
<script>
export default {
    data() {
        return {
            deleteConfirm: false,
        }
    },
}
</script>
<style lang="">
    
</style>