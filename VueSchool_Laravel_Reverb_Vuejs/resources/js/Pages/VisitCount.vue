<script setup>
import { ref } from "vue";

const messages = ref([]);
const message = ref("");

const props = defineProps({
    user: Object,
});

Echo.private(`messages.${props.user.id}`).listen("MessageReceived", (e) => {
    if (!messages.value.find((m) => m.id === e.id)) {
        messages.value.push(e);
    }
});

function handleSubmit() {
    const msg = {
        id: crypto.randomUUID(),
        message: message.value,
    };
    messages.value.push({
        ...msg,
        who: "Me",
    });
    axios.post("/messages", msg);

    message.value = "";
}
</script>

<template>
    <ul class="max-w-md space-y-1 list-none list-inside">
        <li v-for="message in messages" :key="message.id">
            {{ message.message }} - {{ message.who }}
        </li>
    </ul>

    <form @submit.prevent="handleSubmit">
        <textarea v-model="message"></textarea>
        <button>Send Message</button>
    </form>
</template>
