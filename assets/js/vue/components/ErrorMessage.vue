<template>
    <article
        class="message is-danger"
        role="alert"
    >
        <div class="message-body">
            {{ error.response.data.error }}
        </div>
    </article>
</template>

<script>
export default {
    name: 'ErrorMessage',
    props: {
        error: {
            type: Error,
            required: true,
        },
    },
};
</script>
