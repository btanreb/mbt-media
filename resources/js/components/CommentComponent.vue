<template>
    <div>
        <label>Komentarz</label>
        <textarea class="form-control" v-model="form.comment"></textarea>
        <button type="button" class="btn btn-sm btn-primary m-t-xs add-comment-warning" :disabled="!form.comment.length" @click="addComment">Dodaj komentarz</button>
    </div>

    <div class="comments feed-element">
        <div v-for="comment in comments" class="comment">
            <button @click="removeComment(comment.id)" class="btn btn-xs btn-micro btn-danger button-delete">Usuń</button>
            <p class="well">{{ comment.content }}</p>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        data() {
            return {
                form: {
                    projectId: this.projectId,
                    comment: ''
                },
                comments: []
            };
        },

        methods: {
            getComments() {
                axios.get(`/api/project-comments/${this.projectId}`)
                     .then(response => this.comments = response.data)
                     .catch(error => console.log(error))
            },

            addComment() {
                axios.post('/api/project-comment', this.form)
                     .then(response => {
                        this.getComments();
                     })
                     .catch(error => console.log(error))

                this.form.comment = ''
            },

            removeComment(commentId) {
                axios.delete(`/api/project-comment/${commentId}`)
                     .then(response => {
                        this.getComments()
                     })
                     .catch(error => console.log(error))
            },
        },

        mounted() {
            this.getComments()
        },

        props: ['projectId'],
    };
</script>
