<script>
export default {
    props: {
        lastReview: {
            type: String,
            required: true,
        },
        evaluationFrequency: {
            type: String,
            required: true,
        },
    },
    methods: {
        getReviewInformations(lastReview, evaluationFrequency) {
            const lastReviewDate = new Date(lastReview * 1000);
            const nextReviewDate = new Date(
                lastReviewDate.getTime() + evaluationFrequency * 1000
            );
            const currentDate = new Date();

            if (currentDate.getTime() > nextReviewDate.getTime()) {
                return 0;
            } else {
                return Math.floor((nextReviewDate.getTime() - currentDate.getTime()) / (1000 * 60 * 60 * 24));
            }
        }
    },
    data: function() {
        return {
            days: 0,
        }
    },
    mounted() {
        this.days = this.getReviewInformations(this.lastReview, this.evaluationFrequency);
    },
};
</script>
<template>
        <span v-if="days === 0" class="text-red">Doit être réévalué</span>
        <span v-else class="text-green">Prochaine évaluation dans {{ days }} jours</span>
</template>
