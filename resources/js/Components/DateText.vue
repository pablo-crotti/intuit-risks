<script>
export default {
    props: {
        date: {
            type: String,
            required: true,
        },
    },
    data: function(){
        return {
            formatDate(dateString) {
            const options = { day: 'numeric', month: 'long', year: 'numeric' };
            const date = new Date(dateString);
            return date.toLocaleDateString('fr-FR', options);
        }
        }
    },

};
</script>
<template>
     <span>{{ formatDate(date) }}</span>
</template>
