<script>
export default {
    props: {
        type: {
            type: String,
            required: true,
        },
        value: {
            type: Number,
            required: true,
        },
    },
    methods: {
        getTooltipText(value) {

            if (this.type === "probability") {
                switch (value) {
                    case 1:
                        return "Peu probable";
                        break;

                    default:
                    case 2:
                        return "Possible";
                        break;
                    case 3:
                        return "Probable";
                        break;
                    case 4:
                        return "Très probable";
                        break;
                }
            } else if (this.type === "impact") {
                switch (value) {
                    case 1:
                        return "Mineur";
                        break;
                    case 2:
                        return "Significatif";
                        break;
                    case 3:
                        return "Important";
                        break;
                    case 4:
                        return "Majeur";
                        break;
                }
            }
        },
    },
};
</script>
<template>
    <span :class="`text-white px-4 py-0 rounded-md ${value == 1 ? 'bg-green' : value == 2 ? 'bg-yellow' : value == 3 ? 'bg-orange' : 'bg-red'}`">{{ value }} {{getTooltipText(value)}}</span>
</template>
