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
            dateFormatter : new Intl.DateTimeFormat('fr-FR', {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            }),
        }
    }

};
</script>
<template>
    <span>{{ dateFormatter.format(new Date(date * 1000)) }}</span>
</template>
