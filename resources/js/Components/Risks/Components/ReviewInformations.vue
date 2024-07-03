<script>
export default {
    props: {
        lastReview: {
            type: String,
            required: true,
        },
        evaluationFrequency: {
            type: Number, 
            required: true,
        },
    },
    methods: {
        getReviewInformations(lastReview, evaluationFrequency) {
            const lastReviewDate = new Date(lastReview);
            const nextReviewDate = new Date(
                lastReviewDate.getTime() + evaluationFrequency * 1000
            );

            const currentDate = new Date();

            if (currentDate.getTime() > nextReviewDate.getTime()) {
                return 0;
            } else {
                const days = Math.floor(
                    (nextReviewDate.getTime() - currentDate.getTime()) /
                        (1000 * 60 * 60 * 24)
                );

                if (days < 1) {
                    return "moins d'un jour";
                } else if (days === 1) {
                    return "1 jour";
                } else if (days < 7) {
                    return `${days} jours`;
                } else if (days < 30) {
                    const weeks = Math.floor(days / 7);
                    return weeks === 1 ? "1 semaine" : `${weeks} semaines`;
                } else if (days < 365) {
                    const months = Math.floor(days / 30);
                    return months === 1 ? "1 mois" : `${months} mois`;
                } else {
                    const years = Math.floor(days / 365);
                    return years === 1 ? "1 an" : `${years} ans`;
                }
            }
        },
    },
    data() {
        return {
            nextReview: "",
        };
    },
    mounted() {
        this.nextReview = this.getReviewInformations(
            this.lastReview,
            this.evaluationFrequency
        );
    },
};
</script>
<template>
    <span v-if="nextReview === 0" class="text-red">Doit être réévalué</span>
    <span v-else class="text-green"
        >Prochaine évaluation dans {{ nextReview }}
    </span>
</template>
