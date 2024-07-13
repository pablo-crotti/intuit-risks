<script>
import UserImgPlaceholder from "../Icons/UserImgPlaceholder.vue";

export default {
    props: {
        user_id: {
            type: Number,
            default: 0,
        },
        
        user_name: {
            type: String,
            default: "User Name",
        },
        user_image: {
            type: String,
            default: "",
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
            <UserImgPlaceholder width="w-6" heigth="h-6" :img="user_image" />
            <span class="text-base font-normal text-gray-500 dark:text-gray-400">{{ user_id == $page.props.auth.user.id ? 'Vous' : user_name }}</span>
            <!-- <p>{{ $page.props.auth.user }}</p> -->
        </div>
    </div>
</template>
