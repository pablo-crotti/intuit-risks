<script>
import UserImgPlaceholder from "@/Icons/UserImgPlaceholder.vue";

export default {
    props: {
        id: {
            type: String,
            required: true,
        },
    },
    data() {
        return {
            file: null,
            fileUrl: null,
        };
    },
    emits: ["selectFile"],
    components: {
        UserImgPlaceholder,
    },

    methods: {
        selectFile(event) {
            const file = event.target.files[0];
            if (!file) {
                this.file = null;
                return;
            }
            const reader = new FileReader();
            reader.readAsDataURL(file);

            reader.onload = (e) => {
                this.fileUrl = e.target.result;
            };
            this.file = file;
            this.$emit("selectFile", file);
        },
        cancel() {
            this.file = null;
            this.fileUrl = null;
        },
    },
};
</script>
<template>
    <div class="flex items-center justify-center w-full">
        <label
            v-if="!file"
            :for="id"
            class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600"
        >
            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                <svg
                    class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400"
                    aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 20 16"
                >
                    <path
                        stroke="currentColor"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"
                    />
                </svg>
                <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
                    <span class="font-semibold">Cliquer pour télécharger</span>
                    ou glisser-déposer un fichier
                </p>
                <p class="text-xs text-gray-500 dark:text-gray-400">
                    SVG, PNG, JPG or GIF (MAX. 800x400px)
                </p>
            </div>
            <input :id="id" type="file" class="hidden" @change="selectFile" />
        </label>
        <div
            v-else
            class="relative flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-600"
        >
            <button
                class="absolute -top-2 -right-2 bg-red rounded-md hover:opacity-85 w-6 h-6 flex justify-center items-center"
                @click="cancel"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    class="size-6 text-white"
                    stroke-width="1.5"
                    stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M6 18 18 6M6 6l12 12"
                    />
                </svg>
            </button>
            <img
                :src="fileUrl"
                class="w-12 h-12 rounded-full object-cover mb-2"
                alt="User Image"
            />
            <p
                class="mb-2 text-sm text-gray-500 dark:text-gray-400 font-semibold"
            >
                <span class="">{{ file.name }}</span>
            </p>
        </div>
    </div>
</template>
