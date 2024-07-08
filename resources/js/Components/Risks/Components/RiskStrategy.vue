<script>
    export default {
        props: {
            strategy: {
                type: String,
                required: true,
            },
        },
    };
</script>
<template>
    <span v-if="strategy == 'Supprimer'" class="bg-red block text-center min-w-max text-white px-2 py-1 rounded-md">{{ strategy }}</span>
    <span v-if="strategy == 'Diminuer'" class="bg-orange block text-center min-w-max text-white px-2 py-1 rounded-md">{{ strategy }}</span>
    <span v-if="strategy == 'Veiller'" class="bg-blue block text-center min-w-max text-white px-2 py-1 rounded-md">{{ strategy }}</span>
    <span v-if="strategy == 'Accepter'" class="bg-green block text-center min-w-max text-white px-2 py-1 rounded-md">{{ strategy }}</span>
</template>
<!-- <style>
* {
    background-color: #129bbd;
}
</style> -->