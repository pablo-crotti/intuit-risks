<script>
import UserImgPlaceholder from "../Icons/UserImgPlaceholder.vue";

export default {
    props: {
        user_name: {
            type: String,
            default: "User Name",
        },
    },
    components: {
        UserImgPlaceholder,
    },
};
</script>
<template>
    <div>
        <div class="flex items-center space-x-2">
            <UserImgPlaceholder width="w-6" heigth="h-6" img="https://img.freepik.com/photos-gratuite/tu-as-eu-heureuse-jeune-femme-bouclee-cheveux-boucles-pointe-camera-index-choisit-quelqu-sourit-largement-isole-mur-bleu-studio_273609-44645.jpg?size=626&ext=jpg&ga=GA1.1.1788614524.1717891200&semt=ais_user" />
            <span class="text-base font-normal text-gray-500 dark:text-gray-400">{{ user_name }}</span>
        </div>
    </div>
</template>
